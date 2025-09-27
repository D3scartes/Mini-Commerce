<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Produk</h1>

    {{-- bar atas: kiri = cari, kanan = aksi admin --}}
    <div class="mb-4 flex items-center justify-between gap-2">
      {{-- kiri: form cari --}}
      <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-3">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Cari produk..."
          class="h-10 px-3 py-2 border rounded"
        >
        <button
          type="submit"
          class="h-10 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600"
        >
          Cari
        </button>
      </form>


      {{-- kanan: tombol admin --}}
      @auth
        @if (auth()->user()->isAdmin())
          <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.index') }}"
              class="inline-flex items-center px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 ms-2">  {{-- or ml-2 --}}
              Kelola Produk
            </a>
          </div>
        @endif
      @endauth
    </div>

    @if ($products->count())
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($products as $p)
          <a href="{{ route('products.show', $p) }}"
             class="block rounded-2xl p-4 shadow hover:shadow-md transition">
            <div class="text-sm text-gray-500">{{ $p->category->name ?? '-' }}</div>
            <div class="font-semibold">{{ $p->name }}</div>
            <div class="mt-1 text-sm">Stok: {{ $p->stock }}</div>
            <div class="mt-2 font-bold">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
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
