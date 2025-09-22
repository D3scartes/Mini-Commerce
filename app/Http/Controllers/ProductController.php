<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'search'     => ['nullable','string','max:100'],
            'category'   => ['nullable','integer'],
            'min_price'  => ['nullable','numeric','min:0'],
            'max_price'  => ['nullable','numeric','min:0'],
            'sort'       => ['nullable','in:newest,price_asc,price_desc'],
        ]);

        $q = trim($data['search'] ?? '');

        $products = Product::with('category')
            ->when($q !== '', fn($query) =>
                $query->where(fn($qq) => $qq
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                )
            )
            ->when(!empty($data['category']), fn($query) =>
                $query->where('category_id', $data['category'])
            )
            ->when(isset($data['min_price']), fn($query) =>
                $query->where('price', '>=', $data['min_price'])
            )
            ->when(isset($data['max_price']), fn($query) =>
                $query->where('price', '<=', $data['max_price'])
            )
            ->when(($data['sort'] ?? 'newest') === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
            ->when(($data['sort'] ?? 'newest') === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when(($data['sort'] ?? 'newest') === 'newest', fn($q) => $q->latest('id'))
            ->paginate(12)
            ->withQueryString();

        //kategori untuk dropdown filter
        $categories = Category::orderBy('name')->get(['id','name']);

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function create()
    {
        // batasi hanya admin sederhana (ganti ke policy/middleware nanti)
        abort_unless(auth()->user()?->email === 'admin@ais.com', 403);

        $categories = Category::orderBy('name')->get(['id','name']);
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()?->email === 'admin@ais.com', 403);

        $data = $request->validate([
            'name'        => ['required','string','max:120'],
            'description' => ['nullable','string','max:1000'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            // boleh simpan status aktif (opsional)
            'is_active'   => ['nullable','boolean'],
        ]);

        // default aktif = true kalau tidak dikirim
        $data['is_active'] = array_key_exists('is_active', $data) ? (bool)$data['is_active'] : true;

        $product = Product::create($data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product created successfully.');
    }
}
