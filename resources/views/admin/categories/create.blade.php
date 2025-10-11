<x-app-layout>
  <div class="max-w-lg mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
      Tambah Kategori
    </h1>

    {{-- Notifikasi error --}}
    @if ($errors->any())
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}"
          class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
      @csrf

      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
          Nama Kategori
        </label>
        <input type="text" id="name" name="name" value="{{ old('name') }}"
               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        @error('name')
          <div class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="flex justify-end gap-3">
        <a href="{{ route('admin.categories.index') }}"
           class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:underline">
          Batal
        </a>
        <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
          Simpan
        </button>
      </div>
    </form>
  </div>
</x-app-layout>
