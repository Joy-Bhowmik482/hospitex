@extends('includePage')

@section('content')

<style>
    @media print {
        .no-print { display: none; }
        body { background: white; }
    }
</style>

<div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="no-print">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Daily Hospital Summary</h1>
                <p class="mt-2 text-slate-600">{{ date('l, F j, Y') }} - Real-time operational dashboard</p>
            </div>

            <div class="mt-6 flex gap-3">
                <button onclick="window.print()" class="inline-flex items-center justify-center rounded-lg bg-slate-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4H7a2 2 0 01-2-2v-4a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 01-2 2zm0 0h2"></path>
                    </svg>
                    Print Report
                </button>
                <a href="{{ route('reports.export-daily-pdf') }}" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Main Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            <x-report.summary-card 
                label="Today's Patients"
                value="{{ number_format($report['summary']['today_patients']) }}"
                icon="👥"
            />
            <x-report.summary-card 
                label="Admissions"
                value="{{ number_format($report['summary']['today_admissions']) }}"
                icon="🏥"
            />
            <x-report.summary-card 
                label="Discharges"
                value="{{ number_format($report['summary']['today_discharges']) }}"
                icon="✅"
            />
            <x-report.summary-card 
                label="Appointments"
                value="{{ number_format($report['summary']['today_appointments']) }}"
                icon="📅"
            />
        </div>

        <!-- Critical Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-report.summary-card 
                label="Revenue"
                value="${{ number_format($report['summary']['today_revenue'], 2) }}"
                icon="💰"
                description="Today's billing"
            />
            <x-report.summary-card 
                label="Emergency Cases"
                value="{{ number_format($report['summary']['emergency_cases']) }}"
                icon="🆘"
                description="Active emergency admissions"
            />
            <x-report.summary-card 
                label="Active Patients"
                value="{{ number_format($report['summary']['active_patients']) }}"
                icon="🏨"
                description="Currently admitted"
            />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-report.chart 
                chartId="hourly-activity"
                title="Hourly Patient Activity"
                type="line"
                :data="$report['charts']['hourly_activity']"
            />
            <x-report.chart 
                chartId="appointment-status"
                title="Appointment Status"
                type="doughnut"
                :data="$report['charts']['appointment_status']"
            />
            <x-report.chart 
                chartId="staff-attendance"
                title="Staff Attendance"
                type="doughnut"
                :data="$report['charts']['staff_attendance']"
            />
        </div>

        <!-- Appointments & Admissions Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Today's Appointments</h2>
                <x-report.table 
                    :columns="[
                        ['key' => 'id', 'label' => 'Appointment ID'],
                        ['key' => 'patient_id', 'label' => 'Patient'],
                        ['key' => 'doctor_id', 'label' => 'Doctor'],
                        ['key' => 'status', 'label' => 'Status'],
                        ['key' => 'appointment_date', 'label' => 'Time'],
                    ]"
                    :rows="$report['data']['appointments']->items() ?? []"
                    :pagination="$report['data']['appointments'] ?? null"
                />
            </div>

            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Today's Admissions</h2>
                <x-report.table 
                    :columns="[
                        ['key' => 'id', 'label' => 'Admission ID'],
                        ['key' => 'patient_id', 'label' => 'Patient'],
                        ['key' => 'department_id', 'label' => 'Department'],
                        ['key' => 'status', 'label' => 'Status'],
                        ['key' => 'admitted_at', 'label' => 'Date'],
                    ]"
                    :rows="$report['data']['admissions']->items() ?? []"
                    :pagination="$report['data']['admissions'] ?? null"
                />
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

@endsection
