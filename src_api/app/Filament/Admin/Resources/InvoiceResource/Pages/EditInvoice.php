<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Pages;

use App\Filament\Admin\Resources\InvoiceResource;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function beforeFill()
    {
        // Cek status invoice sebelum halaman di-render
        if ($this->record->status === 'cancel_order') {
            abort(403, 'This invoice cannot be edited because it is cancelled.');
        }
    }
}
