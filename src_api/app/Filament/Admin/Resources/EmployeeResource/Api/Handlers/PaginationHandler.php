<?php

namespace App\Filament\Admin\Resources\EmployeeResource\Api\Handlers;

use App\Filament\Admin\Resources\EmployeeResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = EmployeeResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['phone', 'branch_company_id', 'department_id', 'user_id'])
            ->with(['department', 'branch_company', 'client', 'user', 'orders'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Employee List Retrieved Successfully');
    }
}
