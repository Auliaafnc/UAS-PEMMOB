<?php

namespace App\Filament\Admin\Resources\RegulationResource\Api;

use App\Filament\Admin\Resources\RegulationResource;
use Rupadana\ApiService\ApiService;

class RegulationApiService extends ApiService
{
    protected static ?string $resource = RegulationResource::class;

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
