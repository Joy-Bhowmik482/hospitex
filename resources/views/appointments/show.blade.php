@extends('includePage')

@section('content')
<div class="w-full max-w-5xl mx-auto px-4 py-4 appointment-page">

    {{-- Screen Header --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-900 px-5 py-4 flex flex-col md:flex-row md:justify-between md:items-center gap-3 rounded-xl shadow-lg no-print">
        <div>
            <h3 class="text-xl font-bold text-white">Appointment Details</h3>
            <p class="text-blue-100 text-sm mt-1">View and print appointment information professionally</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <button
                onclick="window.print()"
                class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition"
                type="button">
                🖨️ Print
            </button>

            <a href="{{ route('appointments.edit', $appointment) }}"
               class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">
                ✏️ Edit
            </a>

            <a href="{{ route('appointments.index') }}"
               class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">
                ← Back
            </a>
        </div>
    </div>

    {{-- Print Content --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mt-4 print-section">

        <div class="p-5 md:p-6">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 flex justify-between items-center no-print">
                    <p class="text-green-700 font-medium">✓ {{ session('success') }}</p>
                    <button onclick="this.parentElement.remove()" class="text-green-700 font-bold" type="button">✕</button>
                </div>
            @endif

            {{-- Printable Header --}}
            <div class="text-center border-b border-gray-200 pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Appointment Slip</h1>
                <p class="text-gray-500 mt-1 text-sm">Professional appointment details print view</p>

                @php
                    $status = strtolower(trim($appointment->status ?? 'pending'));
                    $statusClass = match ($status) {
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'confirmed' => 'bg-blue-100 text-blue-800',
                        'noshow', 'no show' => 'bg-yellow-100 text-yellow-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp

                <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                    Status: {{ $appointment->status ?? 'Pending' }}
                </div>
            </div>

            {{-- Appointment Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 mb-3">Appointment Information</h2>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Appointment No:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->appointment_no ?? '—' }}</span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Appointment Date:</span>
                            <span class="font-semibold text-gray-900">
                                {{ !empty($appointment->appointment_date) ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('d M Y (l)') : '—' }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Appointment Time:</span>
                            <span class="font-semibold text-gray-900">
                                {{ !empty($appointment->appointment_time) ? \Illuminate\Support\Carbon::parse($appointment->appointment_time)->format('H:i') : '—' }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Token No:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->token_no ?? '—' }}</span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Department:</span>
                            <span class="font-semibold text-gray-900">{{ optional($appointment->department)->name ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 mb-3">Patient & Doctor</h2>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Patient:</span>
                            <span class="font-semibold text-gray-900">
                                {{ trim((optional($appointment->patient)->first_name ?? '') . ' ' . (optional($appointment->patient)->last_name ?? '')) ?: '—' }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Patient ID:</span>
                            <span class="font-semibold text-gray-900">{{ optional($appointment->patient)->id ?? '—' }}</span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Doctor:</span>
                            <span class="font-semibold text-gray-900">{{ optional($appointment->doctor)->name ?? '—' }}</span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Specialization:</span>
                            <span class="font-semibold text-gray-900">{{ optional($appointment->doctor)->specialization ?? '—' }}</span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Created By:</span>
                            <span class="font-semibold text-gray-900">{{ optional($appointment->createdBy)->name ?? 'System' }}</span>
                        </div>

                        <div class="flex justify-between gap-3">
                            <span class="text-gray-500">Created At:</span>
                            <span class="font-semibold text-gray-900">
                                {{ $appointment->created_at ? $appointment->created_at->format('d M Y H:i') : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if(!empty($appointment->notes))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <h2 class="text-base font-semibold text-blue-900 mb-1">Notes</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">{{ $appointment->notes }}</p>
                </div>
            @endif

            {{-- Signature/Footer for printing --}}
            <div class="mt-6 grid grid-cols-2 gap-8 pt-4 border-t border-gray-200 print-signature">
                <div>
                    <p class="text-sm text-gray-500 mb-10">Patient Signature</p>
                    <div class="border-t border-gray-400 w-40"></div>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-10">Authorized Signature</p>
                    <div class="border-t border-gray-400 w-40 ml-auto"></div>
                </div>
            </div>

            {{-- Screen-only Actions --}}
            <div class="border-t border-gray-200 my-6 no-print"></div>

            <div class="space-y-3 no-print">
                <a href="{{ route('appointments.edit', $appointment) }}"
                   class="block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg transition text-center">
                    ✏️ Edit Appointment
                </a>

                <form action="{{ route('appointments.changeStatus', $appointment) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                    @csrf
                    <select name="status"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 font-semibold"
                            required>
                        <option value="" disabled {{ empty($appointment->status) ? 'selected' : '' }}>Change status to...</option>
                        <option value="Pending" {{ $appointment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ $appointment->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ $appointment->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $appointment->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="NoShow" {{ $appointment->status === 'NoShow' ? 'selected' : '' }}>No Show</option>
                    </select>

                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition" type="submit">
                        ✓ Update
                    </button>
                </form>

                <form action="{{ route('appointments.destroy', $appointment) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        🗑️ Delete Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        html, body {
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 11px;
            line-height: 1.25;
        }

        * {
            box-shadow: none !important;
            text-shadow: none !important;
        }

        /* Hide common layout wrappers from the main app */
        .sidebar,
        .header,
        .navbar,
        .topbar,
        .app-header,
        .app-sidebar,
        .main-nav,
        .navigation,
        nav,
        aside,
        .print-page-header,
        .page-header,
        .site-header,
        .site-sidebar,
        .no-print {
            display: none !important;
        }

        /* Make the appointment content the only visible block */
        .appointment-page {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .appointment-page > .print-section {
            border: none !important;
            border-radius: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            box-shadow: none !important;
        }

        .print-section {
            background: #fff !important;
        }

        /* Preserve content layout in print */
        .grid {
            display: grid !important;
            gap: 8px !important;
        }

        .bg-gradient-to-r,
        .bg-gray-50,
        .bg-blue-50,
        .shadow-xl,
        .shadow-lg {
            background: #fff !important;
        }

        h1 {
            font-size: 18px !important;
        }

        h2 {
            font-size: 13px !important;
        }

        p, span, div {
            color: #000 !important;
        }

        .print-section,
        .print-signature {
            page-break-inside: avoid;
        }
    }
</style>
@endsection
