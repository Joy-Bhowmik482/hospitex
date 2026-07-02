<?php

namespace App\Services;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Carbon\Carbon;

class PharmacyReportService extends BaseReportService
{
    protected $categories = [];
    protected $suppliers = [];

    /**
     * Filter by category
     */
    public function filterByCategory($category)
    {
        return $this;
    }

    /**
     * Filter by supplier
     */
    public function filterBySupplier($supplier)
    {
        return $this;
    }

    /**
     * Generate summary statistics
     */
    public function generateSummary(): array
    {
        $totalSold = InventoryMovement::where('type', 'Sale')
            ->sum('qty');

        $lowStockItems = InventoryItem::whereRaw('qty_on_hand <= reorder_level')
            ->count();

        return [
            'total_medicines_sold'   => $totalSold,
            'revenue_generated'      => 0,
            'low_stock_medicines'    => $lowStockItems,
            'expired_medicines'      => 0,
            'near_expiry_medicines'  => 0,
            'total_inventory_value'  => 0,
            'total_items'            => InventoryItem::count(),
            'active_items'           => InventoryItem::count(),
        ];
    }

    /**
     * Generate detailed report data
     */
    public function generateData(): array
    {
        $items = InventoryItem::paginate(20);

        return [
            'items'     => $items,
            'total'     => $items->total(),
            'per_page'  => $items->perPage(),
        ];
    }

    /**
     * Generate chart data
     */
    public function generateCharts(): array
    {
        $endDate = $this->endDate ?? now();
        $startDate = $this->startDate ?? $endDate->copy()->subDays(30);

        return [
            'sales_trend'      => $this->getSalesTrend($startDate, $endDate),
            'top_medicines'    => $this->getTopSellingMedicines(),
            'inventory_status' => $this->getInventoryStatus(),
        ];
    }

    /**
     * Sales Trend
     */
    private function getSalesTrend($startDate, $endDate): array
    {
        $data = InventoryMovement::selectRaw('DATE(created_at) as date, SUM(qty) as amount')
            ->where('type', 'Sale')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')
                ->map(fn ($date) => Carbon::parse($date)->format('M d'))
                ->toArray(),

            'datasets' => [
                [
                    'label' => 'Medicines Sold',
                    'data' => $data->pluck('amount')->toArray(),
                    'backgroundColor' => 'rgba(34,197,94,.5)',
                    'borderColor' => 'rgba(34,197,94,1)',
                    'fill' => true,
                    'tension' => .4,
                ],
            ],
        ];
    }

    /**
     * Top Selling Medicines
     */
    private function getTopSellingMedicines(): array
    {
        $data = InventoryMovement::selectRaw('inventory_items.name, SUM(qty) as total_qty')
            ->join(
                'inventory_items',
                'inventory_movements.inventory_item_id',
                '=',
                'inventory_items.id'
            )
            ->where('type', 'Sale')
            ->groupBy('inventory_items.id', 'inventory_items.name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        return [
            'labels' => $data->pluck('name')->toArray(),

            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => $data->pluck('total_qty')->toArray(),
                    'backgroundColor' => 'rgba(59,130,246,.8)',
                    'borderColor' => 'rgba(59,130,246,1)',
                ],
            ],
        ];
    }

    /**
     * Inventory Status
     */
    private function getInventoryStatus(): array
    {
        $good = InventoryItem::whereRaw('qty_on_hand > reorder_level')
            ->count();

        $low = InventoryItem::whereRaw('qty_on_hand <= reorder_level')
            ->count();

        return [
            'labels' => [
                'Good Stock',
                'Low Stock',
            ],

            'datasets' => [
                [
                    'label' => 'Items',
                    'data' => [
                        $good,
                        $low,
                    ],
                    'backgroundColor' => [
                        'rgba(34,197,94,.8)',
                        'rgba(245,158,11,.8)',
                    ],
                ],
            ],
        ];
    }
}