<?php

namespace App\Filament\Admin\Resources\RegulationResource\Api\Handlers;

use App\Filament\Admin\Resources\RegulationResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = RegulationResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'year', 'details'])
            ->with(['products'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Regulation List Retrieved Successfully');
    }
}
