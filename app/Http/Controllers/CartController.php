<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show cart page
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $deliveryFee = $subtotal >= 50 ? 0 : 5.00;
        $total = $subtotal + $deliveryFee;
        
        return view('storefront.cart.index', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    // Add to cart
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->quantity ?? 1;
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }
        
        session()->put('cart', $cart);
        
        // Get cart count
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

    // Update cart
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            // Recalculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $deliveryFee = $subtotal >= 50 ? 0 : 5.00;
            $total = $subtotal + $deliveryFee;
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'item_total' => $cart[$productId]['price'] * $cart[$productId]['quantity'],
                    'subtotal' => $subtotal,
                    'delivery_fee' => $deliveryFee,
                    'total' => $total,
                    'cart_count' => array_sum(array_column($cart, 'quantity'))
                ]);
            }
        }
        
        return back();
    }

    public function remove(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart!',
                    'cart_count' => array_sum(array_column($cart, 'quantity'))
                ]);
            }
        }
        
        return back()->with('success', 'Item removed from cart!');
    }

    // Clear cart
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}