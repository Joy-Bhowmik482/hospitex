<!-- Data Table -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full">

            <!-- Table Header -->
            <thead>
                <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                    @foreach($columns ?? [] as $column)
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">
                            {{ $column['label'] }}
                        </th>
                    @endforeach
                    @if($showActions ?? true)
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                    @endif
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-slate-200">

                @forelse($items ?? [] as $item)

                    <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">

                        @foreach($columns ?? [] as $column)
                            <td class="px-6 py-4">
                                @if($column['type'] === 'avatar')
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($item->{$column['field']}->first_name ?? 'U', 0, 1) }}{{ substr($item->{$column['field']}->last_name ?? '', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">
                                                {{ $item->{$column['field']}->first_name ?? 'N/A' }} {{ $item->{$column['field']}->last_name ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                @elseif($column['type'] === 'status')
                                    @include('appointments.partials._status_badge', ['status' => $item->{$column['field']}])
                                @elseif($column['type'] === 'date')
                                    <div class="text-sm text-slate-700">{{ $item->{$column['field']}->format('d M Y') }}</div>
                                    @if(isset($column['timeField']))
                                        <div class="text-slate-500 text-xs">{{ $item->{$column['timeField']}->format('H:i') }}</div>
                                    @endif
                                @elseif($column['type'] === 'text')
                                    <span class="text-sm text-slate-700">{{ $item->{$column['field']} }}</span>
                                @else
                                    <span class="text-sm text-slate-700">{{ $item->{$column['field']} ?? 'N/A' }}</span>
                                @endif
                            </td>
                        @endforeach

                        @if($showActions ?? true)
                            <td class="px-6 py-4">
                                @include('appointments.partials._actions', ['appointment' => $item, 'showStatusChange' => $showStatusChange ?? false])
                            </td>
                        @endif

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ (count($columns ?? []) + ($showActions ?? true ? 1 : 0)) }}" class="px-6 py-8 text-center text-slate-500">
                            No data available
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    <!-- Footer with Pagination -->
    @if($items && method_exists($items, 'links'))
        <div class="bg-slate-50 border-t border-slate-200 px-6 py-4 flex items-center justify-between">
            <p class="text-sm text-slate-600">
                Showing 
                <span class="font-semibold text-slate-800">{{ $items->count() }}</span> 
                of 
                <span class="font-semibold text-slate-800">{{ $items->total() }}</span> results
            </p>
            {{ $items->links() }}
        </div>
    @endif

</div>
