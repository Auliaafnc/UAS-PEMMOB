<?php

namespace App\Filament\Admin\Resources\DescriptionProductResource\Api;

use App\Filament\Admin\Resources\DescriptionProductResource;
use Rupadana\ApiService\ApiService;

class DescriptionProductApiService extends ApiService
{
    protected static ?string $resource = DescriptionProductResource::class;

    public static function handlers(): array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class,
        ];

    }
}
