<?php

namespace App\Http\Controllers\Frontend\Review;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        Review::create([
            'product_id' => $productId,
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'rating'     => $validated['rating'],
            'comment'    => $validated['comment'],
        ]);

        return back()->with('success', 'Your review has been submitted!');
    }
}