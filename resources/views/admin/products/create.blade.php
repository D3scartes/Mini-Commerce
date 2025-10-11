<x-app-layout>
  <div class="max-w-2xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Produk</h1>
      {{-- Tombol balik ke index admin --}}
      <a href="{{ route('admin.products.index') }}"
         class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 
                bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                transition-colors duration-200">
        ← Kembali
      </a>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
      @csrf

      {{-- Photo --}}
      <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Produk</label>
      <input id="photo" name="photo" type="file" accept="image/*"
             class="block w-full text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 
                    border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer mb-4">
      @error('photo')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      {{-- Name --}}
      <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk</label>
      <input id="name" name="name" value="{{ old('name') }}"
             class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 
                    text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 mb-4"
             required>
      @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      {{-- Category --}}
      <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
      <select id="category_id" name="category_id"
              class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 
                     text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 mb-4"
              required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>

      {{-- Price & Stock --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga</label>
          <input id="price" name="price" type="number" min="0" value="{{ old('price') }}"
                 class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 
                        text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                 required>
        </div>
        <div>
          <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
          <input id="stock" name="stock" type="number" min="0" value="{{ old('stock') }}"
                 class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 
                        text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                 required>
        </div>
      </div>

      {{-- Tampilkan --}}
      <div class="flex items-center gap-2 mb-4">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', 1))
               class="rounded text-blue-600 border-gray-300 dark:border-gray-600">
        <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan produk ini</span>
      </div>

      {{-- Description --}}
      <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
      <textarea id="description" name="description" rows="4"
                class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 
                       text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 mb-4">{{ old('description') }}</textarea>

      {{-- Buttons --}}
      <div class="flex items-center gap-3">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
          Simpan
        </button>
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                  rounded-lg text-gray-700 dark:text-gray-200 transition-colors duration-200">
          Batal
        </a>
      </div>
    </form>
  </div>
</x-app-layout>
