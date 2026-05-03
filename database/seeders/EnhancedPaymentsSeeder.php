<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Invoice;

class EnhancedPaymentsSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = Invoice::where('status', '!=', 'Cancelled')->get();
        
        $paymentMethods = ['Cash', 'Card', 'Bank Transfer', 'Cheque', 'UPI'];

        foreach ($invoices as $invoice) {
            if ($invoice->status === 'Paid' || $invoice->status === 'Partially Paid') {
                $paidAmount = $invoice->status === 'Paid' ? $invoice->amount : $invoice->amount * 0.5;
                
                Payment::firstOrCreate([
                    'invoice_id' => $invoice->id,
                    'payment_date' => now()->toDateString(),
                ], [
                    'amount' => $paidAmount,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'reference_number' => 'PAY-' . time() . '-' . rand(1000, 9999),
                    'notes' => 'Payment received',
                    'is_active' => true,
                ]);
            }
        }
    }
}
