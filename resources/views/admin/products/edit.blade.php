<x-app-layout>
  <div class="max-w-3xl mx-auto p-6">
    
    <!-- Judul -->
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
      Edit Produk
    </h1>

    <!-- Form Edit Produk -->
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Nama Produk -->
      <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}"
          class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
      </div>

      <!-- Kategori -->
      <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200">Kategori</label>
        <select name="category_id"
          class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Harga -->
      <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200">Harga</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}"
          class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
      </div>

      <!-- Stok -->
      <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200">Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
          class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
        <textarea name="description" rows="4"
          class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
      </div>

      <!-- Foto Produk -->
      <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200">Foto Produk</label>
        <input type="file" name="photo"
          class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-200 dark:bg-gray-800 border rounded cursor-pointer focus:outline-none">
        @if ($product->photo)
          <img src="{{ asset('storage/'.$product->photo) }}" alt="Foto Produk" class="h-24 mt-3 rounded border">
        @endif
      </div>

      <!-- Tombol Aksi -->
      <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.products.index') }}"
          class="px-4 py-2 rounded bg-gray-500 text-white hover:bg-gray-600 transition">
          Cancel
        </a>
        <button type="submit"
          class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
          Update
        </button>
      </div>
    </form>

  </div>
</x-app-layout>
