<?php

namespace App\Http\Controllers\Frontend\Shop;

use App\Http\Controllers\Controller;
use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('category_id')
            ->whereNotNull('category_image')
            ->get();

        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }

        $products = $this->buildProductQuery($request)->paginate(9)->withQueryString();

        return view('frontend.shop', compact('categories', 'products'));
    }

    public function categoryWiseProduct(Request $request, $slug)
    {
        $categories = Category::whereNull('category_id')
            ->whereNotNull('category_image')
            ->get();

        $category = Category::where('slug', $slug)->firstOrFail();

        $childCategoryIds = Category::where('category_id', $category->id)
            ->pluck('id')
            ->toArray();

        $allCategoryIds = array_merge([$category->id], $childCategoryIds);

        $products = $this->buildProductQuery($request)
            ->whereIn('category_id', $allCategoryIds)
            ->paginate(12)
            ->withQueryString();

        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }

        return view('frontend.shop', compact('categories', 'products'));
    }

    private function buildProductQuery(Request $request)
    {
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Price filter
        if ($request->filled('price')) {
            switch ($request->price) {
                case '0-500':
                    $query->whereBetween('price', [0, 500]);
                    break;
                case '500-1000':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '1000-1500':
                    $query->whereBetween('price', [1000, 1500]);
                    break;
                case '1500-2000':
                    $query->whereBetween('price', [1500, 2000]);
                    break;
                case '2000-2500':
                    $query->whereBetween('price', [2000, 2500]);
                    break;
                case '2500-3000':
                    $query->whereBetween('price', [2500, 3000]);
                    break;
                case '3000-4000':
                    $query->whereBetween('price', [3000, 4000]);
                    break;
            }
        }

        // Sort
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popularity':
                $query->orderBy('views', 'desc'); // adjust column if needed
                break;
            case 'rating':
                $query->orderBy('rating', 'desc'); // adjust column if needed
                break;
            default:
                $query->latest();
                break;
        }

        return $query;
    }

    public function liveSearch(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->search.'%')
            ->with('productImage')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'slug' => $product->slug,
                    'image' => $product->productImage->first()?->image_name
                        ? asset($product->productImage->first()->image_name)
                        : asset('assets/img/no-image.png'),
                ];
            });

        return response()->json($products);
    }
}