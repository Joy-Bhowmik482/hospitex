<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hospitex Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#2563eb',
                    secondary: '#1e3a8a',
                    darknav: '#0f172a'
                }
            }
        }
    }
</script>
<style>
    /* Smooth collapse/expand animation */
    details > *:not(summary) {
        overflow: hidden;
        transition: all 0.5s ease-out;
        max-height: 1000px;
        opacity: 1;
    }

    details:not([open]) > *:not(summary) {
        max-height: 0;
        opacity: 0;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* Smooth rotation for arrow icon */
    details summary span {
        transition: transform 0.5s ease-out;
        display: inline-block;
    }

    details[open] summary span {
        transform: rotate(90deg);
    }

    
</style>
</head>
<body class="bg-slate-100 font-sans">

<!-- Top Navbar -->
<nav class="fixed top-0 left-0 right-0 bg-darknav text-white shadow-md z-50">
    <div class="flex justify-between items-center px-6 py-4">
        <h1 class="text-lg font-semibold tracking-wide">Hospitex - Admin Panel</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm opacity-80">Welcome, Admin</span>
            <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center">
                <span class="text-white font-bold">A</span>
            </div>
        </div>
    </div>
</nav>

<div class="flex pt-16">

<!-- Sidebar -->
<aside class="w-64 bg-gradient-to-b from-blue-800 via-blue-900 to-indigo-900 h-screen overflow-y-auto shadow-lg fixed text-white
 [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-slate-800 [&::-webkit-scrollbar-thumb]:bg-gradient-to-b [&::-webkit-scrollbar-thumb]:from-blue-500 [&::-webkit-scrollbar-thumb]:to-indigo-500 [&::-webkit-scrollbar-thumb]:rounded-full">

    <!-- Brand / Logo -->
    <div class="p-6 text-center text-2xl font-bold tracking-wide border-b border-white/20">
        HOSPITEX
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-2 space-y-1">

        <!-- Dashboard -->
        <a href="{{ url('/dashboard') }}" 
   class="flex items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium">
    <!-- Dashboard Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h7v7H3V3zM14 3h7v4h-7V3zM14 12h7v9h-7v-9zM3 12h7v9H3v-9z" />
    </svg>
    Dashboard
</a>

        <!-- Patient Management -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Patient Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /> <!-- simple person/medical icon -->
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0121 12.082M12 14v7m0 0l-6.16-3.422A12.083 12.083 0 013 19.082M12 21l0-7" />
        </svg>
        Patient Management
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('patients.create') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Add Patient</a>
                <a href="{{ route('patients.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Patient List</a>               
            </div>
        </details>

        <!-- Doctor & Staff -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Doctor & Staff Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M12 12a4 4 0 100-8 4 4 0 000 8z" />
        </svg>
        Doctor & Staff
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('doctors.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Doctors Directory</a>
                <a href="{{ route('departments.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Departments</a>
                <a href="{{ route('doctor-schedules.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Doctor Schedule</a>
                <a href="{{ route('staff.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Staff Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Duty Roster</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Roles & Permissions</a>
            </div>
        </details>

        <!-- Users & Security -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Users & Security Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11V7" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 11h6" />
        </svg>
        Users & Security
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- User Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Role Based Access Control (RBAC)</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Activity Logs</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Login History</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Audit Trail</a>
            </div>
        </details>

        <!-- Appointments -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Appointments Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Appointments
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('appointments.create') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Book Appointment</a>
                <a href="{{ route('appointments.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- All Appointments</a>
                <a href="{{ route('appointments.queue') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Queue Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- OPD Appointments</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Follow-up Appointments</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Appointment Status</a>
            </div>
        </details>

        <!-- Admission & Beds -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Admission & Beds Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 7v14h18V7M3 7l9-4 9 4" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 10v4M17 10v4" />
        </svg>
        Admission & Beds
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('wards.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Ward Management</a>
                <a href="{{ route('rooms.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Room Types</a>
                <a href="{{ route('beds.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Bed Availability</a>
                <a href="{{ route('admissions.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Admissions</a>
                <a href="{{ route('bed-allocations.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Bed Allocation</a>
                <a href="{{ route('bed-allocations.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Transfer Patient</a>
            </div>
        </details>

        <!-- Billing & Accounts -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Billing & Accounts Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4V6z" />
        </svg>
        Billing & Accounts
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('services.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Services Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- OPD / IPD Billing</a>
                <a href="{{ route('invoices.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Invoices</a>
                <a href="{{ route('payments.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Payments</a>
                <a href="{{ route('insurance-providers.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Insurance / Corporate Billing</a>
                <a href="{{ route('services.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Service Rates & Taxes</a>
            </div>
        </details>

        <!-- Inventory & Assets -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Inventory & Assets Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        Inventory & Assets
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('assets.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Asset Tracking</a>
                <a href="{{ route('inventory-items.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Consumables</a>
                <a href="{{ route('inventory-movements.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Stock Movements</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Maintenance Schedule</a>
            </div>
        </details>

        <!-- Reports -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Reports Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 17h2v-6h-2v6zM5 12h2v-2H5v2zM17 12h2v-2h-2v2z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18V3H3v18z" />
        </svg>
        Reports
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Daily / Monthly Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Patient Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Financial Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Lab Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Pharmacy Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Export (PDF / Excel)</a>
            </div>
        </details>

        <!-- Settings -->
        <details class="group">
                <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
    <div class="flex items-center">
        <!-- Settings Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33h.07a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.07a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
        </svg>
        Settings
    </div>
    <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
</summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Hospital Profile</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Departments Setup</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Service Charges</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Tax Settings</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Payment Gateways</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- SMS / Email Config</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">- Theme & Branding</a>
            </div>
        </details>

    </nav>
</aside>

<!-- Main Content -->
<main class="ml-64 flex-1 p-8">
    <div class="mt-8">
        @yield('content')
    </div>
</main>

</div>

<script>
// Smart Sidebar Accordion with Detailed Control
document.addEventListener('DOMContentLoaded', function() {
    const navDetails = document.querySelectorAll('aside nav > details');
    let currentOpenDetail = null;

    navDetails.forEach(detail => {
        const summary = detail.querySelector('summary');
        const contentDiv = detail.querySelector('div');

        // When clicking the summary (main menu header)
        summary.addEventListener('click', function(e) {
            // If this menu is already open, clicking summary again will close it (toggle)
            // If this menu is closed, clicking will open it and close others
            
            if (detail.open) {
                // Already open - will close when this click finishes
                currentOpenDetail = null;
            } else {
                // Currently closed - close all others and open this one
                navDetails.forEach(otherDetail => {
                    if (otherDetail !== detail) {
                        otherDetail.open = false;
                    }
                });
                currentOpenDetail = detail;
            }
        });

        // When clicking links inside the menu content
        const links = contentDiv.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                // Prevent the summary toggle event from affecting the menu
                // The menu will stay open because we're not clicking on summary
                // This link click doesn't trigger the <details> toggle
                e.stopPropagation();
            });
        });
    });
});
</script>
</body>
</html>
