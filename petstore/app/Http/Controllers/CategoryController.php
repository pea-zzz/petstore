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
        // Fetch categories for dropdown
        $categories = Category::all();

        // Fetch filtered items based on the provided request
        $itemsQuery = Item::query();

        // Apply category filter
        if ($request->has('category_id') && $request->category_id) {
            $itemsQuery->where('category_id', $request->category_id);
        }

        // Apply price range filter
        if ($request->has('min_price') && $request->has('max_price')) {
            $itemsQuery->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Apply rating filter
        if ($request->has('min_rating') && $request->min_rating) {
            $itemsQuery->whereHas('reviews', function ($query) use ($request) {
                $query->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }

        // Get the filtered items
        $items = $itemsQuery->get();

        // Check if there are no items found after applying filters
        $itemsFound = $items->isNotEmpty();

        return view('categories', compact('categories', 'items', 'itemsFound'));
    }

    public function filter(Request $request)
    {
        $query = Item::query()->with('category');

        // Category filter
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Price filter
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        // Rating filter (with join and grouping)
        if ($request->filled('rating')) {
            $query->leftJoin('reviews', 'items.id', '=', 'reviews.item_id')
                ->select('items.*')
                ->groupBy('items.id')
                ->havingRaw('AVG(reviews.rating) >= ?', [$request->rating]);
        }

        $items = $query->get();
        $categories = Category::all(); // for filter dropdown

        return view('categories', compact('items', 'categories', 'request'));
    }
}


