<!-- Search Bar -->
<div class="mb-6">
    <form action="{{ $searchAction ?? '#' }}" method="GET" class="flex items-center gap-3">
        
        <div class="flex-1 relative">
            <svg class="absolute left-4 top-3.5 h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" 
                   name="search" 
                   value="{{ request('search', '') }}"
                   placeholder="Search by patient name, appointment no, doctor..."
                   class="w-full pl-11 pr-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <button type="submit" 
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition">
            🔍 Search
        </button>

    </form>
</div>
