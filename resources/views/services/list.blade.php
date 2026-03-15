@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Services Management</h2>
            <p class="text-slate-500 mt-1">Manage hospital services (Doctor fees, Bed charges, Lab, OT, etc.)</p>
        </div>
        <a href="{{ route('services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
            ➕ Add Service
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="mb-6">
        <input type="text" placeholder="Search services..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-100 border-b border-slate-300">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Code</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Department</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $service->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $service->code }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $service->department?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700 font-semibold">{{ number_format($service->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('services.show', $service) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            <a href="{{ route('services.edit', $service) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-slate-500">No services found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>

@endsection
