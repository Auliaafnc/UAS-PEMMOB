<?php

namespace App\Filament\Admin\Resources\DepartmentResource\Api;

use App\Filament\Admin\Resources\DepartmentResource;
use Rupadana\ApiService\ApiService;

class DepartmentApiService extends ApiService
{
    protected static ?string $resource = DepartmentResource::class;

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
