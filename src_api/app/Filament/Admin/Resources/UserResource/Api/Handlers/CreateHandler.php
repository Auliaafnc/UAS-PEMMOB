<?php
namespace App\Filament\Admin\Resources\UserResource\Api\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\UserResource;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = UserResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar_url' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $model = new (static::getModel());
        $model->fill($validated);
        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create User');
    }
}