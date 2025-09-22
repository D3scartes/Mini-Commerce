<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Produk</h1>

    @if ($products->count())
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($products as $p)
          <div class="rounded-2xl p-4 shadow">
            <div class="text-sm text-gray-500">{{ $p->category->name ?? '-' }}</div>
            <div class="font-semibold">{{ $p->name }}</div>
            <div class="mt-1 text-sm">Stok: {{ $p->stock }}</div>
            <div class="mt-2 font-bold">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
          </div>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $products->links() }}
      </div>
    @else
      <p class="text-gray-600">Belum ada produk.</p>
    @endif
  </div>
</x-app-layout>
