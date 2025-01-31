<?php

namespace App\Filament\Admin\Resources\BranchCompanyResource\Api\Handlers;

use App\Filament\Admin\Resources\BranchCompanyResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = BranchCompanyResource::class;

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
            'address' => 'required|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'client_id' => 'nullable|exists:clients,id',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $model = static::getModel()::find($id);

        if (!$model) {
            return static::sendNotFoundResponse();
        }

        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Update Branch Company');
    }
}
