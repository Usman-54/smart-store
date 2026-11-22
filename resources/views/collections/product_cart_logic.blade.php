<div class="col-md-3">
    <div class="card product-card position-relative overflow-hidden">

        @php
            // Calculate discount
            $originalPrice = $product->price;
            $discountPercent = $product->discount_price; // stored as % discount
            $hasDiscount = ($discountPercent > 0);

            $finalPrice = $hasDiscount ? ($originalPrice - ($originalPrice * $discountPercent / 100)) : $originalPrice;
        @endphp

        {{-- Sale Button (Top-Right) --}}
        <!-- @if($hasDiscount) -->

       @if($product->discount_price > 0)
<a href="{{ route('detail_item', ['id' => $product->id]) }}"
   class="position-absolute top-0 end-0 m-2 btn btn-sm btn-danger"
   style="z-index:20;">
    Sale
</a>
@endif


        <!-- @endif -->

        {{-- Image + Add to Cart (over image) --}}
       

{{-- Product Image --}}

@php
    $image = $product->images->first();
    $imagePath = $image?->image;

    if ($imagePath && !str_starts_with($imagePath, 'products/')) {
        $imagePath = 'products/' . ltrim($imagePath, '/');
    }
@endphp

<div class="position-relative">
    <img
        src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://placehold.co/300x250?text=No+Image' }}"
        alt="{{ $product->name }}"
        class="d-block w-100 product-img"
        onerror="this.onerror=null; this.src='https://placehold.co/300x250?text=Image+Not+Found';"
    >

    <a href="#"
       onclick="event.preventDefault(); addToCart({{ $product->id }});"
       class="add-cart-btn position-absolute bottom-0 end-0 m-2 btn btn-dark rounded-circle p-2">
        <i class="bi bi-cart"></i>
    </a>
</div>



        {{-- Product Info --}}
        <div class="mt-2 p-2">
            <h6>{{ $product->name }}</h6>

            {{-- Price --}}
            @if($hasDiscount)
            <div class="d-flex align-items-center">
                <h5 class="text-danger mb-0 me-2">Rs {{ number_format($finalPrice, 2) }}</h5>
                <small class="text-muted text-decoration-line-through">Rs {{ number_format($originalPrice, 2) }}</small>
            </div>
            @else
            <h5 class="text-dark mb-0">Rs {{ number_format($originalPrice, 2) }}</h5>
            @endif
        </div>

        {{-- Add to Cart Form --}}
        <form id="cart-form-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
        </form>

    </div>
</div>

<style>
.product-img {
    height: 250px;
    object-fit: cover;
}

/* Add to Cart Button */
.add-cart-btn {
    opacity: 0;
    transition: opacity 0.3s ease;
}
.position-relative:hover .add-cart-btn {
    opacity: 1;
}

/* Card overflow hidden */
.product-card {
    position: relative;
    overflow: hidden;
}
</style>
