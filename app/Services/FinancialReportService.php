<?php

namespace App\Services;

use App\Models\Invoice;
use Carbon\Carbon;

class FinancialReportService extends BaseReportService
{
    protected $departments = [];

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

        if ($this->startDate) {
            $query->whereDate('invoice_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('invoice_date', '<=', $this->endDate);
        }

        if (!empty($this->departments)) {
            $query->whereIn('department', $this->departments);
        }

        $totalRevenue = (clone $query)->sum('net_total');
        $totalExpenses = Invoice::sum('discount');
        $paidAmount = (clone $query)
            ->where('status', 'Paid')
            ->sum('net_total');

        $outstandingAmount = max(0, $totalRevenue - $paidAmount);

        return [
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses,
            'net_profit' => $totalRevenue - $totalExpenses,
            'outstanding_bills' => $outstandingAmount,
            'paid_bills' => $paidAmount,
            'pending_payments' => $outstandingAmount,
            'invoice_count' => (clone $query)->count(),
            'average_invoice_amount' => (clone $query)->avg('net_total') ?? 0,
            'paid_percentage' => $totalRevenue > 0
                ? round(($paidAmount / $totalRevenue) * 100, 2)
                : 0,
        ];
    }

    /**
     * Generate report data
     */
    public function generateData(): array
    {
        $query = Invoice::with('patient')
            ->orderByDesc('invoice_date');

        if ($this->startDate) {
            $query->whereDate('invoice_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('invoice_date', '<=', $this->endDate);
        }

        if (!empty($this->departments)) {
            $query->whereIn('department', $this->departments);
        }

        $invoices = $query->paginate(20);

        return [
            'invoices' => $invoices,
            'total' => $invoices->total(),
            'per_page' => $invoices->perPage(),
            'total_amount' => (clone $query)->sum('net_total'),
            'paid_amount' => (clone $query)
                ->where('status', 'Paid')
                ->sum('net_total'),
        ];
    }

    /**
     * Charts
     */
    public function generateCharts(): array
    {
        $endDate = $this->endDate ?? now();
        $startDate = $this->startDate ?? now()->subDays(30);

        return [
            'revenue_trend' => $this->getRevenueTrend($startDate, $endDate),
            'payment_status' => $this->getPaymentStatusBreakdown(),
            'department_revenue' => $this->getDepartmentRevenue(),
            'daily_revenue' => $this->getDailyRevenue($startDate, $endDate),
        ];
    }

    private function getRevenueTrend($startDate, $endDate): array
    {
        $data = Invoice::selectRaw("
                DATE(invoice_date) as date,
                SUM(net_total) as amount
            ")
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')
                ->map(fn($d) => Carbon::parse($d)->format('M d'))
                ->toArray(),
            'datasets' => [[
                'label' => 'Revenue',
                'data' => $data->pluck('amount')->toArray(),
                'backgroundColor' => 'rgba(34,197,94,.5)',
                'borderColor' => 'rgba(34,197,94,1)',
                'fill' => true,
                'tension' => .4,
            ]]
        ];
    }

    private function getPaymentStatusBreakdown(): array
    {
        $data = Invoice::selectRaw("
                status,
                COUNT(*) as count,
                SUM(net_total) as amount
            ")
            ->groupBy('status')
            ->get();

        return [
            'labels' => $data->pluck('status')->toArray(),
            'datasets' => [[
                'label' => 'Invoices',
                'data' => $data->pluck('count')->toArray(),
                'backgroundColor' => [
                    'rgba(34,197,94,.8)',
                    'rgba(239,68,68,.8)',
                    'rgba(245,158,11,.8)',
                ],
            ]]
        ];
    }

    private function getDepartmentRevenue(): array
    {
        $data = Invoice::selectRaw("
                department,
                SUM(net_total) as amount
            ")
            ->whereNotNull('department')
            ->groupBy('department')
            ->get();

        return [
            'labels' => $data->pluck('department')->toArray(),
            'datasets' => [[
                'label' => 'Revenue',
                'data' => $data->pluck('amount')->toArray(),
                'backgroundColor' => 'rgba(59,130,246,.8)',
                'borderColor' => 'rgba(59,130,246,1)',
            ]]
        ];
    }

    private function getDailyRevenue($startDate, $endDate): array
    {
        $data = Invoice::selectRaw("
                DATE(invoice_date) as date,
                COUNT(*) as count,
                SUM(net_total) as amount
            ")
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')
                ->map(fn($d) => Carbon::parse($d)->format('M d'))
                ->toArray(),
            'datasets' => [[
                'label' => 'Revenue',
                'data' => $data->pluck('amount')->toArray(),
                'backgroundColor' => 'rgba(168,85,247,.5)',
                'borderColor' => 'rgba(168,85,247,1)',
                'fill' => true,
                'tension' => .4,
            ]]
        ];
    }
}