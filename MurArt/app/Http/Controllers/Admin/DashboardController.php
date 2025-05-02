<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Design;
use App\Models\Wallpaper;
use App\Models\Order;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Users statistics
        $totalUsers = User::count();
        $newUsers = User::where('created_at', '>=', now()->subMonth())->count();
        $newUsersPercent = $totalUsers > 0 ? round(($newUsers / $totalUsers) * 100) : 0;
        $designerCount = User::where('role', 'designer')->count();
        $customerCount = User::where('role', 'customer')->count();
        $activeUsersPercent = 75; // This would be calculated based on your activity criteria

        // Products statistics
        $totalWallpapers = Wallpaper::count();
        $newWallpapers = Wallpaper::where('created_at', '>=', now()->subMonth())->count();
        $newWallpapersPercent = $totalWallpapers > 0 ? round(($newWallpapers / $totalWallpapers) * 100) : 0;
        $lowStockCount = Wallpaper::where('stock', '<=', 5)->where('stock', '>', 0)->count();
        $outOfStockCount = Wallpaper::where('stock', 0)->count();
        $designsCount = Design::count();

        // Orders statistics
        $totalOrders = Order::count();
        $newOrders = Order::where('created_at', '>=', now()->subMonth())->count();
        $newOrdersPercent = $totalOrders > 0 ? round(($newOrders / $totalOrders) * 100) : 0;
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $completedOrdersCount = Order::where('status', 'completed')->count();
        $averageOrderValue = Order::avg('total') ? '$' . number_format(Order::avg('total'), 2) : '$0.00';

        // Revenue statistics
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])
            ->sum('total');
        $thisMonthRevenue = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total');
        $revenueChangePercent = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : 100;
        $monthlyRevenue = $thisMonthRevenue;
        $yearlyRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::latest()
            ->take(10)
            ->get();

        // Recent activities
        $recentActivities = [];
        try {
            $recentActivities = Activity::with(['causer' => function ($query) {
                $query->select('id', 'name');
            }])
                ->latest()
                ->take(8)
                ->get();
        } catch (\Exception $e) {
            // If Activity model or table doesn't exist, continue with empty array
        }

        // Top selling products
        $topSellingProducts = [];
        try {
            $topSellingProducts = Wallpaper::withCount(['orderItems as sales_count'])
                ->withSum(['orderItems' => function ($query) {
                    $query->join('orders', 'orders.id', '=', 'order_items.order_id')
                        ->where('orders.status', 'completed');
                }], DB::raw('order_items.quantity * order_items.price as total_revenue'))
                ->orderBy('sales_count', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // If the relationship fails, continue with an empty array
        }

        // Popular designs
        $popularDesigns = Design::with('designer')
            ->withAvg('reviews as average_rating', 'rating')
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get();

        // Sales chart data
        $salesChartData = $this->getSalesChartData('month');

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsersPercent',
            'designerCount',
            'customerCount',
            'activeUsersPercent',
            'totalWallpapers',
            'newWallpapersPercent',
            'lowStockCount',
            'outOfStockCount',
            'designsCount',
            'totalOrders',
            'newOrdersPercent',
            'pendingOrdersCount',
            'completedOrdersCount',
            'averageOrderValue',
            'totalRevenue',
            'revenueChangePercent',
            'monthlyRevenue',
            'yearlyRevenue',
            'recentOrders',
            'recentUsers',
            'recentActivities',
            'topSellingProducts',
            'popularDesigns',
            'salesChartData'
        ));
    }

    public function getSalesChartData($timeframe = 'month')
    {
        $labels = [];
        $revenueData = [];
        $ordersData = [];

        if ($timeframe === 'week') {
            // Current week data (last 7 days)
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('D');

                $revenueData[] = Order::where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total');

                $ordersData[] = Order::whereDate('created_at', $date)->count();
            }
        } elseif ($timeframe === 'month') {
            // Current month data (last 30 days)
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('M d');

                $revenueData[] = Order::where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total');

                $ordersData[] = Order::whereDate('created_at', $date)->count();
            }
        } else {
            // Current year data (by month)
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $labels[] = $date->format('M');

                $revenueData[] = Order::where('status', 'completed')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total');

                $ordersData[] = Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }
        }

        return [
            'labels' => $labels,
            'revenue' => $revenueData,
            'orders' => $ordersData
        ];
    }

    public function getSalesChartDataApi(Request $request)
    {
        $timeframe = $request->input('timeframe', 'month');
        return response()->json($this->getSalesChartData($timeframe));
    }

    public function filterUsers(Request $request)
    {
        $query = User::query();

        // Apply role filter if specified
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Apply search filter if specified
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get the results
        $users = $query->latest()->take(10)->get();

        return response()->json($users);
    }
}
