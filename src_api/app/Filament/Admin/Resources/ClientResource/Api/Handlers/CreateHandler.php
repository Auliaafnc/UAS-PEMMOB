<?php

namespace App\Filament\Admin\Resources\ClientResource\Api\Handlers;

use App\Filament\Admin\Resources\ClientResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = ClientResource::class;

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
            'logo' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'branch_company_id' => 'required|exists:branch_companies,id',
        ]);

        $model = new (static::getModel());
        $model->fill($validated);
        $model->employee_id = auth()->user()->employee->id;
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Client');
    }
}
