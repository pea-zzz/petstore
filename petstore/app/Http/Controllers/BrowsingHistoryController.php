<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrowsingHistory;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class BrowsingHistoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $histories = BrowsingHistory::with('item')
                ->where('user_id', Auth::id())
                ->latest()
                ->take(20)
                ->get()
                ->pluck('item');
        } else {
            $ids = session()->get('guest_browsing_history', []);
            $histories = Item::whereIn('id', $ids)->get();
        }

        return view('browsing_history.index', compact('histories'));
    }

    // Store browsing history for authenticated users and guests
    public function store($itemId)
    {
        if (Auth::check()) {
            // For authenticated users, store in the database
            BrowsingHistory::firstOrCreate([
                'user_id' => Auth::id(),
                'item_id' => $itemId,
            ]);
        } else {
            // For guests, store in session
            $history = session()->get('guest_browsing_history', []);
            if (!in_array($itemId, $history)) {
                $history[] = $itemId;
                session()->put('guest_browsing_history', $history);
            }

            // Log guest browsing history in session
            \Log::info('Guest Browsing History in Session:', $history);
        }

        return redirect()->route('items.show', $itemId);
    }

    // Migrate guest browsing history to authenticated user upon registration/login
    public function migrateGuestHistory()
    {
        if (Auth::check()) {
            // Only migrate if the user is authenticated
            $guestHistory = session()->get('guest_browsing_history', []);

            // Log the guest history to check if it's being stored correctly
            \Log::info('Guest Browsing History:', $guestHistory);

            // If guest history exists, transfer it to the user's history in the database
            if (!empty($guestHistory)) {
                foreach ($guestHistory as $itemId) {
                    BrowsingHistory::firstOrCreate([
                        'user_id' => Auth::id(),
                        'item_id' => $itemId,
                    ]);
                }

                // After migration, clear the guest browsing history from session
                session()->forget('guest_browsing_history');
            }
        }
    }

    // Clear browsing history for authenticated users or guests
    public function clear()
    {
        if (Auth::check()) {
            // Delete user browsing history from database
            BrowsingHistory::where('user_id', Auth::id())->delete();
        } else {
            // Clear guest browsing history from session
            session()->forget('guest_browsing_history');
        }

        return redirect()->route('browsing.history')->with('success', 'History cleared.');
    }
}

