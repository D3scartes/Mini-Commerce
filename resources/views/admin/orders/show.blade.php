<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
      Detail Pesanan #{{ $order->id }}
    </h1>
    <div class="max-w-4xl mx-auto p-6">
    <!-- Tombol kembali -->
    <a href="{{ route('admin.orders.index') }}"
       class="mb-4 inline-block px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
      ← Kembali
    </a>

    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Detail Pesanan #{{ $order->id }}</h1>

    <!-- isi detail order seperti sebelumnya -->
  </div>
    {{-- Info Buyer --}}
    <div class="mb-4 p-4 rounded-lg border dark:border-gray-700 dark:bg-gray-800">
      <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Data Pembeli</h2>
      <p class="text-gray-600 dark:text-gray-300">Nama: {{ $order->name }}</p>
      <p class="text-gray-600 dark:text-gray-300">No HP: {{ $order->phone }}</p>
      <p class="text-gray-600 dark:text-gray-300">Alamat: {{ $order->address }}</p>
    </div>

    {{-- Items --}}
    <div class="mb-4 p-4 rounded-lg border dark:border-gray-700 dark:bg-gray-800">
      <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Produk Dipesan</h2>
      <ul class="mt-2 space-y-2">
        @foreach($order->items as $item)
          <li class="flex justify-between text-gray-700 dark:text-gray-200">
            <span>{{ $item->product->name }} (x{{ $item->qty }})</span>
            <span>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
          </li>
        @endforeach
      </ul>
      <div class="mt-3 font-bold text-gray-800 dark:text-white">
        Total: Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->qty), 0, ',', '.') }}
      </div>
    </div>

    {{-- Status Update --}}
    <div class="p-4 rounded-lg border dark:border-gray-700 dark:bg-gray-800">
      <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Update Status</h2>
      <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
        @csrf
        @method('PUT')
        <select name="status"
                class="border rounded p-2 dark:bg-gray-700 dark:text-white">
          <option value="Dikemas" {{ $order->status === 'Dikemas' ? 'selected' : '' }}>Dikemas</option>
          <option value="Dikirim" {{ $order->status === 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
          <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit"
                class="ml-2 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
          Update
        </button>
      </form>
    </div>
  </div>
</x-app-layout>
