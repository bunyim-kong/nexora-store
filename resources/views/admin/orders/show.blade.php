@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header__text">
        <h2 class="admin-page-header__title">Order #{{ $order->id }}</h2>
        <p class="admin-page-header__subtitle">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
    </div>
    <div class="admin-page-header__actions">
        <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--ghost">
            ← Back to Orders
        </a>
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
            {{ $order->status_text }}
        </span>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2">
        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Order Items</h3>
            <div class="overflow-x-auto">
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
                                <td class="px-4 py-3">
                                    {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                </td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-bold">Subtotal:</td>
                            <td class="px-4 py-3">${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-bold">Delivery Fee:</td>
                            <td class="px-4 py-3">
                                @if($order->delivery_fee == 0)
                                    <span class="text-green-600 font-medium">FREE</span>
                                @else
                                    ${{ number_format($order->delivery_fee, 2) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-bold text-lg">Total:</td>
                            <td class="px-4 py-3 font-bold text-lg">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg mb-4">Customer Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p><strong>Delivery Type:</strong> {{ $order->delivery_fee == 0 ? 'Store Pickup' : 'Standard Delivery' }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t">
                <p><strong>Delivery Address:</strong></p>
                <p class="text-sm text-gray-600">{{ $order->address }}</p>
                @if($order->delivery_instructions)
                    <p class="text-sm text-gray-600 mt-2">
                        <strong>Instructions:</strong> {{ $order->delivery_instructions }}
                    </p>
                @endif
                @if($order->google_maps_link)
                    <p class="text-sm mt-2">
                        <a href="{{ $order->google_maps_link }}" target="_blank" class="text-blue-600 hover:underline">
                            📍 View on Google Maps
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Map & Status -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-24">
            <h3 class="font-semibold text-lg mb-4">
                @if($order->delivery_fee == 0)
                    📍 Store Pickup
                @else
                    📍 Delivery Location
                @endif
            </h3>
            
            @if($order->latitude && $order->longitude && $order->delivery_fee != 0)
                <div id="admin-map" style="height: 250px; width: 100%; border-radius: 8px; border: 1px solid #e5e7eb;"></div>
                <div class="mt-3 text-sm">
                    <p><strong>Latitude:</strong> {{ $order->latitude }}</p>
                    <p><strong>Longitude:</strong> {{ $order->longitude }}</p>
                    @if($order->formatted_address)
                        <p class="mt-2 text-gray-600"><strong>Location:</strong> {{ $order->formatted_address }}</p>
                    @endif
                </div>
                
                <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}" 
                   target="_blank" 
                   class="mt-3 inline-block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Open in Google Maps
                </a>
            @elseif($order->delivery_fee == 0)
                <div class="text-center py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mx-auto mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <p class="text-gray-500">Customer selected store pickup.</p>
                    <a href="https://maps.app.goo.gl/hux9Dh7R86kbCCgv6?g_st=atm" 
                       target="_blank" 
                       class="mt-3 inline-block text-blue-600 hover:text-blue-700">
                        View Store Location →
                    </a>
                </div>
            @elseif($order->google_maps_link)
                <div class="text-center py-4">
                    <p class="text-gray-600 mb-3">Customer shared their location:</p>
                    <a href="{{ $order->google_maps_link }}" 
                       target="_blank" 
                       class="inline-block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        📍 Open Customer Location
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-6">No location data available for this order.</p>
            @endif
            
            <!-- Update Status -->
            <div class="mt-6 pt-6 border-t">
                <h4 class="font-semibold mb-2">Update Order Status</h4>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="mt-2 w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($order->latitude && $order->longitude && $order->delivery_fee != 0)
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initAdminMap" async defer></script>
<script>
function initAdminMap() {
    const location = { lat: {{ $order->latitude }}, lng: {{ $order->longitude }} };
    
    const map = new google.maps.Map(document.getElementById('admin-map'), {
        center: location,
        zoom: 15,
        mapTypeControl: false,
        streetViewControl: true,
        fullscreenControl: true,
    });
    
    const marker = new google.maps.Marker({
        position: location,
        map: map,
        animation: google.maps.Animation.DROP,
        title: 'Delivery Location'
    });
    
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div class="p-2">
                <strong>Delivery Location</strong><br>
                {{ $order->customer_name }}<br>
                {{ $order->address }}
                @if($order->delivery_instructions)
                    <br><small>Note: {{ $order->delivery_instructions }}</small>
                @endif
            </div>
        `
    });
    
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
}
</script>
@endif
@endsection