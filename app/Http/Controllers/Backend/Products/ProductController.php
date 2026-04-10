<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\Product;
use App\Models\Backend\Products\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'productImage']);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::whereNull('category_id')->with('children')->get();

        return view('backend.products.index', compact('products', 'categories'));
    }

    public function ajaxSearch(Request $request)
    {
        $q = $request->get('q', '');

        $products = Product::with(['productImage', 'category'])
            ->when($q, fn ($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(10);

        return response()->json([
            'html' => view('backend.products.partials.product-table-body', compact('products'))->render(),
            'total' => $products->total(),
            'links' => $products->links('pagination::bootstrap-5')->toHtml(),
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('backend.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_new'] = $request->boolean('is_new');

            $product = Product::create($data);

            // Save images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->productImage()->create(['image_name' => $path]);
                }
            }

            // FIX: use array_values() to re-index the variants array
            // This prevents "Undefined array key" when rows are deleted in browser
            $variants = array_values($request->input('variants', []));
            foreach ($variants as $variant) {
                if (! empty($variant['variant_name']) && $variant['total_price'] !== '') {
                    $product->productVariant()->create([
                        'variant_name' => $variant['variant_name'],
                        'total_price' => $variant['total_price'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dashboard.products.product-list')
                ->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $product->load(['productImage', 'productVariant']);
        $categories = Category::with('children')->whereNull('category_id')->get();

        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_new'] = $request->boolean('is_new');

            $product->update($data);

            // Add new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->productImage()->create(['image_name' => $path]);
                }
            }

            // Delete checked images
            if ($request->has('delete_images')) {
                $toDelete = ProductImage::whereIn('id', $request->delete_images)->get();
                foreach ($toDelete as $img) {
                    Storage::disk('public')->delete($img->image_name);
                    $img->delete();
                }
            }

            // FIX: use array_values() to re-index the variants array
            // This prevents "Undefined array key" when rows are deleted in browser
            $product->productVariant()->delete();
            $variants = array_values($request->input('variants', []));
            foreach ($variants as $variant) {
                if (! empty($variant['variant_name']) && $variant['total_price'] !== '') {
                    $product->productVariant()->create([
                        'variant_name' => $variant['variant_name'],
                        'total_price' => $variant['total_price'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dashboard.products.product-list')
                ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        foreach ($product->productImage as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->productImage()->delete();
        $product->productVariant()->delete();
        $product->delete();

        return redirect()->route('dashboard.products.product-list')
            ->with('success', 'Product deleted successfully!');
    }
}
