@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100">

    <div class="max-w-6xl mx-auto px-4 py-10 space-y-8">

        <!-- HEADER -->
        <div class="rounded-2xl bg-gradient-to-r from-slate-900 to-slate-700 px-6 py-6 text-white shadow-lg">
            <h1 class="text-2xl font-semibold">Hospital Profile</h1>
            <p class="text-slate-300 text-sm mt-1">
                Manage hospital information, contact details, and system configuration.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            <!-- LEFT COLUMN -->
            <div class="lg:col-span-2 space-y-6">

                <!-- BASIC INFO -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-800">Basic Information</h2>
                    </div>

                    <div class="p-6 grid md:grid-cols-2 gap-5 bg-slate-50/40">

                        @php
                            $get = fn($key) => optional($settings->firstWhere('key', $key))->value['value'] ?? null;
                        @endphp

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Hospital Name</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ $get('site.name') ?? 'Not configured' }}
                            </p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Address</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ $get('site.address') ?? 'Not configured' }}
                            </p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Phone</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ $get('site.phone') ?? 'Not configured' }}
                            </p>
                        </div>

                        <div class="bg-white rounded-xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ $get('site.email') ?? 'Not configured' }}
                            </p>
                        </div>

                    </div>
                </div>

                <!-- MISSION -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-800">Mission Statement</h2>
                    </div>

                    <div class="p-6 bg-emerald-50/30">
                        <div class="bg-white border border-slate-200 rounded-xl p-5 text-slate-700 leading-relaxed">
                            {{ $get('site.mission_statement') ?? 'Not configured' }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN -->
            <div class="space-y-6">

                @php
                    $card = fn($title, $key, $color = 'slate') => [
                        'title' => $title,
                        'value' => optional($settings->firstWhere('key', $key))->value['value'] ?? null,
                        'color' => $color
                    ];
                @endphp

                @foreach([
                    $card('Operating Hours', 'site.visiting_hours', 'amber'),
                    $card('Emergency Contact', 'site.emergency_contact', 'red'),
                    $card('Website', 'site.website_url', 'indigo'),
                    $card('Timezone', 'site.timezone', 'slate'),
                ] as $item)

                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                    <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-800">
                            {{ $item['title'] }}
                        </h3>
                    </div>

                    <div class="p-5 bg-{{ $item['color'] }}-50/40">
                        <div class="bg-white border border-slate-200 rounded-xl p-3 text-slate-900 font-medium break-words">
                            {{ $item['value'] ?? 'Not configured' }}
                        </div>
                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection