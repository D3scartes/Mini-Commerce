<x-app-layout>
  <div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Product</h1>
    <form method="POST" action="{{ route('admin.products.update',$product) }}">
      @csrf @method('PUT')
      {{-- isi form sama seperti create, tapi gunakan old(..., $product->field) --}}
      {{-- ... --}}
    </form>
  </div>
</x-app-layout>
