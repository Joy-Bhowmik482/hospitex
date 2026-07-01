<!-- Filters -->
<div class="bg-white rounded-xl shadow-md border border-slate-200 p-4 mb-6">
    <form action="{{ $filterAction ?? '#' }}" method="GET" class="flex flex-wrap items-center gap-4">
        
        <!-- Preserve search parameter -->
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <!-- Status Filter -->
        @if($showStatusFilter ?? true)
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Status</label>
                <select name="status" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    @foreach($statuses ?? ['Pending', 'Confirmed', 'Checked In', 'Waiting', 'In Consultation', 'Completed', 'Cancelled', 'No Show', 'Rescheduled'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Date Range Filter -->
        @if($showDateFilter ?? true)
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">From Date</label>
                <input type="date" 
                       name="date_from" 
                       value="{{ request('date_from', '') }}"
                       class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">To Date</label>
                <input type="date" 
                       name="date_to" 
                       value="{{ request('date_to', '') }}"
                       class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        @endif

        <!-- Department Filter -->
        @if($showDepartmentFilter ?? true)
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Department</label>
                <select name="department_id" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Departments</option>
                    @foreach($departments ?? \App\Models\Department::orderBy('name')->get() as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Doctor Filter -->
        @if($showDoctorFilter ?? true)
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Doctor</label>
                <select name="doctor_id" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Doctors</option>
                    @foreach($doctors ?? \App\Models\Doctor::where('is_active', true)->orderBy('name')->get() as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="flex gap-2 pt-6">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                ✓ Apply Filters
            </button>
            <a href="{{ str_replace('?', '?', url()->current()) }}" 
               class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-semibold px-4 py-2 rounded-lg text-sm transition">
                ✕ Clear
            </a>
        </div>

    </form>
</div>
