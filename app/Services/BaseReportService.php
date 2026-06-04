<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseReportService
{
    protected $startDate;
    protected $endDate;

    /**
     * Set the date range for the report
     */
    public function setDateRange($startDate, $endDate)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate) : null;
        $this->endDate = $endDate ? Carbon::parse($endDate) : null;
        return $this;
    }

    /**
     * Apply quick date filters
     */
    public function applyQuickFilter($filter)
    {
        $today = Carbon::today();
        
        switch ($filter) {
            case 'today':
                $this->startDate = $today;
                $this->endDate = $today->copy()->endOfDay();
                break;
            case 'yesterday':
                $this->startDate = $today->copy()->subDay()->startOfDay();
                $this->endDate = $today->copy()->subDay()->endOfDay();
                break;
            case 'last7days':
                $this->startDate = $today->copy()->subDays(7)->startOfDay();
                $this->endDate = $today->copy()->endOfDay();
                break;
            case 'last30days':
                $this->startDate = $today->copy()->subDays(30)->startOfDay();
                $this->endDate = $today->copy()->endOfDay();
                break;
            case 'thismonth':
                $this->startDate = $today->copy()->startOfMonth();
                $this->endDate = $today->copy()->endOfMonth();
                break;
            case 'lastmonth':
                $this->startDate = $today->copy()->subMonth()->startOfMonth();
                $this->endDate = $today->copy()->subMonth()->endOfMonth();
                break;
            case 'thisyear':
                $this->startDate = $today->copy()->startOfYear();
                $this->endDate = $today->copy()->endOfYear();
                break;
        }
        
        return $this;
    }

    /**
     * Get the date range for the report
     */
    public function getDateRange()
    {
        return [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
    }

    /**
     * Generate summary statistics
     */
    abstract public function generateSummary(): array;

    /**
     * Generate detailed report data
     */
    abstract public function generateData(): array;

    /**
     * Generate chart data
     */
    abstract public function generateCharts(): array;

    /**
     * Get all report data
     */
    public function generate(): array
    {
        return [
            'date_range' => $this->getDateRange(),
            'summary' => $this->generateSummary(),
            'data' => $this->generateData(),
            'charts' => $this->generateCharts(),
            'generated_at' => now(),
        ];
    }

    /**
     * Format currency
     */
    protected function formatCurrency($amount): string
    {
        return '$' . number_format($amount, 2);
    }

    /**
     * Calculate percentage change
     */
    protected function calculatePercentageChange($current, $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }

    /**
     * Get color based on trend
     */
    protected function getTrendColor($change): string
    {
        if ($change > 0) {
            return 'green';
        } elseif ($change < 0) {
            return 'red';
        }
        return 'gray';
    }

    /**
     * Get trend icon
     */
    protected function getTrendIcon($change): string
    {
        if ($change > 0) {
            return '↑';
        } elseif ($change < 0) {
            return '↓';
        }
        return '→';
    }
}
