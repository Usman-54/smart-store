 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation | Smart Mart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        body {
            background: #f5f7f5;
            color: #253328;
        }
        .confirmation-card {
            max-width: 760px;
            margin: 45px auto;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 8px 35px rgba(0,0,0,.06);
        }
        .success-icon {
            width: 78px;
            height: 78px;
            margin: 0 auto 20px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e3f7e9;
            color: #168344;
            font-size: 36px;
        }
        .product-row {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
    </style>
</head>
<body>

<div class="container px-3">
    <div class="card confirmation-card">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <div class="success-icon">
                    <i class="fa-solid fa-check"></i>
                </div>

                <h1 class="h3 fw-bold">
                    Thank you, {{ $order['name'] }}!
                </h1>

                <p class="text-muted">
                    Your order has been placed successfully.
                </p>

                <span class="badge text-bg-success p-2">
                    Order #{{ $order['order_number'] }}
                </span>
            </div>

            <div class="alert alert-success">
                <i class="fa-solid fa-money-bill-wave me-2"></i>
                <strong>Cash on Delivery</strong>
                <p class="mb-0 mt-1 small">
                    Pay when your order arrives.
                </p>
            </div>

            <h2 class="h5 fw-bold mt-4">Order summary</h2>

            @foreach ($order['items'] as $item)
                <div class="product-row d-flex justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">
                            {{ $item['name'] }}
                        </div>
                        <small class="text-muted">
                            Quantity: {{ $item['quantity'] }}
                        </small>
                    </div>

                    <div class="fw-semibold text-nowrap">
                        Rs. {{ number_format(
                            $item['price'] * $item['quantity'], 2
                        ) }}
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between mt-4 mb-3">
                <span class="text-muted">Subtotal</span>
                <span>
                    Rs. {{ number_format($order['subtotal'], 2) }}
                </span>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Delivery fee</span>
                <span>
                    Rs. {{ number_format($order['delivery_fee'], 2) }}
                </span>
            </div>

            <hr>

            <div class="d-flex justify-content-between fs-5 fw-bold mb-4">
                <span>Total payable</span>
                <span class="text-success">
                    Rs. {{ number_format($order['total'], 2) }}
                </span>
            </div>

            <h2 class="h5 fw-bold">Delivery information</h2>

            <div class="bg-light rounded p-3 mb-4">
                <p class="mb-1 fw-semibold">{{ $order['name'] }}</p>
                <p class="mb-1">{{ $order['phone'] }}</p>
                <p class="mb-1">
                    {{ $order['address'] }}
                </p>
                <p class="mb-1">{{ $order['city'] }}</p>
                @if (!empty($order['postal_code']))
                    <p class="mb-0">{{ $order['postal_code'] }}</p>
                @endif
            </div>

            <a href="{{ url('/smart-mall') }}"
               class="btn btn-success btn-lg w-100">
                <i class="fa-solid fa-store me-2"></i>
                Continue Shopping
            </a>

        </div>
    </div>
</div>

</body>
</html>