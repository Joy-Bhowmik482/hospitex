@props(['title' => '', 'breadcrumbs' => []])
<header class="sticky top-0 z-40 bg-white/75 backdrop-blur-sm border-b border-slate-200 shadow-sm">
  <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Left -->
      <div class="flex items-center gap-3">
        <!-- Sidebar toggle -->
        <button id="sidebarToggle" class="p-2 rounded-md text-slate-700 hover:bg-slate-100 transition" aria-label="Toggle sidebar">
          <!-- Menu Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <!-- Logo (optional) -->
        <div class="hidden sm:flex items-center gap-3">
          <div class="h-8 w-8 rounded-md bg-indigo-50 flex items-center justify-center text-indigo-600 font-semibold">H</div>
          <div class="text-sm font-semibold text-slate-700">Hospitex</div>
        </div>

        <!-- Title & Breadcrumbs -->
        <div class="ml-2">
          <div class="text-lg font-semibold text-slate-800">{{ $title }}</div>
          @if(!empty($breadcrumbs))
            <nav class="text-xs text-slate-500 mt-0.5" aria-label="Breadcrumb">
              @foreach($breadcrumbs as $idx => $bc)
                @if($idx + 1 === count($breadcrumbs))
                  <span class="text-slate-700">{{ $bc['label'] }}</span>
                @else
                  <a href="{{ $bc['url'] ?? '#' }}" class="hover:text-slate-900">{{ $bc['label'] }}</a>
                  <span class="mx-2">/</span>
                @endif
              @endforeach
            </nav>
          @endif
        </div>
      </div>

      <!-- Center: Search -->
      <div class="flex-1 px-4">
        @include('components.header.search')
      </div>

      <!-- Right -->
      <div class="flex items-center gap-3">
        @include('components.header.quick-actions')
        @include('components.header.notifications')
        @include('components.header.messages')
        @include('components.header.user-dropdown')
      </div>
    </div>
  </div>

  <!-- Mobile header (compact) -->
  @include('components.header.mobile')

</header>

<script>
  // Minimal JS for header interactions (vanilla)
  (function(){
    document.addEventListener('click', function(e){
      // close dropdowns when clicking outside
      document.querySelectorAll('[data-dropdown]').forEach(function(el){
        if(!el.contains(e.target) && el.getAttribute('data-open') === 'true'){
          el.setAttribute('data-open','false');
        }
      });
    });

    document.getElementById('sidebarToggle')?.addEventListener('click', function(){
      document.documentElement.classList.toggle('sidebar-collapsed');
    });
  })();
</script>
