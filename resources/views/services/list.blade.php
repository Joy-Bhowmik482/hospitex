@extends('includePage')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Services</h1>
            <p class="text-slate-500 mt-1">Manage the service catalog used for billing and charge codes.</p>
        </div>
        <a href="{{ route('services.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">+ Add Service</a>
    </div>

    <div class="mb-6">
        <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm sm:px-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-700">Service Summary</p>
                    <p class="text-slate-500">Total services: <span class="font-semibold text-slate-900">{{ $services->total() }}</span></p>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row">
                    <input type="text" placeholder="Search services..." class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 sm:w-72" />
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Code</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Department</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($services as $service)
                <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $service->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $service->code }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ optional($service->department)->name ?? 'Unassigned' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-900">{{ number_format($service->price, 2) }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $service->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                        <a href="{{ route('services.show', $service) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        <a href="{{ route('services.edit', $service) }}" class="text-amber-600 hover:text-amber-800">Edit</a>
                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this service?')" class="text-rose-600 hover:text-rose-800">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">
                        No services found. Add a new service to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
@endsection
