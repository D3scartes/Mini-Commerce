<x-app-layout>
  <div class="max-w-md mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Category</h1>
    <form method="POST" action="{{ route('admin.categories.update',$category) }}">
      @csrf @method('PUT')
      <label class="block text-sm mb-1">Name</label>
      <input name="name" value="{{ old('name',$category->name) }}" class="border rounded-lg w-full px-3 py-2">
      @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      <div class="mt-4">
        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="ms-3 underline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
