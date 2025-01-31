<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Api;

use App\Filament\Admin\Resources\InvoiceResource;
use Rupadana\ApiService\ApiService;

class InvoiceApiService extends ApiService
{
    protected static ?string $resource = InvoiceResource::class;

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
