<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Finance Management';

    protected static ?int $navigationSort = -2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('task_id')
                    ->label('Order Number')
                    ->disabled(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'waiting_payment' => 'waiting payment',
                        'paid' => 'PAID',
                    ])
                    ->default('waiting_payment'),

            ]);
    }

    public static function table(Table $table): Table
    {
        Invoice::with('task.order.products.regulations')->get();

        return $table
            ->columns([
                TextColumn::make('task.order.order_number')
                    ->label('Order Number (from Task or Order)')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? $record->task->order->order_number
                            : ($record->order ? $record->order->order_number : 'N/A');
                    }),

                TextColumn::make('task.order.products.name')
                    ->label('Product Name')
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? ($record->task->order->products->pluck('name')->isNotEmpty()
                                ? $record->task->order->products->pluck('name')->join(', ')
                                : 'N/A')
                            : ($record->order->products->pluck('name')->isNotEmpty()
                                ? $record->order->products->pluck('name')->join(', ')
                                : 'N/A');
                    }),

                TextColumn::make('task.order.products.typeProduct.name')
                    ->label('Type of Product')
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? $record->task->order->products->pluck('typeProduct.name')->join(', ')
                            : ($record->order ? $record->order->products->pluck('typeProduct.name')->join(', ') : 'N/A');
                    }),

                TextColumn::make('task.order.products.regulations.name')
                    ->label('Regulation')
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? $record->task->order->products->flatMap(function ($product) {
                                return $product->regulations->pluck('name');
                            })->join(', ')
                            : ($record->order
                                ? $record->order->products->flatMap(function ($product) {
                                    return $product->regulations->pluck('name');
                                })->join(', ')
                                : 'N/A');
                    }),

                TextColumn::make('task.order.products.parameter.name')
                    ->label('Parameter')
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? $record->task->order->products->pluck('parameter.name')->join(', ')
                            : ($record->order ? $record->order->products->pluck('parameter.name')->join(', ') : 'N/A');
                    }),

                TextColumn::make('task.order.products.methode.name')
                    ->label('Methode')
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? $record->task->order->products->pluck('methode.name')->join(', ')
                            : ($record->order ? $record->order->products->pluck('methode.name')->join(', ') : 'N/A');
                    }),

                TextColumn::make('task.order.products.priceProduct.price')
                    ->label('Price')
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->task
                            ? $record->task->order->products->pluck('priceProduct.price')->join(', ')
                            : ($record->order ? $record->order->products->pluck('priceProduct.price')->join(', ') : 'N/A');
                    }),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'waiting_payment',
                        'success' => 'paid',
                        'danger' => 'cancelled',  // Warna untuk status cancelled
                    ])
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'waiting_payment' => 'waiting payment',
                            'paid' => 'PAID',
                            'cancelled' => 'CANCELLED',
                            default => $state,
                        };
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (Invoice $record) => $record->status !== 'cancelled'),

                Action::make('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Invoice $record) => route('invoices.download', $record))
                    ->openUrlInNewTab()
                    ->label('Download PDF')
                    ->color('primary')
                    ->visible(fn (Invoice $record) => $record->status !== 'cancelled'),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Cek apakah pengguna memiliki peran yang sesuai
        if ($user->hasRole(['Sales', 'Labolatory', 'Finance'])) {
            return parent::getEloquentQuery()
                ->where(function ($query) use ($user) {
                    // Filter berdasarkan BranchCompany melalui Task
                    $query->whereHas('task.order.employee.branch_company', function ($subQuery) use ($user) {
                        $subQuery->where('id', $user->employee->branch_company_id);
                    })
                    // Filter berdasarkan BranchCompany langsung dari Order
                        ->orWhereHas('order.employee.branch_company', function ($subQuery) use ($user) {
                            $subQuery->where('id', $user->employee->branch_company_id);
                        });
                });
        }

        return parent::getEloquentQuery();
    }
}
