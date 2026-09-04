@extends('layouts.storefront')

@section('title', 'My Orders')

@section('content')
<section class="container py-8">
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>
    
    @if($orders->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4">${{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
                                    {{ $order->status_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-700">
                                    View Details →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <p class="text-gray-500">You haven't placed any orders yet.</p>
            <a href="{{ route('product.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">
                Start Shopping →
            </a>
        </div>
    @endif
</section>
@endsection