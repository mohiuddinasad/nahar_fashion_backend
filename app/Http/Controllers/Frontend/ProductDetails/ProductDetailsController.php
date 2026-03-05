<?php

namespace App\Http\Controllers\Frontend\ProductDetails;

use App\Http\Controllers\Controller;
use App\Models\Backend\Products\Product;

class ProductDetailsController extends Controller
{
    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'productImage', 'productVariant', 'reviews'])
            ->firstOrFail();

        // Related products
        $relatedProducts = Product::with(['productImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.productDetails', compact('product', 'relatedProducts'));
    }
}