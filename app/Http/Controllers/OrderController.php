<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class OrderController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'payment_method' => 'required|in:COD,Stripe',
    ]);

    // Check if the customer already has an order
    $existingOrder = Order::where('user_id', auth()->id())->first();
    if ($existingOrder) {
        return back()->with('error', 'You can only place one vendor item at a time.');
    }

    // Create the order
    $order = Order::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
        'payment_method' => $request->payment_method,
        'is_paid' => $request->payment_method === 'COD' ? true : false,
    ]);

    return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
}

public function processPayment(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    try {
        $charge = Charge::create([
            'amount' => 1000, // Amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Order Payment',
        ]);

        // Update order as paid
        $order = Order::find($request->order_id);
        $order->update(['is_paid' => true]);

        return redirect()->route('orders.index')->with('success', 'Payment successful.');
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

}
}