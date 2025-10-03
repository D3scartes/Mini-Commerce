<x-app-layout>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">

      <!-- Tombol Close -->
      <button onclick="window.location.href='{{ route('cart.index') }}'"
              class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-red-600">
        ✕
      </button>

      <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Payment</h2>

      <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="name" required
                   class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">No HP</label>
            <input type="text" name="phone" required
                   class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
            <textarea name="address" required
                      class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
            <select name="payment_method" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
              <option value="COD">Cash on Delivery (COD)</option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
          <a href="{{ route('cart.index') }}" 
             class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500">
            Batal
          </a>
          <button type="submit" 
                  class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
            Bayar
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
