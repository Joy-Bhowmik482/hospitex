@php
  $notifications = [
    ['type' => 'Appointment', 'text' => 'New appointment: John Doe at 10:30', 'time' => '5m'],
    ['type' => 'Inventory', 'text' => 'Low stock: Paracetamol', 'time' => '1h'],
    ['type' => 'Emergency', 'text' => 'ER: Bed needed - incoming', 'time' => '2h'],
  ];
  $unread = 3;
@endphp

<div class="relative" data-dropdown data-open="false">
  <button onclick="this.closest('[data-dropdown]').setAttribute('data-open', this.closest('[data-dropdown]').getAttribute('data-open')==='true'?'false':'true')" class="p-2 rounded-full hover:bg-slate-100 transition relative">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118.6 14.6V11a6 6 0 10-12 0v3.6c0 .538-.214 1.055-.595 1.445L4 17h11z" />
    </svg>
    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">{{ $unread }}</span>
  </button>

  <div class="origin-top-right absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 transform scale-95 opacity-0 transition-all pointer-events-none" style="transform-origin: top right;" x-show="false">
    <div class="py-3 px-3">
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold text-slate-700">Notifications</div>
        <a href="#" class="text-xs text-indigo-600 hover:underline">View All</a>
      </div>

      <ul class="mt-3 space-y-2 max-h-60 overflow-auto">
        @foreach($notifications as $n)
          <li class="flex items-start gap-3 p-2 rounded hover:bg-slate-50 transition">
            <div class="h-8 w-8 rounded-md bg-slate-100 flex items-center justify-center text-slate-700 text-sm">{{ substr($n['type'],0,1) }}</div>
            <div class="flex-1 text-sm">
              <div class="text-slate-700">{{ $n['text'] }}</div>
              <div class="text-xs text-slate-400">{{ $n['time'] }}</div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

<style>
  /* Toggle dropdown visibility using data attributes */
  [data-dropdown][data-open="true"] > div[style] { transform: scale(1); opacity:1; pointer-events:auto; }
</style>
