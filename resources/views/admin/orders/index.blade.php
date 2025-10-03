<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
      Daftar Pesanan
    </h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    {{-- Jika kosong --}}
    @if($orders->isEmpty())
      <p class="text-gray-600 dark:text-gray-300">Belum ada pesanan.</p>
    @else
      <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="w-full table-auto border-collapse">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-3 text-left text-gray-700 dark:text-gray-200">#</th>
              <th class="p-3 text-left text-gray-700 dark:text-gray-200">Buyer</th>
              <th class="p-3 text-left text-gray-700 dark:text-gray-200">Total Item</th>
              <th class="p-3 text-left text-gray-700 dark:text-gray-200">Status</th>
              <th class="p-3 text-left text-gray-700 dark:text-gray-200">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              @php
                $statusColors = [
                  'Dikemas' => 'bg-yellow-500',
                  'Dikirim' => 'bg-blue-500',
                  'Selesai' => 'bg-green-600',
                ];
                $colorClass = $statusColors[$order->status] ?? 'bg-gray-500';
              @endphp
              <tr class="odd:bg-gray-50 dark:odd:bg-gray-900 border-t dark:border-gray-700">
                <td class="p-3 text-gray-800 dark:text-white font-semibold">
                  #{{ $order->id }}
                </td>
                <td class="p-3 text-gray-600 dark:text-gray-300">
                  {{ $order->user->name }}
                </td>
                <td class="p-3 text-gray-600 dark:text-gray-300">
                  {{ $order->items->sum('qty') }} barang
                </td>
                <td class="p-3">
                  <span class="px-2 py-1 rounded text-white text-sm {{ $colorClass }}">
                    {{ $order->status }}
                  </span>
                </td>
                <td class="p-3">
                  <a href="{{ route('admin.orders.show', $order) }}"
                     class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                    Detail
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- ✅ Pagination --}}
      <div class="mt-6">
        {{ $orders->links() }}
      </div>
    @endif
  </div>
</x-app-layout>
