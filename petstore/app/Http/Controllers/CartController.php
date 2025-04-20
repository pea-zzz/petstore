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
        $user = auth()->user(); // 获取当前登录用户
        $orders = $user->orders()->with('orderItems.item')->get(); // 获取用户的所有订单，并加载订单项及对应的商品
    
        return view('order_history', compact('orders'));
    }
    

    public function paymentProcessing()
    {
        return view("payment");
    }

    public function checkout(Request $request)
    {
        // 获取当前用户的购物车
        $cart = ShoppingCart::where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return redirect()
                ->route("cart")
                ->with("error", "Your cart is empty.");
        }

        // 获取购物车中的 item_ids
        $item_ids = $cart->pluck('item_id')->toArray();

        // 获取与购物车项相关的商品
        $items = Item::with('images')
            ->whereIn('id', $item_ids)
            ->select('id', 'name', 'price')
            ->get()
            ->keyBy('id');

        $list = collect([]);
        $subtotal = 0;
        $updatedCart = [];
        $invalidItems = false;

        // 更新购物车数据
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

        // 计算运费和总价
        $shippingFee = 5.0;
        $total = $subtotal + $shippingFee;

        // 用户验证
        $user = Auth::user();

        if (!$user) {
            return redirect()
                ->route("cart")
                ->with("error", "User not found.");
        }

        // 渲染结账页面
        return view('checkout', compact('list', 'subtotal', 'shippingFee', 'total', 'user'));
    }


    public function processCheckout(Request $request)
    {
        // 获取当前用户的购物车
        $cart = ShoppingCart::where('user_id', Auth::id())->get();
    
        if ($cart->isEmpty()) {
            return redirect()
                ->route("cart")
                ->with("error", "Your cart is empty.");
        }
    
        // 获取支付方式
        $paymentMethod = $request->input("payment_method");
        if (!$paymentMethod) {
            return redirect()
                ->route("checkout")
                ->with("error", "Please select a payment method.");
        }
    
        // 计算小计、运费和总价
        $subtotal = $cart->sum(function ($cartItem) {
            $item = Item::find($cartItem->item_id);
            return $item ? $item->price * $cartItem->quantity : 0;
        });
    
        $shippingFee = 5.0;
        $total = $subtotal + $shippingFee;
    
        // 创建订单
        $order = Order::create([
            "user_id" => Auth::id(),
            "total_price" => $total,
            "status" => "completed",
        ]);
    
        // 创建订单项
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
            }
        }
    
        // 删除用户购物车中的商品
        $cart->each(function ($cartItem) {
            $cartItem->delete();
        });
    
        // 创建支付信息并清空购物车
        $request->session()->put("order", [
            "id" => $order->id,
            "subtotal" => $subtotal,
            "shipping_fee" => $shippingFee,
            "total" => $total,
            "payment_method" => $paymentMethod,
        ]);
    
        // 重定向到支付页面
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
            $list->push((object)[
                'id' => $cartItem->id, // 添加这个字段！
                'item_id' => $cartItem->item_id,
                'name' => $cartItem->item->name,
                'price' => $cartItem->item->price,
                'image' => optional($cartItem->item->images->first())->url,
                'qty' => $cartItem->quantity, // 这个字段原本是 quantity
                'item_selection' => $cartItem->item_selection,
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
