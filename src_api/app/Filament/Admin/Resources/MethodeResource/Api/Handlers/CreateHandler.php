<?php

namespace App\Filament\Admin\Resources\MethodeResource\Api\Handlers;

use App\Filament\Admin\Resources\MethodeResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = MethodeResource::class;

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
        ]);

        $model = new (static::getModel());
        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Methode');
    }
}
