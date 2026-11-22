
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Checkout | Smart Mart</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>

<body>

<div class="container checkout-wrap py-4 py-lg-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/smart-mall') }}"
           class="back-link text-decoration-none">
            <i class="fa-solid fa-arrow-left me-2"></i>
            <span class="fw-bold">SMART-MALL</span>
        </a>

        <span class="secure-checkout text-muted small">
            <i class="fa-solid fa-lock me-1 text-success"></i>
            Secure checkout
        </span>
    </div>

    <!-- PAGE HEADING -->
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-2">Checkout</h1>
        <p class="text-muted mb-0">
            Complete your shipping details and choose a payment method.
        </p>
    </div>

    {{-- <form action="{{ route('checkout.place') }}" method="POST"> --}}
        <form id="checkoutForm" action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <div class="row g-4">

            <!-- LEFT: CUSTOMER DETAILS -->
            <div class="col-lg-7">

                <div class="checkout-box card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <h2 class="h5 fw-bold mb-4">
                            <i class="fa-regular fa-user me-2 text-success"></i>
                            Contact information
                        </h2>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                Phone number
                            </label>

                            <input
                                class="form-control form-control-lg"
                                id="phone"
                                type="tel"
                                name="phone"
                                autocomplete="tel"
                                placeholder="Enter your phone number"
                                value="{{ old('phone') }}"
                                required
                            >
                        </div>
                        

                        <hr class="my-4">

                        <h2 class="h5 fw-bold mb-4">
                            <i class="fa-solid fa-location-dot me-2 text-success"></i>
                            Shipping address
                        </h2>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Full name
                            </label>

                            <input
                                class="form-control"
                                id="name"
                                type="text"
                                name="name"
                                autocomplete="name"
                                placeholder="Enter your full name"
                                value="{{ old('name') }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">
                                Street address
                            </label>

                            <input
                                class="form-control"
                                id="address"
                                name="address"
                                autocomplete="street-address"
                                placeholder="House number and street address"
                                value="{{ old('address') }}"
                                required
                            >
                        </div>

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label for="city" class="form-label fw-semibold">
                                    City
                                </label>

                                <input
                                    class="form-control"
                                    id="city"
                                    name="city"
                                    autocomplete="address-level2"
                                    placeholder="Your city"
                                    value="{{ old('city') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-5">
                                <label for="postal_code"
                                       class="form-label fw-semibold">
                                    Postal code
                                </label>

                                <input
                                    class="form-control"
                                    id="postal_code"
                                    name="postal_code"
                                    autocomplete="postal-code"
                                    placeholder="Postal code"
                                    value="{{ old('postal_code') }}"
                                >
                            </div>
                        </div>

                    </div>
                </div>

                <!-- PAYMENT METHOD -->
                <div class="checkout-box card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="h5 fw-bold mb-2">
                            <i class="fa-regular fa-credit-card me-2 text-success"></i>
                            Payment method
                        </h2>

                        <p class="text-muted small mb-4">
                            Select how you would like to pay.
                        </p>

                        <!-- CASH ON DELIVERY -->
                        <label for="payment_cod"
                               class="payment-option d-flex align-items-center gap-3 p-3 mb-3">

                            <input
                                class="form-check-input flex-shrink-0 mt-0"
                                type="radio"
                                id="payment_cod"
                                name="payment_method"
                                value="cod"
                                {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                            >

                            <span class="payment-icon bg-success-subtle text-success">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </span>

                            <span class="flex-grow-1">
                                <span class="d-block fw-semibold">
                                    Cash on Delivery
                                </span>

                                <small class="text-muted">
                                    Pay when your order arrives.
                                </small>
                            </span>

                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </label>

                        <!-- PAYFAST -->
                        <label for="payment_payfast"
                               class="payment-option d-flex align-items-center gap-3 p-3">

                            <input
                                class="form-check-input flex-shrink-0 mt-0"
                                type="radio"
                                id="payment_payfast"
                                name="payment_method"
                                value="payfast"
                                {{ old('payment_method') === 'payfast' ? 'checked' : '' }}
                            >

                            <span class="payment-icon bg-primary-subtle text-primary">
                                <i class="fa-solid fa-credit-card"></i>
                            </span>

                            <span class="flex-grow-1">
                                <span class="d-block fw-semibold">
                                    Online payment
                                </span>

                                <small class="text-muted">
                                    Card, wallet or other methods supported by your gateway.
                                </small>
                            </span>

                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </label>

                        <!-- VALIDATION ERRORS -->
                        @if ($errors->any())
                            <div class="alert alert-danger mt-4 mb-0"
                                 role="alert">

                                <strong>Please correct the following:</strong>

                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- ACTION BUTTONS -->
                        <button
                            class="btn place-order btn-lg w-100 mt-4"
                            type="submit"
                            id="completeOrderBtn"
                        >
                            <i class="fa-solid fa-bag-shopping me-2"></i>
                            Complete Order
                        </button>

                        <button
                            class="btn place-order btn-lg w-100 mt-4"
                            type="button"
                            id="payNowBtn"
                            data-url="{{ route('payments.checkout') }}"
                            hidden
                        >
                            <i class="fa-solid fa-lock me-2"></i>
                            Pay Now
                        </button>

                        <p class="text-muted small text-center mt-3 mb-0">
                            <i class="fa-solid fa-shield-halved me-1 text-success"></i>
                            Online payments are subject to gateway confirmation.
                        </p>

                    </div>
                </div>

            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="col-lg-5">

                <div class="checkout-box card border-0 shadow-sm order-summary">

                    <div class="card-body p-4">

                        <h2 class="h5 fw-bold mb-4">
                            Order summary

                            <span class="badge text-bg-light ms-1">
                                {{ count($cartItems) }} items
                            </span>
                        </h2>

                        @forelse ($cartItems as $item)

                            <div class="d-flex gap-3 align-items-center mb-4">

                                @if (!empty($item['image']))
                                    <img
                                        class="product-img"
                                        src="{{ asset('storage/' . $item['image']) }}"
                                        alt="{{ $item['name'] }}"
                                    >
                                @else
                                    <div class="product-img product-img-placeholder
                                                d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-image text-muted"></i>
                                    </div>
                                @endif

                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-semibold product-name">
                                        {{ $item['name'] }}
                                    </div>

                                    <small class="text-muted">
                                        Quantity: {{ $item['quantity'] }}
                                    </small>
                                </div>

                                <div class="text-nowrap fw-semibold">
                                    Rs. {{ number_format(
                                        $item['price'] * $item['quantity'], 2
                                    ) }}
                                </div>

                            </div>

                        @empty

                            <p class="text-muted">Your cart is empty.</p>

                            <a href="{{ url('/') }}"
                               class="btn btn-outline-dark w-100">
                                Continue shopping
                            </a>

                        @endforelse

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>

                            <span class="fw-semibold">
                                Rs. {{ number_format($subtotal, 2) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Delivery</span>

                            <span class="small text-muted text-end">
                                Calculated at checkout
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between
                                    align-items-center mt-3 mb-4">

                            <span class="fw-bold fs-5">Total</span>

                            <span class="fw-bold fs-4 text-success">
                                Rs. {{ number_format($subtotal, 2) }}
                            </span>

                        </div>

                        <div class="summary-note d-flex gap-2 p-3 rounded">
                            <i class="fa-solid fa-shield-halved text-success mt-1"></i>

                            <small class="text-muted">
                                Your order total is calculated by the store.
                                Final delivery charges should be included when applicable.
                            </small>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </form>

    <!-- FOOTER -->
    <footer class="text-center text-muted small mt-5">
        &copy; {{ now()->year }} Smart Mart. All rights reserved.
    </footer>

</div>

<script src="{{ asset('js/checkout.js') }}" defer></script>

</body>
</html>
