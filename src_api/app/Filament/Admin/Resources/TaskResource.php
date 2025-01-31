<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Lab Management';

    protected static ?int $navigationSort = -2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_id')
                    ->label('Order Number')
                    ->required()
                    ->disabled(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Waiting',
                        'processed' => 'Processed',
                        'completed' => 'Completed',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.order_number')
                    ->label('Order Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.products.name')
                    ->wrap()
                    ->label('Product Name'),
                TextColumn::make('order.products.category')
                    ->wrap()
                    ->label('Product Category'),
                TextColumn::make('order.products.typeProduct.name')
                    ->wrap()
                    ->label('Type of Product'),
                TextColumn::make('order.products.regulations.name')
                    ->wrap()
                    ->label('Regulation'),
                TextColumn::make('order.products.parameter.name')
                    ->wrap()
                    ->label('Parameter'),
                TextColumn::make('order.products.methode.name')
                    ->wrap()
                    ->label('Methode'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'waiting',
                        'primary' => 'processed',
                        'success' => 'completed',
                    ]),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Waiting',
                        'processed' => 'Processed',
                        'completed' => 'Completed',
                    ]),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Cek apakah pengguna memiliki peran yang sesuai, misalnya "Sales" atau "Laboratory"
        if ($user->hasRole(['Sales', 'Labolatory'])) {
            // Memfilter berdasarkan BranchCompany dari Employee pengguna yang login
            return parent::getEloquentQuery()->whereHas('order.employee.branch_company', function ($query) use ($user) {
                // Ambil branch company dari pengguna yang sedang login
                $query->where('id', $user->employee->branch_company_id);
            });
        }

        return parent::getEloquentQuery();
    }
}
