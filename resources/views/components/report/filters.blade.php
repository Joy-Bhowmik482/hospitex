<!-- Report Filters Component -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 sticky top-20 z-40">
    <form method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Quick Date Range Filter -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Period</label>
                <select name="date_range" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last7days">Last 7 Days</option>
                    <option value="last30days">Last 30 Days</option>
                    <option value="thismonth">This Month</option>
                    <option value="lastmonth">Last Month</option>
                    <option value="thisyear">This Year</option>
                </select>
            </div>

            <!-- Custom Date Range -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Start Date</label>
                <input type="date" name="start_date" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">End Date</label>
                <input type="date" name="end_date" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <!-- Additional Filters -->
            @if(isset($additionalFilters))
                @foreach($additionalFilters as $filter)
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">{{ $filter['label'] }}</label>
                        <select name="{{ $filter['name'] }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">All</option>
                            @foreach($filter['options'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="flex gap-3 pt-4 border-t border-slate-200">
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply Filters
            </button>
            <a href="{{ request()->url() }}" class="inline-flex items-center justify-center rounded-lg bg-slate-200 px-6 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-300 transition">
                Reset
            </a>
        </div>
    </form>
</div>
