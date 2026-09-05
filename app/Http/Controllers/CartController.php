<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function calculateTotals(array $cart): array
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $deliveryMethod = session()->get('delivery_method', 'standard');
        $deliveryFee = $deliveryMethod === 'pickup' ? 0 : 2.00;
        $total = $subtotal + $deliveryFee;

        return [$subtotal, $deliveryFee, $total, $deliveryMethod];
    }

    // Show cart page
    public function index()
    {
        $cart = session()->get('cart', []);
        [$subtotal, $deliveryFee, $total, $deliveryMethod] = $this->calculateTotals($cart);

        return view('storefront.cart.index', compact('cart', 'subtotal', 'deliveryFee', 'total', 'deliveryMethod'));
    }

    // Add to cart
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->quantity ?? 1;

        $finalPrice = (!is_null($product->discount_price) && $product->discount_price > 0 && $product->discount_price < $product->price)
            ? $product->discount_price
            : $product->price;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $finalPrice,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $cartCount
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    // Update quantity
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Item not found in cart'], 404);
        }

        $cart[$productId]['quantity'] = max(1, (int) $request->quantity);
        session()->put('cart', $cart);

        [$subtotal, $deliveryFee, $total] = $this->calculateTotals($cart);

        return response()->json([
            'success' => true,
            'item_total' => $cart[$productId]['price'] * $cart[$productId]['quantity'],
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // Switch delivery method (standard vs pickup)
    public function setDeliveryMethod(Request $request)
    {
        $request->validate([
            'method' => 'required|in:standard,pickup',
        ]);

        session()->put('delivery_method', $request->method);

        $cart = session()->get('cart', []);
        [$subtotal, $deliveryFee, $total] = $this->calculateTotals($cart);

        return response()->json([
            'success' => true,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
        ]);
    }

    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // Clear cart
    public function clear()
    {
        session()->forget('cart');
        session()->forget('delivery_method');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}