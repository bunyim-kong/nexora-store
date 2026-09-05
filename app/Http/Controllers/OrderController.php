<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('storefront.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {a<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('storefront.orders.index', compact('orders'));
    }

    public function show(Order $order, PaymentService $paymentService)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load('orderItems.product');

        $qrDataUri = null;

        if ($order->payment_method === 'aba_qr' && $order->payment_status === 'unpaid') {
            $khqr = $paymentService->generateKhqr($order);

            $result = Builder::create()
                ->data($khqr['qr'])
                ->size(280)
                ->margin(10)
                ->build();

            $qrDataUri = $result->getDataUri();
        }

        return view('storefront.orders.show', compact('order', 'qrDataUri'));
    }
}
            abort(403);
        }
        
        $order->load('orderItems.product');
        return view('storefront.orders.show', compact('order'));
    }
}