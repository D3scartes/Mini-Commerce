<x-app-layout>
  <div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">New Product</h1>
    <form method="POST" action="{{ route('admin.products.store') }}">
      @csrf

      <label class="block text-sm mb-1">Name</label>
      <input name="name" value="{{ old('name') }}" class="border rounded-lg w-full px-3 py-2">
      @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      <label class="block text-sm mb-1 mt-4">Category</label>
      <select name="category_id" class="border rounded-lg w-full px-3 py-2">
        <option value="">-- pilih --</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('category_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm mb-1">Price</label>
          <input name="price" type="number" min="0" step="1" value="{{ old('price') }}" class="border rounded-lg w-full px-3 py-2">
          @error('price')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="block text-sm mb-1">Stock</label>
          <input name="stock" type="number" min="0" step="1" value="{{ old('stock') }}" class="border rounded-lg w-full px-3 py-2">
          @error('stock')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
      </div>

      <label class="block text-sm mb-1 mt-4">Active</label>
      <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Active

      <label class="block text-sm mb-1 mt-4">Description</label>
      <textarea name="description" rows="4" class="border rounded-lg w-full px-3 py-2">{{ old('description') }}</textarea>
      @error('description')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      <div class="mt-5">
        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Save</button>
        <a href="{{ route('admin.products.index') }}" class="ms-3 underline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
