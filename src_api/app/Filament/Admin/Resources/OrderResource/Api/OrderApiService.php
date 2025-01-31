<?php

namespace App\Filament\Admin\Resources\OrderResource\Api;

use App\Filament\Admin\Resources\OrderResource;
use Rupadana\ApiService\ApiService;

class OrderApiService extends ApiService
{
    protected static ?string $resource = OrderResource::class;

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
