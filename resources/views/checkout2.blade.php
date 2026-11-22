
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | Smart Mart</title>
    
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    
</head>
<body>
<div class="checkout-wrap">
    
    <a href="{{ url('/index') }}" class="back-link"
           aria-label="Back to checkout">
            <i class="fa-solid fa-arrow-left"></i>
            <span>SMART-MALL</span>
        </a>

    <div class="row g-4 mt-3">
        <div class="col-lg-7">
            <h4 class="mb-4">Checkout</h4>

            <form action="{{ route('checkout.place') }}" method="POST">
                @csrf

                <h6>Contact information</h6>

                <input class="form-control mb-3" type="text" name="phone"
                       placeholder="Phone number" value="{{ old('phone') }}" required>

                <h6 class="mt-4">Shipping address</h6>
                <input class="form-control mb-3" name="name"
                       placeholder="Full name" value="{{ old('name') }}" required>

                <input class="form-control mb-3" name="address"
                       placeholder="House number and street address"
                       value="{{ old('address') }}" required>

                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control mb-3" name="city"
                               placeholder="City" value="{{ old('city') }}" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control mb-3" name="postal_code"
                               placeholder="Postal code" value="{{ old('postal_code') }}">
                    </div>
                </div>
                
<h6 class="mt-4">Payment Method</h6>

<div class="checkout-box mb-4 p-3 border rounded">

    <!-- Cash on Delivery -->
    <label class="d-flex align-items-center gap-3 py-2"
           for="payment_cod"
           style="cursor: pointer;">

        <input
            type="radio"
            id="payment_cod"
            name="payment_method"
            value="cod"
            checked
        >

        <i class="fas fa-money-bill-wave fa-lg text-success"></i>

        <div class="flex-grow-1">
            <span class="fw-semibold d-block">
                Cash on Delivery
            </span>
            <small class="text-muted">
                Pay when your order arrives
            </small>
        </div>
    </label>

    <hr class="my-2">

    <!-- PayFast -->
    <label class="d-flex align-items-center gap-3 py-2"
           for="payment_payfast"
           style="cursor: pointer;">

        <input
            type="radio"
            id="payment_payfast"
            name="payment_method"
            value="payfast"
        >

        <i class="fas fa-credit-card fa-lg text-primary"></i>

        <div class="flex-grow-1">
            <span class="fw-semibold d-block">
                PayFast
            </span>
            <small class="text-muted">
                Debit card, credit card, wallet or bank account
            </small>
        </div>
    </label>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

   

<button
    class="btn place-order w-100 mt-3"
    type="submit"
    id="completeOrderBtn">
    Complete Order
</button>

<button
    class="btn place-order w-100 mt-3"
    type="button"
    id="payNowBtn"
    data-url="{{ route('payments.checkout') }}"
    hidden>
    Pay Now
</button>



</div>

            </form>
        </div>

        <div class="col-lg-5">
            <div class="checkout-box">
                <h5 class="mb-4">Order summary</h5>

                @forelse ($cartItems as $item)
                    <div class="d-flex gap-3 align-items-center mb-3">
                        @if (!empty($item['image']))
                            <img class="product-img"
                                 src="{{ asset('storage/' . $item['image']) }}"
                                 alt="{{ $item['name'] }}">
                        @endif

                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item['name'] }}</div>
                            <small class="text-muted">
                                Quantity: {{ $item['quantity'] }}
                            </small>
                        </div>

                        <div class="text-nowrap">
                            Rs {{ number_format($item['price'] * $item['quantity'], 2) }}
                        </div>
                    </div>
                @empty
                    <p>Your cart is empty.</p>
                    <a href="{{ url('/') }}">Continue shopping</a>
                @endforelse

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>Rs {{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Delivery</span>
                    <span>Calculated at checkout</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>Rs {{ number_format($subtotal, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html>
