<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Selection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\ShoppingCart;
use App\Models\ItemSelection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function history()
    {
        // Get all orders of the user, including order items and their associated products
        $orders = Order::with(['orderItems.item'])
                    ->where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('order_history', compact('orders'));
    }
    

    public function paymentProcessing()
    {
        return view("payment");
    }

    public function checkout(Request $request)
    {
        // Get the current user's shopping cart
        $cart = ShoppingCart::where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return redirect()
                ->route("cart")
                ->with("error", "Your cart is empty.");
        }

        // Get item IDs from the shopping cart
        $item_ids = $cart->pluck('item_id')->toArray();

        // Get the items associated with the cart entries
        $items = Item::with('images')
            ->whereIn('id', $item_ids)
            ->select('id', 'name', 'price')
            ->get()
            ->keyBy('id');

        $list = collect([]);
        $subtotal = 0;
        $updatedCart = [];
        $invalidItems = false;

        // Update shopping cart data
        foreach ($cart as $cart_item) {
            $item = $items->get($cart_item->item_id);

            if ($item) {
                $selection_option = $cart_item->item_selection ? $cart_item->item_selection : 'N/A';

                $list->push(
                    (object) [
                        'item_id' => $cart_item->item_id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'qty' => $cart_item->quantity,
                        'item_selection' => $selection_option,
                        'image' => $item->images->isNotEmpty() ? $item->images->first()->url : null,
                    ]
                );

                $subtotal += $item->price * $cart_item->quantity;
                $updatedCart[] = $cart_item;
            } else {
                $invalidItems = true;
            }
        }

        // Calculate shipping fee and total price
        $shippingFee = 5.0;
        $total = $subtotal + $shippingFee;

        // User validation
        $user = Auth::user();

        if (!$user) {
            return redirect()
                ->route("cart")
                ->with("error", "User not found.");
        }

        // Render the checkout page
        return view('checkout', compact('list', 'subtotal', 'shippingFee', 'total', 'user'));
    }


    public function processCheckout(Request $request)
    {
        // Get the current user's shopping cart
        $cart = ShoppingCart::where('user_id', Auth::id())->get();
    
        if ($cart->isEmpty()) {
            return redirect()
                ->route("cart")
                ->with("error", "Your cart is empty.");
        }
    
        // Get the payment method
        $paymentMethod = $request->input("payment_method");
        if (!$paymentMethod) {
            return redirect()
                ->route("checkout")
                ->with("error", "Please select a payment method.");
        }
    
        // Calculate subtotal, shipping fee, and total price
        $subtotal = $cart->sum(function ($cartItem) {
            $item = Item::find($cartItem->item_id);
            return $item ? $item->price * $cartItem->quantity : 0;
        });
    
        $shippingFee = 5.0;
        $total = $subtotal + $shippingFee;
    
        // Create an order
        $order = Order::create([
            "user_id" => Auth::id(),
            "total_price" => $total,
            "status" => "completed",
        ]);
    
        // Create order items and update stock values in Item table
        foreach ($cart as $cartItem) {
            $item = Item::find($cartItem->item_id);
            if ($item) {
                $selection_option = $cartItem->item_selection ?? 'N/A';
    
                OrderItem::create([
                    "order_id" => $order->id,
                    "item_id" => $item->id,
                    "item_name" => $item->name ?? "Unknown Product",
                    "item_selection" => $selection_option,
                    "quantity" => $cartItem->quantity,
                    "price" => $item->price,
                    "image" => $item->image ?? "images/default-image.jpg",
                ]);

                // Reduce stock based on the quantity purchased
                $item->stock -= $cartItem->quantity;
                $item->save(); // Save the updated stock value
            }
        }
    
        // Remove items from the user's shopping cart
        $cart->each(function ($cartItem) {
            $cartItem->delete();
        });
    
        // Create payment information
        $request->session()->put("order", [
            "id" => $order->id,
            "subtotal" => $subtotal,
            "shipping_fee" => $shippingFee,
            "total" => $total,
            "payment_method" => $paymentMethod,
        ]);
    
        // Redirect to the payment processing page
        return redirect()->route("payment.processing");
    }
    


    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to your cart.');
        }
        
        $user = Auth::user();
        $item_id = $request->input("item_id");
        $quantity = $request->input("quantity", 1);
        $selection = $request->input("item_selection");

        $existing = ShoppingCart::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->where('item_selection', $selection)
            ->first();

        if ($existing) {
            $existing->quantity += $quantity;
            $existing->save();
        } else {
            ShoppingCart::create([
                'user_id' => $user->id,
                'item_id' => $item_id,
                'item_selection' => $selection,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }


    public function cart()
    {
        $cartItems = ShoppingCart::with('item.images')
            ->where('user_id', Auth::id())
            ->get();
    
        $list = collect();
        $total = 0;
    
        foreach ($cartItems as $cartItem) {
            
            if (!$cartItem->item) {
                continue;               // Skip invalid/deleted items by admin
            }

            $list->push((object)[
                'id' => $cartItem->id,
                'item_id' => $cartItem->item_id,
                'name' => $cartItem->item->name,
                'price' => $cartItem->item->price,
                'image' => optional($cartItem->item->images->first())->url,
                'qty' => $cartItem->quantity,
                'item_selection' => $cartItem->item_selection,
                'stock' => $cartItem->item->stock, 
            ]);            
            $total += $cartItem->item->price * $cartItem->quantity;
        }
    
        return view('shopping_cart', compact('list', 'total'));
    }
    
    
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Find the cart item by its ID
        $cartItem = ShoppingCart::where('id', $id)
            ->where('user_id', Auth::id())  // Ensure that the item belongs to the authenticated user
            ->first();
    
        if ($cartItem) {
            // Update the quantity
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            
            return redirect()->route('shopping.cart')->with('success', 'Cart updated successfully');
        } else {
            return redirect()->route('shopping.cart')->with('error', 'Item not found in your cart');
        }
    }
    
    
    public function removeFromCart($id)
    {
        ShoppingCart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        
        return redirect()->route('shopping.cart')->with('success', 'Item removed from cart!');
    }
}