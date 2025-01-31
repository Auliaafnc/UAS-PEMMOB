<?php

namespace App\Filament\Admin\Resources\ProductResource\Api\Handlers;

use App\Filament\Admin\Resources\ProductResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = ProductResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'category_product', 'category', 'type_product_id', 'parameter_id'])
            ->with([
                'typeProduct',
                'descriptionProduct',
                'parameter',
                'methode',
                'priceProduct',
                'regulations',
                'orders',
            ])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Product List Retrieved Successfully');
    }
}
