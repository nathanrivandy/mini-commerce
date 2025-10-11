<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('stock', '>', 0)->count(),
            'total_orders' => Order::count(),
            'total_categories' => Category::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'completed_orders' => Order::whereIn('status', ['delivered', 'completed'])->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::whereIn('status', ['delivered', 'completed'])->sum('total'),
            'today_revenue' => Order::whereIn('status', ['delivered', 'completed'])
                ->whereDate('created_at', today())
                ->sum('total'),
            'low_stock_products' => Product::where('stock', '<=', 10)->count(),
        ];

        // Get recent orders
        $recentOrders = Order::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get best selling products
        $bestSellingProducts = Product::with('category')
            ->withCount(['orderItems as total_sold' => function($query) {
                $query->select(DB::raw('sum(qty)'));
            }])
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Get monthly sales data for chart
        $monthlySales = Order::whereIn('status', ['delivered', 'completed'])
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get low stock products
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->limit(10)
            ->get();

        // Get order status distribution
        $orderStatusData = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'bestSellingProducts',
            'monthlySales',
            'lowStockProducts',
            'orderStatusData'
        ));
    }
}