@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100">

    <div class="max-w-7xl mx-auto px-4 py-10 space-y-8">

        <!-- HEADER -->
        <div class="rounded-2xl bg-gradient-to-r from-slate-900 to-slate-700 px-6 py-6 text-white shadow-lg">
            <h1 class="text-2xl font-semibold">Settings Management</h1>
            <p class="text-slate-300 text-sm mt-1">
                Organize and manage all hospital configuration settings from one place.
            </p>
        </div>

        <!-- ACTION BAR -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="text-sm text-slate-600">
                Total settings: <span class="font-semibold text-slate-900">{{ $totalSettings }}</span>
            </div>

            <div class="flex flex-wrap gap-3">

                <a href="{{ route('settings.create') }}"
                   class="rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                    Add New Setting
                </a>

                <a href="{{ route('settings.hospital-profile') }}"
                   class="rounded-full bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                    Hospital Profile
                </a>

                <a href="{{ route('settings.index') }}"
                   class="rounded-full border border-slate-300 bg-white px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Refresh
                </a>

            </div>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- TOP CARDS -->
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-widest text-slate-500">Settings</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalSettings }}</p>
                <p class="mt-2 text-sm text-slate-500">Total stored configuration values</p>
            </div>

            <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-widest text-slate-500">Sections</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $groupCount }}</p>
                <p class="mt-2 text-sm text-slate-500">Grouped configuration categories</p>
            </div>

            <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
                <p class="text-xs uppercase tracking-widest text-slate-500">Last update</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">
                    {{ optional($settings->flatten()->sortByDesc('updated_at')->first())->updated_at?->format('d M Y') ?? 'N/A' }}
                </p>
                <p class="mt-2 text-sm text-slate-500">Most recently modified setting</p>
            </div>

        </div>

        <!-- SECTION SUMMARY + GUIDE -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- SECTION SUMMARY -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-lg font-semibold text-slate-900">Section Summary</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Settings are grouped into logical sections for easier management.
                </p>

                <div class="mt-5 grid sm:grid-cols-2 gap-4">

                    @foreach($groupMeta as $groupKey => $metadata)
                        @if($groupKey !== 'hospital')

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-widest text-slate-500">
                                    {{ $metadata['title'] }}
                                </p>

                                <p class="mt-3 text-xl font-semibold text-slate-900">
                                    {{ $settings->get($groupKey)?->count() ?? 0 }}
                                </p>

                                <p class="mt-2 text-sm text-slate-600">
                                    {{ $metadata['description'] }}
                                </p>
                            </div>

                        @endif
                    @endforeach

                </div>
            </div>

            <!-- GUIDE -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-lg font-semibold text-slate-900">Quick Guide</h2>

                <ul class="mt-5 space-y-4 text-sm text-slate-600">

                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                        <span><strong>Hospital Profile</strong> manages core identity and contact info.</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                        <span><strong>Billing</strong> controls invoices, tax, and currency settings.</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                        <span><strong>Communication</strong> manages email/SMS integration.</span>
                    </li>

                    <li class="flex gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                        <span><strong>Branding</strong> controls UI theme and branding assets.</span>
                    </li>

                </ul>

            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            <!-- TABLE HEADER -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-6 py-5 border-b border-slate-200 bg-slate-50">

                <div>
                    <h2 class="text-xl font-semibold text-slate-900">All Settings</h2>
                    <p class="text-sm text-slate-600">View and manage every configuration value</p>
                </div>

                <a href="{{ route('settings.create') }}"
                   class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Add New
                </a>

            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-xs uppercase tracking-widest text-left">Section</th>
                            <th class="px-6 py-4 text-xs uppercase tracking-widest text-left">Setting</th>
                            <th class="px-6 py-4 text-xs uppercase tracking-widest text-left">Value</th>
                            <th class="px-6 py-4 text-xs uppercase tracking-widest text-left">Updated</th>
                            <th class="px-6 py-4 text-xs uppercase tracking-widest text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @forelse($settings as $group => $groupSettings)

                            <tr class="bg-slate-50">
                                <td colspan="5" class="px-6 py-3 text-xs font-semibold uppercase tracking-widest text-slate-500">
                                    {{ data_get($groupMeta, $group.'.title', ucfirst($group)) }}
                                </td>
                            </tr>

                            @foreach($groupSettings as $setting)

                                @php
                                    $meta = data_get($settingMeta, $setting->key, []);
                                    $label = $meta['label'] ?? ucfirst(str_replace(['.', '_'], ' ', $setting->key));
                                    $value = is_array($setting->value)
                                        ? data_get($setting->value, 'value', json_encode($setting->value))
                                        : $setting->value;
                                @endphp

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4 text-slate-700">
                                        {{ data_get($groupMeta, $group.'.title', ucfirst($group)) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900">{{ $label }}</div>
                                        <div class="text-xs text-slate-500">{{ $setting->key }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-slate-600 break-words">
                                        {{ $value }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $setting->updated_at->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('settings.edit', $setting) }}"
                                           class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800 transition">
                                            Edit
                                        </a>
                                    </td>

                                </tr>

                            @endforeach

                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                    No settings found. Please add some configuration.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

@endsection