<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\Product;
use Illuminate\Support\Facades\Auth;

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

        return view('welcome', compact('products', 'categories', 'featuredProducts', 'newProducts', 'wishlistCount'));
    }
}