<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Admission;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Ward;
use Carbon\Carbon;

class PatientReportService extends BaseReportService
{
    protected $doctors = [];
    protected $departments = [];
    protected $wards = [];

    /**
     * Filter by doctor
     */
    public function filterByDoctor($doctorId)
    {
        if ($doctorId) {
            $this->doctors = [$doctorId];
        }
        return $this;
    }

    /**
     * Filter by department
     */
    public function filterByDepartment($departmentId)
    {
        if ($departmentId) {
            $this->departments = [$departmentId];
        }
        return $this;
    }

    /**
     * Filter by ward
     */
    public function filterByWard($wardId)
    {
        if ($wardId) {
            $this->wards = [$wardId];
        }
        return $this;
    }

    /**
     * Generate summary statistics
     */
    public function generateSummary(): array
    {
        $query = Patient::query();
        if ($this->startDate) $query->where('created_at', '>=', $this->startDate);
        if ($this->endDate) $query->where('created_at', '<=', $this->endDate);

        $totalPatients = $query->count();
        $newPatients = $query->whereDate('created_at', '>=', $this->startDate ?? Carbon::today()->subDays(30))->count();
        $maleCount = Patient::query()->where('gender', 'Male')->count();
        $femaleCount = Patient::query()->where('gender', 'Female')->count();

        $admittedCount = Admission::whereNull('discharge_at')->count();
        $discharged = Admission::whereNotNull('discharge_at')->count();

        return [
            'total_patients' => $totalPatients,
            'new_patients' => $newPatients,
            'returning_patients' => max(0, $totalPatients - $newPatients),
            'admitted_patients' => $admittedCount,
            'discharged_patients' => $discharged,
            'icu_patients' => Admission::whereHas('bedAllocations', function($q) { $q->where('status', 'active'); })->whereNull('discharge_at')->count(),
            'emergency_patients' => Admission::where('status', 'Emergency')->whereNull('discharge_at')->count(),
            'male_patients' => $maleCount,
            'female_patients' => $femaleCount,
            'other_patients' => max(0, $totalPatients - $maleCount - $femaleCount),
        ];
    }

    /**
     * Generate detailed report data
     */
    public function generateData(): array
    {
        $query = Patient::with(['admissions' => function($q) {
            $q->orderByDesc('admitted_at');
        }]);

        if ($this->startDate) $query->where('created_at', '>=', $this->startDate);
        if ($this->endDate) $query->where('created_at', '<=', $this->endDate);

        $patients = $query->paginate(20);

        return [
            'patients' => $patients,
            'total' => $patients->total(),
            'per_page' => $patients->perPage(),
        ];
    }

    /**
     * Generate chart data
     */
    public function generateCharts(): array
    {
        $endDate = $this->endDate ?? now();
        $startDate = $this->startDate ?? $endDate->copy()->subDays(30);

        // Patient Registration Trend (last 30 days by day)
        $registrationTrend = $this->getRegistrationTrend($startDate, $endDate);

        // Admission Trend
        $admissionTrend = $this->getAdmissionTrend($startDate, $endDate);

        // Discharge Trend
        $dischargeTrend = $this->getDischargeTrend($startDate, $endDate);

        // Gender Distribution
        $genderDistribution = $this->getGenderDistribution();

        // Age Group Distribution
        $ageDistribution = $this->getAgeGroupDistribution();

        // Department Wise Patient Distribution
        $departmentDistribution = $this->getDepartmentDistribution();

        return [
            'registration_trend' => $registrationTrend,
            'admission_trend' => $admissionTrend,
            'discharge_trend' => $dischargeTrend,
            'gender_distribution' => $genderDistribution,
            'age_distribution' => $ageDistribution,
            'department_distribution' => $departmentDistribution,
        ];
    }

    private function getRegistrationTrend($startDate, $endDate): array
    {
        $data = Patient::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => [
                [
                    'label' => 'Patient Registrations',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    private function getAdmissionTrend($startDate, $endDate): array
    {
        $data = Admission::selectRaw('DATE(admitted_at) as date, COUNT(*) as count')
            ->whereBetween('admitted_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => [
                [
                    'label' => 'Admissions',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    private function getDischargeTrend($startDate, $endDate): array
    {
        $data = Admission::selectRaw('DATE(discharge_at) as date, COUNT(*) as count')
            ->whereNotNull('discharge_at')
            ->whereBetween('discharge_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => [
                [
                    'label' => 'Discharges',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(168, 85, 247, 0.5)',
                    'borderColor' => 'rgba(168, 85, 247, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    private function getGenderDistribution(): array
    {
        $query = Patient::selectRaw('gender, COUNT(*) as count')->groupBy('gender')->get();

        return [
            'labels' => $query->pluck('gender')->toArray(),
            'datasets' => [
                [
                    'label' => 'Patients',
                    'data' => $query->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(107, 114, 128, 0.8)',
                    ],
                    'borderColor' => [
                        'rgba(59, 130, 246, 1)',
                        'rgba(236, 72, 153, 1)',
                        'rgba(107, 114, 128, 1)',
                    ],
                ],
            ],
        ];
    }

    private function getAgeGroupDistribution(): array
    {
        $ageGroups = [
            '0-18' => ['min' => 0, 'max' => 18],
            '19-30' => ['min' => 19, 'max' => 30],
            '31-45' => ['min' => 31, 'max' => 45],
            '46-60' => ['min' => 46, 'max' => 60],
            '60+' => ['min' => 61, 'max' => 150],
        ];

        $data = [];
        foreach ($ageGroups as $label => $range) {
            $count = Patient::whereBetween('age', [$range['min'], $range['max']])->count();
            $data[$label] = $count;
        }

        return [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'Patient Count',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                ],
            ],
        ];
    }

    private function getDepartmentDistribution(): array
    {
        $data = Admission::selectRaw('departments.name, COUNT(*) as count')
            ->join('departments', 'admissions.department_id', '=', 'departments.id')
            ->whereNull('admissions.discharge_at')
            ->groupBy('departments.id', 'departments.name')
            ->limit(10)
            ->get();

        return [
            'labels' => $data->pluck('name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Admitted Patients',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                ],
            ],
        ];
    }
}
