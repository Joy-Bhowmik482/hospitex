@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Patient List</h2>
            <p class="text-slate-600">View, edit, or delete patient records from the system.</p>
        </div>
        <a href="{{ route('patients.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Patient
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Patients Message -->
    @if ($patients->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🏥</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Patients Found</h3>
            <p class="text-slate-600 mb-6">There are no patients in the system yet. Click the button below to add a new patient.</p>
            <a href="{{ route('patients.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Patient
            </a>
        </div>
    @else
        <!-- Patient List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Phone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Age</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Blood Type</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($patients as $patient)
                            <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">
                                <!-- ID -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">#{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($patient->first_name, 0, 1) }}{{ substr($patient->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ $patient->email }}</p>
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ $patient->phone }}</p>
                                </td>

                                <!-- Age -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} yrs</p>
                                </td>

                                <!-- Blood Type -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        {{ $patient->blood_type ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $patient->status === 'In' ? 'bg-green-100 text-green-800' : ($patient->status === 'Out' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800') }}">
                                        {{ $patient->status }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- View Button -->
                                        <a href="{{ route('patients.show', $patient->id) }}" 
                                            class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
                                            👁️ View
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('patients.edit', $patient->id) }}" 
                                            class="inline-block bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
                                            ✏️ Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer with Record Count -->
            <div class="bg-slate-50 border-t border-slate-200 px-6 py-4">
                <p class="text-sm text-slate-600">
                    Showing <span class="font-semibold text-slate-800">{{ $patients->count() }}</span> of <span class="font-semibold text-slate-800">{{ $patients->count() }}</span> patients
                </p>
            </div>
        </div>
    @endif
</div>

@endsection
