@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">User Management</h2>
            <p class="text-slate-600">Manage system users, active status, and role assignments.</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New User
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($users->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">👤</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Users Found</h3>
            <p class="text-slate-600 mb-6">There are no users in the system yet. Create a new user to start managing access.</p>
            <a href="{{ route('users.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First User
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Name</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Email</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Last Login</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Roles</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ optional($user->last_login_at)->format('M d, Y H:i') ?? 'Never' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">
                                    @foreach ($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 mr-1">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('users.show', $user) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 transition">View</a>
                                        <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">Edit</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-red-600 transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection
