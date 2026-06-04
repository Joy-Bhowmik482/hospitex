@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Role Based Access Control (RBAC)</h2>
            <p class="text-slate-600">Manage roles, permissions, and access controls for the system.</p>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <a href="{{ route('security.roles') }}" class="block rounded-3xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-md transition">
            <div class="text-5xl mb-4">🛡️</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Roles</h3>
            <p class="text-slate-600">Create, edit, and delete user roles to group permissions across the hospital system.</p>
        </a>

        <a href="{{ route('security.permissions') }}" class="block rounded-3xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-md transition">
            <div class="text-5xl mb-4">🔐</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Permissions</h3>
            <p class="text-slate-600">Manage individual access permissions that are assigned to roles for fine-grained control.</p>
        </a>
    </div>

    <div class="mt-8 bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        <h3 class="text-2xl font-semibold text-slate-800 mb-4">RBAC Overview</h3>
        <p class="text-slate-600 mb-4">Use roles to group permissions and assign those roles to users. This keeps access control simple, consistent, and easy to maintain.</p>
        <ul class="list-disc pl-5 space-y-2 text-slate-600">
            <li>Roles define job functions or responsibilities in the hospital.</li>
            <li>Permissions define what each role can do in the system.</li>
            <li>Users are assigned roles to inherit permissions without assigning individual rules.</li>
        </ul>
    </div>
</div>

@endsection
