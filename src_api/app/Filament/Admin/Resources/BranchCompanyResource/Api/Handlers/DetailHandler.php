<?php

namespace App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers;

use App\Filament\Admin\Resources\BranchCompanyResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = BranchCompanyResource::class;

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = QueryBuilder::for(static::getModel())
            ->with(['company', 'department', 'employee', 'client', 'typeProducts'])
            ->where('id', $id)
            ->first();

        if (!$query) {
            return static::sendNotFoundResponse();
        }

        return static::sendSuccessResponse($query, 'Branch Company Details Retrieved Successfully');
    }
}
