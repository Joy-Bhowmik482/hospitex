@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">User Details</h2>
            <p class="text-slate-600">Review the selected user's profile and access roles.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-5 py-3 rounded-xl hover:bg-yellow-600 transition">Edit</a>
            <a href="{{ route('users.index') }}" class="bg-slate-200 text-slate-800 px-5 py-3 rounded-xl hover:bg-slate-300 transition">Back</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Name</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Email</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Phone</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $user->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Status</p>
                <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Last Login</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ optional($user->last_login_at)->format('M d, Y H:i') ?? 'Never' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Roles</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @forelse ($user->roles as $role)
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">{{ $role->name }}</span>
                    @empty
                        <span class="text-slate-600">No roles assigned</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
