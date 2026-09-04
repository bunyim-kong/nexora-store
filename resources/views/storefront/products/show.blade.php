@extends('layouts.storefront')

@section('title', 'NEXORA — ' . ($product->name ?? 'Product Detail'))

@section('content')
<section class="container product-detail">
    <div class="top-section">
        <a class="back-btn" href="{{ route('product.index') }}"> 
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Back
        </a>
    </div>

    <div class="product-detail-section">
        <div class="product-detail-wrapper">
            <div class="product-image-section">
                <div class="product-image-container">
                    <img src="{{ $product->image ? asset('images/'.$product->image) : asset('images/placeholder.jpg') }}" 
                        alt="{{ $product->name ?? 'Product' }}" 
                        id="main-product-image">
                    
                    @if(isset($product->is_best_seller) && $product->is_best_seller)
                        <div class="product-badge best-seller">Best Seller</div>
                    @endif
                    
                    @if(isset($product->is_featured) && $product->is_featured)
                        <div class="product-badge featured">Featured</div>
                    @endif
                </div>
            </div>

            <div class="product-info-section">
                <div class="product-stock-status">
                    @if(($product->stock ?? 0) > 0)
                        <span class="in-stock">✓ In Stock</span>
                    @else
                        <span class="out-of-stock">× Out of Stock</span>
                    @endif
                </div>

                <h1 class="product-title">{{ $product->name ?? 'Product Name' }}</h1>

                <div class="product-price">
                    @if(isset($product->discount_price) && $product->discount_price > 0)
                        <span class="original-price">${{ number_format($product->price, 2) }}</span>
                        <span class="discounted-price">${{ number_format($product->price * (1 - $product->discount_price / 100), 2) }}</span>
                        <span class="discount-badge">-{{ $product->discount_price }}%</span>
                    @else
                        <span class="current-price">${{ number_format($product->price ?? 0, 2) }}</span>
                    @endif
                </div>

                @if(isset($product->options) && count($product->options) > 0)
                    <div class="product-options">
                        @foreach($product->options as $option)
                            <div class="option-group">
                                <label class="option-label">{{ $option->name }}</label>
                                <div class="option-values">
                                    @foreach($option->values as $value)
                                        <button class="option-btn {{ $loop->first ? 'active' : '' }}">
                                            {{ $value }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="product-meta-info">
                    <div class="meta-item">
                        <span class="meta-label">Stock:</span>
                        <span class="meta-value">{{ ($product->stock ?? 0) > 0 ? 'In stock' : 'Out of stock' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">SKU:</span>
                        <span class="meta-value">{{ $product->sku ?? '—' }}</span>
                    </div>
                    @if(isset($product->brand) && $product->brand)
                    <div class="meta-item">
                        <span class="meta-label">Brand:</span>
                        <span class="meta-value">{{ $product->brand }}</span>
                    </div>
                    @endif
                    @if(isset($product->category) && $product->category)
                    <div class="meta-item">
                        <span class="meta-label">Category:</span>
                        <span class="meta-value">{{ $product->category->name }}</span>
                    </div>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form" id="add-to-cart-form">
                    @csrf
                    <div class="product-cart-section">
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" onclick="decrementQuantity()">−</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock ?? 0 }}" readonly>
                            <button type="button" class="qty-btn" onclick="incrementQuantity()">+</button>
                        </div>
                        
                        <button type="submit" class="add-to-cart-btn" {{ ($product->stock ?? 0) <= 0 ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                    </form>

                <!-- <div class="product-cart-section">
                    <div class="quantity-selector">
                        <button class="qty-btn" onclick="decrementQuantity()">−</button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock ?? 0 }}" readonly>
                        <button class="qty-btn" onclick="incrementQuantity()">+</button>
                    </div>

                    <!-- <div class="cart-total">
                        <span class="total-label">Total</span>
                        <span class="total-price" id="total-price">
                            ${{ number_format($product->price ?? 0, 2) }}
                        </span>
                    </div> -->

                    
                </div> -->
            </div>
        </div>

        <div class="description-section">
            <div class="product-description">
                <h3 class="spec-title">Description</h3>
                <p class="description-short">{{ $product->des ?? 'No description available' }}</p>
                
                <div class="specifications">
                    <h3 class="spec-title">Specifications</h3>
                    
                    @if(isset($product->specs) && is_array($product->specs))
                        <div class="spec-grid">
                            @foreach($product->specs as $key => $value)
                                <div class="spec-item">
                                    <span class="spec-label">{{ $key }}:</span>
                                    <span class="spec-value">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="spec-grid">
                            @php
                                $sampleSpecs = [
                                    'Sensor' => 'PixArt PAW3395 SE',
                                    'DPI' => 'Up to 18,000 DPI',
                                    'Polling Rate' => '125Hz – 2000Hz',
                                    'Weight' => '51g–55g',
                                    'Battery' => '500mAh',
                                    'Battery Life' => '~35–75 hours (depends on polling rate)',
                                    'Connection' => 'Wired USB-C + 2.4GHz + Bluetooth',
                                    'Switches' => 'Huano Blue Glow V2 / Ice Berry Pink Dot',
                                    'Scroll Wheel' => 'Kailih GE upgraded encoder',
                                    'Size' => '120.6 × 64 × 37.8 mm',
                                    'Feet' => 'PTFE skates',
                                    'Shape' => 'Symmetrical lightweight FPS shape',
                                    'Software' => 'Web software + ATK HUB support'
                                ];
                            @endphp
                            
                            @foreach($sampleSpecs as $key => $value)
                                <div class="spec-item">
                                    <span class="spec-label">{{ $key }}:</span>
                                    <span class="spec-value">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="quick-recap">
                    <h3 class="recap-title">Quick recap</h3>
                    <ul class="recap-list">
                        <li>Excellent budget lightweight mouse</li>
                        <li>Great for Valorant, CS2, Apex, and FPS games</li>
                        <li>Comfortable for claw and fingertip grip</li>
                        <li>Very good battery life for the price</li>
                        <li>Strong value compared to Logitech and Razer budget mice</li>
                    </ul>
                </div>

                <div class="more-btn">
                    <button class="read-more-btn" onclick="toggleDescription()">
                        <span id="read-more-text">Read Full Description</span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="chevron-down">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
            </div>

            
        </div>
    </div>

    

    
</section>

<!-- JavaScript for quantity and total price -->
<script>
    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        let value = parseInt(input.value);
        if (value < max) {
            input.value = value + 1;
            updateTotal();
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
            updateTotal();
        }
    }

    function updateTotal() {
        const quantity = parseInt(document.getElementById('quantity').value);
        const price = {{ $product->price ?? 0 }};
        const total = quantity * price;
        document.getElementById('total-price').textContent = '$' + total.toFixed(2);
    }

    function toggleDescription() {
        const description = document.querySelector('.product-description');
        const btnText = document.getElementById('read-more-text');
        const chevron = document.querySelector('.chevron-down');
        
        description.classList.toggle('expanded');
        
        if (description.classList.contains('expanded')) {
            btnText.textContent = 'Show Less';
            chevron.style.transform = 'rotate(180deg)';
        } else {
            btnText.textContent = 'Read Full Description';
            chevron.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endsection