<x-app-layout>
  <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Payment</h2>

    <form method="POST" action="{{ route('orders.store') }}">
      @csrf
      <div class="mb-3">
        <label class="block text-sm text-gray-700 dark:text-gray-300">Nama</label>
        <input type="text" name="name" required
               class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
      </div>

      <div class="mb-3">
        <label class="block text-sm text-gray-700 dark:text-gray-300">No HP</label>
        <input type="text" name="phone" required
               class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
      </div>

      <div class="mb-3">
        <label class="block text-sm text-gray-700 dark:text-gray-300">Alamat</label>
        <textarea name="address" required
                  class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
      </div>

      <div class="mb-3">
        <label class="block text-sm text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
        <input type="text" value="COD" disabled
               class="w-full p-2 border rounded bg-gray-200 dark:bg-gray-600 dark:text-white">
      </div>

      <button type="submit"
              class="w-full py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
        Bayar Sekarang
      </button>
    </form>
  </div>
</x-app-layout>
