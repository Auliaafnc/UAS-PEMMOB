<?php

namespace App\Filament\Admin\Resources\DepartmentResource\Api\Handlers;

use App\Filament\Admin\Resources\DepartmentResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = DepartmentResource::class;

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = QueryBuilder::for(static::getModel())
            ->with(['branch_company', 'employee', 'client', 'branch_companies'])
            ->where('id', $id)
            ->first();

        if (!$query) {
            return static::sendNotFoundResponse();
        }

        return static::sendSuccessResponse($query, 'Department Details Retrieved Successfully');
    }
}
