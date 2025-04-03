<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $items = Item::where('name', 'like', "%{$query}%")->get();
        
        return view('search-results', compact('items'));
    }
}
