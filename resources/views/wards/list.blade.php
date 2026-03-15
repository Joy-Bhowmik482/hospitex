@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Ward Management</h2>
            <p class="text-slate-600">Manage hospital wards and their configurations.</p>
        </div>
        <a href="{{ route('wards.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Ward
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Wards Message -->
    @if ($wards->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🏥</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Wards Found</h3>
            <p class="text-slate-600 mb-6">There are no wards in the system yet. Click the button below to add a new ward.</p>
            <a href="{{ route('wards.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Ward
            </a>
        </div>
    @else
        <!-- Wards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($wards as $ward)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 border-b border-slate-200">
                        <h3 class="text-xl font-bold text-slate-800">{{ $ward->name }}</h3>
                        <p class="text-sm text-slate-600 mt-1">Ward Code: <span class="font-semibold">{{ $ward->code }}</span></p>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <!-- Floor -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-slate-700">Floor:</span>
                            <span class="text-sm text-slate-600">{{ $ward->floor ?? 'N/A' }}</span>
                        </div>

                        <!-- Gender Policy -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-slate-700">Gender Policy:</span>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $ward->gender_policy === 'Male' ? 'bg-blue-100 text-blue-800' : ($ward->gender_policy === 'Female' ? 'bg-pink-100 text-pink-800' : 'bg-slate-100 text-slate-800') }}">
                                {{ $ward->gender_policy }}
                            </span>
                        </div>

                        <!-- Rooms Count -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-slate-700">Rooms:</span>
                            <span class="text-sm text-slate-600">{{ $ward->rooms->count() }}</span>
                        </div>

                        <!-- Beds Count -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-slate-700">Total Beds:</span>
                            <span class="text-sm text-slate-600">{{ $ward->rooms->sum(function($r) { return $r->beds->count(); }) }}</span>
                        </div>

                        <!-- Created Date -->
                        <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                            <span class="text-xs text-slate-600">Created: {{ $ward->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex gap-3">
                        <a href="{{ route('wards.show', $ward) }}" class="flex-1 text-center bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded-lg hover:bg-blue-200 transition">
                            View
                        </a>
                        <a href="{{ route('wards.edit', $ward) }}" class="flex-1 text-center bg-amber-100 text-amber-700 font-semibold py-2 px-4 rounded-lg hover:bg-amber-200 transition">
                            Edit
                        </a>
                        <form action="{{ route('wards.destroy', $ward) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 text-red-700 font-semibold py-2 px-4 rounded-lg hover:bg-red-200 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
