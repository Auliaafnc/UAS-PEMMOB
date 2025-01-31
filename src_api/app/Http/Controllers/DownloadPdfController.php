<?php

namespace App\Http\Controllers;

use App\Models\Order;
use illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class DownloadPdfController extends Controller
{
    public function download(Order $order)
    {
        // Load necessary relationships to avoid N+1 queries
        $order->load('employee.branch_company.client', 'products.parameter', 'products.methode', 'products.priceProduct');

        // Access the Client model
        $client = $order->employee->branch_company->client->first(); // Assuming you need the first client

        if (! $client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        // Buyer (Client) details
        $buyer = new Buyer([
            'name' => $client->name,
            'address' => $client->address,
            'custom_fields' => [
                'email' => $client->email,
                'phone' => $client->phone,
            ],
        ]);

        // Seller details (Branch Company)
        $seller = new Party([
            'name' => $order->employee->branch_company->name,
            'address' => $order->employee->branch_company->address,
            'custom_fields' => [
                'email' => $order->employee->branch_company->email, // Employee's email
                'phone' => $order->employee->branch_company->phone, // Employee's phone
            ],
        ]);

        // Generate Items from Order Products
        $items = [];
        foreach ($order->products as $product) {
            $description = "Parameter: {$product->parameter->name}, Metode: {$product->methode->name}";
            $items[] = (new InvoiceItem)
                ->title($product->name)
                ->description($description)
                ->pricePerUnit($product->priceProduct->price)
                ->quantity(1);  // Assuming quantity is 1 for simplicity
        }

        $notes = [
            "<br>1. Penawaran harga berlaku 30 hari sejak tanggal penawaran.
             <br>2. Pembayaran dilakukan maksimal 30 hari kalender setelah dokumen Invoice diterima dengan lengkap dan benar. <br>
             <br>3. Lead Time Analysis 16 hari kerja untuk laporan hasil uji (LHU).
             <br>Demikian surat penawaran ini kami sampaikan. Mohon konfirmasi ke {$order->employee->branch_company->phone} dengan {$order->employee->user->name} jika sudah
menerima Penawaran ini",
        ];
        $notes = implode('<br>', $notes);

        // $series = $order->status === 'Purchase Order' ? 'Purchase Order' : 'Sales Order';

        $invoiceNumber = $this->getNextInvoiceNumber($order->status);

        // dd($series);

        // Create the Invoice
        $invoice = Invoice::make()
            ->name('HAS BEEN ORDER') // Change the invoice title
            ->buyer($buyer)         // Set the buyer (client)
            ->seller($seller)       // Set the seller (branch company)
            ->addItems($items)      // Add items to the invoice
            ->series($order->order_number)          // Custom series
            ->sequence($order->id)  // Use order ID for sequence
            ->date(now())           // Set the date
            ->discountByPercent(25) // Optional discount
            ->taxRate(11)           // Optional tax rate
            // ->payUntilDays(14)      // Payment terms
            ->currencySymbol('Rp ')  // Currency symbol
            ->currencyCode('IDR')   // Currency code
            ->currencyFormat('{SYMBOL}{VALUE}') // Currency format
            ->filename("file-{$invoiceNumber}.pdf") // File name
            ->notes($notes)
            ->logo(storage_path('app/public/logo.png'));  // Optional logo

        // Download the generated invoice as PDF
        return $invoice->stream();

    }

    protected function getNextInvoiceNumber($status)
    {
        // Fetch the highest id across all statuses
        $maxId = Order::max('id');
        // Determine the prefix based on the status
        $prefix = $status === 'PO' ? 'PO' : 'SO';

        // Generate the invoice number with the prefix and padded id
        return $prefix.'-'.Str::padLeft($maxId + 1, 5, '0');
    }
}
