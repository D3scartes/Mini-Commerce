<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
{
    // ambil semua order beserta user yang pesan dan item-itemnya
    $orders = Order::with('items', 'user')->latest()->paginate(10);

    // lempar ke view admin/orders/index.blade.php
    return view('admin.orders.index', compact('orders'));
}


    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Dikemas,Dikirim,Selesai',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
