@php
  $messages = [
    ['from'=>'Nurse Anna','text'=>'Patient 234 needs review','time'=>'10m'],
    ['from'=>'Lab','text'=>'Blood results ready','time'=>'2h']
  ];
  $unreadMessages = 2;
@endphp

<div class="relative" data-dropdown data-open="false">
  <button onclick="this.closest('[data-dropdown]').setAttribute('data-open', this.closest('[data-dropdown]').getAttribute('data-open')==='true'?'false':'true')" class="p-2 rounded-full hover:bg-slate-100 transition relative">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-5-5H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v7a2 2 0 01-2 2h-3l-5 5z" />
    </svg>
    <span class="absolute -top-1 -right-1 bg-amber-500 text-white text-xs rounded-full px-1">{{ $unreadMessages }}</span>
  </button>

  <div class="origin-top-right absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 transform scale-95 opacity-0 transition-all pointer-events-none" style="transform-origin: top right;">
    <div class="py-3 px-3">
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold text-slate-700">Messages</div>
        <a href="#" class="text-xs text-indigo-600 hover:underline">See all</a>
      </div>

      <ul class="mt-3 space-y-2 max-h-60 overflow-auto">
        @foreach($messages as $m)
          <li class="flex items-start gap-3 p-2 rounded hover:bg-slate-50 transition">
            <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 text-sm">{{ strtoupper(substr($m['from'],0,1)) }}</div>
            <div class="flex-1 text-sm">
              <div class="text-slate-700 font-medium">{{ $m['from'] }}</div>
              <div class="text-slate-500 text-sm">{{ $m['text'] }}</div>
              <div class="text-xs text-slate-400">{{ $m['time'] }}</div>
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

