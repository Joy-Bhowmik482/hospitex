@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">
                Dashboard Overview
            </h2>
            <p class="text-slate-500 mt-1">
                Welcome to Hospitex Hospital Management System
            </p>
        </div>

        <div class="text-sm text-slate-500">
            {{ now()->format('l, d M Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Patients -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
            <div class="flex justify-between items-center">
                <div>
    <p class="text-sm opacity-80">Total Patients</p>
    <h3 class="text-3xl font-bold mt-2">
        {{ $totalPatients }}
    </h3>
</div>
                <div class="bg-white/20 p-3 rounded-xl">
                    🏥
                </div>
            </div>
        </div>

        <!-- Doctors -->
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-6 rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Total Doctors</p>
                    <h3 class="text-3xl font-bold mt-2">25</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    👨‍⚕️
                </div>
            </div>
        </div>

        <!-- Appointments -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Appointments Today</p>
                    <h3 class="text-3xl font-bold mt-2">34</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    📅
                </div>
            </div>
        </div>

        <!-- Beds -->
        <div class="bg-gradient-to-r from-rose-500 to-rose-600 text-white p-6 rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-80">Available Beds</p>
                    <h3 class="text-3xl font-bold mt-2">18</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    🛏️
                </div>
            </div>
        </div>

    </div>

    <!-- Extra Section (Optional Future Content Area) -->
    <div class="mt-10 bg-white p-6 rounded-2xl shadow-sm">
        <h4 class="text-lg font-semibold text-slate-700 mb-4">
            Recent Activity
        </h4>

        <p class="text-slate-500 text-sm">
            No recent activity available.
        </p>
    </div>

</div>

@endsection
