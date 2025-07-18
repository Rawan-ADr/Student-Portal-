<?php
namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function createCheckoutSession($amount, $studentId, $requestId)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Document Request Fees',
                    ],
                    'unit_amount' => $amount * 100, // المبلغ بـ سنتات
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            //'success_url' => url('/api/payment/success?request_id=' . $requestId . '&student_id=' . $studentId),
            'success_url' => 'myapp://payment-success?request_id=' . $requestId . '&student_id=' . $studentId,
            'cancel_url' => url('/api/payment/cancel'),
            'metadata' => [
                'student_id' => $studentId,
                'request_id' => $requestId,
            ]
        ]);
    }
}