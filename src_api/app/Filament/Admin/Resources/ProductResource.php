<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = 'Product';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = -2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Product Name'),

                Select::make('category_product')
                    ->label('Category Product')
                    ->options([
                        'analisis air' => 'Analisis Air',
                        'analisis lingkungan' => 'Analisis Lingkungan',
                    ])
                    ->required(),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        'air higiene sanitasis' => 'Air Higiene Sanitasis',
                        'air limbah ipal' => 'Air Limbah IPAL',
                        'analisis udara 24 jam' => 'Analisis Udara 24 Jam',
                        'emisi pembangkit' => 'Emisi Pembangkit',
                    ])
                    ->required(),

                Forms\Components\Select::make('type_product_id')
                    ->relationship('typeProduct', 'name')
                    ->required()
                    ->label('Type of Product'),

                Forms\Components\Select::make('description_product_id')
                    ->relationship('descriptionProduct', 'name')
                    ->required(false)
                    ->label('Product Description'),

                Forms\Components\Select::make('parameter_id')
                    ->relationship('parameter', 'name')
                    ->required(false)
                    ->label('Parameter'),

                Forms\Components\Select::make('methode_id')
                    ->relationship('methode', 'name')
                    ->required(false)
                    ->label('Method'),

                Forms\Components\Select::make('priceProduct')
                    ->relationship('priceProduct', 'price')
                    ->label('Price')
                    ->prefix('Rp ')
                    ->required(false),

                Forms\Components\Select::make('regulations')
                    ->relationship('regulations', 'name')
                    ->label('Regulations')
                    ->multiple()
                    ->required(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Product Name'),
                Tables\Columns\TextColumn::make('category_product')
                    ->searchable()
                    ->label('Product Category'),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->label('Category'),

                Tables\Columns\TextColumn::make('regulations.name')
                    ->label('Regulations')
                    ->sortable(),

                Tables\Columns\TextColumn::make('typeProduct.name')
                    ->label('Type of Product')
                    ->sortable(),

                Tables\Columns\TextColumn::make('descriptionProduct.name')
                    ->label('Product Description')
                    ->sortable(),

                Tables\Columns\TextColumn::make('parameter.name')
                    ->label('Parameter')
                    ->sortable(),

                Tables\Columns\TextColumn::make('methode.name')
                    ->label('Method')
                    ->sortable(),

                Tables\Columns\TextColumn::make('priceProduct.price')
                    ->label('Price')
                    ->sortable()
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'IDR '.number_format($state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
