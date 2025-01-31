<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use stdClass;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Client Management';

    protected static ?int $navigationSort = -3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('client_id')
                            ->disabled()
                            ->default(function () {
                                return 'CLIENT-'.Str::padLeft(Client::max('id') + 1, 5, '0');
                            }),
                        FileUpload::make('logo'),
                        TextInput::make('name'),
                        TextInput::make('email')
                            ->email(),
                        Textarea::make('address'),
                        TextInput::make('phone')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        Select::make('branch_company_id')
                            ->relationship('branch_company', 'name')
                            ->label('Branch Company')
                            ->options(function () {
                                $user = auth()->user();
                                if ($user->hasRole('Sales')) {
                                    return \App\Models\BranchCompany::whereHas('employee', function ($query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    })->pluck('name', 'id');
                                }

                                return \App\Models\BranchCompany::pluck('name', 'id');
                            }),

                        Select::make('employee_id')
                            ->label('Sales')
                            ->options(function () {
                                $user = auth()->user();

                                if ($user->hasRole('Sales')) {
                                    return \App\Models\Employee::where('user_id', $user->id)
                                        ->with('user') // Eager load the related user
                                        ->get()
                                        ->mapWithKeys(function ($employee) {
                                            return [$employee->id => $employee->user->name.' '.$employee->employee_id.''];
                                        });
                                }

                                return \App\Models\Employee::with('user') // Eager load the related user
                                    ->get()
                                    ->mapWithKeys(function ($employee) {
                                        return [$employee->id => $employee->user->name.' '.$employee->employee_id.''];
                                    });
                            }),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('address'),
                TextColumn::make('phone'),
                ImageColumn::make('logo'),
                TextColumn::make('branch_company.name'),
                TextColumn::make('employee.user.name'),
                // TextColumn::make('department.name'),
                // TextColumn::make('employee.employee_code'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    // Memfilter berdasarkan role "Sales"
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole('Sales')) {
            return parent::getEloquentQuery()->whereHas('employee', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        return parent::getEloquentQuery();
    }
}
