<?php
namespace App\Filament\Admin\Resources\UserResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Admin\Resources\UserResource;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = UserResource::class;


    public function handler()
    {
        $query = QueryBuilder::for(static::getModel())
            ->allowedFilters(['name', 'email'])
            ->with(['employee'])
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return static::sendSuccessResponse($query, 'User List Retrieved Successfully');
    }
}
