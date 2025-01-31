<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public function aftercreate()
    {
        Notification::make()
            ->title('Order dibuat');
        // ->message('Order has been created successfully.')
        // ->send();
    }
}
