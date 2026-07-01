@extends('includePage')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Search results for “{{ $query }}”</h1>
            <p class="text-slate-600 mt-2">Showing quick matches from patients, appointments, and inventory.</p>
        </div>

        @if (empty($query))
            <div class="text-slate-600">Enter a search term to get started.</div>
        @else
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-slate-800">Patients</h2>
                    @forelse($results['patients'] as $patient)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:underline">{{ $patient->first_name }} {{ $patient->last_name }}</a>
                            <p class="text-slate-500 text-sm">{{ $patient->email }} · {{ $patient->phone }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No patients found.</p>
                    @endforelse
                </div>

                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-slate-800">Appointments</h2>
                    @forelse($results['appointments'] as $appointment)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:underline">Appointment #{{ $appointment->id }}</a>
                            <p class="text-slate-500 text-sm">{{ optional($appointment->appointment_date)->format('d M Y') }} · {{ optional($appointment->appointment_time)->format('H:i') }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No appointments found.</p>
                    @endforelse
                </div>

                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-slate-800">Inventory</h2>
                    @forelse($results['inventory_items'] as $item)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="text-slate-900 font-semibold">{{ $item->name }}</div>
                            <p class="text-slate-500 text-sm">{{ $item->category }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No inventory items found.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
