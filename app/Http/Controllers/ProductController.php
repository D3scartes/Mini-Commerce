<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // eager load kategori, urut terbaru, paginate 12
        $products = Product::with('category')->latest('id')->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(\App\Models\Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

}
