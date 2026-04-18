@extends('includePage')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Settings Management</h2>
            <p class="mt-2 text-slate-600 max-w-2xl">Keep hospital configuration organized by section. Use these settings cards and edit pages to manage all global values stored in the database.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <a href="{{ route('settings.create') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Add New Setting</a>
            <a href="{{ route('settings.hospital-profile') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">Hospital Profile</a>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">Refresh</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-[1.5fr_1fr]">
        <div class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Settings</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalSettings }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total settings currently stored.</p>
                </div>
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Sections</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $groupCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Distinct settings sections available.</p>
                </div>
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Last updated</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ optional($settings->flatten()->sortByDesc('updated_at')->first())->updated_at?->format('d M Y') ?? 'N/A' }}</p>
                    <p class="mt-2 text-sm text-slate-500">Most recent setting update.</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Section Summary</h3>
                <p class="mt-2 text-sm text-slate-600">Each section groups related site configuration values. Use the Add New Setting button to expand the available options and keep values current.</p>
                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    @foreach($groupMeta as $groupKey => $metadata)
                        @if($groupKey !== 'hospital')
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ $metadata['title'] }}</p>
                            <p class="mt-3 text-lg font-semibold text-slate-900">{{ $settings->get($groupKey)?->count() ?? 0 }} settings</p>
                            <p class="mt-2 text-sm text-slate-600">{{ $metadata['description'] }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Quick section guidance</h3>
            <ul class="mt-5 space-y-3 text-sm text-slate-600">
                <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-900"></span><span><strong>Hospital Profile</strong> contains address and contact details used for reports and patient communications.</span></li>
                <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-900"></span><span><strong>Billing & Finance</strong> controls tax, currency, and invoice settings.</span></li>
                <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-900"></span><span><strong>Communication</strong> includes email and SMS provider connections.</span></li>
                <li class="flex gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-slate-900"></span><span><strong>Branding</strong> defines logos and theme colors for the dashboard experience.</span></li>
            </ul>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between p-6 border-b border-slate-200 bg-slate-50">
            <div>
                <h3 class="text-xl font-semibold text-slate-900">Global Settings Table</h3>
                <p class="mt-1 text-sm text-slate-600">Review or edit any configured value from the database below.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('settings.create') }}" class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Add New</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-[0.2em]">Section</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-[0.2em]">Setting</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-[0.2em]">Value</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-[0.2em]">Last Updated</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-[0.2em] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($settings as $group => $groupSettings)
                        <tr class="bg-slate-50">
                            <td colspan="5" class="px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">{{ data_get($groupMeta, $group.'.title', ucfirst(str_replace(['.', '_'], ' ', $group))) }}</td>
                        </tr>
                        @foreach($groupSettings as $setting)
                            @php
                                $meta = data_get($settingMeta, $setting->key, []);
                                $displayLabel = $meta['label'] ?? ucfirst(str_replace(['.', '_'], ' ', $setting->key));
                                $displayDescription = $meta['description'] ?? null;
                                $rawValue = $setting->value;
                                $displayValue = is_array($rawValue) ? data_get($rawValue, 'value', json_encode($rawValue)) : $rawValue;
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 align-top text-sm text-slate-700">{{ data_get($groupMeta, $group.'.title', ucfirst($group ?: 'General')) }}</td>
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    <div class="font-semibold">{{ $displayLabel }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $setting->key }}</div>
                                    @if($displayDescription)
                                        <div class="mt-2 text-xs text-slate-500">{{ $displayDescription }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-slate-600 break-words">{{ $displayValue }}</td>
                                <td class="px-6 py-4 align-top text-sm text-slate-500">{{ $setting->updated_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-center align-top">
                                    <a href="{{ route('settings.edit', $setting) }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800 transition">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                No settings have been configured yet. Please run the database seeder or add settings manually.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
