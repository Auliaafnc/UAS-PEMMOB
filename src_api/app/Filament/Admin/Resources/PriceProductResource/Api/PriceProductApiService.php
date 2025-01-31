<?php

namespace App\Filament\Admin\Resources\PriceProductResource\Api;

use App\Filament\Admin\Resources\PriceProductResource;
use Rupadana\ApiService\ApiService;

class PriceProductApiService extends ApiService
{
    protected static ?string $resource = PriceProductResource::class;

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
