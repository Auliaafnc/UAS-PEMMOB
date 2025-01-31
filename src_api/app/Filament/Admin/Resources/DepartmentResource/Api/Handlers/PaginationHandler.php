<?php

namespace App\Filament\Admin\Resources\DepartmentResource\Api\Handlers;

use App\Filament\Admin\Resources\DepartmentResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = DepartmentResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'branch_company_id'])
            ->with(['branch_company', 'employee', 'client', 'branch_companies'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Department List Retrieved Successfully');
    }
}
