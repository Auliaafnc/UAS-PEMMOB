<?php

namespace App\Filament\Admin\Resources\BranchCompanyResource\Api;

use App\Filament\Admin\Resources\BranchCompanyResource;
use Rupadana\ApiService\ApiService;

class BranchCompanyApiService extends ApiService
{
    protected static ?string $resource = BranchCompanyResource::class;

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
