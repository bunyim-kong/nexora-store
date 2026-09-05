<?php

namespace App\Services;

use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

// ... inside the PaymentService class, alongside your existing methods:

/**
 * Generate a KHQR code for a given order.
 * Returns ['qr' => string, 'md5' => string]
 */
public function generateKhqr(Order $order): array
{
    $individualInfo = new IndividualInfo(
        bakongAccountID: config('services.bakong.account_id'),
        merchantName: config('services.bakong.merchant_name'),
        merchantCity: config('services.bakong.merchant_city'),
        currency: KHQRData::CURRENCY_USD,
        amount: (float) $order->total,
    );

    $individualInfo->billNumber = $order->order_number ?? ('ORD-' . $order->id);

    $result = BakongKHQR::generateIndividual($individualInfo);

    return [
        'qr' => $result->getData()['qr'],
        'md5' => $result->getData()['md5'],
    ];
}