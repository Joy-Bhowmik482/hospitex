<!-- Action Buttons -->
<div class="flex items-center justify-center gap-2 flex-wrap">

    <!-- View -->
    @if($showView ?? true)
        <a href="{{ route('appointments.show', $appointment) }}"
           class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
            👁️ View
        </a>
    @endif

    <!-- Edit -->
    @if($showEdit ?? true)
        <a href="{{ route('appointments.edit', $appointment) }}"
           class="inline-block bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
            ✏️ Edit
        </a>
    @endif

    <!-- Status Change -->
    @if($showStatusChange ?? false)
        <form action="{{ route('appointments.changeStatus', $appointment) }}" method="POST" class="inline-block">
            @csrf
            <select name="status" class="border border-slate-300 rounded-md px-2 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    onchange="this.form.submit()">
                <option value="">Change Status</option>
                <option value="Pending" {{ $appointment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ $appointment->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="Checked In" {{ $appointment->status === 'Checked In' ? 'selected' : '' }}>Checked In</option>
                <option value="In Consultation" {{ $appointment->status === 'In Consultation' ? 'selected' : '' }}>In Consultation</option>
                <option value="Completed" {{ $appointment->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ $appointment->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    @endif

    <!-- Print -->
    @if($showPrint ?? true)
        <button onclick="window.print()"
                class="inline-block bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
            🖨️ Print
        </button>
    @endif

    <!-- Delete -->
    @if($showDelete ?? true)
        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
              class="inline-block"
              onsubmit="return confirm('Are you sure? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-1.5 px-3 rounded-md transition text-xs whitespace-nowrap">
                🗑️ Delete
            </button>
        </form>
    @endif

</div>
