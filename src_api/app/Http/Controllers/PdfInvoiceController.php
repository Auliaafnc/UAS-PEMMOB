<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice as InvoicePDF;

class PdfInvoiceController extends Controller
{
    public function download(Invoice $invoice)
    {
        // Load relationships to avoid N+1 queries
        $invoice->load('task.order.products.parameter', 'task.order.products.methode', 'task.order.products.priceProduct', 'task.order.employee.branch_company.client');

        // Access the Client model
        $client = $invoice->task->order->employee->branch_company->client->first(); // Assuming you need the first client

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
            'name' => $invoice->task->order->employee->branch_company->name,
            'address' => $invoice->task->order->employee->branch_company->address,
            'custom_fields' => [
                'email' => $invoice->task->order->employee->branch_company->email,
                'phone' => $invoice->task->order->employee->branch_company->phone,
            ],
        ]);

        // Generate Items from Order Products
        $items = [];
        foreach ($invoice->task->order->products as $product) {
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
             <br>Demikian surat penawaran ini kami sampaikan. Mohon konfirmasi ke {$invoice->task->order->employee->branch_company->phone} dengan {$invoice->task->order->employee->user->name} jika sudah menerima Penawaran ini",
        ];
        $notes = implode('<br>', $notes);

        $invoiceNumber = $this->getNextInvoiceNumber($invoice->status);

        // Create the Invoice
        $invoicePDF = InvoicePDF::make()
            ->name('HAS BEEN ORDER') // Change the invoice title
            ->buyer($buyer)         // Set the buyer (client)
            ->seller($seller)       // Set the seller (branch company)
            ->addItems($items)      // Add items to the invoice
            ->series($invoice->task->order->order_number)          // Custom series
            ->sequence($invoice->id)  // Use invoice ID for sequence
            ->date(now())           // Set the date
            ->discountByPercent(25) // Optional discount
            ->taxRate(11)           // Optional tax rate
            ->currencySymbol('Rp ')  // Currency symbol
            ->currencyCode('IDR')   // Currency code
            ->currencyFormat('{SYMBOL}{VALUE}') // Currency format
            ->filename("file-{$invoiceNumber}.pdf") // File name
            ->notes($notes)
            ->logo(storage_path('app/public/logo.png'));  // Optional logo

        // Download the generated invoice as PDF
        return $invoicePDF->stream();
    }

    protected function getNextInvoiceNumber($status)
    {
        // Fetch the highest id across all invoices
        $maxId = Invoice::max('id');
        // Determine the prefix based on the status
        $prefix = $status === 'PO' ? 'PO' : 'SO';

        // Generate the invoice number with the prefix and padded id
        return $prefix.'-'.Str::padLeft($maxId + 1, 5, '0');
    }
}
