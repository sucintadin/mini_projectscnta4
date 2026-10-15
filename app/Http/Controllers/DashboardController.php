<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the inventory overview dashboard
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalStockUnits = Product::sum('stock');
        
        // Inventory total valuation (SUM(price * stock))
        $totalInventoryValue = Product::select(DB::raw('SUM(price * stock) as total_val'))
            ->value('total_val') ?? 0;

        // Stock status metrics (Business rule)
        $lowStockCount = Product::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'min_stock')
            ->count();

        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        // Items requiring urgent attention (low stock or out of stock)
        $stockAlertItems = Product::with('category')
            ->where(function ($q) {
                $q->where('stock', '<=', 0)
                  ->orWhereColumn('stock', '<=', 'min_stock');
            })
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Latest added products
        $latestProducts = Product::with('category')
            ->latest()
            ->limit(5)
            ->get();

        // Categories summary with count
        $categorySummary = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        // P4 Sales metrics
        $totalSalesRevenue = \App\Models\Sale::select(DB::raw('SUM(quantity * unit_price) as rev'))->value('rev') ?? 0;
        $totalSalesCount = \App\Models\Sale::count();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalStockUnits',
            'totalInventoryValue',
            'lowStockCount',
            'outOfStockCount',
            'stockAlertItems',
            'latestProducts',
            'categorySummary',
            'totalSalesRevenue',
            'totalSalesCount'
        ));
    }
}
