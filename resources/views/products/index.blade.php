<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Produk</h1>
    
    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
      <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari produk..." class="border p-2 rounded">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
          Cari
      </button>
    </form>
    @if ($products->count())
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($products as $p)
          <a href="{{ route('products.show', $p) }}"
            class="block rounded-2xl p-4 shadow hover:shadow-md transition">
            <div class="text-sm text-gray-500">{{ $p->category->name ?? '-' }}</div>
            <div class="font-semibold">{{ $p->name }}</div>
            <div class="mt-1 text-sm">Stok: {{ $p->stock }}</div>
            <div class="mt-2 font-bold">Rp {{ number_format($p->price,0,',','.') }}</div>
          </a>
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
