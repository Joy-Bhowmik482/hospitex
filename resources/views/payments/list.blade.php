@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Payments</h2>
            <p class="text-slate-500 mt-1">Manage payment records</p>
        </div>
        <a href="{{ route('payments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
            ➕ Record Payment
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="mb-6">
        <input type="text" placeholder="Search payments..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-100 border-b border-slate-300">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Invoice</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Method</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Paid Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Received By</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $payment->invoice?->invoice_no }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700 font-semibold">{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $payment->method }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $payment->paid_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $payment->receivedByUser?->name }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('payments.show', $payment) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            <a href="{{ route('payments.edit', $payment) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-slate-500">No payments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>

@endsection
