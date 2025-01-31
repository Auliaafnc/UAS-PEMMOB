<?php

namespace App\Filament\Admin\Resources\PriceProductResource\Pages;

use App\Filament\Admin\Resources\PriceProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPriceProducts extends ListRecords
{
    protected static string $resource = PriceProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
