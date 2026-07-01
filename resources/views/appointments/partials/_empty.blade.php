<!-- Empty State -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">

    <div class="text-6xl mb-4">{{ $icon ?? '📅' }}</div>

    <h3 class="text-xl font-semibold text-slate-800 mb-2">
        {{ $title ?? 'No appointments found' }}
    </h3>

    <p class="text-slate-600 mb-6">
        {{ $message ?? 'Try adjusting your filters or create a new appointment.' }}
    </p>

    @if($action ?? false)
        <a href="{{ $action['url'] }}"
           class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
            {{ $action['label'] }}
        </a>
    @endif

</div>
