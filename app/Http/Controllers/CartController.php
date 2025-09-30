<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cart->sum(fn($item) => $item->product->price * $item->qty);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Product $product)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('qty');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'qty' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }
    public function update(Request $request, $id)
{
    $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();

    if ($cartItem) {
        $action = $request->input('action');

        if ($action === 'increase') {
            $cartItem->increment('qty');
        } elseif ($action === 'decrease') {
            if ($cartItem->qty > 1) {
                $cartItem->decrement('qty');
            } else {
                $cartItem->delete(); // kalau qty 0, hapus
            }
        }
    }

    return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui.');
}

}
