@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Staff Management</h2>
            <p class="text-slate-600">Manage hospital staff members and their information.</p>
        </div>
        <a href="{{ route('staff.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Staff
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Staff Message -->
    @if ($staff->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">👥</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Staff Found</h3>
            <p class="text-slate-600 mb-6">There are no staff members in the system yet. Click the button below to add a new staff member.</p>
            <a href="{{ route('staff.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Staff Member
            </a>
        </div>
    @else
        <!-- Staff List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Designation</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Joining Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($staff as $member)
                            <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">
                                <!-- ID -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">#{{ str_pad($member->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($member->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $member->name }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Designation -->
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-800">{{ $member->designation }}</p>
                                </td>

                                <!-- Department -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $member->department->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Joining Date -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ $member->joining_date->format('M d, Y') }}</p>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('staff.show', $member) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 transition">
                                            View
                                        </a>
                                        <a href="{{ route('staff.edit', $member) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('staff.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
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