<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class BrowsingHistoryController extends Controller
{
    public function index()
    {
        $history = session('browsing_history', []);
        return view('browsing-history', compact('history'));
    }

    public function addToHistory(Item $item)
    {
        $history = session('browsing_history', []);
        $history[] = $item;
        session(['browsing_history' => $history]);

        return redirect()->route('browsing.history');
    }
}

