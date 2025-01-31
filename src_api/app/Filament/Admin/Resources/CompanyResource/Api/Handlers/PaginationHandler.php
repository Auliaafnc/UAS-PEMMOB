<?php

namespace App\Filament\Admin\Resources\CompanyResource\Api\Handlers;

use App\Filament\Admin\Resources\CompanyResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = CompanyResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name'])
            ->with(['branch_company'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Company List Retrieved Successfully');
    }
}
