<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Selection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function history(Request $request)
    {
        $orders = Order::where("user_id", 1)
            ->with(["orderItems.item"])
            ->orderBy("created_at", "desc")
            ->get();

        return view("order_history", compact("orders"));
    }

    public function paymentProcessing()
    {
        return view("payment");
    }

    public function checkout(Request $request)
    {
        $cart = $request->session()->get("cart", []);

        if (empty($cart)) {
            return redirect()
                ->route("cart")
                ->with("error", "Your cart is empty.");
        }

        $item_ids = array_map(function ($item) {
            return $item["item_id"];
        }, $cart);

        $items = Item::with("images")
            ->whereIn("id", $item_ids)
            ->select("id", "name", "price")
            ->get()
            ->keyBy("id");

        $list = collect([]);
        $subtotal = 0;
        $updatedCart = [];
        $invalidItems = false;

        foreach ($cart as $cart_key => $cart_item) {
            $item_id = $cart_item["item_id"];
            $quantity = $cart_item["quantity"];
            $selection_id = $cart_item["item_selection"] ?? null;

            $item = $items->get($item_id);

            if ($item) {
                $selection_option = $selection_id
                    ? ItemSelection::where("id", $selection_id)->value("option")
                    : null;

                $list->push(
                    (object) [
                        "item_id" => $item_id,
                        "name" => $item->name,
                        "price" => $item->price,
                        "qty" => $quantity,
                        "item_selection" => $selection_option ?? "N/A",
                        "image" => $item->images->isNotEmpty()
                            ? $item->images->first()->url
                            : null,
                    ],
                );

                $subtotal += $item->price * $quantity;
                $updatedCart[$cart_key] = $cart_item;
            } else {
                $invalidItems = true;
            }
        }

        $request->session()->put("cart", $updatedCart);

        if ($invalidItems) {
            $request
                ->session()
                ->flash(
                    "warning",
                    "Some items in your cart are no longer available and have been removed.",
                );
        }

        $shippingFee = 5.0;
        $total = $subtotal + $shippingFee;

        $user = User::find(1);

        if (!$user) {
            return redirect()
                ->route("cart")
                ->with("error", "User not found.");
        }

        return view(
            "checkout",
            compact("list", "subtotal", "shippingFee", "total", "user"),
        );
    }

    public function processCheckout(Request $request)
    {
        $cart = $request->session()->get("cart", []);
        if (empty($cart)) {
            return redirect()
                ->route("cart")
                ->with("error", "Your cart is empty.");
        }

        $paymentMethod = $request->input("payment_method");
        if (!$paymentMethod) {
            return redirect()
                ->route("checkout")
                ->with("error", "Please select a payment method.");
        }

        $subtotal = collect($cart)->sum(function ($cartItem) {
            $item = Item::find($cartItem["item_id"]);
            return $item ? $item->price * $cartItem["quantity"] : 0;
        });
        $shippingFee = 5.0;
        $total = $subtotal + $shippingFee;

        $order = Order::create([
            "user_id" => 1,
            "total_price" => $total,
            "status" => "completed",
        ]);

        foreach ($cart as $cartItem) {
            $item = Item::find($cartItem["item_id"]);
            if ($item) {
                $selection_id = $cartItem["item_selection"] ?? null;
                $selection_option = $selection_id
                    ? ItemSelection::where("id", $selection_id)->value("option")
                    : null;

                OrderItem::create([
                    "order_id" => $order->id,
                    "item_id" => $item->id,
                    "item_name" => $item->name ?? "Unknown Product",
                    "item_selection" => $selection_option ?? "N/A",
                    "quantity" => $cartItem["quantity"],
                    "price" => $item->price,
                    "image" => $item->image ?? "images/default-image.jpg",
                ]);
            }
        }

        $request->session()->put("order", [
            "id" => $order->id,
            "subtotal" => $subtotal,
            "shipping_fee" => $shippingFee,
            "total" => $total,
            "payment_method" => $paymentMethod,
        ]);

        $request->session()->forget("cart");

        return redirect()->route("payment.processing");
    }

    public function addToCart(Request $request)
    {
        $item_id = $request->input("item_id");
        $quantity = $request->input("quantity", 1);
        $selection_id = $request->input("item_selection");

        $cart = $request->session()->get("cart", []);
        $cart_key = $item_id . "_" . ($selection_id ?? "");
        $cart[$cart_key] = [
            "item_id" => $item_id,
            "quantity" => $quantity,
            "item_selection" => $selection_id,
        ];

        $request->session()->put("cart", $cart);

        return response()->json([
            "success" => true,
            "message" => "Item added to cart!",
        ]);
    }

    public function cart(Request $request)
    {
        $cart = $request->session()->get("cart", []);

        if (empty($cart)) {
            $list = collect([]);
            $total = 0;
            return view("shopping_cart", compact("list", "total"));
        }

        $item_ids = array_map(function ($item) {
            return $item["item_id"];
        }, $cart);

        $items = Item::with("images")
            ->whereIn("id", $item_ids)
            ->select("id", "name", "price")
            ->get()
            ->keyBy("id");

        $list = collect([]);
        $total = 0;

        foreach ($cart as $cart_key => $cart_item) {
            $item_id = $cart_item["item_id"];
            $quantity = $cart_item["quantity"];
            $selection_option = $cart_item["item_selection"] ?? null;

            $item = $items->get($item_id);

            if ($item) {
                $list->push(
                    (object) [
                        "item_id" => $item_id,
                        "name" => $item->name,
                        "price" => $item->price,
                        "image" => $item->images->first()->url ?? null,
                        "qty" => $quantity,
                        "item_selection" => $selection_option,
                    ],
                );

                $total += $item->price * $quantity;
            }
        }

        return view("shopping_cart", compact("list", "total"));
    }

    public function updateCart(Request $request, $item_id)
    {
        $quantity = $request->input("quantity");
        $cart = $request->session()->get("cart", []);

        foreach ($cart as $cart_key => $cart_item) {
            if ($cart_item["item_id"] == $item_id) {
                $cart[$cart_key]["quantity"] = $quantity;
                break;
            }
        }

        $request->session()->put("cart", $cart);

        return redirect()
            ->route("cart")
            ->with("success", "Cart updated!");
    }

    public function removeFromCart(Request $request, $item_id)
    {
        $cart = $request->session()->get("cart", []);

        foreach ($cart as $cart_key => $cart_item) {
            if ($cart_item["item_id"] == $item_id) {
                unset($cart[$cart_key]);
                break;
            }
        }

        $request->session()->put("cart", $cart);

        return redirect()
            ->route("cart")
            ->with("success", "Item removed from cart!");
    }
}
