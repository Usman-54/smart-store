<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
public function checkout()
{
    $cartItems = session()->get('cart', []);

    if (empty($cartItems)) {
        return redirect()->route('home')
            ->with('error', 'Your cart is empty.');
    }

    // Calculate the actual cart total
    $totalAmount = collect($cartItems)->sum(
        fn ($item) => (float) $item['price']
            * (int) $item['quantity']
    );

    return view('payment', [
        'storeName'   => 'Smart-Mall',
        'orderNumber' => 'ORD-' . strtoupper(uniqid()),
        'orderDate'   => now(),
        'cartItems'   => $cartItems,
        'totalAmount' => $totalAmount,
    ]);
}


    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => [
                'required',
                'in:card,wallet,raast,bank',
            ],

            'wallet_provider' => [
                'required_if:payment_method,wallet',
                'nullable',
                'in:easypaisa,jazzcash',
            ],
            'wallet_mobile' => [
                'required_if:payment_method,wallet',
                'nullable',
                'string',
                'max:20',
            ],
            'wallet_cnic' => [
                'nullable',
                'string',
                'max:15',
            ],

            'raast_id' => [
                'required_if:payment_method,raast',
                'nullable',
                'string',
                'max:100',
            ],

            'bank_name' => [
                'required_if:payment_method,bank',
                'nullable',
                'in:HBL,UBL,MCB,ABL,Meezan Bank,NBP',
            ],
            'account_iban' => [
                'required_if:payment_method,bank',
                'nullable',
                'string',
                'max:100',
            ],
            'bank_cnic' => [
                'nullable',
                'string',
                'max:15',
            ],
        ]);

        /*
         * TODO: Connect your approved payment gateway here.
         *
         * Do not mark the order as paid until the gateway confirms
         * the payment server-side.
         */

        if ($validated['payment_method'] === 'card') {
            return back()->with(
                'error',
                'Card payments are not configured yet. Please connect your payment gateway.'
            );
        }

        return back()->with(
            'error',
            'Payment processing is not configured yet. No payment has been taken.'
        );
    }
}