@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Departments Management</h2>
            <p class="text-slate-600">Manage hospital departments and their information.</p>
        </div>
        <a href="{{ route('departments.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Department
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Departments Message -->
    @if ($departments->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🏥</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Departments Found</h3>
            <p class="text-slate-600 mb-6">There are no departments in the system yet. Click the button below to add a new department.</p>
            <a href="{{ route('departments.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Department
            </a>
        </div>
    @else
        <!-- Departments List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Created At</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($departments as $department)
                            <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">
                                <!-- ID -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">#{{ str_pad($department->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-800">{{ $department->name }}</p>
                                </td>

                                <!-- Code -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $department->code ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $department->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $department->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <!-- Created At -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ $department->created_at->format('M d, Y') }}</p>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('departments.show', $department) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 transition">
                                            View
                                        </a>
                                        <a href="{{ route('departments.edit', $department) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this department?')">
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