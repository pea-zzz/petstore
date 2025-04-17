<?php
// ItemController.php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\BrowsingHistory;

class ItemController extends Controller
{
    public function show($id)
    {
        $item = Item::with('reviews','selections')->findOrFail($id);

        // Calculate the average rating
        $averageRating = $item->reviews->avg('rating');
        
        // Browsing History Tracking
        if (auth()->check()) {
            // For authenticated users: store in DB
            BrowsingHistory::updateOrCreate([
                'user_id' => auth()->id(),
                'item_id' => $item->id,
            ]);
        } else {
            // For guests: use session
            $history = session()->get('guest_browsing_history', []);
            $history = array_diff($history, [$item->id]); // Remove if already exists
            array_unshift($history, $item->id); // Add to front (most recent first)
            session()->put('guest_browsing_history', array_slice($history, 0, 20)); // Limit to 20
        }

        return view('item-detail', compact('item', 'averageRating'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('item-detail', ['id' => $item->id]);
    }
}
