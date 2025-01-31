<?php

namespace App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers;

use App\Filament\Admin\Resources\DescriptionProductResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = DescriptionProductResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name'])
            ->with(['products'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Description Product List Retrieved Successfully');
    }
}
