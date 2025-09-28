<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
        public function index()
    {
        $products = \App\Models\Product::with('category')->latest('id')->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get(['id','name']);
        return view('admin.products.create', compact('categories'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:150'],
            'category_id' => ['required','integer','exists:categories,id'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['sometimes','boolean'],
            'description' => ['nullable','string','max:1000'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);

        \App\Models\Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Produk berhasil ditambahkan!');
    }

    public function edit(\App\Models\Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->get(['id','name']);
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Product $product)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:150'],
            'category_id' => ['required','integer','exists:categories,id'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['sometimes','boolean'],
            'description' => ['nullable','string','max:1000'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? $product->is_active);

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Product updated');
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        return back()->with('success','Product deleted');
    }

}
