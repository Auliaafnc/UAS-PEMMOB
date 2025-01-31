<?php

namespace App\Filament\Admin\Resources\TypeProductResource\Api;

use App\Filament\Admin\Resources\TypeProductResource;
use Rupadana\ApiService\ApiService;

class TypeProductApiService extends ApiService
{
    protected static ?string $resource = TypeProductResource::class;

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
