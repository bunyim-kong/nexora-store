<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Show checkout page
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('product.index')->with('error', 'Your cart is empty.');
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $deliveryFee = $subtotal >= 50 ? 0 : 5.00;
        $total = $subtotal + $deliveryFee;
        
        return view('storefront.checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    // Process order
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $deliveryFee = $subtotal >= 50 ? 0 : 5.00;
            $total = $subtotal + $deliveryFee;
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $id,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    // Update stock (if you have stock field)
                    if (isset($product->stock)) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}