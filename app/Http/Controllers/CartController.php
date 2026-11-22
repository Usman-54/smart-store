<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Add product to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:99',
        ]);

        $product = Product::with('images')
            ->findOrFail($request->product_id);

        $quantity = (int) $request->input('quantity', 1);

        // Calculate discounted price
        $originalPrice = (float) $product->price;
        $discountPercent = (float) ($product->discount_price ?? 0);

        $hasDiscount = $discountPercent > 0
            && $discountPercent <= 100;

        $finalPrice = $hasDiscount
            ? $originalPrice - (
                $originalPrice * $discountPercent / 100
            )
            : $originalPrice;

        // Get existing cart
        $cart = session()->get('cart', []);

        $id = $product->id;

        if (isset($cart[$id])) {
            // Increase quantity if product already exists
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Add new product
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->images->first()?->image,
                'original_price' => $originalPrice,
                'discount_percent' => $hasDiscount
                    ? $discountPercent
                    : 0,
                'price' => round($finalPrice, 2),
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        // Redirect after adding the product
        return redirect('/smart-mall')
            ->with('success', 'Product added to cart successfully!');
    }

    // Display mini cart
    public function miniCart()
    {
        $cart = session()->get('cart', []);

        return view('cart_sidebar', compact('cart'));
    }

    // Update cart quantity
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'change' => 'required|integer',
        ]);

        $cart = session()->get('cart', []);
        $id = $request->product_id;
        $change = (int) $request->change;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $change;

            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => array_sum(
                array_column($cart, 'quantity')
            ),
        ]);
    }
}
