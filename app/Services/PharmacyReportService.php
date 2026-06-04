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
        if ($category) {
            $this->categories = [$category];
        }
        return $this;
    }

    /**
     * Filter by supplier
     */
    public function filterBySupplier($supplier)
    {
        if ($supplier) {
            $this->suppliers = [$supplier];
        }
        return $this;
    }

    /**
     * Generate summary statistics
     */
    public function generateSummary(): array
    {
        $totalSold = InventoryMovement::where('movement_type', 'Sale')
            ->sum('quantity');

        $lowStockItems = InventoryItem::whereRaw('quantity <= reorder_level')->count();
        
        $now = now();
        $expiredItems = InventoryItem::where('expiry_date', '<', $now)->count();
        $nearExpiryItems = InventoryItem::whereBetween('expiry_date', [$now, $now->copy()->addDays(30)])->count();

        $totalRevenue = InventoryMovement::where('movement_type', 'Sale')->sum('total_cost');

        return [
            'total_medicines_sold' => $totalSold,
            'revenue_generated' => $totalRevenue,
            'low_stock_medicines' => $lowStockItems,
            'expired_medicines' => $expiredItems,
            'near_expiry_medicines' => $nearExpiryItems,
            'total_inventory_value' => InventoryItem::sum('quantity') * InventoryItem::avg('unit_cost'),
            'total_items' => InventoryItem::count(),
            'active_items' => InventoryItem::where('status', 'Active')->count(),
        ];
    }

    /**
     * Generate detailed report data
     */
    public function generateData(): array
    {
        $query = InventoryItem::query();
        
        if ($this->categories) {
            $query->whereIn('category', $this->categories);
        }

        $items = $query->paginate(20);

        return [
            'items' => $items,
            'total' => $items->total(),
            'per_page' => $items->perPage(),
        ];
    }

    /**
     * Generate chart data
     */
    public function generateCharts(): array
    {
        $endDate = $this->endDate ?? now();
        $startDate = $this->startDate ?? $endDate->copy()->subDays(30);

        $salesTrend = $this->getSalesTrend($startDate, $endDate);
        $topSellingMedicines = $this->getTopSellingMedicines();
        $inventoryStatus = $this->getInventoryStatus();

        return [
            'sales_trend' => $salesTrend,
            'top_medicines' => $topSellingMedicines,
            'inventory_status' => $inventoryStatus,
        ];
    }

    private function getSalesTrend($startDate, $endDate): array
    {
        $data = InventoryMovement::selectRaw('DATE(created_at) as date, SUM(total_cost) as amount')
            ->where('movement_type', 'Sale')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $data->pluck('amount')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }

    private function getTopSellingMedicines(): array
    {
        $data = InventoryMovement::selectRaw('inventory_items.name, SUM(quantity) as total_qty, SUM(total_cost) as total_amount')
            ->join('inventory_items', 'inventory_movements.inventory_item_id', '=', 'inventory_items.id')
            ->where('movement_type', 'Sale')
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
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                ],
            ],
        ];
    }

    private function getInventoryStatus(): array
    {
        $now = now();
        $good = InventoryItem::where('quantity', '>', 0)
            ->where('expiry_date', '>', $now)
            ->where('quantity', '>', 'reorder_level')
            ->count();
        
        $low = InventoryItem::where('quantity', '<=', 'reorder_level')
            ->where('quantity', '>', 0)
            ->count();
        
        $expired = InventoryItem::where('expiry_date', '<', $now)->count();

        return [
            'labels' => ['Good Stock', 'Low Stock', 'Expired'],
            'datasets' => [
                [
                    'label' => 'Items',
                    'data' => [$good, $low, $expired],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                ],
            ],
        ];
    }
}
