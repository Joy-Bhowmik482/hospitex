<div class="max-w-2xl mx-auto">
  <form action="{{ route('search') ?? '#' }}" method="GET" class="relative">
    <label for="global-search" class="sr-only">Search</label>
    <div class="flex items-center bg-white border border-slate-200 rounded-full shadow-sm px-3 py-1.5 focus-within:ring-2 focus-within:ring-indigo-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.386-1.414 1.415-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
      </svg>
      <input id="global-search" name="q" type="search" placeholder="Search patients, appointments, inventory..." class="w-full px-3 py-2 text-sm bg-transparent outline-none placeholder-slate-400" />
      <button type="submit" class="ml-2 inline-flex items-center px-3 py-1 rounded-full bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition">Search</button>
    </div>
  </form>
</div>
