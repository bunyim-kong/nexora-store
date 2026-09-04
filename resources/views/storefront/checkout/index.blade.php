@extends('layouts.storefront')

@section('title', 'Checkout')

@section('content')
<section class="container py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Order Summary</h2>
                @foreach($cart as $item)
                    <div class="flex justify-between py-2 border-b">
                        <div>
                            <span class="font-medium">{{ $item['name'] }}</span>
                            <span class="text-sm text-gray-500">× {{ $item['quantity'] }}</span>
                        </div>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Delivery Fee</span>
                        <span>${{ number_format($deliveryFee, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Checkout Form -->
        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Shipping Details</h2>
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', Auth::user()->name ?? '') }}" 
                               class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        @error('customer_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" 
                               class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Address *</label>
                        <textarea name="address" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 bg-blue-50 border-blue-500">
                                <input type="radio" name="payment_method" value="cash_on_delivery" class="mr-3" checked>
                                <span class="font-medium">Cash on Delivery</span>
                                <span class="ml-auto text-sm text-gray-500">Pay when you receive</span>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection