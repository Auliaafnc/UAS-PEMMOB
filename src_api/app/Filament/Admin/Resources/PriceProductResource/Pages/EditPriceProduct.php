<?php

namespace App\Filament\Admin\Resources\PriceProductResource\Pages;

use App\Filament\Admin\Resources\PriceProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriceProduct extends EditRecord
{
    protected static string $resource = PriceProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
