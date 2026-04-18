@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100">
    <div class="max-w-6xl mx-auto px-4 py-10">

        <!-- HEADER (slightly colored) -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-xl p-6 mb-8 text-white">
            <h1 class="text-2xl font-semibold">Hospital Profile</h1>
            <p class="text-slate-300 text-sm mt-1">
                Manage your hospital information and configuration
            </p>
        </div>

        <!-- GRID -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- LEFT SIDE -->
            <div class="lg:col-span-2 space-y-6">

                <!-- BASIC INFO -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <!-- Section Header -->
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h2 class="text-lg font-medium text-slate-800">Basic Information</h2>
                    </div>

                    <!-- BODY (soft blue tint) -->
                    <div class="p-6 bg-blue-50/40 grid md:grid-cols-2 gap-5">

                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <p class="text-sm text-slate-500">Hospital Name</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ optional($settings->firstWhere('key','site.name'))->value['value'] ?? 'Not configured' }}
                            </p>
                        </div>

                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <p class="text-sm text-slate-500">Address</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ optional($settings->firstWhere('key','site.address'))->value['value'] ?? 'Not configured' }}
                            </p>
                        </div>

                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <p class="text-sm text-slate-500">Phone</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ optional($settings->firstWhere('key','site.phone'))->value['value'] ?? 'Not configured' }}
                            </p>
                        </div>

                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="mt-1 font-medium text-slate-900">
                                {{ optional($settings->firstWhere('key','site.email'))->value['value'] ?? 'Not configured' }}
                            </p>
                        </div>

                    </div>
                </div>

                <!-- MISSION -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h2 class="text-lg font-medium text-slate-800">Mission Statement</h2>
                    </div>

                    <!-- BODY (soft green tint) -->
                    <div class="p-6 bg-emerald-50/40">
                        <p class="text-slate-700 leading-relaxed bg-white border border-slate-200 rounded-lg p-4">
                            {{ optional($settings->firstWhere('key','site.mission_statement'))->value['value'] ?? 'Not configured' }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="space-y-6">

                <!-- OPERATING HOURS -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-base font-medium text-slate-800">Operating Hours</h3>
                    </div>

                    <div class="p-5 bg-amber-50/40">
                        <p class="text-slate-900 font-medium bg-white border border-slate-200 rounded-lg p-3">
                            {{ optional($settings->firstWhere('key','site.visiting_hours'))->value['value'] ?? 'Not configured' }}
                        </p>
                    </div>
                </div>

                <!-- EMERGENCY -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-base font-medium text-slate-800">Emergency Contact</h3>
                    </div>

                    <div class="p-5 bg-red-50/40">
                        <p class="text-slate-900 font-medium bg-white border border-slate-200 rounded-lg p-3">
                            {{ optional($settings->firstWhere('key','site.emergency_contact'))->value['value'] ?? 'Not configured' }}
                        </p>
                    </div>
                </div>

                <!-- WEBSITE -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-base font-medium text-slate-800">Website</h3>
                    </div>

                    <div class="p-5 bg-indigo-50/40">
                        <p class="text-slate-900 font-medium bg-white border border-slate-200 rounded-lg p-3 break-all">
                            {{ optional($settings->firstWhere('key','site.website_url'))->value['value'] ?? 'Not configured' }}
                        </p>
                    </div>
                </div>

                <!-- TIMEZONE -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">
                        <h3 class="text-base font-medium text-slate-800">Timezone</h3>
                    </div>

                    <div class="p-5 bg-slate-100/60">
                        <p class="text-slate-900 font-medium bg-white border border-slate-200 rounded-lg p-3">
                            {{ optional($settings->firstWhere('key','site.timezone'))->value['value'] ?? 'Not configured' }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection