@extends('layouts.storefront')

@section('title', 'Shopping Cart')

@section('content')
<section class="container py-8">
    <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(!empty($cart))
        <div class="rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="cart-items">
                    @foreach($cart as $id => $item)
                        <tr data-product-id="{{ $id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('images/' . ($item['image'] ?? 'placeholder.jpg')) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-16 h-16 object-cover rounded">
                                    <span class="ml-4">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">${{ number_format($item['price'], 2) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center border rounded-lg">
                                    <button class="px-3 py-1 hover:bg-gray-100 quantity-btn" data-action="decrease">-</button>
                                    <input type="number" value="{{ $item['quantity'] }}" min="1" 
                                           class="w-12 text-center border-0 quantity-input" 
                                           data-product-id="{{ $id }}">
                                    <button class="px-3 py-1 hover:bg-gray-100 quantity-btn" data-action="increase">+</button>
                                </div>
                            </td>
                            <td class="px-6 py-4 item-subtotal">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td class="px-6 py-4">
                                <button class="text-red-600 hover:text-red-800 remove-item" data-product-id="{{ $id }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="font-medium">Subtotal:</span>
                                    <span id="cart-subtotal">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Delivery Fee:</span>
                                    <span id="cart-delivery">${{ number_format($deliveryFee, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t pt-2">
                                    <span>Total:</span>
                                    <span id="cart-total">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('product.index') }}" class="text-blue-600 hover:text-blue-700">
                ← Continue Shopping
            </a>
            <div class="flex gap-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg" onclick="return confirm('Clear your cart?')">
                        Clear Cart
                    </button>
                </form>
                <a href="{{ route('checkout.index') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                    Proceed to Checkout →
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <p class="text-gray-500">Your cart is empty.</p>
            <a href="{{ route('product.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">
                Continue Shopping →
            </a>
        </div>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.flex').querySelector('.quantity-input');
            const productId = input.dataset.productId;
            let quantity = parseInt(input.value);
            
            if (this.dataset.action === 'increase') {
                quantity++;
            } else if (this.dataset.action === 'decrease' && quantity > 1) {
                quantity--;
            }
            
            updateQuantity(productId, quantity);
        });
    });
    
    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const quantity = parseInt(this.value) || 1;
            updateQuantity(productId, quantity);
        });
    });
    
    // Remove item
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            if (confirm('Remove this item from cart?')) {
                removeItem(productId);
            }
        });
    });
    
    function updateQuantity(productId, quantity) {
        fetch(`/cart/update/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update subtotal for this item
                const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                if (row) {
                    const subtotal = row.querySelector('.item-subtotal');
                    subtotal.textContent = '$' + data.item_total.toFixed(2);
                }
                
                // Update totals
                document.getElementById('cart-subtotal').textContent = '$' + data.subtotal.toFixed(2);
                document.getElementById('cart-delivery').textContent = '$' + data.delivery_fee.toFixed(2);
                document.getElementById('cart-total').textContent = '$' + data.total.toFixed(2);
                
                // Update cart count in header
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) cartCount.textContent = data.cart_count;
            }
        });
    }
    
    function removeItem(productId) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
});
</script>
@endsection