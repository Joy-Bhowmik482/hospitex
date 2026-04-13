@extends('includePage')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Edit Setting</h2>
            <p class="mt-2 text-slate-600 max-w-2xl">Modify this configuration entry to keep the hospital system aligned with your branding, billing, or communication settings.</p>
        </div>
        <a href="{{ route('settings.index') }}" class="inline-flex items-center rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">Back to Settings</a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-slate-50">
            <p class="text-sm uppercase tracking-[0.22em] text-slate-500">Setting in focus</p>
            <h3 class="mt-2 text-xl font-semibold text-slate-900">{{ data_get($settingMeta, $setting->key.'.label', $setting->key) }}</h3>
            <p class="mt-2 text-sm text-slate-600">{{ data_get($settingMeta, $setting->key.'.description', 'Update the raw value saved to the database for this key.') }}</p>
        </div>

        <div class="p-8">
            <form action="{{ route('settings.update', $setting) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label for="key" class="block text-sm font-semibold text-slate-700 mb-2">Setting Key</label>
                        <input id="key" type="text" value="{{ $setting->key }}" disabled class="w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-slate-700 outline-none" />
                    </div>
                    <div>
                        <label for="group" class="block text-sm font-semibold text-slate-700 mb-2">Section</label>
                        <input id="group" type="text" value="{{ data_get($groupMeta, $setting->group.'.title', $setting->group ?? 'General') }}" disabled class="w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-slate-700 outline-none" />
                    </div>
                </div>

                @php
                    $meta = data_get($settingMeta, $setting->key, []);
                    $rawValue = $setting->value;
                    $displayValue = is_array($rawValue) ? data_get($rawValue, 'value', json_encode($rawValue)) : $rawValue;
                    $fieldType = data_get($meta, 'type', 'text');
                @endphp

                <div>
                    <label for="value" class="block text-sm font-semibold text-slate-700 mb-2">Value</label>
                    @if($fieldType === 'textarea')
                        <textarea id="value" name="value" rows="5" required class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('value', $displayValue) }}</textarea>
                    @else
                        <input id="value" name="value" type="{{ in_array($fieldType, ['email','tel','number','url']) ? $fieldType : 'text' }}" value="{{ old('value', $displayValue) }}" required class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    @endif
                    @error('value')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-slate-500">Use a simple text value or paste JSON for structured data. Stored values are saved directly to the database.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                        <h4 class="text-sm font-semibold text-slate-800 mb-3">Current data</h4>
                        <pre class="whitespace-pre-wrap break-words text-sm text-slate-600">{{ json_encode($setting->value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                        <h4 class="text-sm font-semibold text-slate-800 mb-3">Value purpose</h4>
                        <p class="text-sm text-slate-600">This setting is loaded from the database when the application reads configuration values. Keep it accurate to ensure the system behaves correctly.</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('settings.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:shadow-xl transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
