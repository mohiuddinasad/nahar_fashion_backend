<?php

namespace App\Http\Controllers\Backend\Sales;

use App\Http\Controllers\Controller;
use App\Models\Backend\Sales\DailySale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailySaleController extends Controller
{
    public function index(Request $request)
{
    $today = Carbon::today();

    // ── Date Filter ────────────────────────────────────
    $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
    $endDate   = $request->filled('end_date')   ? Carbon::parse($request->end_date)->endOfDay()     : null;

    $isFiltered = $startDate || $endDate;

    // ── Filtered Table Query ───────────────────────────
    $query = DailySale::query();

    if ($startDate && $endDate) {
        $query->whereBetween('sale_date', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->whereDate('sale_date', '>=', $startDate);
    } elseif ($endDate) {
        $query->whereDate('sale_date', '<=', $endDate);
    }

    // Filtered summary totals
    $filteredSale   = (clone $query)->sum('total_sale');
    $filteredCost   = (clone $query)->sum('total_cost');
    $filteredProfit = (clone $query)->sum('profit');

    // Paginated table results
    $sales = $query->orderBy('sale_date', 'desc')->latest()->paginate(10)->withQueryString();

    // ── Fixed Stat Boxes (never changes) ──────────────
    $todaySale   = DailySale::whereDate('sale_date', $today)->sum('total_sale');
    $todayCost   = DailySale::whereDate('sale_date', $today)->sum('total_cost');
    $todayProfit = DailySale::whereDate('sale_date', $today)->sum('profit');

    $monthlySale   = DailySale::whereMonth('sale_date', $today->month)->whereYear('sale_date', $today->year)->sum('total_sale');
    $monthlyCost   = DailySale::whereMonth('sale_date', $today->month)->whereYear('sale_date', $today->year)->sum('total_cost');
    $monthlyProfit = DailySale::whereMonth('sale_date', $today->month)->whereYear('sale_date', $today->year)->sum('profit');

    $yearlySale   = DailySale::whereYear('sale_date', $today->year)->sum('total_sale');
    $yearlyProfit = DailySale::whereYear('sale_date', $today->year)->sum('profit');

    $totalSale   = DailySale::sum('total_sale');
    $totalProfit = DailySale::sum('profit');

    // ── Chart: last 30 days ────────────────────────────
    $chartData = DailySale::where('sale_date', '>=', Carbon::today()->subDays(29))
        ->orderBy('sale_date')
        ->get(['sale_date', 'total_sale', 'profit']);

    return view('backend.sales.index', compact(
        'todaySale', 'todayCost', 'todayProfit',
        'monthlySale', 'monthlyCost', 'monthlyProfit',
        'yearlySale', 'yearlyProfit',
        'totalSale', 'totalProfit',
        'chartData', 'sales',
        'filteredSale', 'filteredCost', 'filteredProfit', 'isFiltered'
    ));
}
    public function create()
    {
        return view('backend.sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'total_sale' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
        ]);

        DailySale::create([
            'sale_date' => $request->sale_date,
            'total_sale' => $request->total_sale,
            'total_cost' => $request->total_cost,
            'profit' => $request->total_sale - $request->total_cost,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard.daily-sales.index')
            ->with('success', 'Sale record added successfully!');
    }

    public function edit(DailySale $dailySale)
    {
        return view('backend.sales.edit', compact('dailySale'));
    }

    public function update(Request $request, DailySale $dailySale)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'total_sale' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
        ]);

        $dailySale->update([
            'sale_date' => $request->sale_date,
            'total_sale' => $request->total_sale,
            'total_cost' => $request->total_cost,
            'profit' => $request->total_sale - $request->total_cost,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard.daily-sales.index')
            ->with('success', 'Sale record updated!');
    }

    public function destroy(DailySale $dailySale)
    {
        $dailySale->delete();

        return redirect()->route('dashboard.daily-sales.index')
            ->with('success', 'Sale record deleted!');
    }
}