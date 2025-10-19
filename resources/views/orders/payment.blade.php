<x-app-layout>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 relative">

      {{-- Tombol Close --}}
      <button onclick="window.location.href='{{ route('cart.index') }}'"
              class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-red-600"
              aria-label="Tutup">✕</button>

      <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Payment</h2>

      {{-- Notifikasi server --}}
      @if (session('error'))
        <div class="mb-3 p-3 rounded bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-100">
          {{ session('error') }}
        </div>
      @endif

      {{-- Ringkasan Keranjang --}}
      <div class="rounded-lg border dark:border-gray-700 overflow-hidden mb-5">
        <div class="max-h-56 overflow-auto">
          <table class="w-full text-left">
            <thead class="bg-gray-100 dark:bg-gray-900 sticky top-0">
              <tr>
                <th class="p-3 text-gray-700 dark:text-gray-200">Produk</th>
                <th class="p-3 text-gray-700 dark:text-gray-200">Harga</th>
                <th class="p-3 text-gray-700 dark:text-gray-200">Qty</th>
                <th class="p-3 text-gray-700 dark:text-gray-200">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cart as $item)
                <tr class="border-t dark:border-gray-700">
                  <td class="p-3">
                    <div class="flex items-center gap-3">
                      <img
                        src="{{ $item->product->photo ? asset('storage/'.$item->product->photo) : asset('img/default.png') }}"
                        alt="Foto"
                        class="h-10 w-10 object-cover rounded border dark:border-gray-600">
                      <span class="text-gray-900 dark:text-white">{{ $item->product->name }}</span>
                    </div>
                  </td>
                  <td class="p-3 text-gray-900 dark:text-gray-200">
                    Rp {{ number_format($item->product->price,0,',','.') }}
                  </td>
                  <td class="p-3 text-gray-900 dark:text-gray-200">{{ $item->qty }}</td>
                  <td class="p-3 font-semibold text-gray-900 dark:text-white">
                    Rp {{ number_format($item->product->price * $item->qty,0,',','.') }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="p-3 flex justify-end bg-gray-50 dark:bg-gray-900">
          <div class="text-lg font-bold text-gray-900 dark:text-white">
            Total: Rp {{ number_format($total,0,',','.') }}
          </div>
        </div>
      </div>

      {{-- Form Payment --}}
      <form id="payment-form" method="POST" action="{{ route('orders.store') }}" novalidate>
        @csrf

        <div class="space-y-4">
          {{-- Nama --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="name" required minlength="3"
                   value="{{ old('name', auth()->user()->name ?? '') }}"
                   class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            <p data-err-for="name" class="mt-1 text-sm text-red-600 hidden"></p>
          </div>

          {{-- No HP --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">No HP</label>
            <input type="tel" name="phone" required pattern="^[0-9+\-\s]{8,15}$"
                   placeholder="08xxxxxxxxxx"
                   value="{{ old('phone') }}"
                   class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            <p data-err-for="phone" class="mt-1 text-sm text-red-600 hidden"></p>
          </div>

          {{-- Alamat --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
            <textarea name="address" required minlength="10" rows="4"
                      class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota/kab, kode pos">{{ old('address') }}</textarea>
            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            <p data-err-for="address" class="mt-1 text-sm text-red-600 hidden"></p>
          </div>

          {{-- Metode Pembayaran (fixed COD) --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
            <select name="payment_method"
                    class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
              <option value="COD" selected>Cash on Delivery (COD)</option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
          <a href="{{ route('cart.index') }}"
             class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500">
            Batal
          </a>
          <button type="submit"
                  class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
            Bayar
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Validasi Client-side --}}
  <script>
    (function () {
      const form = document.getElementById('payment-form');

      function showErr(field, msg) {
        const el = form.querySelector(`[data-err-for="${field}"]`);
        if (!el) return;
        if (msg) { el.textContent = msg; el.classList.remove('hidden'); }
        else { el.textContent = ''; el.classList.add('hidden'); }
      }

      form.addEventListener('submit', function (e) {
        let ok = true;

        const name = form.elements['name'];
        if (!name.value || name.value.trim().length < 3) { showErr('name', 'Nama minimal 3 karakter.'); ok = false; }
        else { showErr('name', ''); }

        const phone = form.elements['phone'];
        const phonePattern = /^[0-9+\-\s]{8,15}$/;
        if (!phone.value || !phonePattern.test(phone.value.trim())) {
          showErr('phone', 'No. telepon 8–15 digit (angka, spasi, +, -).'); ok = false;
        } else { showErr('phone', ''); }

        const address = form.elements['address'];
        if (!address.value || address.value.trim().length < 10) { showErr('address', 'Alamat minimal 10 karakter.'); ok = false; }
        else { showErr('address', ''); }

        if (!ok) {
          e.preventDefault();
          alert('Mohon periksa kembali data yang dimasukkan.');
        }
      });
    })();
  </script>
</x-app-layout>
