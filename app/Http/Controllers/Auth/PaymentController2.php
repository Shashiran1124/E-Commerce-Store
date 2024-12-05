<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController2 extends Controller
{
    public function processPayment(Request $request)
{
    // Use Stripe SDK to process payment
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    $payment = $stripe->charges->create([
        'amount' => 5000, // Amount in cents
        'currency' => 'usd',
        'source' => $request->input('token'), // Token from frontend
        'description' => 'Payment Description',
    ]);
    return response()->json($payment);
}

}
