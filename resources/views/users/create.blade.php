@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Create New User</h2>
        <p class="text-slate-600">Add a new system user and assign roles for access control.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6 bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        @csrf

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select name="is_active" class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none">
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Assign Roles</label>
            <div class="grid gap-3 md:grid-cols-2">
                @foreach ($roles as $role)
                    <label class="inline-flex items-center gap-2 rounded-xl border border-slate-200 p-3">
                        <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-slate-700">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('users.index') }}" class="text-slate-700 hover:text-slate-900 font-semibold">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-600 transition">Create User</button>
        </div>
    </form>
</div>

@endsection
