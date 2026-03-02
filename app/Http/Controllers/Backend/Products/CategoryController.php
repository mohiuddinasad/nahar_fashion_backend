<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Backend\Products\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent');

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Filter by parent category
        if ($request->filled('parent_id')) {
            $query->where('category_id', $request->parent_id);
        }

        $categories = $query->latest()->paginate(15)->withQueryString();
        $parentCategories = Category::whereNull('category_id')->get();

        return view('backend.categories.index', compact('categories', 'parentCategories'));
    }

    public function search(Request $request)
    {
        $results = Category::where('name', 'like', '%'.$request->q.'%')
            ->limit(10)
            ->pluck('name');

        return response()->json($results);
    }

    public function create()
    {
        $parentCategories = Category::whereNull('category_id')->get();
        $categories = Category::all();

        return view('backend.categories.create', compact('parentCategories', 'categories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        if ($request->hasFile('category_image')) {
            $data['category_image'] = $request->file('category_image')
                ->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('dashboard.categories.category-list')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('category_id')
            ->where('id', '!=', $category->id)
            ->get();
        $categories = Category::all();

        return view('backend.categories.edit', compact('category', 'parentCategories', 'categories'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        if ($request->hasFile('category_image')) {
            if ($category->category_image) {
                Storage::disk('public')->delete($category->category_image);
            }
            $data['category_image'] = $request->file('category_image')
                ->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('dashboard.categories.category-list')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->category_image) {
            Storage::disk('public')->delete($category->category_image);
        }

        $category->delete();

        return redirect()->route('dashboard.categories.category-list')
            ->with('success', 'Category deleted successfully!');
    }
}
