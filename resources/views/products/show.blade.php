<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <a href="{{ route('products.index') }}"
       class="inline-block px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 transition mb-4">
       &larr; Kembali
    </a>

    <div class="mb-4">
      <img src="{{ $product->photo ? asset('storage/'.$product->photo) : asset('img/default.png') }}"
           alt="Foto Produk"
           class="h-64 w-full object-cover rounded-xl border dark:border-gray-700">
    </div>

    <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>

    @auth
      @if (auth()->user()->isAdmin())
        <a href="{{ route('admin.products.edit', $product) }}"
           class="inline-flex items-center px-4 py-2 rounded bg-amber-500 text-white hover:bg-amber-600">
          Edit Produk
        </a>
      @endif
    @endauth

    <p class="text-gray-500 dark:text-gray-400">{{ $product->category->name ?? '-' }}</p>

    <div class="mt-4 rounded-2xl p-4 shadow bg-white dark:bg-gray-800">
      <div class="text-lg font-semibold text-gray-900 dark:text-white">
        Rp {{ number_format($product->price,0,',','.') }}
      </div>
      <div class="text-sm text-gray-700 dark:text-gray-300">
        Stok: {{ $product->stock }}
      </div>

      @if($product->description)
        <p class="mt-3 leading-relaxed text-gray-800 dark:text-gray-200">
          {{ $product->description }}
        </p>
      @endif

      <form class="mt-4" method="POST" action="{{ route('cart.add', $product) }}">
        @csrf
        <button type="submit"
                class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-700 dark:bg-blue-600 dark:hover:bg-blue-500">
          Tambah ke Keranjang
        </button>
      </form>
    </div>
  </div>
</x-app-layout>
