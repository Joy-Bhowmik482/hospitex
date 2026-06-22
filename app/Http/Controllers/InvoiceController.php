<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /* =======================
        LIST
    ======================= */
    public function index()
    {
        $invoices = Invoice::with('patient', 'admission')
            ->orderByDesc('id')
            ->paginate(10);

        return view('invoices.list', compact('invoices'));
    }

    /* =======================
        CREATE
    ======================= */
    public function create()
    {
        $patients = Patient::all();
        $admissions = Admission::where('status', 'Admitted')->get();
        $appointments = Appointment::all();
        $services = Service::all();

        return view('invoices.create', compact(
            'patients',
            'admissions',
            'appointments',
            'services'
        ));
    }

    /* =======================
        STORE
    ======================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid,cancelled',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'net_total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // SAFE invoice number generation
            $lastInvoice = Invoice::lockForUpdate()
                ->orderByDesc('id')
                ->first();

            $nextNumber = $lastInvoice
                ? ((int) str_replace('INV-', '', $lastInvoice->invoice_no)) + 1
                : 1;

            $validated['invoice_no'] = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $invoice = Invoice::create($validated);

            /* OPTIONAL: If you store services (invoice items) */
            if ($request->has('services')) {
                foreach ($request->services as $service) {
                    if (!empty($service['id'])) {
                        $invoice->items()->create([
                            'service_id' => $service['id'],
                            'price' => $service['price'] ?? 0,
                            'qty' => $service['qty'] ?? 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice created successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /* =======================
        SHOW
    ======================= */
    public function show(Invoice $invoice)
    {
        $invoice->load('patient', 'admission', 'appointment', 'createdBy', 'items.service');

        return view('invoices.show', compact('invoice'));
    }

    /* =======================
        EDIT
    ======================= */
    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $admissions = Admission::all();
        $appointments = Appointment::all();
        $services = Service::all();

        $invoice->load('items');

        return view('invoices.edit', compact(
            'invoice',
            'patients',
            'admissions',
            'appointments',
            'services'
        ));
    }

    /* =======================
        UPDATE
    ======================= */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|string|unique:invoices,invoice_no,' . $invoice->id,
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid,cancelled',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'net_total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // update invoice
            $invoice->update($validated);

            /* OPTIONAL: replace invoice items */
            if ($request->has('services')) {

                // delete old items
                $invoice->items()->delete();

                // insert new items
                foreach ($request->services as $service) {
                    if (!empty($service['id'])) {
                        $invoice->items()->create([
                            'service_id' => $service['id'],
                            'price' => $service['price'] ?? 0,
                            'qty' => $service['qty'] ?? 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /* =======================
        DELETE
    ======================= */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice deleted successfully');
    }
}