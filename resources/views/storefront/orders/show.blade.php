@extends('layouts.storefront')

@section('title', 'Order #' . $order->id)

@section('content')
<section class="container py-8">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-700">
            ← Back to Orders
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">Order #{{ $order->id }}</h1>
                    <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
                    {{ $order->status_text }}
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold mb-2">Customer Information</h3>
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
                    <p><strong>Address:</strong> {{ $order->address }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Order Summary</h3>
                    <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                    <p><strong>Delivery Fee:</strong> ${{ number_format($order->delivery_fee, 2) }}</p>
                    <p class="text-lg font-bold"><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                </div>
            </div>

            @if($qrDataUri)
                <div class="border rounded-lg p-6 mb-6 text-center bg-gray-50">
                    <h3 class="font-semibold mb-3">Scan to Pay with KHQR</h3>
                    <img src="{{ $qrDataUri }}" alt="KHQR Payment Code" class="mx-auto mb-3" style="width: 280px; height: 280px;">
                    <p class="text-sm text-gray-500">Amount: ${{ number_format($order->total, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-2">Scan this with any Bakong-member banking app (ABA, ACLEDA, Wing, etc.)</p>
                </div>
            @endif
            
            <h3 class="font-semibold mb-2">Order Items</h3>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->product->name ?? 'Product #' . $item->product_id }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-3">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection