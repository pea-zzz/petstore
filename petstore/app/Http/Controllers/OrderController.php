<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function adminIndex()
    {
        $orders = Order::with(['user', 'orderItems.item'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }
}
