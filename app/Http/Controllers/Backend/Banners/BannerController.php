<?php

namespace App\Http\Controllers\Backend\Banners;

use App\Http\Controllers\Controller;
use App\Models\Backend\Banners\BottomBanner;
use App\Models\Backend\Banners\TopBanner;
use App\Models\Backend\Products\Category;
use Illuminate\Http\Request;

class BannerController extends Controller
{

// top banners------------------------------------------------------------
    public function index()
    {
        $banners = TopBanner::with('category')->get();
        $categories = Category::all();

        return view('backend.banners.topBanners.index', compact('categories', 'banners'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('backend.banners.topBanners.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'top_image' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('top_image')) {
            $image = $request->file('top_image');
            $imageName = time().'_'.$image->getClientOriginalName();

            // Make sure the folder exists
            if (! file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }

            $image->move(public_path('uploads/banners'), $imageName);
        }

        TopBanner::create([
            'top_image' => 'uploads/banners/'.$imageName,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.banners.top.banner-list')->with('success', 'Top banner created successfully.');
    }

    public function destroy($id)
    {
        $banner = TopBanner::findOrFail($id);

        // Delete the image file if it exists
        if (file_exists(public_path($banner->top_image))) {
            unlink(public_path($banner->top_image));
        }

        $banner->delete();

        return redirect()->route('dashboard.banners.top.banner-list')->with('success', 'Top banner deleted successfully.');
    }

    public function edit($id)
    {
        $banner = TopBanner::findOrFail($id);
        $categories = Category::all();

        return view('backend.banners.topBanners.edit', compact('banner', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $banner = TopBanner::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('top_image')) {
            // Delete old image if it exists
            if (file_exists(public_path($banner->top_image))) {
                unlink(public_path($banner->top_image));
            }
 
            $image = $request->file('top_image');
            $imageName = time().'_'.$image->getClientOriginalName();

            // Make sure the folder exists
            if (! file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }

            $image->move(public_path('uploads/banners'), $imageName);
            $banner->top_image = 'uploads/banners/'.$imageName;
        }

        $banner->category_id = $request->category_id;
        $banner->save();

        return redirect()->route('dashboard.banners.top.banner-list')->with('success', 'Top banner updated successfully.');
    }

    // bottom banners------------------------------------------------------------
    public function bottomIndex()
    {
        $banners = BottomBanner::with('category')->get();
        $categories = Category::all();

        return view('backend.banners.bottomBanner.index', compact('categories', 'banners'));
    }

    public function bottomCreate()
    {
        $categories = Category::all();

        return view('backend.banners.bottomBanner.create', compact('categories'));
    }

    public function bottomStore(Request $request)
    {
        $request->validate([
            'bottom_image' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('bottom_image')) {
            $image = $request->file('bottom_image');
            $imageName = time().'_'.$image->getClientOriginalName();

            // Make sure the folder exists
            if (! file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }

            $image->move(public_path('uploads/banners'), $imageName);
        }

        BottomBanner::create([
            'bottom_image' => 'uploads/banners/'.$imageName,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.banners.bottom.banner-list')->with('success', 'Secondary banner created successfully.');
    }

    public function bottomDestroy($id)
    {
        $banner = BottomBanner::findOrFail($id);

        // Delete the image file if it exists
        if (file_exists(public_path($banner->bottom_image))) {
            unlink(public_path($banner->bottom_image));
        }

        $banner->delete();

        return redirect()->route('dashboard.banners.bottom.banner-list')->with('success', 'Secondary banner deleted successfully.');
    }
    public function bottomEdit($id)
    {
        $banner = BottomBanner::findOrFail($id);
        $categories = Category::all();

        return view('backend.banners.bottomBanner.edit', compact('banner', 'categories'));
    }

    public function bottomUpdate(Request $request, $id)
    {
        $banner = BottomBanner::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('bottom_image')) {
            // Delete old image if it exists
            if (file_exists(public_path($banner->bottom_image))) {
                unlink(public_path($banner->bottom_image));
            }

            $image = $request->file('bottom_image');
            $imageName = time().'_'.$image->getClientOriginalName();

            // Make sure the folder exists
            if (! file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }

            $image->move(public_path('uploads/banners'), $imageName);
            $banner->bottom_image = 'uploads/banners/'.$imageName;
        }

        $banner->category_id = $request->category_id;
        $banner->save();

        return redirect()->route('dashboard.banners.bottom.banner-list')->with('success', 'Secondary banner updated successfully.');
    }
}
