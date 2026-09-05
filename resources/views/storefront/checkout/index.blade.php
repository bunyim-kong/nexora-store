@extends('layouts.storefront')

@section('title', 'Checkout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/checkout.css') }}">
@endpush

@section('content')
<section class="container checkout-page">
    <div class="top-section">
        <a href="{{ route('cart.index') }}" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Back to Cart
        </a>
    </div>

    <h1 class="page-title">Checkout</h1>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="checkout-layout">
        <!-- Order Summary -->
        <div class="checkout-card">
            <h2 class="checkout-card-title">Order Summary</h2>

            @foreach($cart as $item)
                <div class="checkout-summary-item">
                    <div>
                        <span class="checkout-item-name">{{ $item['name'] }}</span>
                        <span class="checkout-item-qty">× {{ $item['quantity'] }}</span>
                    </div>
                    <span class="checkout-item-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
            @endforeach

            <div class="checkout-totals">
                <div class="checkout-totals-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="checkout-totals-row delivery-row">
                    <span>Delivery Fee</span>
                    <span>
                        @if($deliveryFee == 0)
                            <span class="free-delivery-badge">FREE</span>
                        @else
                            ${{ number_format($deliveryFee, 2) }}
                        @endif
                    </span>
                </div>
                <div class="checkout-totals-row grand-total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <!-- Delivery Method Display -->
            <div class="delivery-method-display">
                <span class="delivery-method-label">Delivery Method:</span>
                <span class="delivery-method-value">
                    @if($deliveryMethod === 'pickup')
                        🏪 Store Pickup
                    @else
                        🚚 Standard Delivery
                    @endif
                </span>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="checkout-card">
            <h2 class="checkout-card-title">Shipping Details</h2>

            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="delivery_method" value="{{ $deliveryMethod }}">

                <div class="checkout-field">
                    <label class="checkout-label">Full Name *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', Auth::user()->name ?? '') }}"
                           class="checkout-input" required>
                    @error('customer_name')
                        <p class="checkout-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="checkout-field">
                    <label class="checkout-label">Phone Number *</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                           class="checkout-input" required>
                    @error('phone_number')
                        <p class="checkout-error">{{ $message }}</p>
                    @enderror
                </div>

                @if($deliveryMethod !== 'pickup')
                    <!-- Delivery Address with Google Maps -->
                    <div class="checkout-field">
                        <label class="checkout-label">Delivery Address</label>
                        <input type="text" id="address-autocomplete" name="address" 
                               placeholder="Start typing your address or paste Google Maps link..."
                               class="checkout-input" value="{{ old('address') }}">
                        <p class="checkout-hint">Start typing your address or paste a Google Maps link</p>
                        @error('address')
                            <p class="checkout-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Or Paste Google Maps Link -->
                    <div class="checkout-field">
                        <label class="checkout-label">Or Paste Google Maps Link</label>
                        <input type="url" id="google-maps-link" name="google_maps_link" 
                               placeholder="https://maps.app.goo.gl/..."
                               class="checkout-input" value="{{ old('google_maps_link') }}">
                        <p class="checkout-hint">Paste a Google Maps share link to show your exact location</p>
                        @error('google_maps_link')
                            <p class="checkout-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Map Container -->
                    <div id="map-container" style="display: none;" class="checkout-field">
                        <label class="checkout-label">Confirm Location on Map</label>
                        <div id="map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid #e5e7eb;"></div>
                        <p class="checkout-hint">Drag the marker to adjust your exact location</p>
                    </div>

                    <!-- Hidden fields for location data -->
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="formatted_address" id="formatted_address">
                    
                    <div class="checkout-field">
                        <label class="checkout-label">Delivery Instructions (Optional)</label>
                        <textarea name="delivery_instructions" rows="2" 
                                  class="checkout-textarea"
                                  placeholder="e.g., Gate code, building number, landmark, etc.">{{ old('delivery_instructions') }}</textarea>
                    </div>
                @else
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
                @endif

                <!-- Payment Method -->
                <div class="checkout-field">
                    <label class="checkout-label">Payment Method *</label>

                    <div class="payment-methods">
                        <label class="payment-option {{ $deliveryMethod === 'pickup' ? 'active' : '' }}">
                            <input type="radio" name="payment_method" value="cash_on_delivery" 
                                   {{ $deliveryMethod !== 'pickup' ? 'checked' : '' }}>
                            <span class="payment-option-label">Cash on Delivery</span>
                            <span class="payment-option-hint">Pay when you receive</span>
                        </label>

                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="aba_qr">
                            <span class="payment-option-label">ABA KHQR</span>
                            <span class="payment-option-hint">Scan to pay with ABA Mobile</span>
                        </label>
                    </div>

                    <!-- ABA QR panel -->
                    <div id="aba-panel" class="payment-panel" style="display:none;">
                        <p class="payment-panel-text">Scan this KHQR code with your ABA Mobile app to pay.</p>
                        <div class="aba-qr-box">
                            <img src="{{ asset('images/qr-code.jpg') }}" alt="ABA KHQR Code">
                        </div>
                        <p class="payment-panel-hint">Total to pay: <strong>${{ number_format($total, 2) }}</strong></p>
                    </div>

                    @error('payment_method')
                        <p class="checkout-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="checkout-submit-btn">
                    Place Order
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method toggle
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const abaPanel = document.getElementById('aba-panel');

    function togglePanels() {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if (selected) {
            abaPanel.style.display = selected.value === 'aba_qr' ? 'block' : 'none';
        }
    }

    paymentRadios.forEach(radio => radio.addEventListener('change', togglePanels));
    togglePanels();

    // Google Maps autocomplete (only if element exists)
    const addressInput = document.getElementById('address-autocomplete');
    if (addressInput) {
        // Extract coordinates from Google Maps link
        const mapsLinkInput = document.getElementById('google-maps-link');
        if (mapsLinkInput) {
            mapsLinkInput.addEventListener('change', function() {
                const link = this.value;
                if (link) {
                    extractCoordinatesFromLink(link);
                }
            });
        }
    }
});

// Global function for Google Maps callback
let autocomplete;
let map;
let marker;
let geocoder;

function initAutocomplete() {
    const input = document.getElementById('address-autocomplete');
    if (!input) return;
    
    // Initialize Autocomplete
    autocomplete = new google.maps.places.Autocomplete(input, {
        componentRestrictions: { country: ['kh'] },
        fields: ['address_components', 'geometry', 'formatted_address']
    });
    
    autocomplete.addListener('place_changed', onPlaceChanged);
    
    // Initialize Geocoder
    geocoder = new google.maps.Geocoder();
    
    input.addEventListener('blur', function() {
        if (this.value) {
            geocodeAddress(this.value);
        }
    });
}

function onPlaceChanged() {
    const place = autocomplete.getPlace();
    
    if (!place.geometry) {
        geocodeAddress(document.getElementById('address-autocomplete').value);
        return;
    }
    
    updateMap(place.geometry.location, place.formatted_address);
}

function geocodeAddress(address) {
    if (!address || !geocoder) return;
    
    geocoder.geocode({ address: address }, function(results, status) {
        if (status === 'OK' && results[0]) {
            const location = results[0].geometry.location;
            const formattedAddress = results[0].formatted_address;
            updateMap(location, formattedAddress);
        }
    });
}

function updateMap(location, address) {
    const mapContainer = document.getElementById('map-container');
    if (mapContainer) mapContainer.style.display = 'block';
    
    document.getElementById('latitude').value = location.lat();
    document.getElementById('longitude').value = location.lng();
    document.getElementById('formatted_address').value = address;
    document.getElementById('address-autocomplete').value = address;
    
    if (!map) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 16,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true,
        });
        
        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });
        
        marker.addListener('dragend', function() {
            const position = marker.getPosition();
            document.getElementById('latitude').value = position.lat();
            document.getElementById('longitude').value = position.lng();
            
            geocoder.geocode({ location: position }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    document.getElementById('formatted_address').value = results[0].formatted_address;
                    document.getElementById('address-autocomplete').value = results[0].formatted_address;
                }
            });
        });
    } else {
        map.setCenter(location);
        marker.setPosition(location);
    }
}

function extractCoordinatesFromLink(link) {
    // Try to extract coordinates from Google Maps link
    const latMatch = link.match(/@([-0-9.]+),([-0-9.]+)/);
    if (latMatch) {
        const lat = parseFloat(latMatch[1]);
        const lng = parseFloat(latMatch[2]);
        if (!isNaN(lat) && !isNaN(lng)) {
            const location = new google.maps.LatLng(lat, lng);
            geocoder.geocode({ location: location }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    updateMap(location, results[0].formatted_address);
                }
            });
        }
    } else {
        // Try to extract place ID or use geocoding
        const address = document.getElementById('address-autocomplete').value;
        if (address) {
            geocodeAddress(address);
        }
    }
}

// Form validation for standard delivery
document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
    const deliveryMethod = '{{ $deliveryMethod }}';
    if (deliveryMethod === 'standard') {
        const address = document.getElementById('address-autocomplete')?.value;
        const lat = document.getElementById('latitude')?.value;
        const lng = document.getElementById('longitude')?.value;
        const mapsLink = document.getElementById('google-maps-link')?.value;
        
        // Allow either address with location or a Google Maps link
        if (!mapsLink && (!address || !lat || !lng)) {
            e.preventDefault();
            alert('Please enter your delivery address or paste a Google Maps link to confirm your location.');
            return false;
        }
    }
});
</script>
@endpush
@endsection