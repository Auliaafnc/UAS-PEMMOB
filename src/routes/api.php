<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\CreateHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\DeleteHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\DetailHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\UpdateHandler;
use App\Filament\Admin\Resources\ProductResource\Api\Handlers\PaginationHandler;

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('products')->group(function () {
        Route::post('/', [CreateHandler::class, 'handler'])->name('api.products.create');
        Route::get('/', [PaginationHandler::class, 'handler'])->name('api.products.pagination');
        Route::get('/{id}', [DetailHandler::class, 'handler'])->name('api.products.detail');
        Route::put('/{id}', [UpdateHandler::class, 'handler'])->name('api.products.update');
        Route::delete('/{id}', [DeleteHandler::class, 'handler'])->name('api.products.delete');
    });
});
