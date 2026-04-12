<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\Product;
use App\Models\Backend\Products\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            // Save images (uploads system)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $filename = time().'_'.$image->getClientOriginalName();
                    $image->move(public_path('uploads/products'), $filename);

                    $product->productImage()->create([
                        'image_name' => 'uploads/products/'.$filename,
                    ]);
                }
            }

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

                    $filename = time().'_'.$image->getClientOriginalName();
                    $image->move(public_path('uploads/products'), $filename);

                    $product->productImage()->create([
                        'image_name' => 'uploads/products/'.$filename,
                    ]);
                }
            }

            // Delete checked images
            if ($request->has('delete_images')) {
                $toDelete = ProductImage::whereIn('id', $request->delete_images)->get();

                foreach ($toDelete as $img) {
                    if ($img->image_name && file_exists(public_path($img->image_name))) {
                        unlink(public_path($img->image_name));
                    }
                    $img->delete();
                }
            }

            // Variants reset
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
        // Delete images from folder
        foreach ($product->productImage as $img) {
            if ($img->image_name && file_exists(public_path($img->image_name))) {
                unlink(public_path($img->image_name));
            }
        }

        $product->productImage()->delete();
        $product->productVariant()->delete();
        $product->delete();

        return redirect()->route('dashboard.products.product-list')
            ->with('success', 'Product deleted successfully!');
    }
}
