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
        
        // Get delivery method from session (set in cart)
        $deliveryMethod = session()->get('delivery_method', 'standard');
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $deliveryFee = $deliveryMethod === 'pickup' ? 0 : 2.00;
        $total = $subtotal + $deliveryFee;
        
        return view('storefront.checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'total', 'deliveryMethod'));
    }

    // Process order
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,pickup,aba_qr',
            'delivery_method' => 'required|in:standard,pickup',
            'google_maps_link' => 'nullable|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'formatted_address' => 'nullable|string',
            'delivery_instructions' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        
        try {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $deliveryFee = $request->delivery_method === 'pickup' ? 0 : 2.00;
            $total = $subtotal + $deliveryFee;
            
            // Prepare address
            $address = $request->address;
            if ($request->formatted_address) {
                $address = $request->formatted_address;
            }
            
            // Create order with location data
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'phone_number' => $request->phone_number,
                'address' => $address,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'formatted_address' => $request->formatted_address,
                'delivery_instructions' => $request->delivery_instructions,
                'google_maps_link' => $request->google_maps_link,
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

                    if (isset($product->stock)) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }

            session()->forget('cart');
            session()->forget('delivery_method');

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}