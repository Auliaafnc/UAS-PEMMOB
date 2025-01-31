<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BranchCompanyResource\Pages;
use App\Filament\Admin\Resources\BranchCompanyResource\RelationManagers\ClientRelationManager;
use App\Filament\Admin\Resources\BranchCompanyResource\RelationManagers\DepartmentRelationManager;
use App\Filament\Admin\Resources\BranchCompanyResource\RelationManagers\EmployeeRelationManager;
use App\Models\BranchCompany;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class BranchCompanyResource extends Resource
{
    protected static ?string $model = BranchCompany::class;

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
                        TextInput::make('name'),
                        Textarea::make('address'),
                        TextInput::make('email')
                            ->email(),
                        TextInput::make('phone')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        Select::make('company_id')
                            ->relationship('company', 'name'),
                    ]),
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
                TextColumn::make('address')
                    ->wrap(),
                TextColumn::make('email'),
                TextColumn::make('phone'),
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
            DepartmentRelationManager::class,
            EmployeeRelationManager::class,
            ClientRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranchCompanies::route('/'),
            'create' => Pages\CreateBranchCompany::route('/create'),
            'edit' => Pages\EditBranchCompany::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Jika user memiliki role "Sales", filter berdasarkan user_id
        if ($user->hasRole(['Sales', 'Labolatory', 'Finance'])) {
            return parent::getEloquentQuery()->whereHas('employee', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        // Jika bukan role "Sales", return query default atau bisa tambahkan logic lain
        return parent::getEloquentQuery();
    }
}
