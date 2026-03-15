<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('invoice', 'receivedByUser')->paginate(10);
        return view('payments.list', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::where('status', '!=', 'Paid')->get();
        $users = User::where('is_active', true)->get();
        return view('payments.create', compact('invoices', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'paid_at' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:Cash,Card,bKash,Bank,Other',
            'trx_id' => 'nullable|string|max:100',
            'received_by' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        Payment::create($validated);
        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully');
    }

    public function show(Payment $payment)
    {
        $payment->load('invoice', 'receivedByUser');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $invoices = Invoice::get();
        $users = User::where('is_active', true)->get();
        return view('payments.edit', compact('payment', 'invoices', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'paid_at' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:Cash,Card,bKash,Bank,Other',
            'trx_id' => 'nullable|string|max:100',
            'received_by' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully');
    }
}
