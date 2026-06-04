@php
  $user = (object)[ 'name' => 'Dr. Emily Carter', 'role' => 'Administrator', 'avatar' => null ];
@endphp

<div class="relative" data-dropdown data-open="false">
  <button onclick="this.closest('[data-dropdown]').setAttribute('data-open', this.closest('[data-dropdown]').getAttribute('data-open')==='true'?'false':'true')" class="flex items-center gap-2 p-1 rounded hover:bg-slate-100 transition">
    <img src="{{ $user->avatar ?? asset('images/avatar-placeholder.png') }}" alt="avatar" class="h-8 w-8 rounded-full object-cover" />
    <div class="hidden sm:flex flex-col text-left">
      <span class="text-sm font-medium text-slate-700">{{ $user->name }}</span>
      <span class="text-xs text-slate-400">{{ $user->role }}</span>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
  </button>

  <div class="origin-top-right absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 transform scale-95 opacity-0 transition-all pointer-events-none" style="transform-origin: top right;">
    <div class="py-3 px-3">
      <div class="flex items-center gap-3 p-2">
        <img src="{{ $user->avatar ?? asset('images/avatar-placeholder.png') }}" alt="avatar" class="h-10 w-10 rounded-full object-cover" />
        <div>
          <div class="text-sm font-semibold text-slate-800">{{ $user->name }}</div>
          <div class="text-xs text-slate-500">{{ $user->role }}</div>
        </div>
      </div>

      <div class="mt-2 border-t border-slate-100"></div>
      <ul class="py-2">
        <li><a href="#" class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded">My Profile</a></li>
        <li><a href="#" class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded">Settings</a></li>
        <li><a href="#" class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded">Activity Logs</a></li>
      </ul>
      <div class="mt-2 border-t border-slate-100"></div>
      <div class="py-2 px-3">
        <form method="POST" action="{{ route('logout') ?? '#' }}">
          @csrf
          <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>
