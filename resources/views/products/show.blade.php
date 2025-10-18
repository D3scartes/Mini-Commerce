<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <a href="{{ route('products.index') }}"
       class="inline-block px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 transition mb-4">
       &larr; Kembali
    </a>

    <div class="mb-4">
      @php
        use Illuminate\Support\Facades\Storage;

        // cek file di storage/public
        $hasPhoto = $product->photo && Storage::disk('public')->exists($product->photo);

        // fallback ke default placeholder
        $imgUrl = $hasPhoto ? Storage::url($product->photo) : asset('img/default.png');
      @endphp

      @if($hasPhoto)
        <img
          src="{{ $imgUrl }}"
          alt="{{ $product->name }}"
          class="h-64 w-full object-cover rounded-xl border-none"
          loading="lazy"
        />
      @else
        <div class="h-64 w-full flex items-center justify-center
                    bg-gray-100 dark:bg-gray-700 text-gray-400 text-6xl rounded-xl">
          🛒
        </div>
      @endif
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

      @auth
        <form method="POST" action="{{ route('cart.add', $product) }}" class="inline">
          @csrf
          <input type="hidden" name="qty" value="1">
          <button type="submit"
            class="inline-flex items-center h-10 px-4 rounded-xl bg-blue-600 text-white
                  hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50
                  transition text-sm font-medium">
            Tambah ke Keranjang
          </button>
        </form>
      @endauth

      @guest
      <a href="{{ route('login') }}"
        class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white
                hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50
                transition text-sm font-medium">
        Login untuk tambah ke keranjang
      </a>
      @endguest
    </div>
  </div>
</x-app-layout>
