<?php

namespace App\Filament\Admin\Resources\OrderResource\Api\Handlers;

use App\Filament\Admin\Resources\OrderResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = OrderResource::class;

    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $userId = auth()->user()->id;

        $query = QueryBuilder::for(static::getModel())
            ->with(['products','products.priceProduct', 'employee', 'discount', 'client', 'branchCompany'])
            ->whereHas('employee', fn ($query) => $query->where('user_id', $userId))
            ->where('id', $id)
            ->first();

        if (!$query) {
            return static::sendNotFoundResponse();
        }

        return static::sendSuccessResponse($query, 'Order Details Retrieved Successfully');
    }
}
