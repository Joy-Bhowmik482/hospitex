@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Doctors Directory</h2>
            <p class="text-slate-600">Manage hospital doctors and their information.</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Doctor
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Doctors Message -->
    @if ($doctors->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">👨‍⚕️</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Doctors Found</h3>
            <p class="text-slate-600 mb-6">There are no doctors in the system yet. Click the button below to add a new doctor.</p>
            <a href="{{ route('doctors.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Doctor
            </a>
        </div>
    @else
        <!-- Doctors List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Registration No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Specialization</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Fee</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($doctors as $doctor)
                            <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">
                                <!-- ID -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">#{{ str_pad($doctor->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($doctor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $doctor->name }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Registration No -->
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-800">{{ $doctor->reg_no }}</p>
                                </td>

                                <!-- Specialization -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        {{ $doctor->specialization }}
                                    </span>
                                </td>

                                <!-- Department -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $doctor->department->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Fee -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">${{ number_format($doctor->fee, 2) }}</p>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $doctor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('doctors.show', $doctor) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 transition">
                                            View
                                        </a>
                                        <a href="{{ route('doctors.edit', $doctor) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this doctor?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection