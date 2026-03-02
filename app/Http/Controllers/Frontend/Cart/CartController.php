<?php

namespace App\Http\Controllers\Frontend\Cart;

use App\Http\Controllers\Controller;
use App\Models\Backend\Products\Product;
use App\Models\Backend\Products\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('frontend.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::with(['productVariant', 'productImage'])
            ->findOrFail($request->product_id);

        $variant = $request->variant_id
            ? ProductVariant::findOrFail($request->variant_id)
            : $product->productVariant->first();

        $cartKey = $request->product_id.'_'.($variant->id ?? 0);
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $request->qty ?? 1;
        } else {
            $cart[$cartKey] = [
                'name' => $product->name,
                'price' => $variant ? $variant->total_price : ($product->discount_price ?? $product->price),
                'qty' => $request->qty ?? 1,
                'variant_name' => $variant?->variant_name,
                'image' => $product->productImage->first()?->image_name,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            $cart[$request->cart_key]['qty'] = $request->quantity;
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return response()->json([
            'success' => true,
            'total' => number_format($total, 2),
            'cart_count' => count($cart),
        ]);
    }
}