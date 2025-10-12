<x-app-layout>
  <div class="max-w-md mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Category</h1>

    <form method="POST"
          action="{{ route('admin.categories.update',$category) }}"
          enctype="multipart/form-data">   {{-- ← tambah enctype --}}
      @csrf @method('PUT')

      {{-- Name --}}
      <label class="block text-sm mb-1">Name</label>
      <input name="name" value="{{ old('name',$category->name) }}" class="border rounded-lg w-full px-3 py-2">
      @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      {{-- Preview image saat ini (jika ada) --}}
      @if ($category->image_path)
        <div class="mt-4">
          <div class="text-sm text-gray-600 mb-1">Current Image</div>
          <img src="{{ asset('storage/'.$category->image_path) }}"
               alt="{{ $category->name }}"
               class="h-24 w-24 rounded-lg object-cover border">
        </div>
      @endif

      {{-- Upload image baru --}}
      <div class="mt-4">
        <label class="block text-sm mb-1">Image (optional)</label>
        <input type="file" name="image" accept="image/*"
               class="block w-full text-sm file:mr-3 file:py-2 file:px-3
                      file:rounded-lg file:border-0 file:bg-gray-900 file:text-white
                      hover:file:bg-black/90">
        <p class="text-xs text-gray-500 mt-1">PNG/JPG/WEBP, maks 2MB.</p>
        @error('image')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
      </div>

      <div class="mt-6">
        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="ms-3 underline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>

