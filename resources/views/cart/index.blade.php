<x-app-layout>

  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>

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

      <!-- {{-- TOTAL (atas) --}} //Mendingan dibawah totalnya
      <div class="text-lg font-bold text-gray-900 dark:text-white mb-3">
        Total: <span class="cart-total">Rp {{ number_format($total,0,',','.') }}</span>
      </div> -->

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
            <tr id="row-{{ $item->id }}" class="border-t dark:border-gray-700">
              {{-- Produk --}}
              <td class="p-3">
                <div class="flex items-center gap-3">
                  <img src="{{ $item->product->photo ? asset('storage/'.$item->product->photo) : asset('img/default.png') }}"
                       class="h-12 w-12 object-cover rounded border dark:border-gray-600" alt="Foto">
                  <span class="text-gray-900 dark:text-white">{{ $item->product->name }}</span>
                </div>
              </td>

              {{-- Harga --}}
              <td class="p-3 text-gray-900 dark:text-gray-200">
                Rp {{ number_format($item->product->price,0,',','.') }}
              </td>

              {{-- Qty --}}
              <td class="p-3 text-gray-900 dark:text-gray-200">
                <div class="flex items-center gap-2">
                  {{-- MINUS (AJAX) --}}
                  <button type="button"
                          class="btn-dec px-2 py-1 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600"
                          data-id="{{ $item->id }}">–</button>

                  {{-- qty sekarang (akan diupdate lewat JS) --}}
                  <span id="qty-{{ $item->id }}" class="px-2">{{ $item->qty }}</span>

                  {{-- PLUS (AJAX) --}}
                  <button type="button"
                          class="btn-inc px-2 py-1 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600 disabled:opacity-50"
                          data-id="{{ $item->id }}"
                          @if($item->qty >= $item->product->stock) disabled @endif>+</button>
                </div>
                <div class="text-xs text-slate-500 mt-1">Stok: {{ $item->product->stock }}</div>
              </td>

              {{-- Subtotal --}}
              <td class="p-3 font-semibold text-gray-900 dark:text-white">
                <span id="sub-{{ $item->id }}">
                  Rp {{ number_format($item->product->price * $item->qty,0,',','.') }}
                </span>
              </td>

              {{-- Hapus --}}
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

      {{-- TOTAL (bawah) + Checkout --}}
      <div class="flex justify-between items-center mt-6">
        <div class="text-lg font-bold text-gray-900 dark:text-white">
          Total: <span class="cart-total">Rp {{ number_format($total,0,',','.') }}</span>
        </div>

        <a href="{{ route('orders.payment') }}"
           class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
          Lanjut ke Payment
        </a>
      </div>
    @endif
  </div>
</x-app-layout>

{{-- ================== AJAX SCRIPT ================== --}}
<script>
const token = document.querySelector('meta[name="csrf-token"]').content;

function fmt(n){
  return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(n);
}
function setAllTotals(v){
  document.querySelectorAll('.cart-total').forEach(el => el.textContent = fmt(v));
}

document.addEventListener('click', async (e) => {
  // + (increment)
  const incBtn = e.target.closest('.btn-inc');
  if (incBtn) {
    const id = incBtn.dataset.id;
    incBtn.disabled = true;
    const res = await fetch(`{{ url('/cart') }}/${id}/increment`, {
      method: 'PATCH',
      headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    });
    if (res.ok) {
      const d = await res.json();
      document.getElementById(`qty-${id}`).textContent = d.qty;
      document.getElementById(`sub-${id}`).textContent = fmt(d.subtotal);
      if (d.cart_total !== undefined) setAllTotals(d.cart_total);
      incBtn.disabled = !!d.reached_max;
    } else if (res.status === 422) {
      incBtn.disabled = true;
      const err = await res.json();
      alert(err.message || 'Jumlah sudah maksimal.');
    } else {
      incBtn.disabled = false;
      alert('Gagal menambah quantity.');
    }
    return;
  }

  // – (decrement)
  const decBtn = e.target.closest('.btn-dec');
  if (decBtn) {
    const id = decBtn.dataset.id;
    decBtn.disabled = true;

    const res = await fetch(`{{ url('/cart') }}/${id}/decrement`, {
      method: 'PATCH',
      headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    });

    if (!res.ok) {
      decBtn.disabled = false;
      alert('Gagal mengurangi quantity.');
      return;
    }

    const d = await res.json();
    if (d.cart_total !== undefined) setAllTotals(d.cart_total);

    if (d.removed) {
      // hapus baris
      const row = document.getElementById(`row-${id}`);
      if (row) row.remove();

      // kalau kosong, hilangkan tabel & tampilkan pesan
      if (!document.querySelector('tbody tr')) {
        const table = document.querySelector('table'); if (table) table.remove();
        const empty = document.createElement('div');
        empty.className = 'text-gray-500 dark:text-gray-300';
        empty.textContent = 'Keranjang kosong.';
        document.querySelector('.max-w-3xl')?.appendChild(empty);
      }
    } else {
      // update qty & subtotal
      document.getElementById(`qty-${id}`).textContent = d.qty;
      document.getElementById(`sub-${id}`).textContent = fmt(d.subtotal);

      // pastikan tombol + aktif lagi jika sebelumnya disabled
      const plus = document.querySelector(`.btn-inc[data-id="${id}"]`);
      if (plus) plus.disabled = !d.can_increment;

      decBtn.disabled = false;
    }
  }
});
</script>
