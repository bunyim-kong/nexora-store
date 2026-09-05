@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header__text">
        <h2 class="admin-page-header__title">All Orders</h2>
        <p class="admin-page-header__subtitle">Manage all customer orders</p>
    </div>
    <div class="admin-page-header__actions">
        <span class="text-sm text-gray-500">
            Pending: {{ \App\Models\Order::where('status', 'pending')->count() }}
        </span>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Location</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td class="font-medium">#{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->phone_number }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                        <span class="text-xs">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </td>
                    <td>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
                            {{ $order->status_text }}
                        </span>
                    </td>
                    <td>
                        @if($order->latitude && $order->longitude)
                            <span class="text-green-600 text-sm">📍 Map</span>
                        @elseif($order->delivery_fee == 0)
                            <span class="text-blue-600 text-sm">🏪 Pickup</span>
                        @else
                            <span class="text-gray-400 text-sm">—</span>
                        @endif
                    </td>
                    <td class="text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="admin-btn admin-btn--ghost admin-btn--sm">
                                View
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Delete this order? This cannot be undone.');"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="admin-table-empty">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-pagination">
    {{ $orders->links() }}
</div>
@endsection