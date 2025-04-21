<?php
// ItemController.php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\BrowsingHistory;
use App\Models\Category;
use App\Models\Selection;

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

    public function create()
    {
        $categories = Category::all();
        return view('admin.create-item', compact('categories'));
    }

    public function store(Request $request)
    {
        // Form validation
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Main image is required
            'selections' => 'nullable|array',
            'selections.*.option' => 'nullable|string',
        ]);
    
        // Handle uploaded images
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }
    
        // Create the item
        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
    
        // Save Selections
        if ($request->has('selections')) {
            foreach ($request->selections as $selection) {
                if ($selection['option']) {
                    $item->selections()->create([
                        'option' => $selection['option'],
                    ]);
                }
            }
        }
    
        return redirect()->route('admin.items.create')->with('success', 'Item created successfully!');
    }
}
