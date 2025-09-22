<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <a href="{{ route('products.index') }}" class="text-sm underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold">{{ $product->name }}</h1>
    <p class="text-gray-500">{{ $product->category->name ?? '-' }}</p>

    <div class="mt-4 rounded-2xl p-4 shadow">
      <div class="text-lg font-semibold">Rp {{ number_format($product->price,0,',','.') }}</div>
      <div class="text-sm">Stok: {{ $product->stock }}</div>
      @if($product->description)
        <p class="mt-3 leading-relaxed">{{ $product->description }}</p>
      @endif
      <form class="mt-4" method="POST" action="#">
        {{-- nanti diganti ke route cart --}}
        <button type="button" class="px-4 py-2 rounded-lg bg-gray-900 text-white">Tambah ke Keranjang</button>
      </form>
    </div>
  </div>
</x-app-layout>
