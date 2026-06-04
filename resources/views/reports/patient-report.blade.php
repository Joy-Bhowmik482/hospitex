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
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900">Patient Reports</h1>
                    <p class="mt-2 text-slate-600">Comprehensive patient statistics, admissions, and demographics analysis</p>
                </div>
                <div class="flex gap-3">
                    @include('components.report.export-buttons', [
                        'pdfExportUrl' => route('reports.export-patient-pdf', request()->query())
                    ])
                </div>
            </div>

            <!-- Filters -->
            @include('components.report.filters', [
                'additionalFilters' => [
                    [
                        'name' => 'doctor_id',
                        'label' => 'Doctor',
                        'options' => $doctors->pluck('name', 'id')->toArray()
                    ],
                    [
                        'name' => 'department_id',
                        'label' => 'Department',
                        'options' => $departments->pluck('name', 'id')->toArray()
                    ],
                    [
                        'name' => 'ward_id',
                        'label' => 'Ward',
                        'options' => $wards->pluck('name', 'id')->toArray()
                    ]
                ]
            ])
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-report.summary-card 
                label="Total Patients"
                value="{{ number_format($report['summary']['total_patients']) }}"
                icon="👥"
                description="All registered patients"
            />
            <x-report.summary-card 
                label="New Patients"
                value="{{ number_format($report['summary']['new_patients']) }}"
                icon="✨"
                description="Registered in this period"
            />
            <x-report.summary-card 
                label="Admitted Patients"
                value="{{ number_format($report['summary']['admitted_patients']) }}"
                icon="🏥"
                description="Currently in hospital"
            />
            <x-report.summary-card 
                label="Discharged Patients"
                value="{{ number_format($report['summary']['discharged_patients']) }}"
                icon="✅"
                description="Completed treatment"
            />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-report.chart 
                chartId="registration-trend"
                title="Patient Registration Trend"
                type="line"
                :data="$report['charts']['registration_trend']"
            />
            <x-report.chart 
                chartId="admission-trend"
                title="Admission Trend"
                type="line"
                :data="$report['charts']['admission_trend']"
            />
            <x-report.chart 
                chartId="gender-distribution"
                title="Gender Distribution"
                type="doughnut"
                :data="$report['charts']['gender_distribution']"
            />
            <x-report.chart 
                chartId="age-distribution"
                title="Age Group Distribution"
                type="bar"
                :data="$report['charts']['age_distribution']"
            />
            <x-report.chart 
                chartId="department-distribution"
                title="Department Wise Patient Distribution"
                type="bar"
                :data="$report['charts']['department_distribution']"
            />
            <x-report.chart 
                chartId="discharge-trend"
                title="Discharge Trend"
                type="line"
                :data="$report['charts']['discharge_trend']"
            />
        </div>

        <!-- Additional Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-report.summary-card 
                label="ICU Patients"
                value="{{ number_format($report['summary']['icu_patients']) }}"
                icon="🚨"
            />
            <x-report.summary-card 
                label="Emergency Cases"
                value="{{ number_format($report['summary']['emergency_patients']) }}"
                icon="🆘"
            />
            <x-report.summary-card 
                label="Male Patients"
                value="{{ number_format($report['summary']['male_patients']) }}"
                icon="👨"
            />
            <x-report.summary-card 
                label="Female Patients"
                value="{{ number_format($report['summary']['female_patients']) }}"
                icon="👩"
            />
        </div>

        <!-- Data Table -->
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Patient List</h2>
            <x-report.table 
                :columns="[
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'first_name', 'label' => 'Name'],
                    ['key' => 'email', 'label' => 'Email'],
                    ['key' => 'phone', 'label' => 'Phone'],
                    ['key' => 'gender', 'label' => 'Gender'],
                    ['key' => 'age', 'label' => 'Age'],
                ]"
                :rows="$report['data']['patients']->items()"
                :pagination="$report['data']['patients']"
            />
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

@endsection
