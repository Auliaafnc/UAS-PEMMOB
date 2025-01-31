<?php

namespace App\Filament\Admin\Resources\ClientResource\Api;

use App\Filament\Admin\Resources\ClientResource;
use Rupadana\ApiService\ApiService;

class ClientApiService extends ApiService
{
    protected static ?string $resource = ClientResource::class;

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
