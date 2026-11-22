<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get()->groupBy('category');
        return view('index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('images');
        return view('detail_item', compact('product'));
    }

    public function mensCollection()
    {
        $products = Product::where('category', 'men')->with('images')->get();
        return view('collections.men_collection', compact('products'));
   
    }

    public function womensCollection()
    {
        $products = Product::where('category', 'female')->with('images')->get();
        return view('collections.women_collection', compact('products'));
    }

    public function footwearCollection()
    {
        $products = Product::where('category', 'footwear')->with('images')->get();
        // return dd($products);
        return view('collections.footwear', compact('products'));
    }

    public function watchesCollection()
    {
        $products = Product::where('category', 'watches')->with('images')->get();
        return view('collections.watches', compact('products'));
    }

    // Cart logic
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $cartProducts = Product::whereIn('id', array_keys($cart))->with('images')->get();
        return view('cart', compact('cart', 'cartProducts'));
    }
    public function detail($id)
{
    $product = Product::findOrFail($id);
    return view('detail_item', compact('product'));
}


    // Admin CRUD (optional)
    public function create()
    {
        return view('admin.products.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'category' => 'required|in:men,female,footwear,watches',
            'price' => 'required|numeric',
            'discount_price' => 'required|numeric',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'discount_price' => $data['discount_price'],
            'sale_price' => $data['price'] - $data['discount_price'],
            'description' => $data['description'] ?? null,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image in 'products' folder
                $image->store('products', 'public');

                // Get only the generated filename
                $filename = $image->hashName();

                // Save only the filename in the database
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                ]);
            }
        }


        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    { /* Similar to store logic */
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted');
    }
}
