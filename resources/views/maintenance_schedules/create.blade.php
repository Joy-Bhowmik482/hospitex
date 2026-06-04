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
                <h2 class="text-3xl font-bold text-slate-800">Schedule Maintenance</h2>
                <p class="text-slate-600">Create a new maintenance schedule for hospital equipment</p>
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
        <form action="{{ route('maintenance-schedules.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Asset Selection -->
                <div>
                    <label for="asset_id" class="block text-sm font-medium text-slate-700 mb-2">Equipment/Asset *</label>
                    <select id="asset_id" name="asset_id" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Equipment</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}">{{ $asset->name }} ({{ $asset->asset_code }})</option>
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
                        <option value="preventive">Preventive Maintenance</option>
                        <option value="corrective">Corrective Maintenance</option>
                        <option value="predictive">Predictive Maintenance</option>
                        <option value="calibration">Calibration</option>
                        <option value="inspection">Inspection</option>
                        <option value="emergency">Emergency Repair</option>
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
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-medium text-slate-700 mb-2">Department</label>
                    <select id="department" name="department"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Department</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Surgery">Surgery</option>
                        <option value="Radiology">Radiology</option>
                        <option value="Laboratory">Laboratory</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="ICU">ICU</option>
                        <option value="Pharmacy">Pharmacy</option>
                        <option value="Administration">Administration</option>
                    </select>
                    @error('department')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_date" class="block text-sm font-medium text-slate-700 mb-2">Scheduled Date & Time *</label>
                    <input type="datetime-local" id="scheduled_date" name="scheduled_date" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}">
                    @error('scheduled_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scheduled End Date -->
                <div>
                    <label for="scheduled_end_date" class="block text-sm font-medium text-slate-700 mb-2">End Date & Time (Optional)</label>
                    <input type="datetime-local" id="scheduled_end_date" name="scheduled_end_date"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('scheduled_end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technician Name -->
                <div>
                    <label for="technician_name" class="block text-sm font-medium text-slate-700 mb-2">Technician Name</label>
                    <input type="text" id="technician_name" name="technician_name"
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
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                    @error('estimated_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Describe the maintenance work to be performed"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Additional Notes</label>
                <textarea id="notes" name="notes" rows="2"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Any additional notes or special instructions"></textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('maintenance-schedules.index') }}"
                   class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Schedule Maintenance
                </button>
            </div>
        </form>
    </div>
</div>

@endsection