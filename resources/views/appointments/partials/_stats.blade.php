<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    @foreach($stats ?? [] as $stat)
        <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-600 uppercase">{{ $stat['label'] }}</h3>
                <div class="text-2xl">{{ $stat['icon'] ?? '📊' }}</div>
            </div>
            <div class="text-3xl font-bold text-slate-900 mb-2">{{ $stat['value'] }}</div>
            @if(isset($stat['trend']))
                <div class="text-xs {{ $stat['trend'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $stat['trend'] > 0 ? '↑' : '↓' }} {{ abs($stat['trend']) }}% from last week
                </div>
            @endif
        </div>
    @endforeach

</div>
