<?php

namespace App\Filament\Admin\Resources\DescriptionProductResource\Pages;

use App\Filament\Admin\Resources\DescriptionProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDescriptionProducts extends ListRecords
{
    protected static string $resource = DescriptionProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
