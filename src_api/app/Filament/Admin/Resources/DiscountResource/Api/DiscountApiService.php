<?php

namespace App\Filament\Admin\Resources\DiscountResource\Api;

use App\Filament\Admin\Resources\DiscountResource;
use Rupadana\ApiService\ApiService;

class DiscountApiService extends ApiService
{
    protected static ?string $resource = DiscountResource::class;

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
