<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

      {{-- Salam --}}
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          Halo, {{ Auth::user()->name }}! 👋<br>
          Selamat datang di <b>{{ config('app.name','Mini Commerce') }}</b> 🎉
        </div>
      </div>

      {{-- PROMOSI --}}
      <section aria-labelledby="promo" class="rounded-2xl overflow-hidden">
        <h2 id="promo" class="sr-only">Promosi</h2>
        <div class="h-48 md:h-64 lg:h-72 bg-gradient-to-r from-orange-500 to-red-500
                    flex items-center justify-center text-white dark:text-white">
            <div class="text-center">
            <div class="text-2xl md:text-3xl font-extrabold tracking-tight">PROMOSI</div>
            <p class="opacity-90 mt-2 text-sm md:text-base">Diskon spesial & penawaran terbaik hari ini</p>
            </div>
        </div>
      </section>

      {{-- KATEGORI --}}


      {{-- KATEGORI (langsung query di Blade) --}}
        @php
        $categories = \App\Models\Category::select('id','name','image_path')->orderBy('name')->get();
        @endphp

        <section aria-labelledby="kategori" class="space-y-4">
        <h2 id="kategori" class="text-xl font-bold text-gray-900 dark:text-gray-100">KATEGORI</h2>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
            @forelse($categories as $c)
            <a href="{{ route('products.index', ['category' => $c->id]) }}"
                class="flex flex-col items-center gap-2 p-3 rounded-lg border
                        border-gray-200 hover:bg-gray-50
                        dark:border-gray-700 dark:hover:bg-gray-700/50">
                @if($c->image_path)
                <img src="{{ asset('storage/'.$c->image_path) }}"
                    alt="{{ $c->name }}"
                    class="h-16 w-16 rounded-lg object-cover">
                @else
                <div class="h-16 w-16 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-2xl">🛒</div>
                @endif
                <div class="text-sm text-gray-700 dark:text-gray-200 text-center">{{ $c->name }}</div>
            </a>
            @empty
            @for($i=0;$i<8;$i++)
                <div class="h-24 rounded-lg bg-gray-100 dark:bg-gray-700"></div>
            @endfor
            @endforelse
        </div>
        </section>



      {{-- PRODUK --}}
      <section aria-labelledby="produk" class="space-y-4">
        <h2 id="produk" class="text-xl font-bold text-gray-900 dark:text-gray-100">PRODUK</h2>

        @php
            $latestProducts = \App\Models\Product::with('category')->latest('id')->take(8)->get();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($latestProducts as $p)
            <a href="{{ route('products.show', $p) }}"
                class="block rounded-2xl bg-white dark:bg-gray-800 p-4 shadow hover:shadow-md transition">
                <div class="aspect-[4/3] w-full rounded-lg bg-gray-100 dark:bg-gray-700 mb-3"></div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $p->category->name ?? '-' }}</div>
                <div class="font-semibold text-gray-900 dark:text-gray-100 line-clamp-2">{{ $p->name }}</div>
                <div class="mt-1 text-sm text-gray-700 dark:text-gray-200">Stok: {{ $p->stock }}</div>
                <div class="mt-2 font-bold text-gray-900 dark:text-gray-100">
                Rp {{ number_format($p->price, 0, ',', '.') }}
                </div>
            </a>
            @empty
            @for($i=0; $i<8; $i++)
                <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 shadow">
                <div class="aspect-[4/3] w-full rounded-lg bg-gray-100 dark:bg-gray-700 mb-3"></div>
                <div class="h-3 bg-gray-100 dark:bg-gray-700 rounded w-2/3 mb-2"></div>
                <div class="h-3 bg-gray-100 dark:bg-gray-700 rounded w-1/2 mb-2"></div>
                <div class="h-3 bg-gray-100 dark:bg-gray-700 rounded w-1/3"></div>
                </div>
            @endfor
            @endforelse
        </div>

        <div class="text-right">
            <a href="{{ route('products.index') }}"
            class="inline-flex items-center h-10 px-4 rounded-lg
                    border border-gray-300 hover:bg-gray-50 text-gray-800
                    dark:border-gray-700 dark:text-gray-100 dark:hover:bg-gray-700">
            Lihat semua produk →
            </a>
        </div>
        </section>


    </div>
  </div>
</x-app-layout>
