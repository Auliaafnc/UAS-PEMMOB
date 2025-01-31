<?php

namespace App\Filament\Admin\Resources\TaskResource\Api;

use App\Filament\Admin\Resources\TaskResource;
use Rupadana\ApiService\ApiService;

class TaskApiService extends ApiService
{
    protected static ?string $resource = TaskResource::class;

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
