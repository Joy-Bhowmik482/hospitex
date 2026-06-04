<!-- Report Header Component -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold text-slate-900">{{ $title }}</h1>
            <p class="mt-2 text-slate-600">{{ $description }}</p>
        </div>
        <div class="flex gap-3">
            @if(isset($actions))
                @foreach($actions as $action)
                    @if($action['type'] === 'button')
                        <a href="{{ $action['href'] }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition">
                            {{ $action['label'] }}
                        </a>
                    @elseif($action['type'] === 'dropdown')
                        <div class="relative group">
                            <button class="inline-flex items-center justify-center rounded-lg bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-200 transition">
                                {{ $action['label'] }}
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50">
                                @foreach($action['items'] as $item)
                                    <a href="{{ $item['href'] }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 first:rounded-t-lg last:rounded-b-lg">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
