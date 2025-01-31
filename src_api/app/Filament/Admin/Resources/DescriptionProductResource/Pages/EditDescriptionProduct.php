<?php

namespace App\Filament\Admin\Resources\DescriptionProductResource\Pages;

use App\Filament\Admin\Resources\DescriptionProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDescriptionProduct extends EditRecord
{
    protected static string $resource = DescriptionProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
