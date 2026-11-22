<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class Cart_sidebarController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::with('images')->findOrFail(
            $validated['product_id']
        );

        $cart = session('cart', []);
        $id = (string) $product->id;
        $quantity = (int) ($validated['quantity'] ?? 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min(
                99,
                (int) $cart[$id]['quantity'] + $quantity
            );
        } else {
            $imagePath = $product->images->first()?->image;

            $cart[$id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price' => (
                    !empty($product->discount_price)
                    && $product->discount_price > 0
                    && $product->discount_price < 100
                )
                    ? (float) $product->price
                    - ((float) $product->price * (float) $product->discount_price / 100)
                    : (float) $product->price,

                'quantity'   => $quantity,
                'image'      => $imagePath,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Product added to your cart.');
    }


    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session('cart', []);
        $key = (string) $id;

        if (!isset($cart[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }

        $product = Product::findOrFail($id);

        $originalPrice = (float) $product->price;
        $discount = (float) $product->discount_price;

        $cart[$key]['price'] = (
            $discount > 0 && $discount < 100
        )
            ? $originalPrice - ($originalPrice * $discount / 100)
            : $originalPrice;

        $cart[$key]['quantity'] = (int) $validated['quantity'];

        session(['cart' => $cart]);

        $itemSubtotal = (float) $cart[$key]['price']
            * (int) $cart[$key]['quantity'];

        $cartSubtotal = collect($cart)->sum(
            fn($item) => (float) $item['price']
                * (int) $item['quantity']
        );

        $cartCount = collect($cart)->sum(
            fn($item) => (int) $item['quantity']
        );

        return response()->json([
            'success'      => true,
            'quantity'     => (int) $cart[$key]['quantity'],
            'itemSubtotal' => $itemSubtotal,
            'cartSubtotal' => $cartSubtotal,
            'cartCount'    => $cartCount,
        ]);
    }


    
public function remove(Request $request, int $id)
{
    $cart = session('cart', []);
    unset($cart[(string) $id]);

    session(['cart' => $cart]);

    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
        ]);
    }

    return back()->with('success', 'Product removed from your cart.');
}


    public function view()
    {
        $cart = session('cart', []);

        $subtotal = collect($cart)->sum(
            fn($item) => (float) $item['price']
                * (int) $item['quantity']
        );

        return view('cart', compact('cart', 'subtotal'));
    }

    /**
     * Data used by the cart sidebar.
     */
    public function sidebarData(): array
    {
        $cart = session('cart', []);
        $cartIds = collect($cart)->pluck('product_id')->all();

        $subtotal = collect($cart)->sum(
            fn($item) => (float) $item['price']
                * (int) $item['quantity']
        );

        $recommendations = Product::with('images')
            ->when(
                count($cartIds) > 0,
                fn($query) => $query->whereNotIn('id', $cartIds)
            )
            ->latest()
            ->take(4)
            ->get();

        return [
            'cartItems'       => $cart,
            'cartSubtotal'    => $subtotal,
            'cartCount'       => collect($cart)->sum('quantity'),
            'recommendations' => $recommendations,
        ];
    }
}
