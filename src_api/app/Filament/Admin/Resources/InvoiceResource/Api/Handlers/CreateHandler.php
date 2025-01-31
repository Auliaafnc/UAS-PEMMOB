<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Api\Handlers;

use App\Filament\Admin\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = InvoiceResource::class;

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
            'task_id' => 'nullable|exists:tasks,id',
            'order_id' => 'nullable|exists:orders,id',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $model = new (static::getModel());
        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Invoice');
    }
}
