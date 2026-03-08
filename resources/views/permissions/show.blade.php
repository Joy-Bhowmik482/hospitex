@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Permission Details</h2>
            <p class="text-slate-600">Complete information for {{ $permission->name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('permissions.edit', $permission) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-2 px-6 rounded-lg transition">
                ✏️ Edit Permission
            </a>
            <a href="{{ route('permissions.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-2 px-6 rounded-lg transition">
                ← Back to List
            </a>
        </div>
    </div>

    <!-- Permission Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Permission Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Permission Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Permission Name</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $permission->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Permission Slug</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $permission->slug }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Module</p>
                            <p class="text-base text-slate-800 font-semibold">{{ $permission->module }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Created At</p>
                            <p class="text-base text-slate-800">{{ $permission->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Updated At</p>
                            <p class="text-base text-slate-800">{{ $permission->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column - Actions & Stats -->
        <div class="space-y-6">

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('permissions.edit', $permission) }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition text-center">
                        Edit Permission
                    </a>
                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Delete Permission
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-b border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800">Statistics</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-slate-800">{{ $permission->roles->count() }}</p>
                        <p class="text-sm text-slate-600">Roles with this permission</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection