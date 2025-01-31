<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    // public function updated(Order $order)
    // {
    //     Log::info('Observer: Order updated.', ['order_id' => $order->id, 'status' => $order->status]);

    //     // Cek jika status berubah menjadi 'PO'
    //     if ($order->wasChanged('status') && $order->status === OrderStatus::PO->value) {
    //         Log::info('Observer: Order status changed to PO.', ['order_id' => $order->id]);

    //         // Ambil employee_id dari pengguna yang sedang login (yang mengubah status)
    //         $employeeId = Auth::id(); // Mengambil ID pengguna yang sedang login

    //         // Buat task baru di tabel tasks dengan employee_id dari pengguna yang mengubah status
    //         Task::create([
    //             'order_id' => $order->id,
    //             'status' => 'waiting', // Status default untuk task
    //             'employee_id' => $employeeId, // Set employee_id dari pengguna yang merubah status
    //         ]);

    //         Log::info('Observer: Task created for order with employee_id.', ['order_id' => $order->id, 'employee_id' => $employeeId]);
    //     }
    // }

    // public function updated(Order $order)
    // {
    //     Log::info('Observer: Order updated.', ['order_id' => $order->id, 'status' => $order->status]);

    //     // Cek jika status berubah menjadi 'PO'
    //     if ($order->wasChanged('status') && $order->status === OrderStatus::PO->value) {
    //         Log::info('Observer: Order status changed to PO.', ['order_id' => $order->id]);

    //         // Buat task baru di tabel tasks
    //         Task::create([
    //             'order_id' => $order->id,
    //             'status' => 'waiting', // Status default untuk task
    //         ]);

    //         Log::info('Observer: Task created for order.', ['order_id' => $order->id]);
    //     }
    // }

    public function updated(Order $order)
    {
        Log::info('Observer: Order updated.', ['order_id' => $order->id, 'status' => $order->status]);

        // Cek jika status berubah menjadi 'PO' (Purchase Order)
        if ($order->wasChanged('status') && $order->status === OrderStatus::PO->value) {
            Log::info('Observer: Order status changed to PO.', ['order_id' => $order->id]);

            // Buat task baru di tabel tasks
            Task::create([
                'order_id' => $order->id,
                'status' => 'waiting', // Status default untuk task
            ]);

            Log::info('Observer: Task created for order.', ['order_id' => $order->id]);
        }

        // Cek jika status berubah menjadi 'Cancel Order'
        if ($order->wasChanged('status') && $order->status === OrderStatus::CANCEL->value) {
            Log::info('Observer: Order status changed to Cancel Order.', ['order_id' => $order->id]);

            // Buat atau perbarui invoice secara langsung terkait order yang dibatalkan
            $invoice = Invoice::firstOrNew([
                'order_id' => $order->id, // Asumsikan ada relasi langsung ke order_id di invoice
            ]);

            $invoice->name = 'Invoice for Cancelled Order';
            $invoice->status = 'Cancelled'; // Sesuaikan status sesuai kebutuhan
            $invoice->save();

            Log::info('Observer: Invoice created or updated for cancelled order.', ['order_id' => $order->id, 'invoice_id' => $invoice->id]);
        }
    }
}
