<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Api\Handlers;

use App\Filament\Admin\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = InvoiceResource::class;

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = QueryBuilder::for(static::getModel())
            ->with(['task', 'order', 'branchCompanyThroughTask', 'branchCompanyThroughOrder'])
            ->where('id', $id)
            ->first();

        if (!$query) {
            return static::sendNotFoundResponse();
        }

        return static::sendSuccessResponse($query, 'Invoice Details Retrieved Successfully');
    }
}
