<?php

namespace App\Filament\Admin\Resources\TypeProductResource\Api\Handlers;

use App\Filament\Admin\Resources\TypeProductResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = TypeProductResource::class;

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
            'name' => 'required|string|max:255',
            'branch_company_id' => 'required|exists:branch_companies,id',
        ]);

        $model = static::getModel()::find($id);

        if (!$model) {
            return static::sendNotFoundResponse();
        }

        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Update Type Product');
    }
}
