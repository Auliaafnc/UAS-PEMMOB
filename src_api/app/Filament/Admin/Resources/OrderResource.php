<?php

namespace App\Filament\Admin\Resources;

use App\Enums\OrderStatus;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use illuminate\Support\Str;
use stdClass;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Sales Management';

    protected static ?int $navigationSort = -2;

    // Badge for the total count of orders
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_number')
                    ->label('Order Number')
                    ->disabled()
                    ->default(function () {
                        return 'SO-'.Str::padLeft(Order::max('id') + 1, 10, '0');
                    }),
                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee.user', 'name') // Assumes Employee has a 'name' attribute
                    ->required()
                    ->default(function () {
                        return Filament::auth()->id(); // Safe navigation operator to avoid errors
                    })
                    ->disabled(),
                Select::make('branch_company_id')
                    ->label('Branch Company')
                    ->relationship('branchCompany', 'name') // Relasi ke Branch Company
                    ->options(function () {
                        $user = Filament::auth()->user();

                        // Mengambil Branch Company yang berhubungan dengan employee yang login
                        return \App\Models\BranchCompany::whereHas('employee', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })->pluck('name', 'id'); // 'name' adalah nama perusahaan cabang, 'id' adalah nilai yang disimpan
                    })
                    ->required()
                    ->searchable(),
                Select::make('client_id')
                    ->label('Client Company')
                    ->relationship('client', 'name') // Relasi ke Client
                    ->options(function () {
                        $user = Filament::auth()->user();

                        // Mengambil client berdasarkan employee yang berhubungan dengan user login
                        return \App\Models\Client::whereHas('employee', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })->pluck('name', 'id'); // 'name' adalah atribut yang ditampilkan, 'id' adalah value
                    })
                    ->required()
                    ->searchable(),
                Select::make('discount_id')
                    ->relationship('discount', 'name')
                    ->label('Discount')
                    ->default(3),
                Select::make('status')
                    ->label('Status')
                    ->options(OrderStatus::options())
                    ->required()
                    ->default(OrderStatus::SO->value),
                // Multi-select for Products
                Forms\Components\Wizard::make([
                    // Step 1: Pilih Kategori Produk
                    Forms\Components\Wizard\Step::make('Select Category Product')
                        ->schema([
                            Select::make('category_product')
                                ->label('Category Product')
                                ->options([
                                    'analisis air' => 'Analisis Air',
                                    'analisis lingkungan' => 'Analisis Lingkungan',
                                ])
                                ->required()
                                ->reactive(),
                        ]),

                    // Step 2: Pilih Kategori Berdasarkan Category Product
                    Forms\Components\Wizard\Step::make('Select Category')
                        ->schema([
                            Select::make('category')
                                ->label('Category')
                                ->options(function ($get) {
                                    $categoryProduct = $get('category_product');
                                    if ($categoryProduct === 'analisis air') {
                                        return [
                                            'air higiene sanitasis' => 'Air Higiene Sanitasis',
                                            'air limbah ipal' => 'Air Limbah IPAL',
                                        ];
                                    } elseif ($categoryProduct === 'analisis lingkungan') {
                                        return [
                                            'analisis udara 24 jam' => 'Analisis Udara 24 Jam',
                                            'emisi pembangkit' => 'Emisi Pembangkit',
                                        ];
                                    }
                                    return [];
                                })
                                ->required()
                                ->reactive()
                                ->visible(fn ($get) => $get('category_product') !== null),
                        ]),

                    // Step 3: Pilih Produk Berdasarkan Kategori dan Category Product
                    Forms\Components\Wizard\Step::make('Select Products')
                        ->schema([
                            Forms\Components\CheckboxList::make('products')
                                ->label('Products')
                                ->relationship('products', 'name')
                                ->options(function ($get) {
                                    $categoryProduct = $get('category_product');
                                    $category = $get('category');

                                    if ($categoryProduct && $category) {
                                        return \App\Models\Product::where('category_product', $categoryProduct)
                                            ->where('category', $category)
                                            ->pluck('name', 'id');
                                    }
                                    return [];
                                })
                                ->required()
                                ->visible(fn ($get) => $get('category') !== null),
                        ]),
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
                Tables\Columns\TextColumn::make('order_number')
                    ->wrap()
                    ->label('Order Number'),
                Tables\Columns\TextColumn::make('branchCompany.name')
                    ->wrap()
                    ->label('Branch Company'),
                Tables\Columns\TextColumn::make('client.name')
                    ->wrap()
                    ->label('Client Company'),
                Tables\Columns\TextColumn::make('products.name')
                    ->wrap()
                    ->label('Product Name'),
                Tables\Columns\TextColumn::make('products.typeProduct.name')
                    ->wrap()
                    ->label('Type of Product'),
                Tables\Columns\TextColumn::make('products.regulations.name')
                    ->wrap()
                    ->label('Regulation'),
                Tables\Columns\TextColumn::make('products.parameter.name')
                    ->wrap()
                    ->label('Parameter'),
                Tables\Columns\TextColumn::make('products.methode.name')
                    ->wrap()
                    ->label('Methode'),
                Tables\Columns\TextColumn::make('products.priceProduct.price')
                    ->money('idr', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount.name')
                    ->wrap()
                    ->label('Discount'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => OrderStatus::SO->value,
                        'success' => OrderStatus::PO->value,
                        'danger' => OrderStatus::CANCEL->value,
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                // EditAction::make()
                Tables\Actions\EditAction::make()
                    ->successNotification(null),
                Tables\Actions\Action::make('downloadPDF')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Order $record) => route('order.pdf.download', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole(['Sales', 'Labolatory', 'Finance'])) {
            return parent::getEloquentQuery()->whereHas('employee', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        return parent::getEloquentQuery();
    }
}
