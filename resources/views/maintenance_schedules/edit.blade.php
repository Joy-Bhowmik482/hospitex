@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('maintenance-schedules.index') }}" class="text-slate-600 hover:text-slate-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Edit Maintenance Schedule</h2>
                <p class="text-slate-600">Update maintenance schedule details</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        <form action="{{ route('maintenance-schedules.update', $maintenanceSchedule) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Asset Selection -->
                <div>
                    <label for="asset_id" class="block text-sm font-medium text-slate-700 mb-2">Equipment/Asset *</label>
                    <select id="asset_id" name="asset_id" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Equipment</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ $maintenanceSchedule->asset_id == $asset->id ? 'selected' : '' }}>
                                {{ $asset->name }} ({{ $asset->asset_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Maintenance Type -->
                <div>
                    <label for="maintenance_type" class="block text-sm font-medium text-slate-700 mb-2">Maintenance Type *</label>
                    <select id="maintenance_type" name="maintenance_type" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <option value="preventive" {{ $maintenanceSchedule->maintenance_type == 'preventive' ? 'selected' : '' }}>Preventive Maintenance</option>
                        <option value="corrective" {{ $maintenanceSchedule->maintenance_type == 'corrective' ? 'selected' : '' }}>Corrective Maintenance</option>
                        <option value="predictive" {{ $maintenanceSchedule->maintenance_type == 'predictive' ? 'selected' : '' }}>Predictive Maintenance</option>
                        <option value="calibration" {{ $maintenanceSchedule->maintenance_type == 'calibration' ? 'selected' : '' }}>Calibration</option>
                        <option value="inspection" {{ $maintenanceSchedule->maintenance_type == 'inspection' ? 'selected' : '' }}>Inspection</option>
                        <option value="emergency" {{ $maintenanceSchedule->maintenance_type == 'emergency' ? 'selected' : '' }}>Emergency Repair</option>
                    </select>
                    @error('maintenance_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-slate-700 mb-2">Priority *</label>
                    <select id="priority" name="priority" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="low" {{ $maintenanceSchedule->priority == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $maintenanceSchedule->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $maintenanceSchedule->priority == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ $maintenanceSchedule->priority == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status *</label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="scheduled" {{ $maintenanceSchedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="in_progress" {{ $maintenanceSchedule->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $maintenanceSchedule->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="overdue" {{ $maintenanceSchedule->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ $maintenanceSchedule->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-medium text-slate-700 mb-2">Department</label>
                    <select id="department" name="department"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Department</option>
                        <option value="Emergency" {{ $maintenanceSchedule->department == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                        <option value="Surgery" {{ $maintenanceSchedule->department == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                        <option value="Radiology" {{ $maintenanceSchedule->department == 'Radiology' ? 'selected' : '' }}>Radiology</option>
                        <option value="Laboratory" {{ $maintenanceSchedule->department == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                        <option value="Cardiology" {{ $maintenanceSchedule->department == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                        <option value="ICU" {{ $maintenanceSchedule->department == 'ICU' ? 'selected' : '' }}>ICU</option>
                        <option value="Pharmacy" {{ $maintenanceSchedule->department == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                        <option value="Administration" {{ $maintenanceSchedule->department == 'Administration' ? 'selected' : '' }}>Administration</option>
                    </select>
                    @error('department')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-slate-700 mb-2">Scheduled Date & Time *</label>
                    <input type="datetime-local" id="scheduled_date" name="scheduled_date" required
                           value="{{ $maintenanceSchedule->scheduled_date->format('Y-m-d\TH:i') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('scheduled_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scheduled End Date -->
                <div>
                    <label for="scheduled_end_date" class="block text-sm font-medium text-slate-700 mb-2">End Date & Time (Optional)</label>
                    <input type="datetime-local" id="scheduled_end_date" name="scheduled_end_date"
                           value="{{ $maintenanceSchedule->scheduled_end_date ? $maintenanceSchedule->scheduled_end_date->format('Y-m-d\TH:i') : '' }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('scheduled_end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technician Name -->
                <div>
                    <label for="technician_name" class="block text-sm font-medium text-slate-700 mb-2">Technician Name</label>
                    <input type="text" id="technician_name" name="technician_name"
                           value="{{ old('technician_name', $maintenanceSchedule->technician_name) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter technician name">
                    @error('technician_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technician Contact -->
                <div>
                    <label for="technician_contact" class="block text-sm font-medium text-slate-700 mb-2">Technician Contact</label>
                    <input type="text" id="technician_contact" name="technician_contact"
                           value="{{ old('technician_contact', $maintenanceSchedule->technician_contact) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Phone or email">
                    @error('technician_contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estimated Cost -->
                <div>
                    <label for="estimated_cost" class="block text-sm font-medium text-slate-700 mb-2">Estimated Cost ($)</label>
                    <input type="number" id="estimated_cost" name="estimated_cost" step="0.01" min="0"
                           value="{{ old('estimated_cost', $maintenanceSchedule->estimated_cost) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                    @error('estimated_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actual Cost -->
                <div>
                    <label for="actual_cost" class="block text-sm font-medium text-slate-700 mb-2">Actual Cost ($)</label>
                    <input type="number" id="actual_cost" name="actual_cost" step="0.01" min="0"
                           value="{{ old('actual_cost', $maintenanceSchedule->actual_cost) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                    @error('actual_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Describe the maintenance work to be performed">{{ old('description', $maintenanceSchedule->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Work Performed -->
            <div class="mt-6">
                <label for="work_performed" class="block text-sm font-medium text-slate-700 mb-2">Work Performed</label>
                <textarea id="work_performed" name="work_performed" rows="3"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Describe the work that was actually performed">{{ old('work_performed', $maintenanceSchedule->work_performed) }}</textarea>
                @error('work_performed')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parts Used -->
            <div class="mt-6">
                <label for="parts_used" class="block text-sm font-medium text-slate-700 mb-2">Parts Used</label>
                <textarea id="parts_used" name="parts_used" rows="2"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="List any parts or materials used">{{ old('parts_used', $maintenanceSchedule->parts_used) }}</textarea>
                @error('parts_used')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Additional Notes</label>
                <textarea id="notes" name="notes" rows="2"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Any additional notes or special instructions">{{ old('notes', $maintenanceSchedule->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Completed Date (only show if status is completed) -->
            @if($maintenanceSchedule->status === 'completed')
            <div class="mt-6">
                <label for="completed_date" class="block text-sm font-medium text-slate-700 mb-2">Completed Date</label>
                <input type="datetime-local" id="completed_date" name="completed_date"
                       value="{{ $maintenanceSchedule->completed_date ? $maintenanceSchedule->completed_date->format('Y-m-d\TH:i') : '' }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('completed_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

            <!-- Form Actions -->
            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('maintenance-schedules.index') }}"
                   class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>
</div>

@endsection