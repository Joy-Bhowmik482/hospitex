<div class="md:hidden bg-white/60 border-t border-slate-100">
  <div class="flex items-center justify-between px-4 py-2">
    <div class="flex items-center gap-2">
      <button id="mobileSidebarToggle" class="p-2 rounded-md text-slate-700 hover:bg-slate-100 transition" aria-label="Toggle sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <div class="text-sm font-semibold text-slate-700">{{ $title }}</div>
    </div>
    <div class="flex items-center gap-2">
      <button onclick="document.querySelector('[data-dropdown]')?.setAttribute('data-open','true')" class="p-2 rounded-md hover:bg-slate-100 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118.6 14.6V11a6 6 0 10-12 0v3.6c0 .538-.214 1.055-.595 1.445L4 17h11z" />
        </svg>
      </button>
      <a href="#" class="p-2 rounded-md hover:bg-slate-100 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-5-5H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v7a2 2 0 01-2 2h-3l-5 5z" />
        </svg>
      </a>
    </div>
  </div>
</div>

<script>
  document.getElementById('mobileSidebarToggle')?.addEventListener('click', function(){
    document.documentElement.classList.toggle('sidebar-open');
  });
</script>
