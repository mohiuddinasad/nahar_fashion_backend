<?php

namespace App\Http\Controllers\Frontend\Wishlist;

use App\Http\Controllers\Controller;
use App\Models\Backend\Products\Product;
use App\Models\Frontend\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view wishlist.');
        }

        $wishlists = Wishlist::with('product.productImage')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('frontend.wishlist', compact('wishlists'));
    }

    public function add($id)
    {
        if (! Auth::check()) {
            return response()->json(['status' => 'login_required', 'message' => 'Please login first.'], 401);
        }

        $product = Product::findOrFail($id);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return response()->json(['status' => 'already_added', 'message' => 'Already in wishlist.']);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json(['status' => 'added', 'message' => 'Added to wishlist!', 'count' => $count]);
    }

    public function remove($id)
    {
        if (! Auth::check()) {
            return response()->json(['status' => 'login_required'], 401);
        }

        $product = Product::findOrFail($id);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist.', 'count' => $count]);
    }
}
