<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all()->groupBy('category');

        foreach ($products as $category => $items) {
            foreach ($items as $product) {

                // Format price
                $product->price_formatted = number_format($product->price, 2);
                $product->discount_price_formatted = null;
                $product->discount_percent = 0;

                // Discount logic
                if (!empty($product->discount_price) && $product->discount_price > 0 && $product->discount_price < $product->price) {
                    $product->discount_price_formatted = number_format($product->discount_price, 2);
                    $product->discount_percent = round((($product->price - $product->discount_price) / $product->price) * 100);
                }

                // Image URL
                $product->image_url = asset('images/' . $product->image);
            }
        }

        return view('index', compact('products'));
    }
}
