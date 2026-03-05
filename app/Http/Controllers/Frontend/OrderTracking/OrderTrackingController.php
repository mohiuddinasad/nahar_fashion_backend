<?php

namespace App\Http\Controllers\Frontend\OrderTracking;

use App\Http\Controllers\Controller;
use App\Models\Backend\Orders\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('frontend.orderTracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $search = $request->input('query'); // ← use input() instead of $request->query

        $order = Order::with(['items', 'images'])
            ->where('order_number', $search)
            ->orWhere('phone', $search)
            ->orWhere('email', $search)
            ->first();

        if (! $order) {
            return back()->withErrors(['not_found' => 'No order found. Please check your order number or phone number.'])->withInput();
        }

        return view('frontend.orderTracking', compact('order'));
    }
}
