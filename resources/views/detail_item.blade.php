
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $product->name }} | Smart Mall</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: #f7f8fa;
            color: #222;
            font-family: Arial, sans-serif;
        }

        .product-section {
            padding: 55px 0 75px;
        }

        .product-card {
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .06);
        }

        .product-image-box {
            position: relative;
            background: #f1f2f4;
            min-height: 560px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .product-image {
            width: 100%;
            height: 520px;
            object-fit: contain;
            transition: transform .35s ease;
        }

        .product-image:hover {
            transform: scale(1.04);
        }

        .sale-badge {
            position: absolute;
            top: 24px;
            left: 24px;
            background: #dc3545;
            color: #fff;
            padding: 9px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
        }

        .product-info {
            padding: 45px 40px;
        }

        .store-label {
            color: #777;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .product-title {
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 20px;
            overflow-wrap: anywhere;
        }

        .product-description {
            color: #6c757d;
            font-size: 16px;
            line-height: 1.9;
            white-space: pre-line;
        }

        .price-current {
            color: #dc3545;
            font-size: 32px;
            font-weight: 700;
        }

        .price-original {
            color: #999;
            font-size: 17px;
        }

        .discount-label {
            background: #fff0f1;
            color: #dc3545;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 700;
        }

        .detail-divider {
            border-top: 1px solid #eee;
            margin: 26px 0;
        }

        .quantity-input {
            width: 85px;
            height: 48px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .add-cart-btn {
            height: 52px;
            background: #212529;
            border: 1px solid #212529;
            border-radius: 9px;
            color: #fff;
            font-weight: 600;
            transition: .25s;
        }

        .add-cart-btn:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .back-link {
            color: #555;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .back-link:hover {
            color: #dc3545;
        }

        .service-item {
            color: #555;
            font-size: 14px;
            margin-top: 16px;
        }

        
.btn-add-cart {
    transition: all 0.25s ease;
}

.btn-add-cart:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(220, 53, 69, 0.25) !important;
}

.btn-add-cart:active {
    transform: scale(0.98);
}


        @media (max-width: 767px) {
            .product-section {
                padding: 25px 0 40px;
            }

            .product-image-box {
                min-height: 350px;
                padding: 20px;
            }

            .product-image {
                height: 350px;
            }

            .product-info {
                padding: 28px 23px;
            }

            .product-title {
                font-size: 28px;
            }

            .price-current {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

@include('header')

@php
    $originalPrice = (float) $product->price;
    $discountPercent = (float) ($product->discount_price ?? 0);

    $hasDiscount = $discountPercent > 0 && $discountPercent <= 100;

    $finalPrice = $hasDiscount
        ? $originalPrice - ($originalPrice * $discountPercent / 100)
        : $originalPrice;

    $image = $product->images->first();
@endphp

<section class="product-section">
    <div class="container">

        <a href="{{ url('/smart-mall') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Continue Shopping
        </a>

        <div class="product-card">
            <div class="row g-0">

                {{-- Large product image --}}
                <div class="col-lg-7">
                    <div class="product-image-box">

                        @if($hasDiscount)
                            <span class="sale-badge">
                                {{ rtrim(rtrim(number_format($discountPercent, 2), '0'), '.') }}% OFF
                            </span>
                        @endif

                        <img
                            src="{{ $image
                                ? asset('storage/' . $image->image)
                                : 'https://placehold.co/700x700/f1f2f4/777?text=No+Image' }}"
                            alt="{{ $product->name }}"
                            class="product-image"
                        >
                    </div>
                </div>

                {{-- Product details --}}
                <div class="col-lg-5">
                    <div class="product-info">

                        <div class="store-label">
                            <i class="bi bi-shop me-2"></i>
                            Smart Mall Collection
                        </div>

                        <h1 class="product-title">
                            {{ $product->name }}
                        </h1>

                        <p class="product-description">
                            {{ $product->description ?: 'Discover quality and value with this product from Smart Mall.' }}
                        </p>

                        <div class="detail-divider"></div>

                        {{-- Pricing --}}
                        <div class="mb-4">
                            @if($hasDiscount)
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <span class="price-current">
                                        Rs {{ number_format($finalPrice, 2) }}
                                    </span>

                                    <span class="price-original text-decoration-line-through">
                                        Rs {{ number_format($originalPrice, 2) }}
                                    </span>

                                    <span class="discount-label">
                                        SAVE {{ rtrim(rtrim(number_format($discountPercent, 2), '0'), '.') }}%
                                    </span>
                                </div>

                                <small class="text-success mt-2 d-block">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    You save Rs {{ number_format($originalPrice - $finalPrice, 2) }}
                                </small>
                            @else
                                <span class="price-current text-dark">
                                    Rs {{ number_format($originalPrice, 2) }}
                                </span>
                            @endif
                        </div>

                        <div class="detail-divider"></div>

                        {{-- Add to cart --}}
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf

                            <input type="hidden"
                                   name="product_id"
                                   value="{{ $product->id }}">

                            <label for="quantity" class="form-label fw-semibold">
                                Quantity
                            </label>

                            <div class="d-flex gap-3 align-items-center mb-4">
                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="99"
                                    class="form-control quantity-input"
                                    required
                                >

                                
<button type="submit"
        class="btn btn-dark btn-lg w-100 rounded-3 shadow-sm fw-semibold py-3">
    <i class="bi bi-cart-plus me-2"></i>
    Add to Cart
    <i class="bi bi-arrow-right ms-2"></i>
</button>

                            </div>
                        </form>

                        <div class="detail-divider"></div>

                        <div class="service-item">
                            <i class="bi bi-truck me-2"></i>
                            Shop conveniently at Smart Mall
                        </div>

                        <div class="service-item">
                            <i class="bi bi-shield-check me-2"></i>
                            A simple and secure shopping experience
                        </div>

                        <div class="service-item">
                            <i class="bi bi-bag-check me-2"></i>
                            Browse more products in our collection
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/cart_badge.js') }}"></script>

</body>
</html>
