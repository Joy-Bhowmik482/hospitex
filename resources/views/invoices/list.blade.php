@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Invoices</h2>
            <p class="text-slate-500 mt-1">Manage patient billing invoices</p>
        </div>
        <a href="{{ route('invoices.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
            ➕ Create Invoice
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="mb-6">
        <input type="text" placeholder="Search invoices..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-100 border-b border-slate-300">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Invoice No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Patient</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $invoice->invoice_no }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $invoice->patient?->first_name }} {{ $invoice->patient?->last_name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $invoice->invoice_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700 font-semibold">{{ number_format($invoice->net_total, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $invoice->status === 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->status === 'Partial' ? 'bg-yellow-100 text-yellow-800' : ($invoice->status === 'Unpaid' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-slate-500">No invoices found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
</div>

@endsection
