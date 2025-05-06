<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Show the form to submit a review
    public function create(Item $id)
    {
        return view('reviews.create', ['item' => $id]);
    }
    
    public function store(Request $request, $id)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a review.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $item = Item::findOrFail($id); // Ensure the item exists

        // Create and save the review
        Review::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redirect back to the item detail page with a success message
        return redirect()->route('items.show', $item->id)->with('success', 'Review added successfully');
    }
}


