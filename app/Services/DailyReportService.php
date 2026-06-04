<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Staff;
use Carbon\Carbon;

class DailyReportService extends BaseReportService
{
    /**
     * Generate summary statistics
     */
    public function generateSummary(): array
    {
        $today = Carbon::today();

        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
        $todayAdmissions = Admission::whereDate('admission_date', $today)->count();
        $todayDischarges = Admission::whereDate('discharge_at', $today)->count();
        $todayRevenue = Invoice::whereDate('created_at', $today)->sum('total_amount');

        $activePatients = Admission::whereNull('discharge_at')->count();
        $emergencyAdmissions = Admission::where('status', 'Emergency')->whereDate('admitted_at', $today)->count();

        return [
            'date' => $today->format('Y-m-d'),
            'today_patients' => Patient::whereDate('created_at', $today)->count(),
            'today_admissions' => $todayAdmissions,
            'today_discharges' => $todayDischarges,
            'today_appointments' => $todayAppointments,
            'today_surgeries' => 0, // Placeholder - no surgeries model yet
            'today_revenue' => $todayRevenue,
            'today_pharmacy_sales' => 0, // Placeholder - no pharmacy module
            'today_lab_tests' => 0, // Placeholder - no lab module
            'active_patients' => $activePatients,
            'emergency_cases' => $emergencyAdmissions,
        ];
    }

    /**
     * Generate detailed report data
     */
    public function generateData(): array
    {
        $today = Carbon::today();

        $appointments = Appointment::whereDate('appointment_date', $today)
            ->with('patient', 'doctor')
            ->orderBy('appointment_date')
            ->paginate(15);

        $admissions = Admission::whereDate('admitted_at', $today)
            ->with('patient', 'bed')
            ->paginate(15);

        return [
            'appointments' => $appointments,
            'admissions' => $admissions,
        ];
    }

    /**
     * Generate chart data
     */
    public function generateCharts(): array
    {
        $today = Carbon::today();

        $hourlyPatientActivity = $this->getHourlyPatientActivity();
        $appointmentStatus = $this->getAppointmentStatus();
        $staffAttendance = $this->getStaffAttendance();

        return [
            'hourly_activity' => $hourlyPatientActivity,
            'appointment_status' => $appointmentStatus,
            'staff_attendance' => $staffAttendance,
        ];
    }

    private function getHourlyPatientActivity(): array
    {
        $hours = [];
        $counts = [];

        $today = Carbon::today();
        for ($i = 0; $i < 24; $i++) {
            $hours[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $start = $today->copy()->hour($i)->minute(0)->second(0);
            $end = $today->copy()->hour($i)->minute(59)->second(59);
            
            $count = Appointment::whereBetween('appointment_date', [$start, $end])->count() +
                     Admission::whereBetween('admitted_at', [$start, $end])->count();
            $counts[] = $count;
        }

        return [
            'labels' => $hours,
            'datasets' => [
                [
                    'label' => 'Patient Activity',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    private function getAppointmentStatus(): array
    {
        $today = Carbon::today();
        $data = Appointment::whereDate('appointment_date', $today)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return [
            'labels' => $data->pluck('status')->toArray(),
            'datasets' => [
                [
                    'label' => 'Appointments',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                ],
            ],
        ];
    }

    private function getStaffAttendance(): array
    {
        $today = Carbon::today();
        
        $presentStaff = Staff::where('status', 'Active')->count();
        $absentStaff = Staff::where('status', 'Inactive')->count();
        $onLeaveStaff = 0; // Placeholder

        return [
            'labels' => ['Present', 'Absent', 'On Leave'],
            'datasets' => [
                [
                    'label' => 'Staff',
                    'data' => [$presentStaff, $absentStaff, $onLeaveStaff],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                    ],
                ],
            ],
        ];
    }
}
