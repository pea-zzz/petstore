<?php
// CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $itemsQuery = Item::query()->with('category');

        // Category filter
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $itemsQuery->where('category_id', $request->category_id);
        }

        // Price range filter
        $minPrice = $request->input('min_price', 0); // default to 0
        $maxPrice = $request->input('max_price');

        if ($maxPrice !== null) {
            $itemsQuery->whereBetween('price', [$minPrice, $maxPrice]);
        } else {
            $itemsQuery->where('price', '>=', $minPrice);
        }

        // Rating filter
        if ($request->filled('min_rating')) {
            $itemsQuery->whereHas('reviews', function ($query) use ($request) {
                $query->select('item_id')
                      ->groupBy('item_id')
                      ->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }

        $items = $itemsQuery->get();
        $itemsFound = $items->isNotEmpty();

        return view('categories', compact('categories', 'items', 'itemsFound', 'request'));
    }
}



