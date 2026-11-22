<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mart Shop</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    .navbar {
      background-color: #fff;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .nav-link {
      font-weight: 500;
      color: #333 !important;
      transition: all 0.3s ease;
    }
    .nav-link:hover {
      color: #007bff !important;
      transform: translateY(-2px);
    }
    .navbar-toggler {
      border: none;
    }
    .icon-btn {
      font-size: 1.3rem;
      color: #333;
      margin-left: 1rem;
      transition: all 0.3s;
    }
    .icon-btn:hover {
      color: #007bff;
      transform: translateY(-2px);
    }
  </style>
</head>
<body>

  <!-- Header / Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Mart Logo" height="80" width="80" class="rounded-circle">
      </a>

      <!-- Mobile toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav Links -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item mx-2">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a href="{{ url('/mens-collection') }}" class="nav-link">Men's</a>
          </li>
          <li class="nav-item mx-2">
            <a href="{{ route('womens.collection') }}" class="nav-link">Female's</a>
          </li>
          <li class="nav-item mx-2">
            <a href="{{ url('/footwear') }}" class="nav-link">FootWear</a>
          </li>
          <li class="nav-item mx-2">
            <a href="{{ url('/watches') }}" class="nav-link">Watches</a>
          </li>
          
<!-- cart badge -->
<li class="nav-item mx-2 position-relative">
  <a href="javascript:void(0);"
   class="icon-btn"
   onclick="openMiniCart()"
   aria-label="Open shopping cart">
    <i class="bi bi-cart-fill"></i>

    <span id="cart-count"
          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        {{ session('cart') ? collect(session('cart'))->sum('quantity') : 0 }}
    </span>
</a>
    {{-- <a href="javascript:void(0);" class="icon-btn" onclick="openMiniCart()">
        <i class="bi bi-cart-fill"></i>
        <span id="cart-count"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ session('cart') ? count(session('cart')) : 0 }}
        </span>
    </a> --}}
</li>
      


          <!-- Login Icon -->
          <li class="nav-item mx-2">
            <a href="{{ route('register') }}" class="icon-btn">
              <i class="bi bi-person-fill"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
