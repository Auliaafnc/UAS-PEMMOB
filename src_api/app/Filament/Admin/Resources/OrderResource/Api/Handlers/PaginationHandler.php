<?php

namespace App\Filament\Admin\Resources\OrderResource\Api\Handlers;

use App\Filament\Admin\Resources\OrderResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = OrderResource::class;

    public function handler()
    {
        $userId = auth()->user()->id;

        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['status', 'employee_id', 'discount_id', 'client_id', 'branch_company_id'])
            ->with(['products','products.priceProduct', 'employee', 'discount', 'client', 'branchCompany'])
            ->whereHas('employee', fn ($query) => $query->where('user_id', $userId))
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Order List Retrieved Successfully');
    }
}
