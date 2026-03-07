<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Orders\Order;
use App\Models\Backend\Sales\DailySale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $month = Carbon::now();

        // ── Orders ─────────────────────────────────────────
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $monthlyOrders = Order::whereMonth('created_at', $month->month)
            ->whereYear('created_at', $month->year)->count();

        $pendingOrders = Order::where('order_status', 'pending')->count();
        $processingOrders = Order::where('order_status', 'processing')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();
        $totalOrders = Order::count();

        // ── Sales (from DailySale) ──────────────────────────
        $todaySale = DailySale::whereDate('sale_date', $today)->sum('total_sale');
        $todayCost = DailySale::whereDate('sale_date', $today)->sum('total_cost');
        $todayProfit = DailySale::whereDate('sale_date', $today)->sum('profit');

        $monthlySale = DailySale::whereMonth('sale_date', $month->month)
            ->whereYear('sale_date', $month->year)->sum('total_sale');
        $monthlyCost = DailySale::whereMonth('sale_date', $month->month)
            ->whereYear('sale_date', $month->year)->sum('total_cost');
        $monthlyProfit = DailySale::whereMonth('sale_date', $month->month)
            ->whereYear('sale_date', $month->year)->sum('profit');

        // ── Chart: last 7 days orders ───────────────────────
        $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'date' => $date->format('d M'),
                'orders' => Order::whereDate('created_at', $date)->count(),
            ];
        });

        // ── Recent Orders ───────────────────────────────────
        $recentOrders = Order::with('items')->latest()->take(5)->get();

        return view('dashboard', compact(
            'todayOrders', 'monthlyOrders',
            'pendingOrders', 'processingOrders', 'deliveredOrders', 'cancelledOrders', 'totalOrders',
            'todaySale', 'todayCost', 'todayProfit',
            'monthlySale', 'monthlyCost', 'monthlyProfit',
            'last7Days', 'recentOrders'
        ));
    }
}
