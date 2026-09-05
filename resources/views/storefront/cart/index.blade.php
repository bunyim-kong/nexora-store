@extends('layouts.storefront')

@section('title', 'Shopping Cart')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/cart.css') }}">
@endpush

@section('content')
<section class="container cart-page">
    <div class="top-section">
        <a href="{{ route('product.index') }}" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Continue Shopping
        </a>
    </div>

    <h1 class="page-title">Shopping Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(!empty($cart))
        <div class="cart-layout">
            <!-- Items -->
            <div class="cart-items-card">
                <div class="cart-item-head">
                    <span>Product</span>
                    <span>Price</span>
                    <span>Quantity</span>
                    <span>Subtotal</span>
                    <span></span>
                </div>

                <div id="cart-items">
                    @foreach($cart as $id => $item)
                        <div class="cart-item-row" data-product-id="{{ $id }}">
                            <div class="cart-product">
                                <img src="{{ asset('images/' . ($item['image'] ?? 'placeholder.jpg')) }}"
                                     alt="{{ $item['name'] }}">
                                <span class="cart-product-name">{{ $item['name'] }}</span>
                            </div>

                            <div class="cart-price">${{ number_format($item['price'], 2) }}</div>

                            <div class="quantity-selector">
                                <button type="button" class="qty-btn quantity-btn" data-action="decrease">−</button>
                                <input type="number" value="{{ $item['quantity'] }}" min="1"
                                       class="quantity-input"
                                       data-product-id="{{ $id }}">
                                <button type="button" class="qty-btn quantity-btn" data-action="increase">+</button>
                            </div>

                            <div class="cart-subtotal item-subtotal">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>

                            <button class="cart-remove-btn remove-item" data-product-id="{{ $id }}" aria-label="Remove item">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary -->
            <div class="cart-summary-card">
                <h2 class="cart-summary-title">Order Summary</h2>

                <div class="cart-summary-row">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">${{ number_format($subtotal, 2) }}</span>
                </div>

                <!-- Delivery Option -->
                <div class="delivery-options">
                    <label class="delivery-option">
                        <input type="radio" name="delivery_method" value="standard" {{ $deliveryMethod === 'standard' ? 'checked' : '' }}>
                        <div class="delivery-option-info">
                            <span class="delivery-option-label">Standard Delivery</span>
                            <span class="delivery-option-hint">Regular shipping (1–2 business days)</span>
                        </div>
                        <span class="delivery-option-price">$2.00</span>
                    </label>

                    <label class="delivery-option">
                        <input type="radio" name="delivery_method" value="pickup" {{ $deliveryMethod === 'pickup' ? 'checked' : '' }}>
                        <div class="delivery-option-info">
                            <span class="delivery-option-label">Store Pick Up</span>
                            <span class="delivery-option-hint">Pick up directly at our store</span>
                        </div>
                        <span class="delivery-option-price">Free</span>
                    </label>
                </div>

                <!-- Store location panel, only shown for pickup -->
                <div id="store-location-panel" class="store-location-panel" style="{{ $deliveryMethod === 'pickup' ? '' : 'display:none;' }}">
                    <p class="store-location-text">Click below to view our location on Google Maps and pick up your order.</p>
                    <a href="https://maps.app.goo.gl/hux9Dh7R86kbCCgv6?g_st=atm" target="_blank" rel="noopener" class="store-location-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        Open Store on Google Maps
                    </a>
                </div>

                <div class="cart-summary-row">
                    <span>Delivery Fee</span>
                    <span id="cart-delivery">
                        @if($deliveryFee == 0)
                            <span class="free-delivery-badge">FREE</span>
                        @else
                            ${{ number_format($deliveryFee, 2) }}
                        @endif
                    </span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total</span>
                    <span id="cart-total">${{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="cart-checkout-btn">
                    Proceed to Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </a>

                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cart-clear-btn" onclick="return confirm('Clear your cart?')">
                        Clear Cart
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="cart-empty">
            <p>Your cart is empty.</p>
            <a href="{{ route('product.index') }}">Continue Shopping →</a>
        </div>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.quantity-selector').querySelector('.quantity-input');
            const productId = input.dataset.productId;
            let quantity = parseInt(input.value);

            if (this.dataset.action === 'increase') {
                quantity++;
            } else if (this.dataset.action === 'decrease' && quantity > 1) {
                quantity--;
            }

            input.value = quantity;
            updateQuantity(productId, quantity);
        });
    });

    // Delivery method switch
    document.querySelectorAll('input[name="delivery_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const method = this.value;
            const panel = document.getElementById('store-location-panel');
            panel.style.display = method === 'pickup' ? 'block' : 'none';

            fetch(`{{ route('cart.delivery-method') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ method })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const deliveryEl = document.getElementById('cart-delivery');
                    deliveryEl.innerHTML = data.delivery_fee == 0
                        ? '<span class="free-delivery-badge">FREE</span>'
                        : '$' + data.delivery_fee.toFixed(2);
                    document.getElementById('cart-total').textContent = '$' + data.total.toFixed(2);
                }
            })
            .catch(error => console.error('Delivery method update failed:', error));
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const quantity = parseInt(this.value) || 1;
            updateQuantity(productId, quantity);
        });
    });

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
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Request-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`[data-product-id="${productId}"].cart-item-row`);
                if (row) {
                    const subtotal = row.querySelector('.item-subtotal');
                    subtotal.textContent = '$' + data.item_total.toFixed(2);
                }

                document.getElementById('cart-subtotal').textContent = '$' + data.subtotal.toFixed(2);
                
                const deliveryEl = document.getElementById('cart-delivery');
                if (data.delivery_fee == 0) {
                    deliveryEl.innerHTML = '<span class="free-delivery-badge">Free Delivery</span>';
                } else {
                    deliveryEl.textContent = '$' + data.delivery_fee.toFixed(2);
                }

                document.getElementById('cart-total').textContent = '$' + data.total.toFixed(2);

                const cartCount = document.querySelector('.cart-count');
                if (cartCount) cartCount.textContent = data.cart_count;
            }
        })
        .catch(error => console.error('Update quantity failed:', error));
    }

    function removeItem(productId) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`.cart-item-row[data-product-id="${productId}"]`);
                if (row) row.remove();

                const cartCount = document.querySelector('.cart-count');
                if (cartCount) cartCount.textContent = data.cart_count;

                if (data.cart_count === 0) {
                    location.reload();
                } else {
                    fetch(`/cart/update/${productId}`); // no-op placeholder removed below
                }
            }
        })
        .catch(error => console.error('Remove item failed:', error));
    }
});
</script>
@endsection