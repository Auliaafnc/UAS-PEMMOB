<?php

namespace App\Filament\Admin\Resources\TypeProductResource\Api\Handlers;

use App\Filament\Admin\Resources\TypeProductResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = TypeProductResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'branch_company_id'])
            ->with(['branch_company', 'products'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Type Product List Retrieved Successfully');
    }
}
