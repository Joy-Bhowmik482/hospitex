@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Insurance Providers</h2>
            <p class="text-slate-500 mt-1">Manage insurance and corporate billing providers</p>
        </div>
        <a href="{{ route('insurance-providers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
            ➕ Add Provider
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="mb-6">
        <input type="text" placeholder="Search providers..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-100 border-b border-slate-300">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Policy Rules</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Created Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($insuranceProviders as $provider)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $provider->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($provider->policy_rules, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $provider->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('insurance-providers.show', $provider) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            <a href="{{ route('insurance-providers.edit', $provider) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('insurance-providers.destroy', $provider) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">No insurance providers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $insuranceProviders->links() }}
    </div>
</div>

@endsection
