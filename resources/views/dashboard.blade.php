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
        @if(Auth::check())
            Halo, {{ Auth::user()->name }}! 👋
        @else
            Halo, Guest! 👋
        @endif
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
        @php
        $categories = \App\Models\Category::select('id','name','image_path')->orderBy('name')->get();
        @endphp

        <section aria-labelledby="kategori" class="space-y-4">
        <h2 id="kategori" class="text-xl font-bold text-gray-900 dark:text-gray-100">KATEGORI</h2>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
        @forelse($categories as $c)
            <a href="{{ route('products.index', ['category' => $c->id]) }}"
                class="block rounded-2xl bg-white dark:bg-gray-800 p-4 shadow hover:shadow-md hover:-translate-y-0.5 transition transform duration-150">
                
                @if($c->image_path)
                <div class="aspect-square w-full rounded-lg overflow-hidden mb-3 bg-gray-100 dark:bg-gray-700">
                    <img src="{{ asset('storage/'.$c->image_path) }}"
                        alt="{{ $c->name }}"
                        class="h-full w-full object-cover">
                </div>
                @else
                <div class="aspect-square w-full rounded-lg bg-gray-100 dark:bg-gray-700 mb-3
                            flex items-center justify-center text-gray-400 text-4xl">
                    🛒
                </div>
                @endif

                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 text-center">
                {{ $c->name }}
                </div>
            </a>
        @empty
            @for($i=0;$i<8;$i++)
                <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 shadow">
                <div class="aspect-square w-full rounded-lg bg-gray-100 dark:bg-gray-700 mb-3"></div>
                <div class="h-3 bg-gray-100 dark:bg-gray-700 rounded w-2/3 mx-auto"></div>
                </div>
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
                class="block rounded-2xl bg-white dark:bg-gray-800 p-4 shadow hover:shadow-md hover:-translate-y-0.5 transform duration-150 transition">

                @if($p->photo)
                <div class="aspect-[4/3] w-full rounded-lg overflow-hidden mb-3 bg-gray-100 dark:bg-gray-700">
                    <img
                    src="{{ asset('storage/'.$p->photo) }}"
                    alt="{{ $p->name }}"
                    class="h-full w-full object-cover"
                    loading="lazy"
                    />
                </div>
                @else
                <div class="aspect-[4/3] w-full rounded-lg bg-gray-100 dark:bg-gray-700 mb-3
                            flex items-center justify-center text-gray-400 text-4xl">
                    🛒
                </div>
                @endif

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
