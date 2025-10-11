<x-app-layout>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Keranjang</h1>

    {{-- pesan sukses --}}
    @if (session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    @if ($cart->isEmpty())
      <div class="text-gray-500 dark:text-gray-300">Keranjang kosong.</div>
    @else
      <div class="mb-4 border rounded-lg overflow-hidden dark:border-gray-700">
        <table class="w-full text-left">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="p-3 text-gray-700 dark:text-gray-200">Produk</th>
              <th class="p-3 text-gray-700 dark:text-gray-200">Harga</th>
              <th class="p-3 text-gray-700 dark:text-gray-200">Qty</th>
              <th class="p-3 text-gray-700 dark:text-gray-200">Subtotal</th>
              <th class="p-3"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cart as $item)
              <tr class="border-t dark:border-gray-700">
                {{-- Produk --}}
                <td class="p-3 flex items-center gap-3">
                  <img src="{{ $item->product->photo ? asset('storage/'.$item->product->photo) : asset('img/default.png') }}"
                       class="h-12 w-12 object-cover rounded border dark:border-gray-600">
                  <span class="text-gray-900 dark:text-white">{{ $item->product->name }}</span>
                </td>

                {{-- Harga --}}
                <td class="p-3 text-gray-900 dark:text-gray-200">
                  Rp {{ number_format($item->product->price,0,',','.') }}
                </td>

                {{-- Qty dengan + / - --}}
                <td class="p-3 text-gray-900 dark:text-gray-200">
                  <div class="flex items-center gap-2">
                    {{-- tombol - --}}
                    <form method="POST" action="{{ route('cart.update', $item->id) }}">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="action" value="decrease">
                      <button type="submit"
                              class="px-2 py-1 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600">
                        -
                      </button>
                    </form>

                    <span class="px-2">{{ $item->qty }}</span>

                    {{-- tombol + --}}
                    <form method="POST" action="{{ route('cart.update', $item->id) }}">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="action" value="increase">
                      <button type="submit" name="action" value="increase" @if($item->qty >= $item->product->stock) disabled @endif>
                        +
                      </button>
                    </form>
                  </div>
                </td>

                {{-- Subtotal --}}
                <td class="p-3 font-semibold text-gray-900 dark:text-white">
                  Rp {{ number_format($item->product->price * $item->qty,0,',','.') }}
                </td>

                {{-- Tombol Hapus --}}
                <td class="p-3">
                  <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700 text-sm">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Total & Checkout --}}
      <div class="flex justify-between items-center mt-6">
        <div class="text-lg font-bold text-gray-900 dark:text-white">
          Total: Rp {{ number_format($total,0,',','.') }}
        </div>
        <a href="{{ route('orders.payment') }}"
   class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
  Lanjut ke Payment
</a>

      </div>
    @endif
  </div>
</x-app-layout>
