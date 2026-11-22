<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Mart - Home</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/cart_sidebar.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">

  {{-- Include header --}}
  @include('header')

  {{-- Hero Carousel --}}
  <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
      <div class="carousel-inner">
          <div class="carousel-item active" style="background-image: url('{{ asset('images/slide5.jpg') }}');">
              <div class="carousel-overlay"></div>
              <div class="carousel-caption">
                  <h1>New Brand</h1>
                  <p>Discover the latest premium fashion that defines you.</p>
                  <a href="#" class="btn btn-warning custom-btn">Shop Now</a>
              </div>
          </div>
          <div class="carousel-item" style="background-image: url('{{ asset('images/slide2.jpg') }}');">
              <div class="carousel-overlay"></div>
              <div class="carousel-caption">
                  <h1>New Arrival</h1>
                  <p>Fresh styles waiting for you every season.</p>
                  <a href="#" class="btn btn-warning custom-btn">Explore</a>
              </div>
          </div>
          <div class="carousel-item" style="background-image: url('{{ asset('images/slide4.jpeg') }}');">
              <div class="carousel-overlay"></div>
              <div class="carousel-caption">
                  <h1>Best Deals</h1>
                  <p>Don’t miss out – limited time offers inside.</p>
                  <a href="#" class="btn btn-warning custom-btn">Shop Deals</a>
              </div>
          </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
          <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
          <span class="visually-hidden">Next</span>
      </button>
  </div>


{{-- Dynamic Product Sections --}}
<div class="container py-5">
    @foreach($products as $category => $items)
        <h2 class="mb-4">{{ ucfirst($category) }} Collection</h2>

        <div class="row g-4">
            @foreach($items->take(4) as $product)
                <div class="col-md-3">
                    <div class="card product-card position-relative overflow-hidden h-100">

                        @php
                            // Calculate discount
                            $originalPrice = $product->price;
                            $discountPercent = $product->discount_price;
                            $hasDiscount = $discountPercent > 0;

                            $finalPrice = $hasDiscount
                                ? $originalPrice - ($originalPrice * $discountPercent / 100)
                                : $originalPrice;

                            // Keep the original index image relationship and path
                            $image = $product->images->first();
                            $imagePath = $image?->image;
                        @endphp

                        {{-- Sale Button --}}
                        @if($hasDiscount)
                            <a href="{{ route('detail_item', ['id' => $product->id]) }}"
                               class="position-absolute top-0 end-0 m-2 btn btn-sm btn-danger"
                               style="z-index: 20;">
                                Sale
                            </a>
                        @endif

                        {{-- Product Image + Add to Cart --}}
                        <div class="position-relative">
                            <img
                                src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/300' }}"
                                alt="{{ $product->name }}"
                                class="d-block w-100 product-img"
                            >

                            <a href="#"
                               onclick="event.preventDefault(); document.getElementById('cart-form-{{ $product->id }}').submit();"
                               class="add-cart-btn position-absolute bottom-0 end-0 m-2 btn btn-dark rounded-circle p-2">
                                <i class="bi bi-cart"></i>
                            </a>
                        </div>

                        {{-- Product Info --}}
                        <div class="mt-2 p-2">
                            <h6>{{ $product->name }}</h6>

                            @if($hasDiscount)
                                <div class="d-flex align-items-center">
                                    <h5 class="text-danger mb-0 me-2">
                                        Rs {{ number_format($finalPrice, 2) }}
                                    </h5>

                                    <small class="text-muted text-decoration-line-through">
                                        Rs {{ number_format($originalPrice, 2) }}
                                    </small>
                                </div>
                            @else
                                <h5 class="text-dark mb-0">
                                    Rs {{ number_format($originalPrice, 2) }}
                                </h5>
                            @endif
                        </div>

                        {{-- Add to Cart Form --}}
                        <form id="cart-form-{{ $product->id }}"
                              action="{{ route('cart.add') }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </form>

                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>


  {{-- JS Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/cart_badge.js') }}"></script>

@include('Cart_sidebar', app(App\Http\Controllers\Cart_sidebarController::class)->sidebarData())
<script src="{{ asset('js/cart_sidebar.js') }}"></script>



 {{-- Footer --}}
  <footer class="bg-dark text-center py-3">
    <p class="mb-0 text-white-50">&copy; 2025 SmartMart. All rights reserved.</p>
  </footer>
</body>

</html>
