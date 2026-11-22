<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('home')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cartItems)->sum(
            fn($item) => (float) $item['price']
                * (int) $item['quantity']
        );

        return view('checkout', compact('cartItems', 'subtotal'));
    }

    public function placeOrder(Request $request)
{
    $request->validate([
        'phone' => ['required', 'string', 'max:30'],
        'name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:1000'],
        'city' => ['required', 'string', 'max:100'],
        'postal_code' => ['nullable', 'string', 'max:20'],
        'payment_method' => ['required', 'in:cod'],
    ]);

    $cartItems = session('cart', []);

    if (empty($cartItems)) {
        return redirect()->route('checkout')
            ->withErrors(['cart' => 'Your cart is empty.']);
    }

    $subtotal = collect($cartItems)->sum(
        fn ($item) => (float) $item['price']
            * (int) $item['quantity']
    );

    $deliveryFee = 200;

    $order = [
        'order_number' => 'SM-' . strtoupper(
            \Illuminate\Support\Str::random(8)
        ),
        'name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
        'city' => $request->city,
        'postal_code' => $request->postal_code,
        'items' => array_values($cartItems),
        'subtotal' => $subtotal,
        'delivery_fee' => $deliveryFee,
        'total' => $subtotal + $deliveryFee,
    ];

    session()->forget('cart');

    return view('confirmation_order', compact('order'));
}
}
