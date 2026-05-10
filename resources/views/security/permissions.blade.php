@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Permissions</h2>
            <p class="text-slate-600">Manage the individual system permissions used by RBAC roles.</p>
        </div>
        <a href="{{ route('permissions.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 transition">Open Permissions List</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Permission definitions</h3>
            <p class="text-slate-600">Define permissions for actions such as managing patients, appointments, billing, and settings.</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">⚙️</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Permission assignment</h3>
            <p class="text-slate-600">Permissions are assigned to roles, and roles are assigned to users for consistent access control.</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        <h3 class="text-2xl font-semibold text-slate-800 mb-4">How permissions work</h3>
        <p class="text-slate-600 mb-4">Permissions allow you to control what users can do in the system without granting access on a per-user basis. Assign permissions to roles and keep access management centralized.</p>
        <ul class="list-disc pl-5 space-y-2 text-slate-600">
            <li>Each permission represents a single capability, such as creating appointments or editing invoices.</li>
            <li>Roles bundle these permissions together for job functions like Receptionist or Administrator.</li>
            <li>Users receive permissions by being assigned roles, so management is scalable.</li>
        </ul>
    </div>
</div>

@endsection
