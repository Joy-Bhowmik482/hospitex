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
<aside class="w-64 bg-gradient-to-b from-blue-800 via-blue-900 to-indigo-900 min-h-screen shadow-lg fixed text-white">

    <!-- Brand / Logo -->
    <div class="p-6 text-center text-2xl font-bold tracking-wide border-b border-white/20">
        HOSPITEX
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-2 space-y-1">

        <!-- Dashboard -->
        <a href="{{ url('/dashboard') }}" 
           class="block px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium">
            Dashboard
        </a>

        <!-- Patient Management -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Patient Management
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('patients.create') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Add Patient</a>
                <a href="{{ route('patients.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Patient List</a>               
            </div>
        </details>

        <!-- Doctor & Staff -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Doctor & Staff
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('doctors.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Doctors Directory</a>
                <a href="{{ route('departments.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Departments</a>
                <a href="{{ route('doctor-schedules.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Doctor Schedule</a>
                <a href="{{ route('staff.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Staff Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Duty Roster</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Roles & Permissions</a>
            </div>
        </details>

        <!-- Users & Security -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Users & Security
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">User Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Role Based Access Control (RBAC)</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Activity Logs</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Login History</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Audit Trail</a>
            </div>
        </details>

        <!-- Appointments -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Appointments
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Book Appointment</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Appointment Calendar</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Queue Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">OPD Appointments</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Follow-up Appointments</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Appointment Status</a>
            </div>
        </details>

        <!-- Admission & Beds -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Admission & Beds
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('wards.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Ward Management</a>
                <a href="{{ route('rooms.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Room Types</a>
                <a href="{{ route('beds.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Bed Availability</a>
                <a href="{{ route('admissions.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Admissions</a>
                <a href="{{ route('bed-allocations.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Bed Allocation</a>
                <a href="{{ route('bed-allocations.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Transfer Patient</a>
            </div>
        </details>

        <!-- Billing & Accounts -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Billing & Accounts
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="{{ route('services.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Services Management</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">OPD / IPD Billing</a>
                <a href="{{ route('invoices.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Invoices</a>
                <a href="{{ route('payments.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Payments</a>
                <a href="{{ route('insurance-providers.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Insurance / Corporate Billing</a>
                <a href="{{ route('services.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Service Rates & Taxes</a>
            </div>
        </details>

        <!-- Inventory & Assets -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Inventory & Assets
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Medical Equipment</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Consumables</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Stock In / Out</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Asset Tracking</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Maintenance Schedule</a>
            </div>
        </details>

        <!-- Reports -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Reports
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Daily / Monthly Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Patient Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Financial Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Lab Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Pharmacy Reports</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Export (PDF / Excel)</a>
            </div>
        </details>

        <!-- Settings -->
        <details class="group">
            <summary class="flex justify-between items-center px-4 py-2 rounded-lg hover:bg-white/20 transition font-medium cursor-pointer">
                Settings
                <span class="transition-transform duration-200 group-open:rotate-90">➤</span>
            </summary>
            <div class="pl-4 mt-1 space-y-1">
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Hospital Profile</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Departments Setup</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Service Charges</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Tax Settings</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Payment Gateways</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">SMS / Email Config</a>
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/20 transition">Theme & Branding</a>
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
