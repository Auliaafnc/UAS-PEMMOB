<?php

namespace App\Filament\Admin\Resources\TypeProductResource\Pages;

use App\Filament\Admin\Resources\TypeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeProducts extends ListRecords
{
    protected static string $resource = TypeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
