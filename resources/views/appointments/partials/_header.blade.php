<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ $title ?? 'Appointments' }}</h2>
        <p class="text-slate-600">{{ $subtitle ?? 'Manage patient appointments' }}</p>
    </div>

    <div class="flex gap-3">
        @foreach($actions ?? [] as $action)
            <a href="{{ $action['url'] }}" 
               class="bg-gradient-to-r {{ $action['color'] ?? 'from-blue-500 to-blue-600' }} text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                {{ $action['label'] }}
            </a>
        @endforeach
    </div>
</div>
