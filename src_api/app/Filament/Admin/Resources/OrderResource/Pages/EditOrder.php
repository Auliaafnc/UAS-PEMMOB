<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use App\Models\BranchCompany;
use App\Models\Client;
use App\Models\Order;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = Filament::auth()->user();

        // Set default value for fields during editing, based on creation defaults
        $data['order_number'] = $data['order_number'] ?? 'SO-' . Str::padLeft(Order::max('id') + 1, 10, '0');
        $data['employee_id'] = $data['employee_id'] ?? $user->id;
        $data['branch_company_id'] = $data['branch_company_id'] ?? BranchCompany::whereHas('employee', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->pluck('id')->first();
        $data['client_id'] = $data['client_id'] ?? Client::whereHas('employee', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->pluck('id')->first();

        // Include selected products in the data
        $order = Order::find($data['id']);
        if ($order) {
            $data['products_air_higiene'] = $order->products->where('category', 'air higiene sanitasis')->pluck('id')->toArray();
            $data['products_air_limbah'] = $order->products->where('category', 'air limbah ipal')->pluck('id')->toArray();
        }

        return $data;
    }

    protected function mutateFormSchemaBeforeFill(array $schema): array
    {
        foreach ($schema as &$field) {
            // Set specific conditions to make fields non-editable
            if (in_array($field->getName(), ['order_number', 'products'])) {
                $field->disabled();
            }
        }

        return $schema;
    }
}
