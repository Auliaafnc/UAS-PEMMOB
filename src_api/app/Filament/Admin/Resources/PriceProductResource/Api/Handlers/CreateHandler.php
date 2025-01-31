<?php

namespace App\Filament\Admin\Resources\PriceProductResource\Api\Handlers;

use App\Filament\Admin\Resources\PriceProductResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = PriceProductResource::class;

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
            'price' => 'required|numeric|min:0',
            'price_minimal' => 'nullable|numeric|min:0',
            'price_maximal' => 'nullable|numeric|min:0',
            'product_id' => 'required|exists:products,id',
        ]);

        $model = new (static::getModel());
        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Price Product');
    }
}
