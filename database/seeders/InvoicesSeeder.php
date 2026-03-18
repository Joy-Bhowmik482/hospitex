<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\Service;

class InvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $admission = Admission::first();
        $service = Service::first();

        if ($patient && $service) {
            $invoice = Invoice::firstOrCreate([
                'invoice_no' => 'INV-' . now()->format('Ymd') . '-1'
            ], [
                'patient_id' => $patient->id,
                'admission_id' => $admission?->id,
                'invoice_date' => now()->toDateString(),
                'status' => 'unpaid',
                'subtotal' => $service->price ?? 100,
                'discount' => 0,
                'tax' => 0,
                'net_total' => $service->price ?? 100,
                'created_by' => $patient->id,
            ]);

            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice->id,
                'ref_id' => $service?->id,
            ], [
                'item_type' => 'service',
                'description' => $service->name ?? 'Service',
                'qty' => 1,
                'rate' => $service->price ?? 100,
                'subtotal' => $service->price ?? 100,
            ]);

            // ensure there's a user to record who received the payment
            $receivedBy = \App\Models\User::first()?->id;
            if (! $receivedBy) {
                $receivedBy = \App\Models\User::create([
                    'name' => 'Seeder User',
                    'email' => 'seeder@localhost',
                    'password' => bcrypt('password'),
                    'is_active' => true,
                ])->id;
            }

            Payment::firstOrCreate([
                'invoice_id' => $invoice->id,
            ], [
                'paid_at' => now(),
                'amount' => 0,
                'method' => 'Cash',
                'trx_id' => null,
                'received_by' => $receivedBy,
                'notes' => null,
            ]);
        }
    }
}
