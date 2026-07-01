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
            'status' => 'required|in:Unpaid,Partial,Paid,Cancelled',
            'subtotal' => 'required|decimal:0,2|min:0',
            'discount' => 'nullable|decimal:0,2|min:0',
            'tax' => 'nullable|decimal:0,2|min:0',
            'net_total' => 'required|decimal:0,2|min:0',
            'department' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.price' => 'required|decimal:0,2|min:0',
            'services.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // SAFE invoice number generation with lock
            $lastInvoice = Invoice::lockForUpdate()
                ->orderByDesc('id')
                ->first();

            $nextNumber = $lastInvoice
                ? ((int) str_replace('INV-', '', $lastInvoice->invoice_no)) + 1
                : 1;

            $validated['invoice_no'] = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $validated['created_by'] = auth()->id();

            $invoice = Invoice::create($validated);

            // Create invoice items
            if ($request->has('services') && !empty($request->services)) {
                $servicesMap = Service::whereIn('id', array_column($request->services, 'id'))->get()->keyBy('id');

                foreach ($request->services as $serviceData) {
                    if (!empty($serviceData['id']) && isset($servicesMap[$serviceData['id']])) {
                        $service = $servicesMap[$serviceData['id']];
                        $qty = (int) ($serviceData['qty'] ?? 1);
                        $rate = (float) ($serviceData['price'] ?? $service->price);
                        $subtotal = $qty * $rate;

                        $invoice->items()->create([
                            'item_type' => 'Service',
                            'ref_id' => $service->id,
                            'description' => $service->name,
                            'qty' => $qty,
                            'rate' => $rate,
                            'subtotal' => $subtotal,
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

            return back()->withInput()
                ->with('error', 'Failed to create invoice: ' . $e->getMessage());
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
            'status' => 'required|in:Unpaid,Partial,Paid,Cancelled',
            'subtotal' => 'required|decimal:0,2|min:0',
            'discount' => 'nullable|decimal:0,2|min:0',
            'tax' => 'nullable|decimal:0,2|min:0',
            'net_total' => 'required|decimal:0,2|min:0',
            'department' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.price' => 'required|decimal:0,2|min:0',
            'services.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $invoice->update($validated);

            // Replace invoice items
            if ($request->has('services')) {
                // Delete old items
                $invoice->items()->delete();

                // Create new items
                if (!empty($request->services)) {
                    $servicesMap = Service::whereIn('id', array_column($request->services, 'id'))->get()->keyBy('id');

                    foreach ($request->services as $serviceData) {
                        if (!empty($serviceData['id']) && isset($servicesMap[$serviceData['id']])) {
                            $service = $servicesMap[$serviceData['id']];
                            $qty = (int) ($serviceData['qty'] ?? 1);
                            $rate = (float) ($serviceData['price'] ?? $service->price);
                            $subtotal = $qty * $rate;

                            $invoice->items()->create([
                                'item_type' => 'Service',
                                'ref_id' => $service->id,
                                'description' => $service->name,
                                'qty' => $qty,
                                'rate' => $rate,
                                'subtotal' => $subtotal,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Failed to update invoice: ' . $e->getMessage());
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