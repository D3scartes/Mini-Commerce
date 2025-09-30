<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'photo'       => ['required','image','max:2048'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('products', 'public');
        }

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
    // ...existing code...
        $data = $request->validate([
            'name'        => ['required','string','max:150'],
            'category_id' => ['required','integer','exists:categories,id'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'is_active'   => ['sometimes','boolean'],
            'description' => ['nullable','string','max:1000'],
            'photo'       => ['nullable','image','max:2048'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? $product->is_active);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            $data['photo'] = $request->file('photo')->store('products', 'public');
        }

        // Debug log isi data sebelum update
        Log::info('Data update produk:', $data);

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Product updated');
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        return back()->with('success','Product deleted');
    }

}
