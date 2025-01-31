<?php

namespace App\Filament\Admin\Resources\OrderResource\Api\Handlers;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\OrderResource;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = OrderResource::class;

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
            'status' => 'required|string|in:' . implode(',', array_column(OrderStatus::cases(), 'value')),
            'employee_id' => 'nullable|exists:employees,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'client_id' => [
                'nullable',
                'exists:clients,id',
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    $isValid = \App\Models\Client::where('id', $value)
                        ->whereHas('employee', fn ($query) => $query->where('user_id', $user->id))
                        ->exists();

                    if (!$isValid) {
                        $fail('The selected client is invalid or not associated with your employee account.');
                    }
                },
            ],
            'branch_company_id' => [
                'nullable',
                'exists:branch_companies,id',
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    $isValid = \App\Models\BranchCompany::where('id', $value)
                        ->whereHas('employee', fn ($query) => $query->where('user_id', $user->id))
                        ->exists();

                    if (!$isValid) {
                        $fail('The selected branch company is invalid or not associated with your employee account.');
                    }
                },
            ],
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $model = static::getModel()::find($id);

        if (!$model) {
            return static::sendNotFoundResponse();
        }

        $previousStatus = $model->status;

        $model->status = OrderStatus::from($validated['status']);
        $model->employee_id = $validated['employee_id'] ?? $model->employee_id;
        $model->discount_id = $validated['discount_id'];
        $model->client_id = $validated['client_id'];
        $model->branch_company_id = $validated['branch_company_id'];

        // Update order number based on status
        if ($previousStatus !== $model->status->value) {
            $prefix = match ($model->status->value) {
                OrderStatus::PO->value => 'PO-',
                OrderStatus::CANCEL->value => 'CO-',
                default => 'SO-',
            };
            $model->order_number = $prefix . str_pad((static::getModel()::max('id') + 1), 10, '0', STR_PAD_LEFT);
        }

        $model->save();

        // Update product relationships
        if (isset($validated['products'])) {
            $model->products()->sync($validated['products']);
        }

        return static::sendSuccessResponse($model->load(['products', 'employee', 'discount', 'client', 'branchCompany']), 'Successfully Update Order');
    }
}
