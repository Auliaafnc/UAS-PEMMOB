<?php

namespace App\Filament\Admin\Resources\ParameterResource\Api;

use App\Filament\Admin\Resources\ParameterResource;
use Rupadana\ApiService\ApiService;

class ParameterApiService extends ApiService
{
    protected static ?string $resource = ParameterResource::class;

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
