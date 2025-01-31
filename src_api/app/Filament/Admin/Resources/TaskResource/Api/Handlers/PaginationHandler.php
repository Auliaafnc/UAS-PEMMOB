<?php

namespace App\Filament\Admin\Resources\TaskResource\Api\Handlers;

use App\Filament\Admin\Resources\TaskResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = TaskResource::class;

    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['status', 'order_id'])
            ->with(['order', 'invoices'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'Task List Retrieved Successfully');
    }
}
