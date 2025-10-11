<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">
      Kelola Kategori
    </h1>

    {{-- Tombol Tambah --}}
    <div class="flex justify-end mb-4">
      <a href="{{ route('admin.categories.create') }}"
         class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
        + Tambah Kategori
      </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200">
        {{ $errors->first() }}
      </div>
    @endif

    {{-- Tabel --}}
    @if($categories->isEmpty())
      <p class="text-gray-600 dark:text-gray-300">Belum ada kategori.</p>
    @else
      <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="w-full table-auto border-collapse">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="p-3 text-left text-gray-700 dark:text-gray-200">Nama Kategori</th>
              <th class="p-3 text-center text-gray-700 dark:text-gray-200 w-1/4">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $category)
              <tr class="odd:bg-gray-50 dark:odd:bg-gray-900 border-t dark:border-gray-700">
                <td class="p-3 text-gray-800 dark:text-white font-medium">
                  {{ $category->name }}
                </td>
                <td class="p-3 flex justify-center gap-2">
                  <a href="{{ route('admin.categories.edit', $category) }}"
                     class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                    Edit
                  </a>
                  <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="mt-6">
        {{ $categories->links() }}
      </div>
    @endif
  </div>
</x-app-layout>
