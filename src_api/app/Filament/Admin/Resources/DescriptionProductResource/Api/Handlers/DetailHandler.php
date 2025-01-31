<?php

namespace App\Filament\Admin\Resources\DescriptionProductResource\Api\Handlers;

use App\Filament\Admin\Resources\DescriptionProductResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = DescriptionProductResource::class;

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = QueryBuilder::for(static::getModel())
            ->with(['products'])
            ->where('id', $id)
            ->first();

        if (!$query) {
            return static::sendNotFoundResponse();
        }

        return static::sendSuccessResponse($query, 'Description Product Details Retrieved Successfully');
    }
}
