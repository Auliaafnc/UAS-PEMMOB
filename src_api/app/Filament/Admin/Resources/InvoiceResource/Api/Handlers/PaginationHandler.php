<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Api\Handlers;

use App\Filament\Admin\Resources\InvoiceResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = InvoiceResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'status', 'task_id', 'order_id'])
            ->with(['task', 'order', 'branchCompanyThroughTask', 'branchCompanyThroughOrder'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Invoice List Retrieved Successfully');
    }
}
