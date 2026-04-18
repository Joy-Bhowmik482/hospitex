@extends('includePage')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Add New Setting</h2>
            <p class="mt-2 text-slate-600 max-w-2xl">Create a new configuration entry and assign it to the correct section. New settings are stored in the database and available immediately.</p>
        </div>
        <a href="{{ route('settings.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">Back to Settings</a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-slate-50">
            <p class="text-sm uppercase tracking-[0.22em] text-slate-500">Create Setting</p>
            <h3 class="mt-2 text-xl font-semibold text-slate-900">Add a new configuration entry</h3>
        </div>

        <div class="p-8">
            @if($errors->any())
                <div class="rounded-3xl bg-rose-50 border border-rose-200 p-4 mb-6 text-sm text-rose-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('settings.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label for="group" class="block text-sm font-semibold text-slate-700 mb-2">Section</label>
                        <select id="group" name="group" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">Select a section</option>
                            @foreach($groupMeta as $groupKey => $metadata)
                                <option value="{{ $groupKey }}" {{ old('group') === $groupKey ? 'selected' : '' }}>{{ $metadata['title'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="key" class="block text-sm font-semibold text-slate-700 mb-2">Setting Key</label>
                        <input id="key" name="key" type="text" value="{{ old('key') }}" placeholder="site.new_setting_key" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    </div>
                </div>

                <div>
                    <label for="value" class="block text-sm font-semibold text-slate-700 mb-2">Value</label>
                    <textarea id="value" name="value" rows="5" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('value') }}</textarea>
                    <p class="mt-2 text-sm text-slate-500">Enter the raw value for the setting. Use JSON objects only for advanced structured settings.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('settings.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:shadow-xl transition">Create Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
