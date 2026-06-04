@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Roles</h2>
            <p class="text-slate-600">Manage the role definitions used by the RBAC system.</p>
        </div>
        <a href="{{ route('roles.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 transition">Open Roles List</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">👥</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Role definitions</h3>
            <p class="text-slate-600">Define roles for department groups, staff responsibilities, and access levels.</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">🔁</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Role assignment</h3>
            <p class="text-slate-600">Assign roles to users so permissions are inherited automatically and consistently.</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        <h3 class="text-2xl font-semibold text-slate-800 mb-4">How roles work</h3>
        <p class="text-slate-600 mb-4">Roles group permissions and make it easy to manage access at scale. Instead of assigning permissions directly to each user, assign a role once and reuse it across the organization.</p>
        <ul class="list-disc pl-5 space-y-2 text-slate-600">
            <li>Roles represent job functions like Administrator, Receptionist, or Accountant.</li>
            <li>Each role can include many permissions, such as viewing patients or managing invoices.</li>
            <li>Users assigned a role automatically inherit all permissions attached to that role.</li>
        </ul>
    </div>
</div>

@endsection
