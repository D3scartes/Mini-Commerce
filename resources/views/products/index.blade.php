<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Produk</h1>

    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    {{-- bar atas: kiri = cari --}}
    <div class="mb-4 flex items-center justify-between gap-2">
      {{-- kiri: form cari --}}
      <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-3">

        {{-- input search --}}
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Cari produk..."
          class="h-10 px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white dark:border-gray-600"
        >

        {{-- filter kategori --}}
        <select name="category"
          class="h-10 border rounded px-4 w-40 appearance-none bg-white dark:bg-gray-800 dark:text-white dark:border-gray-600">
          <option value="">Kategori</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>

        {{-- sorting --}}
        <select name="sort"
          class="h-10 border rounded px-2 bg-white dark:bg-gray-800 dark:text-white dark:border-gray-600">
          <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
          <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
          <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
        </select>

        <button
          type="submit"
          class="h-10 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600"
        >
          Cari
        </button>
      </form>
    </div>

    @if ($products->count())
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($products as $p)
          <a href="{{ route('products.show', $p) }}"
             class="block rounded-2xl p-4 shadow hover:shadow-md transition bg-white dark:bg-gray-800">
            <div class="mb-2">
              <img src="{{ $p->photo ? asset('storage/'.$p->photo) : asset('img/default.png') }}"
                   alt="Foto Produk"
                   class="h-32 w-full object-cover rounded-lg border">
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $p->category->name ?? '-' }}</div>
            <div class="font-semibold text-gray-900 dark:text-white">{{ $p->name }}</div>
            <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">Stok: {{ $p->stock }}</div>
            <div class="mt-2 font-bold text-gray-900 dark:text-white">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
          </a>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $products->links() }}
      </div>
    @else
      <p class="text-gray-600 dark:text-gray-300">Belum ada produk.</p>
    @endif
  </div>
</x-app-layout>
