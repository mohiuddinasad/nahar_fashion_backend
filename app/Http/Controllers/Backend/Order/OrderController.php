<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\Controller;
use App\Models\Backend\Orders\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'images'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%'.$request->search.'%')
                    ->orWhere('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('phone', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
        ];

        return view('backend.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'images']);

        return view('backend.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['order_status' => $request->order_status]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('dashboard.orders.order-list')
            ->with('success', 'Order deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'order_ids' => ['required', 'array', 'min:1'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
        ]);

        $orders = Order::whereIn('id', $request->order_ids)->get();

        foreach ($orders as $order) {
            // Related images delete (local storage হলে)
            foreach ($order->images as $img) {
                if (file_exists(public_path($img->image_path))) {
                    unlink(public_path($img->image_path));
                }
                $img->delete();
            }

            $order->items()->delete();
            $order->delete();
        }

        $count = count($request->order_ids);

        return redirect()
            ->route('dashboard.orders.order-list')
            ->with('success', $count.' order(s) deleted successfully.');
    }
}
