<?php

namespace App\Filament\Admin\Resources\PriceProductResource\Api\Handlers;

use App\Filament\Admin\Resources\PriceProductResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = PriceProductResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['price', 'product_id'])
            ->with(['product'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Price Product List Retrieved Successfully');
    }
}
