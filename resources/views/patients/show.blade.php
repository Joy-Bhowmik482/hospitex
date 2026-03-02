@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Patient Details</h2>
            <p class="text-slate-600">Complete information for {{ $patient->first_name }} {{ $patient->last_name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('patients.edit', $patient->id) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-2 px-6 rounded-lg transition">
                ✏️ Edit Patient
            </a>
            <a href="{{ route('patients.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-2 px-6 rounded-lg transition">
                ← Back to List
            </a>
        </div>
    </div>

    <!-- Patient Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Personal Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Personal Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">First Name</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $patient->first_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Last Name</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $patient->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Date of Birth</p>
                            <p class="text-base text-slate-800">{{ $patient->date_of_birth->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Age</p>
                            <p class="text-base text-slate-800">{{ $patient->date_of_birth->age }} years</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Gender</p>
                            <p class="text-base text-slate-800">{{ $patient->gender }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Contact Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Email</p>
                            <p class="text-base text-blue-600 hover:underline"><a href="mailto:{{ $patient->email }}">{{ $patient->email }}</a></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Phone</p>
                            <p class="text-base text-blue-600 hover:underline"><a href="tel:{{ $patient->phone }}">{{ $patient->phone }}</a></p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Address</p>
                        <p class="text-base text-slate-800">{{ $patient->address ?? 'N/A' }}</p>
                    </div>

                </div>
            </div>

            <!-- Medical Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-red-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Medical Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Blood Type</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $patient->blood_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Date Admitted</p>
                            <p class="text-base text-slate-800">{{ $patient->date_admitted?->format('d M Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if ($patient->allergies)
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Allergies</p>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mt-2">
                                <p class="text-base text-red-800">{{ $patient->allergies }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($patient->medical_conditions)
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Medical Conditions</p>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-2">
                                <p class="text-base text-blue-800">{{ $patient->medical_conditions }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($patient->notes)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Notes</h3>
                    <p class="text-base text-slate-800 whitespace-pre-line">{{ $patient->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Right Column - Status & Emergency Contact -->
        <div class="space-y-6">
            
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Patient Status</h3>
                <div class="space-y-2">
                    <div class="text-center">
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $patient->status === 'In' ? 'bg-green-100 text-green-800' : ($patient->status === 'Out' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800') }}">
                            {{ $patient->status }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 font-semibold uppercase text-center">Current Status</p>
                </div>
            </div>

            <!-- Patient ID Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Patient ID</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">#{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <p class="text-xs text-slate-600 font-semibold uppercase text-center mt-2">Unique Identifier</p>
            </div>

            <!-- Emergency Contact Card -->
            @if ($patient->emergency_contact_name || $patient->emergency_contact_phone)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-b border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-800">Emergency Contact</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if ($patient->emergency_contact_name)
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Name</p>
                                <p class="text-base text-slate-800">{{ $patient->emergency_contact_name }}</p>
                            </div>
                        @endif
                        @if ($patient->emergency_contact_phone)
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Phone</p>
                                <p class="text-base text-blue-600 hover:underline"><a href="tel:{{ $patient->emergency_contact_phone }}">{{ $patient->emergency_contact_phone }}</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif



            <!-- Metadata Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Record Information</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Created</p>
                        <p class="text-slate-800">{{ $patient->created_at->format('d M Y, H:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Last Updated</p>
                        <p class="text-slate-800">{{ $patient->updated_at->format('d M Y, H:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex gap-3">
        <a href="{{ route('patients.edit', $patient->id) }}" class="flex-1 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 text-center">
            ✏️ Edit Patient
        </a>
        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="flex-1"
            onsubmit="return confirm('Are you sure you want to delete this patient? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                🗑️ Delete Patient
            </button>
        </form>
        <a href="{{ route('patients.index') }}" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-3 px-6 rounded-lg transition text-center">
            ← Back to List
        </a>
    </div>
</div>

@endsection
