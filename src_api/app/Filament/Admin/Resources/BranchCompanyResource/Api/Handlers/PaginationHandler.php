<?php

namespace App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers;

use App\Filament\Admin\Resources\BranchCompanyResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = BranchCompanyResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'email', 'address'])
            ->with(['company', 'department', 'employee', 'client', 'typeProducts'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Branch Company List Retrieved Successfully');
    }
}
