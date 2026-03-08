@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ $staff->name }} <span class="text-base font-normal">- Details</span></h2>
            <p class="text-slate-600">Complete information for the staff member</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('staff.edit', $staff) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-2 px-6 rounded-lg transition">
                ✏️ Edit Staff
            </a>
            <a href="{{ route('staff.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-2 px-6 rounded-lg transition">
                ← Back to List
            </a>
        </div>
    </div>

    <!-- Staff Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Staff Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Staff Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Name</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $staff->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Department</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $staff->department->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Designation</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $staff->designation }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Joining Date</p>
                            <p class="text-base text-slate-800">{{ $staff->joining_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Salary</p>
                            <p class="text-base text-slate-800">${{ number_format($staff->salary, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Status</p>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $staff->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $staff->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Created At</p>
                            <p class="text-base text-slate-800">{{ $staff->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Updated At</p>
                            <p class="text-base text-slate-800">{{ $staff->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column - Actions -->
        <div class="space-y-6">

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('staff.edit', $staff) }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition text-center">
                        Edit Staff Member
                    </a>
                    <form action="{{ route('staff.destroy', $staff) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Delete Staff Member
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection