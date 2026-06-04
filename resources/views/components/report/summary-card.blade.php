<!-- Summary Card Component -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">{{ $label }}</p>
            <p class="mt-3 text-3xl font-bold text-slate-900">{{ $value }}</p>
            @if(isset($previous) && isset($change))
                <p class="mt-2 flex items-center text-sm">
                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold 
                        @if($change > 0) bg-green-100 text-green-700
                        @elseif($change < 0) bg-red-100 text-red-700
                        @else bg-slate-100 text-slate-700
                        @endif">
                        {{ $change > 0 ? '↑' : ($change < 0 ? '↓' : '→') }}
                        {{ abs($change) }}%
                    </span>
                    <span class="ml-2 text-slate-600">vs last period</span>
                </p>
            @endif
            @if(isset($description))
                <p class="mt-1 text-sm text-slate-600">{{ $description }}</p>
            @endif
        </div>
        @if(isset($icon))
            <div class="text-4xl ml-4">{{ $icon }}</div>
        @endif
    </div>
</div>
