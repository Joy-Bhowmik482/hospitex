@extends('includePage')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">{{ $service->name }}</h1>
            <p class="text-slate-500 mt-1">Details for this billing service.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Edit Service</a>
            <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Back to Services</a>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-3">
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Code</p>
                <p class="text-lg font-medium text-slate-900">{{ $service->code }}</p>
            </div>
            <div class="space-y-3">
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Price</p>
                <p class="text-lg font-medium text-slate-900">{{ number_format($service->price, 2) }}</p>
            </div>
            <div class="space-y-3">
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Department</p>
                <p class="text-lg font-medium text-slate-900">{{ optional($service->department)->name ?? 'Unassigned' }}</p>
            </div>
            <div class="space-y-3">
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Status</p>
                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $service->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
        </div>

        <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
            <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Description</h2>
            <p class="mt-3 text-sm leading-6 text-slate-700">{{ $service->description ?? 'No description was provided for this service.' }}</p>
        </div>
    </div>
</div>
@endsection
