@php
    $user = auth()->user();
@endphp

@guest
    <div class="flex items-center gap-2">
        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900 transition">Sign in</a>
        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-slate-900 px-4 py-2 rounded-full hover:bg-slate-800 transition">Register</a>
    </div>
@else
    <div class="relative" data-dropdown data-open="false">
      <button onclick="this.closest('[data-dropdown]').setAttribute('data-open', this.closest('[data-dropdown]').getAttribute('data-open')==='true'?'false':'true')" class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-3 py-2 shadow-sm hover:shadow-md transition">
        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-semibold uppercase">
          {{ substr($user->name ?? 'U', 0, 1) }}
        </div>
        <div class="hidden sm:flex flex-col text-left">
          <span class="text-sm font-semibold text-slate-900">{{ $user->name }}</span>
          <span class="text-xs text-slate-500">{{ $user->role ?? 'Administrator' }}</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <div class="origin-top-right absolute right-0 mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 opacity-0 scale-95 pointer-events-none transition-all duration-200" style="transform-origin: top right;">
        <div class="p-4">
          <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-semibold uppercase">{{ substr($user->name ?? 'U', 0, 1) }}</div>
            <div>
              <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
              <div class="text-xs text-slate-500">{{ $user->email }}</div>
            </div>
          </div>
          <div class="grid gap-2 py-3">
            <a href="#" class="block px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">My Profile</a>
            <a href="#" class="block px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">Account Settings</a>
            <a href="#" class="block px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-slate-50 transition">Activity Log</a>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">Logout</button>
          </form>
        </div>
      </div>
    </div>
@endguest

<script>
  document.addEventListener('click', function(event) {
    document.querySelectorAll('[data-dropdown]').forEach(function(dropdown) {
      var open = dropdown.getAttribute('data-open') === 'true';
      if (!dropdown.contains(event.target) && open) {
        dropdown.setAttribute('data-open', 'false');
      }
    });
  });

  document.querySelectorAll('[data-dropdown] > button').forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      var dropdown = this.closest('[data-dropdown]');
      var open = dropdown.getAttribute('data-open') === 'true';
      dropdown.setAttribute('data-open', open ? 'false' : 'true');
    });
  });

  var observer = new MutationObserver(function() {
    document.querySelectorAll('[data-dropdown]').forEach(function(dropdown) {
      var open = dropdown.getAttribute('data-open') === 'true';
      var menu = dropdown.querySelector('div[style*="transform-origin"]');
      if (menu) {
        if (open) {
          menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
          menu.classList.add('opacity-100', 'scale-100');
        } else {
          menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
          menu.classList.remove('opacity-100', 'scale-100');
        }
      }
    });
  });

  document.querySelectorAll('[data-dropdown]').forEach(function(node) {
    observer.observe(node, { attributes: true, attributeFilter: ['data-open'] });
  });
</script>
