<!-- Report Table Component -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    @if(count($rows) > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        @foreach($columns as $column)
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                {{ $column['label'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($rows as $row)
                        <tr class="hover:bg-slate-50 transition">
                            @foreach($columns as $column)
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    @if(isset($column['render']))
                                        {!! $column['render']($row) !!}
                                    @else
                                        {{ $row->{$column['key']} ?? '-' }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($pagination) && $pagination->lastPage() > 1)
            <div class="bg-slate-50 border-t border-slate-200 px-6 py-4 flex items-center justify-between">
                <p class="text-sm text-slate-600">
                    Showing <span class="font-semibold">{{ $pagination->firstItem() }}</span> to 
                    <span class="font-semibold">{{ $pagination->lastItem() }}</span> of 
                    <span class="font-semibold">{{ $pagination->total() }}</span> results
                </p>
                <div class="flex gap-2">
                    @if($pagination->onFirstPage())
                        <button disabled class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-400 bg-slate-100">← Previous</button>
                    @else
                        <a href="{{ $pagination->previousPageUrl() }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 hover:bg-slate-100 transition">← Previous</a>
                    @endif

                    <div class="flex gap-1">
                        @foreach($pagination->getUrlRange(1, $pagination->lastPage()) as $page => $url)
                            @if($page == $pagination->currentPage())
                                <button disabled class="rounded-lg bg-blue-600 text-white px-4 py-2 text-sm font-semibold">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 hover:bg-slate-100 transition">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>

                    @if($pagination->hasMorePages())
                        <a href="{{ $pagination->nextPageUrl() }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 hover:bg-slate-100 transition">Next →</a>
                    @else
                        <button disabled class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-400 bg-slate-100">Next →</button>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-14 w-14 text-slate-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-semibold text-slate-900 mb-1">No data available</h3>
            <p class="text-sm text-slate-600">Try adjusting your filters to see results.</p>
        </div>
    @endif
</div>
