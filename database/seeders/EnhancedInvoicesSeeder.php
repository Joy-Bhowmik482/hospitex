<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\Service;

class EnhancedInvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $services = Service::all();
        
        $numInvoices = min(50, $patients->count());
        
        for ($i = 0; $i < $numInvoices; $i++) {
            $patient = $patients->random();
            $amount = 0;
            $status = ['Pending', 'Paid', 'Partially Paid', 'Cancelled'][array_rand(['Pending', 'Paid', 'Partially Paid', 'Cancelled'])];
            
            $invoice = Invoice::firstOrCreate([
                'patient_id' => $patient->id,
                'invoice_date' => now()->subDays(rand(0, 90))->toDateString(),
            ], [
                'invoice_number' => 'INV-' . time() . '-' . rand(1000, 9999),
                'due_date' => now()->addDays(30)->toDateString(),
                'status' => $status,
                'notes' => 'Medical services rendered',
                'is_active' => true,
            ]);
            
            // Add 2-5 items per invoice
            $numItems = rand(2, 5);
            for ($j = 0; $j < $numItems; $j++) {
                $service = $services->random();
                $quantity = rand(1, 3);
                $itemAmount = ($service->price ?? 500) * $quantity;
                $amount += $itemAmount;
                
                InvoiceItem::firstOrCreate([
                    'invoice_id' => $invoice->id,
                    'service_id' => $service->id,
                ], [
                    'quantity' => $quantity,
                    'unit_price' => $service->price ?? 500,
                    'total' => $itemAmount,
                ]);
            }
            
            // Update invoice amount
            $invoice->update(['amount' => $amount]);
        }
    }
}
