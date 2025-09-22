<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest('id')->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(\App\Models\Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

}
