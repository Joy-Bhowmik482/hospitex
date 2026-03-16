@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Admission Management</h2>
            <p class="text-slate-600">Manage patient admissions and discharges.</p>
        </div>
        <a href="{{ route('admissions.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + New Admission
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Admissions Message -->
    @if ($admissions->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Admissions Found</h3>
            <p class="text-slate-600 mb-6">There are no admissions in the system yet.</p>
            <a href="{{ route('admissions.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Create First Admission
            </a>
        </div>
    @else
        <!-- Admissions Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Admission No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Patient</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Admitted Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($admissions as $admission)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $admission->admission_no }}</td>
                                <td class="px-6 py-4">
                                    {{ $admission->patient->first_name ?? 'N/A' }} {{ $admission->patient->last_name ?? '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $admission->doctor->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $admission->department->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $admission->admitted_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $admission->status === 'Admitted' ? 'bg-green-100 text-green-800' : ($admission->status === 'Discharged' ? 'bg-slate-100 text-slate-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $admission->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('admissions.show', $admission) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">View</a>
                                        <a href="{{ route('admissions.edit', $admission) }}" class="text-amber-600 hover:text-amber-800 font-semibold text-sm">Edit</a>
                                        <form action="{{ route('admissions.destroy', $admission) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
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
