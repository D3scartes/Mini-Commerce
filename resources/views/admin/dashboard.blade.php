<x-app-layout>
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
      Dashboard Admin - Ringkasan Pesanan
    </h1>

    @forelse($orders as $order)
      <div class="border rounded-lg p-4 mb-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex justify-between items-center">
          <div>
            <span class="font-semibold text-gray-800 dark:text-white">
              Order #{{ $order->id }} - {{ $order->user->name }}
            </span>
            <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $order->address }}</p>
            <ul class="mt-2 text-sm text-gray-700 dark:text-gray-200">
              @foreach($order->items as $item)
                <li>- {{ $item->product->name }} (x{{ $item->qty }})</li>
              @endforeach
            </ul>
          </div>

          <div class="text-right space-y-2">
            <span class="inline-block px-2 py-1 rounded text-white text-sm
              {{ $order->status === 'Dikemas' ? 'bg-yellow-500' : '' }}
              {{ $order->status === 'Dikirim' ? 'bg-blue-500' : '' }}
              {{ $order->status === 'Selesai' ? 'bg-green-600' : '' }}">
              {{ $order->status }}
            </span>

            {{-- Tombol Detail --}}
            <a href="{{ route('admin.orders.show', $order->id) }}"
               class="block mt-2 px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">
              Detail
            </a>
          </div>
        </div>
      </div>
    @empty
      <p class="text-gray-500 dark:text-gray-300">Belum ada pesanan.</p>
    @endforelse
  </div>
</x-app-layout>
