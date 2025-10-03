<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Pesanan Saya</h1>

    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    @if($orders->isEmpty())
      <p class="text-gray-500 dark:text-gray-300">Belum ada pesanan.</p>
    @else
      <div class="space-y-4">
        @foreach($orders as $order)
          <div class="border rounded-lg p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex justify-between items-center mb-2">
              <span class="font-semibold text-gray-800 dark:text-white">
                Order #{{ $order->id }}
              </span>
              <span class="text-sm px-2 py-1 rounded bg-blue-500 text-white">
                {{ $order->status }}
              </span>
            </div>
            <div class="text-gray-600 dark:text-gray-300 text-sm">
              {{ $order->name }} - {{ $order->phone }} <br>
              {{ $order->address }}
            </div>
            <ul class="mt-2 text-sm text-gray-700 dark:text-gray-200">
              @foreach($order->items as $item)
                <li>
                  {{ $item->product->name }} x {{ $item->qty }}
                  (Rp {{ number_format($item->price,0,',','.') }})
                </li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</x-app-layout>
