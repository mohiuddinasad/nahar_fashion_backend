<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Banners\BottomBanner;
use App\Models\Backend\Banners\TopBanner;
use App\Models\Backend\Orders\Order;
use App\Models\Backend\Orders\OrderImage;
use App\Models\Backend\Orders\OrderItem;
use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\Product;
use App\Models\Backend\Setting\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('category_id')
            ->whereNotNull('category_image')
            ->get();
        $products = Product::latest()->take(8)->get();
        $featuredProducts = Product::where('is_featured', '1')->latest()->take(8)->get();
        $newProducts = Product::where('is_new', '1')->latest()->take(8)->get();
        $wishlistCount = Auth::check() ? Auth::user()->wishlists()->count() : 0;
        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }
        $topBanners = TopBanner::with('category')->get();
        $bottomBanners = BottomBanner::with('category')->get();
        $globalSetting = WebsiteSetting::instance();

        return view('welcome', compact('products', 'categories', 'featuredProducts', 'newProducts', 'wishlistCount', 'topBanners', 'bottomBanners', 'globalSetting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal' => 'nullable|string|max:20',
            'comments' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
            $shippingCost = 0;
            $total = $subtotal + $shippingCost;

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal' => $request->postal,
                'comments' => $request->comments,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $total,
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            // Save order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['name'],
                    'product_image' => $item['image'] ?? null,
                    'variant_name' => $item['variant_name'] ?? null,
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);
            }

            // ✅ FIXED: Save uploaded images (uploads system)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    // unique filename
                    $filename = uniqid().'_'.$image->getClientOriginalName();

                    // move to uploads/order-images
                    $image->move(public_path('uploads/order-images'), $filename);

                    // save path in DB
                    OrderImage::create([
                        'order_id' => $order->id,
                        'image_path' => 'uploads/order-images/'.$filename,
                    ]);
                }
            }

            DB::commit();
            session()->forget('cart');

            return view('frontend.orderSuccess', compact('order'))
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function success($orderNumber)
    {
        $order = Order::with(['items', 'images'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('frontend.orderSuccess', compact('order'));
    }
}
