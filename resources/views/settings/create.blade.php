@extends('includePage')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Add New Setting</h1>
            <p class="mt-2 text-slate-600 max-w-2xl">
                Create a new configuration entry and assign it to the appropriate section. The setting will be available immediately after saving.
            </p>
        </div>

        <a href="{{ route('settings.index') }}"
           class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
            Back to Settings
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

        <!-- Card Header -->
        <div class="px-8 py-6 border-b border-slate-200 bg-slate-50">
            <p class="text-xs uppercase tracking-widest text-slate-500">Create Setting</p>
            <h2 class="mt-2 text-xl font-semibold text-slate-900">
                Add a new configuration entry
            </h2>
        </div>

        <!-- Card Body -->
        <div class="p-8">

            <!-- Errors -->
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('settings.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Row -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Section -->
                    <div>
                        <label for="group" class="block text-sm font-semibold text-slate-700 mb-2">
                            Section
                        </label>

                        <select id="group"
                                name="group"
                                required
                                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">Select a section</option>

                            @foreach($groupMeta as $groupKey => $metadata)
                                <option value="{{ $groupKey }}" {{ old('group') === $groupKey ? 'selected' : '' }}>
                                    {{ $metadata['title'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Key -->
                    <div>
                        <label for="key" class="block text-sm font-semibold text-slate-700 mb-2">
                            Setting Key
                        </label>

                        <input id="key"
                               name="key"
                               type="text"
                               value="{{ old('key') }}"
                               placeholder="e.g. site.new_setting_key"
                               required
                               class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </div>
                </div>

                <!-- Value -->
                <div>
                    <label for="value" class="block text-sm font-semibold text-slate-700 mb-2">
                        Value
                    </label>

                    <textarea id="value"
                              name="value"
                              rows="6"
                              required
                              class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('value') }}</textarea>

                    <p class="mt-2 text-sm text-slate-500">
                        You can store plain text or JSON (for structured settings).
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('settings.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg transition">
                        Create Setting
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection