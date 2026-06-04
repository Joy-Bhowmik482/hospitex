<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Department;
use Carbon\Carbon;

class FinancialReportService extends BaseReportService
{
    protected $departments = [];

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
     * Generate summary statistics
     */
    public function generateSummary(): array
    {
        $query = Invoice::query();
        if ($this->startDate) $query->where('created_at', '>=', $this->startDate);
        if ($this->endDate) $query->where('created_at', '<=', $this->endDate);

        $totalRevenue = $query->sum('total_amount');
        $totalExpenses = Invoice::sum('discount_amount'); // Placeholder
        $paidAmount = Invoice::where('payment_status', 'Paid')->sum('total_amount');
        $outstandingAmount = max(0, $totalRevenue - $paidAmount);

        return [
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses,
            'net_profit' => max(0, $totalRevenue - $totalExpenses),
            'outstanding_bills' => $outstandingAmount,
            'paid_bills' => $paidAmount,
            'pending_payments' => max(0, $totalRevenue - $paidAmount),
            'invoice_count' => $query->count(),
            'average_invoice_amount' => $query->avg('total_amount') ?? 0,
            'paid_percentage' => $totalRevenue > 0 ? ($paidAmount / $totalRevenue) * 100 : 0,
        ];
    }

    /**
     * Generate detailed report data
     */
    public function generateData(): array
    {
        $query = Invoice::with('patient')->orderByDesc('created_at');
        
        if ($this->startDate) $query->where('created_at', '>=', $this->startDate);
        if ($this->endDate) $query->where('created_at', '<=', $this->endDate);

        $invoices = $query->paginate(20);

        return [
            'invoices' => $invoices,
            'total' => $invoices->total(),
            'per_page' => $invoices->perPage(),
            'total_amount' => $query->sum('total_amount'),
            'paid_amount' => $query->where('payment_status', 'Paid')->sum('total_amount'),
        ];
    }

    /**
     * Generate chart data
     */
    public function generateCharts(): array
    {
        $endDate = $this->endDate ?? now();
        $startDate = $this->startDate ?? $endDate->copy()->subDays(30);

        $revenueTrend = $this->getRevenueTrend($startDate, $endDate);
        $paymentStatusBreakdown = $this->getPaymentStatusBreakdown();
        $departmentRevenue = $this->getDepartmentRevenue();
        $dailyRevenue = $this->getDailyRevenue($startDate, $endDate);

        return [
            'revenue_trend' => $revenueTrend,
            'payment_status' => $paymentStatusBreakdown,
            'department_revenue' => $departmentRevenue,
            'daily_revenue' => $dailyRevenue,
        ];
    }

    private function getRevenueTrend($startDate, $endDate): array
    {
        $data = Invoice::selectRaw('DATE(created_at) as date, SUM(total_amount) as amount')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data->pluck('amount')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    private function getPaymentStatusBreakdown(): array
    {
        $data = Invoice::selectRaw('payment_status, COUNT(*) as count, SUM(total_amount) as amount')
            ->groupBy('payment_status')
            ->get();

        return [
            'labels' => $data->pluck('payment_status')->toArray(),
            'datasets' => [
                [
                    'label' => 'Invoice Count',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                    ],
                ],
            ],
        ];
    }

    private function getDepartmentRevenue(): array
    {
        $data = Invoice::selectRaw('services.name, SUM(total_amount) as amount')
            ->leftJoin('services', 'invoices.service_id', '=', 'services.id')
            ->groupBy('services.id', 'services.name')
            ->limit(10)
            ->get();

        return [
            'labels' => $data->pluck('name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data->pluck('amount')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                ],
            ],
        ];
    }

    private function getDailyRevenue($startDate, $endDate): array
    {
        $data = Invoice::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as amount')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data->pluck('amount')->toArray(),
                    'backgroundColor' => 'rgba(168, 85, 247, 0.5)',
                    'borderColor' => 'rgba(168, 85, 247, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }
}
