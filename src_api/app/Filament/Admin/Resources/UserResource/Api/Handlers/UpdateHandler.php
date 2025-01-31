<?php
namespace App\Filament\Admin\Resources\UserResource\Api\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\UserResource;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = UserResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'avatar_url' => 'nullable|string|max:255',
        ]);

        $model = static::getModel()::find($id);

        if (!$model) {
            return static::sendNotFoundResponse();
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Update User');
    }
}