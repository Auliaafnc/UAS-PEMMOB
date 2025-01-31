<?php

namespace App\Filament\Admin\Resources\ProductResource\Api\Handlers;

use App\Filament\Admin\Resources\ProductResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = ProductResource::class;

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = QueryBuilder::for(static::getModel())
            ->with([
                'typeProduct',
                'descriptionProduct',
                'parameter',
                'methode',
                'priceProduct',
                'regulations',
                'orders',
            ])
            ->where('id', $id)
            ->first();

        if (!$query) {
            return static::sendNotFoundResponse();
        }

        return static::sendSuccessResponse($query, 'Product Details Retrieved Successfully');
    }
}
