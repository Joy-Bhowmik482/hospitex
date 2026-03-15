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
                    <h3 class="text-3xl font-bold mt-2">{{ $availableBeds }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    🛏️
                </div>
            </div>
        </div>

    </div>

    <!-- Ward Management Section -->
    <div class="mt-12">
        <h3 class="text-2xl font-bold text-slate-800 mb-6">Ward Management Overview</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Wards Card -->
            <a href="{{ route('wards.index') }}" class="bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition p-6 cursor-pointer border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Wards</p>
                        <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalWards }}</h4>
                        <p class="text-xs text-slate-500 mt-2">Click to manage wards</p>
                    </div>
                    <span class="text-3xl">🏢</span>
                </div>
            </a>

            <!-- Rooms Card -->
            <a href="{{ route('rooms.index') }}" class="bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition p-6 cursor-pointer border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Rooms</p>
                        <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalRooms }}</h4>
                        <p class="text-xs text-slate-500 mt-2">Click to manage rooms</p>
                    </div>
                    <span class="text-3xl">🚪</span>
                </div>
            </a>

            <!-- Admissions Card -->
            <a href="{{ route('admissions.index') }}" class="bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition p-6 cursor-pointer border-l-4 border-orange-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Active Admissions</p>
                        <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $activeAdmissions }}</h4>
                        <p class="text-xs text-slate-500 mt-2">Click to manage admissions</p>
                    </div>
                    <span class="text-3xl">👤</span>
                </div>
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h4 class="text-lg font-semibold text-slate-800 mb-4">Quick Actions</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('wards.create') }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    ➕ Add Ward
                </a>
                <a href="{{ route('rooms.create') }}" class="bg-green-50 hover:bg-green-100 text-green-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    ➕ Add Room
                </a>
                <a href="{{ route('beds.create') }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    ➕ Add Bed
                </a>
                <a href="{{ route('admissions.create') }}" class="bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    ➕ New Admission
                </a>
            </div>
        </div>
    </div>

    <!-- Patient Billing Section -->
    <div class="mt-12">
        <h3 class="text-2xl font-bold text-slate-800 mb-6">Patient Billing Overview</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Invoices Card -->
            <a href="{{ route('invoices.index') }}" class="bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition p-6 cursor-pointer border-l-4 border-indigo-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Invoices</p>
                        <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalInvoices }}</h4>
                        <p class="text-xs text-red-600 mt-2 font-semibold">{{ $unpaidInvoices }} Unpaid</p>
                    </div>
                    <span class="text-3xl">📄</span>
                </div>
            </a>

            <!-- Payments Card -->
            <a href="{{ route('payments.index') }}" class="bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition p-6 cursor-pointer border-l-4 border-green-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Payments</p>
                        <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalPayments }}</h4>
                        <p class="text-xs text-green-600 mt-2 font-semibold">{{ number_format($totalPaidAmount, 2) }} Collected</p>
                    </div>
                    <span class="text-3xl">💰</span>
                </div>
            </a>

            <!-- Services Card -->
            <a href="{{ route('services.index') }}" class="bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition p-6 cursor-pointer border-l-4 border-orange-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Active Services</p>
                        <h4 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalServices }}</h4>
                        <p class="text-xs text-slate-500 mt-2">Service Types Available</p>
                    </div>
                    <span class="text-3xl">⚕️</span>
                </div>
            </a>
        </div>

        <!-- Quick Billing Actions -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h4 class="text-lg font-semibold text-slate-800 mb-4">Billing Quick Actions</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('invoices.create') }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    ➕ Create Invoice
                </a>
                <a href="{{ route('payments.create') }}" class="bg-green-50 hover:bg-green-100 text-green-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    💳 Record Payment
                </a>
                <a href="{{ route('services.create') }}" class="bg-orange-50 hover:bg-orange-100 text-orange-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    ➕ Add Service
                </a>
                <a href="{{ route('insurance-providers.index') }}" class="bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-3 px-4 rounded-lg transition text-center">
                    🏢 Insurance
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
