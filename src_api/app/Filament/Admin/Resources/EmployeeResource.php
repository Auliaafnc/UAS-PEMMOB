<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EmployeeStatus;
use App\Filament\Admin\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
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

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Company Management';

    protected static ?int $navigationSort = -2;

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
                        TextInput::make('employee_code')
                            ->label('Employee ID')
                            ->disabled()
                            ->default(function () {
                                return 'EMP-'.Str::padLeft(Employee::max('id') + 1, 5, '0');
                            }),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Full Name'),
                        Select::make('user_id')
                            ->relationship('user', 'email')
                            ->label('email'),
                        TextInput::make('phone')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        Select::make('status')
                            ->label('Status')
                            ->options(EmployeeStatus::options())
                            ->required()
                            ->default(EmployeeStatus::ACTIVE->value),

                        Select::make('branch_company_id')
                            ->relationship('branch_company', 'name')
                            ->label('Branch Company'),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->label('Department'),

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
                TextColumn::make('employee_code'),
                TextColumn::make('user.name')
                    ->label('Full Name'),
                ImageColumn::make('user.avatar_url')
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->label('Avatar')
                    ->circular(),
                TextColumn::make('user.email'),
                TextColumn::make('phone'),
                TextColumn::make('branch_company.name'),
                TextColumn::make('department.name'),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => EmployeeStatus::from($state)->label())
                    ->sortable()
                    ->badge(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole(['Sales', 'Labolatory', 'Finance'])) {
            return parent::getEloquentQuery()->where('user_id', $user->id);
        }

        return parent::getEloquentQuery();
    }
}
