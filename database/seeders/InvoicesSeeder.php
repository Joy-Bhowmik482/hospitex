<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\Admission;
// Services removed: use defaults when seeding invoices

class InvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $admission = Admission::first();
        $service = null;

        if ($patient) {
            $invoice = Invoice::firstOrCreate([
                'invoice_no' => 'INV-' . now()->format('Ymd') . '-1'
            ], [
                'patient_id' => $patient->id,
                'admission_id' => $admission?->id,
                'invoice_date' => now()->toDateString(),
                'status' => 'unpaid',
                'subtotal' => $service?->price ?? 100,
                'discount' => 0,
                'tax' => 0,
                'net_total' => $service?->price ?? 100,
                'created_by' => $patient->id,
            ]);

            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice->id,
                'ref_id' => $service?->id,
            ], [
                'item_type' => 'service',
                'description' => $service?->name ?? 'Service',
                'qty' => 1,
                'rate' => $service?->price ?? 100,
                'subtotal' => $service?->price ?? 100,
            ]);

            // Payments removed from seeder
        }
    }
}
