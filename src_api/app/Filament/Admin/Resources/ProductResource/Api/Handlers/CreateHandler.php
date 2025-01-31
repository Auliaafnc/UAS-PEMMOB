<?php

namespace App\Filament\Admin\Resources\ProductResource\Api\Handlers;

use App\Filament\Admin\Resources\ProductResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = ProductResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_product' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'type_product_id' => 'nullable|exists:type_products,id',
            'description_product_id' => 'nullable|exists:description_products,id',
            'parameter_id' => 'nullable|exists:parameters,id',
            'methode_id' => 'nullable|exists:methodes,id',
            'price_product_id' => 'nullable|exists:price_products,id',
        ]);

        $model = new (static::getModel());
        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Product');
    }
}
