<?php

namespace App\Filament\Admin\Resources\ProductResource\Api;

use App\Filament\Admin\Resources\ProductResource;
use Rupadana\ApiService\ApiService;

class ProductApiService extends ApiService
{
    protected static ?string $resource = ProductResource::class;

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
