
@php
    // These values are prepared by the controller.
    $cartItems = $cartItems ?? [];
    $cartSubtotal = $cartSubtotal ?? 0;
    $cartCount = $cartCount ?? 0;
    $recommendations = $recommendations ?? collect();
@endphp

<div id="cartOverlay" class="cart-overlay" aria-hidden="true"></div>

<aside
    id="mini-cart"
    class="cart-sidebar"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cartSidebarTitle"
    aria-hidden="true"
    tabindex="-1"
>
    <div class="cart-sidebar__header">
        <div>
            <span class="cart-sidebar__eyebrow">YOUR SELECTION</span>
            <h2 id="cartSidebarTitle">
                Your Cart
                <span class="cart-sidebar__count" data-cart-count>{{ $cartCount }}</span>
            </h2>
        </div>

        <button
            type="button"
            class="cart-close"
            onclick="closeMiniCart()"
            aria-label="Close cart"
        >
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="cart-sidebar__body">
        @if (count($cartItems))
            <p class="cart-note">
                <i class="bi bi-check-circle"></i>
                Your items are waiting for you.
            </p>

            <div class="cart-items">
                @foreach ($cartItems as $key => $item)
                    
<article class="cart-item">
    <div class="cart-item__image">
        @if (!empty($item['image']))
            <img
                src="{{ asset('storage/' . $item['image']) }}"
                alt="{{ $item['name'] }}"
            >
        @else
            <div class="cart-item__placeholder">
                <i class="bi bi-image"></i>
            </div>
        @endif
    </div>

    <div class="cart-item__details">
        <h3>{{ $item['name'] }}</h3>

        <p class="cart-item__price">
            Rs. {{ number_format((float) $item['price'], 2) }}
        </p>

        <div class="cart-item__actions">
            <div
                class="cart-quantity-form"
                data-update-url="{{ route('cart.update', $item['product_id'] ?? $key) }}"
                data-remove-url="{{ route('cart.remove', $item['product_id'] ?? $key) }}"
                data-price="{{ (float) $item['price'] }}"
            >
                @csrf

                <button
                    type="button"
                    class="cart-qty-btn cart-qty-minus"
                    aria-label="Decrease quantity of {{ $item['name'] }}"
                >
                    <i class="bi bi-dash-lg"></i>
                </button>

                <input
                    type="number"
                    class="cart-quantity-input"
                    id="quantity-{{ $key }}"
                    name="quantity"
                    value="{{ $item['quantity'] }}"
                    min="1"
                    max="99"
                    aria-label="Quantity of {{ $item['name'] }}"
                >

                <button
                    type="button"
                    class="cart-qty-btn cart-qty-plus"
                    aria-label="Increase quantity of {{ $item['name'] }}"
                >
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="cart-item__total">
        Rs. <span class="cart-item-subtotal">
            {{ number_format(
                (float) $item['price'] * (int) $item['quantity'],
                2
            ) }}
        </span>
    </div>
</article>

                @endforeach
            </div>
        @else
            <div class="cart-empty">
                <div class="cart-empty__icon">
                    <i class="bi bi-bag"></i>
                </div>
                <h3>Your cart is empty</h3>
                <p>Discover something you’ll love and add it to your cart.</p>
                <button
                    type="button"
                    class="cart-primary-btn"
                    onclick="closeMiniCart()"
                >
                    Continue shopping
                </button>
            </div>
        @endif

        
@if ($recommendations->isNotEmpty())
    <section class="cart-recommendations">
        <div class="cart-section-heading">
            <div>
                <span class="cart-sidebar__eyebrow">HANDPICKED FOR YOU</span>
                <h3>You might also like</h3>
            </div>
        </div>

        <div class="cart-recommendations__list">
            @foreach ($recommendations as $product)
                @php
                    $originalPrice = (float) $product->price;
                    $discountPercent = (float) $product->discount_price;

                    $hasDiscount = $discountPercent > 0
                        && $discountPercent < 100;

                    $finalPrice = $hasDiscount
                        ? $originalPrice - ($originalPrice * $discountPercent / 100)
                        : $originalPrice;

                    $imagePath = $product->images->first()?->image;
                @endphp

                <article class="cart-recommendation">
                    <div class="cart-recommendation__image">
                        @if ($imagePath)
                            <img
                                src="{{ asset('storage/' . $imagePath) }}"
                                alt="{{ $product->name }}"
                            >
                        @else
                            <i class="bi bi-image"></i>
                        @endif

                        <form
                            action="{{ route('cart.add') }}"
                            method="POST"
                            class="cart-recommendation__form"
                        >
                            @csrf
                            <input
                                type="hidden"
                                name="product_id"
                                value="{{ $product->id }}"
                            >
                            <input type="hidden" name="quantity" value="1">

                            <button
                                type="submit"
                                class="cart-recommendation__add"
                                aria-label="Add {{ $product->name }} to cart"
                            >
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </form>
                    </div>

                    <div class="cart-recommendation__info">
                        <h4>{{ $product->name }}</h4>

                        @if ($hasDiscount)
                            <div class="cart-recommendation__prices">
                                <span class="cart-recommendation__sale-price">
                                    Rs. {{ number_format($finalPrice, 2) }}
                                </span>

                                <span class="cart-recommendation__original-price">
                                    Rs. {{ number_format($originalPrice, 2) }}
                                </span>
                            </div>
                        @else
                            <p class="cart-recommendation__sale-price">
                                Rs. {{ number_format($originalPrice, 2) }}
                            </p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endif

    </div>

    @if (count($cartItems))
        <footer class="cart-sidebar__footer">
            
            <div class="cart-subtotal">
                <span>Subtotal</span>
                <strong>
                    Rs. <span data-cart-subtotal>{{ number_format($cartSubtotal, 2) }}</span>
                </strong>
            </div>


            <p class="cart-shipping-note">
                Shipping and taxes are calculated at checkout.
            </p>

            <a href="{{ route('checkout') }}" class="cart-primary-btn">
                Proceed to checkout
                <i class="bi bi-arrow-right"></i>
            </a>

            <button
                type="button"
                class="cart-continue-btn"
                onclick="closeMiniCart()"
            >
                Continue shopping
            </button>
        </footer>
    @endif
</aside>
