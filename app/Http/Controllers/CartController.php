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

    //Buat nambah barang ke keranjang
    public function add(Request $request, \App\Models\Product $product)
    {
        if (!Auth::check()) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Unauthenticated'], 401)
                : redirect()->guest(route('login'))->with('warning', 'Silakan login untuk menambahkan produk ke keranjang.');
        }

        $reqQty = (int) $request->input('qty', 1);
        $reqQty = max(1, $reqQty);

        $cartItem = \App\Models\Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $current  = (int) ($cartItem->qty ?? 0);
        $desired  = $current + $reqQty;

        if ($desired > $product->stock) {
            // clamp ke stok, atau tolak—di sini kita tolak dgn 422 agar jelas di AJAX
            if ($request->wantsJson()) {
                return response()->json([
                    'ok'      => false,
                    'message' => 'Jumlah melebihi stok',
                    'max'     => $product->stock,
                    'current' => $current,
                ], 422);
            }
            return back()->withErrors(['qty' => "Maksimal {$product->stock}"])->withInput();
        }

        $cartItem->qty = $desired;
        $cartItem->save();

        if ($request->wantsJson()) {
            return response()->json([
                'ok'  => true,
                'qty' => $cartItem->qty,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    // Fungsi increment biar bisa pake ajax
    public function increment(Request $request, \App\Models\Cart $cart)
    {
        // Pastikan cart item milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $product = $cart->product()->firstOrFail();
        $desired = $cart->qty + 1;

        if ($desired > $product->stock) {
            return response()->json([
                'ok'      => false,
                'message' => 'Sudah mencapai stok maksimum',
                'qty'     => $cart->qty,
                'max'     => $product->stock,
            ], 422);
        }

        $cart->increment('qty');

        // hitung subtotal & total
        $subtotal = $cart->qty * (float) $product->price;
        $all = \App\Models\Cart::with('product')->where('user_id', Auth::id())->get();
        $cartTotal = $all->sum(fn($i) => $i->qty * (float) $i->product->price);

        return response()->json([
            'ok'        => true,
            'qty'       => $cart->qty,
            'subtotal'  => $subtotal,
            'cart_total'  => $cartTotal,
            'reached_max' => $cart->qty >= $product->stock,
        ]);
    }

    // Fungsi decrement buat ajax
   public function decrement(Request $request, \App\Models\Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);

        $product = $cart->product()->firstOrFail();

        $removed = false;
        if ($cart->qty > 1) {
            $cart->decrement('qty');
        } else {
            $cart->delete();  // qty==1 ⇒ hapus
            $removed = true;
        }

        // hitung total
        $all = \App\Models\Cart::with('product')->where('user_id', Auth::id())->get();
        $cartTotal = $all->sum(fn($i) => $i->qty * (float) $i->product->price);

        return response()->json([
            'ok'           => true,
            'removed'      => $removed,
            'qty'          => $removed ? 0 : $cart->qty,
            'subtotal'     => $removed ? 0 : $cart->qty * (float) $product->price,
            'cart_total'   => $cartTotal,
            'can_increment'=> !$removed && $cart->qty < $product->stock,
        ]);
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
        $cartItem = Cart::with('product')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return back()->with('error', 'Item tidak ditemukan.');
        }

        $action = $request->input('action');

        if ($action === 'increase') {
            $desired = $cartItem->qty + 1;
            if ($desired > $cartItem->product->stock) {
                // jika mau JSON untuk fetch() juga bisa deteksi via wantsJson()
                return back()->withErrors(['qty' => 'Sudah mencapai stok maksimum.']);
            }
            $cartItem->increment('qty');
        } elseif ($action === 'decrease') {
            if ($cartItem->qty > 1) {
                $cartItem->decrement('qty');
            } else {
                $cartItem->delete();
            }
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }


}
