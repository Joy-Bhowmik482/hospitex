@extends('includePage')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Setting</h1>
            <p class="mt-2 text-slate-600 max-w-2xl">
                Update this configuration entry to ensure the system stays aligned with your operational settings.
            </p>
        </div>

        <a href="{{ route('settings.index') }}"
           class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
            Back to Settings
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-200 bg-slate-50">
            <p class="text-xs uppercase tracking-widest text-slate-500">Setting in focus</p>

            <h2 class="mt-2 text-xl font-semibold text-slate-900">
                {{ data_get($settingMeta, $setting->key.'.label', $setting->key) }}
            </h2>

            <p class="mt-2 text-sm text-slate-600">
                {{ data_get($settingMeta, $setting->key.'.description', 'Update the stored configuration value for this setting.') }}
            </p>
        </div>

        <!-- Body -->
        <div class="p-8">

            <!-- Form -->
            <form action="{{ route('settings.update', $setting) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                @php
                    $meta = data_get($settingMeta, $setting->key, []);
                    $rawValue = $setting->value;

                    $displayValue = is_array($rawValue)
                        ? json_encode($rawValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                        : $rawValue;

                    $fieldType = data_get($meta, 'type', 'text');
                @endphp

                <!-- Key + Group (readonly) -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Setting Key
                        </label>
                        <input type="text"
                               value="{{ $setting->key }}"
                               disabled
                               class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-700" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Section
                        </label>
                        <input type="text"
                               value="{{ data_get($groupMeta, $setting->group.'.title', $setting->group ?? 'General') }}"
                               disabled
                               class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-700" />
                    </div>

                </div>

                <!-- Value -->
                <div>
                    <label for="value" class="block text-sm font-semibold text-slate-700 mb-2">
                        Value
                    </label>

                    @if($fieldType === 'textarea')
                        <textarea id="value"
                                  name="value"
                                  rows="6"
                                  required
                                  class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('value', $displayValue) }}</textarea>
                    @else
                        <input id="value"
                               name="value"
                               type="{{ in_array($fieldType, ['email','tel','number','url']) ? $fieldType : 'text' }}"
                               value="{{ old('value', $displayValue) }}"
                               required
                               class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                    @endif

                    @error('value')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-sm text-slate-500">
                        You may store plain text or structured JSON depending on system configuration needs.
                    </p>
                </div>

                <!-- Info Panels -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <h3 class="text-sm font-semibold text-slate-800 mb-3">Current Stored Value</h3>
                        <pre class="text-sm text-slate-600 whitespace-pre-wrap break-words">
{{ json_encode($setting->value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                        </pre>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <h3 class="text-sm font-semibold text-slate-800 mb-3">Important Note</h3>
                        <p class="text-sm text-slate-600">
                            This value is used directly by the system. Incorrect updates may affect system behavior, billing logic, or UI configuration.
                        </p>
                    </div>

                </div>

                <!-- Actions -->
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('settings.index') }}"
                       class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-700 hover:shadow-lg transition">
                        Save Changes
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection