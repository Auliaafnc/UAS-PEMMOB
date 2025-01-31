<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Api\Handlers;

use App\Filament\Admin\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = InvoiceResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $validated = $request->validate([
            'task_id' => 'nullable|exists:tasks,id',
            'order_id' => 'nullable|exists:orders,id',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $model = static::getModel()::find($id);

        if (!$model) {
            return static::sendNotFoundResponse();
        }

        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Update Invoice');
    }
}
