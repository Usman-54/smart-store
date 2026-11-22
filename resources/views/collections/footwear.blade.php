<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Footwear's Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-img { height: 220px; object-fit: cover; }
        .product-card { border-radius: 10px; overflow: hidden; }
    </style>
</head>
<body>
    @include('header')

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Footwear's Collection</h2>
            <div class="row g-4">
                @foreach($products as $product)
                    @include('collections.product_cart_logic', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
