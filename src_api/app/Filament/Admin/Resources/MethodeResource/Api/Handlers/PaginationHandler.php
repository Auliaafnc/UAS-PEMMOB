<?php

namespace App\Filament\Admin\Resources\MethodeResource\Api\Handlers;

use App\Filament\Admin\Resources\MethodeResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = MethodeResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name'])
            ->with(['products'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Methode List Retrieved Successfully');
    }
}
