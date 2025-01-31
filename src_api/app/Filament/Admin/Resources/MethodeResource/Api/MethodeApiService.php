<?php

namespace App\Filament\Admin\Resources\MethodeResource\Api;

use App\Filament\Admin\Resources\MethodeResource;
use Rupadana\ApiService\ApiService;

class MethodeApiService extends ApiService
{
    protected static ?string $resource = MethodeResource::class;

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
