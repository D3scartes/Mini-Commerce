<x-app-layout>
  <div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Kelola Produk</h1>
      <a href="{{ route('admin.products.create') }}"
         class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
        Tambah Produk
      </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
        {{ session('success') }}
      </div>
    @endif

    {{-- Grid Produk --}}
    @if ($products->count())
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($products as $p)
          <div class="rounded-2xl p-4 shadow bg-white dark:bg-gray-800 hover:shadow-md transition">
            <div class="mb-2">
              <img src="{{ $p->photo ? asset('storage/'.$p->photo) : asset('img/default.png') }}"
                   alt="Foto Produk"
                   class="h-32 w-full object-cover rounded-lg border">
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $p->category->name ?? '-' }}</div>
            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $p->name }}</div>
            <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">Stok: {{ $p->stock }}</div>
            <div class="mt-2 font-bold text-gray-900 dark:text-gray-100">
              Rp {{ number_format($p->price, 0, ',', '.') }}
            </div>

            <div class="flex gap-2 mt-3">
  <a href="{{ route('admin.products.edit', $p) }}"
     class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600 text-center">
    Edit
  </a>
  <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
        onsubmit="return confirm('Yakin hapus produk ini?')">
    @csrf
    @method('DELETE')
    <button type="submit"
            class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600">
      Delete
    </button>
  </form>
</div>

          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div class="mt-6">
        {{ $products->links() }}
      </div>
    @else
      <p class="text-gray-600 dark:text-gray-300">Belum ada produk.</p>
    @endif
  </div>
</x-app-layout>
