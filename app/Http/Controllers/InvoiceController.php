<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('patient', 'admission')->paginate(10);
        return view('invoices.list', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        $admissions = Admission::where('status', 'Admitted')->get();
        $appointments = Appointment::get();
        $users = User::where('is_active', true)->get();
        return view('invoices.create', compact('patients', 'admissions', 'appointments', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|string|unique:invoices,invoice_no',
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:Unpaid,Partial,Paid,Cancelled',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'net_total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'created_by' => 'required|exists:users,id',
        ]);

        Invoice::create($validated);
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('patient', 'admission', 'appointment', 'createdBy');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $admissions = Admission::get();
        $appointments = Appointment::get();
        $users = User::where('is_active', true)->get();
        return view('invoices.edit', compact('invoice', 'patients', 'admissions', 'appointments', 'users'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|string|unique:invoices,invoice_no,' . $invoice->id,
            'patient_id' => 'required|exists:patients,id',
            'admission_id' => 'nullable|exists:admissions,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:Unpaid,Partial,Paid,Cancelled',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'net_total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'created_by' => 'required|exists:users,id',
        ]);

        $invoice->update($validated);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully');
    }
}
