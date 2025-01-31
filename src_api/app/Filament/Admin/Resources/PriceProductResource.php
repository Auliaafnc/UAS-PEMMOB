<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PriceProductResource\Pages;
use App\Models\PriceProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PriceProductResource extends Resource
{
    protected static ?string $model = PriceProduct::class;

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
                Forms\Components\Select::make('product_id')
                    ->required()
                    ->relationship('product', 'name'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->default(null)
                    ->prefix('Rp '),
                Forms\Components\TextInput::make('price_minimal')
                    ->numeric()
                    ->default(null)
                    ->prefix('Rp '),
                Forms\Components\TextInput::make('price_maximal')
                    ->numeric()
                    ->default(null)
                    ->prefix('Rp '),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_minimal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_maximal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListPriceProducts::route('/'),
            'create' => Pages\CreatePriceProduct::route('/create'),
            'edit' => Pages\EditPriceProduct::route('/{record}/edit'),
        ];
    }
}
