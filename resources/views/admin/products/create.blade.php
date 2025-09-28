<x-app-layout>
  <div class="max-w-2xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-bold">New Product</h1>
      {{-- Tombol balik ke index admin --}}
      <a href="{{ route('admin.products.index') }}" class="text-sm underline">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" novalidate>
      @csrf

      {{-- Name --}}
      <label for="name" class="block text-sm mb-1">Name</label>
      <input
        id="name"
        name="name"
        value="{{ old('name') }}"
        class="border rounded-lg w-full px-3 py-2"
        required
        maxlength="120"
        autofocus
      >
      @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      {{-- Category --}}
      <label for="category_id" class="block text-sm mb-1 mt-4">Category</label>
      <select
        id="category_id"
        name="category_id"
        class="border rounded-lg w-full px-3 py-2"
        required
      >
        <option value="">-- pilih --</option>
        @foreach ($categories as $c)
          <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      @error('category_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        {{-- Price --}}
        <div>
          <label for="price" class="block text-sm mb-1">Price</label>
          <input
            id="price"
            name="price"
            type="number"
            min="0"
            step="1"
            value="{{ old('price') }}"
            class="border rounded-lg w-full px-3 py-2"
            required
          >
          @error('price')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        {{-- Stock --}}
        <div>
          <label for="stock" class="block text-sm mb-1">Stock</label>
          <input
            id="stock"
            name="stock"
            type="number"
            min="0"
            step="1"
            value="{{ old('stock') }}"
            class="border rounded-lg w-full px-3 py-2"
            required
          >
          @error('stock')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- Tampilkan (checkbox) --}}
      <div class="mt-4">
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex items-center gap-2">
          <input
            type="checkbox"
            name="is_active"
            value="1"
            @checked(old('is_active', 1))
          >
          <span>Tampilkan</span>
        </label>
      </div>



      {{-- Description --}}
      <label for="description" class="block text-sm mb-1 mt-4">Description</label>
      <textarea
        id="description"
        name="description"
        rows="4"
        class="border rounded-lg w-full px-3 py-2"
        maxlength="1000"
      >{{ old('description') }}</textarea>
      @error('description')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror

      <div class="mt-5">
        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg">Save</button>
        <a href="{{ route('admin.products.index') }}" class="ms-3 underline">Cancel</a>
      </div>
    </form>
  </div>
</x-app-layout>
