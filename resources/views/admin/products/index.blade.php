<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-bold">Products</h1>
      <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg">New</a>
    </div>

    @if (session('success'))
      <div class="mb-3 rounded bg-green-100 text-green-800 px-3 py-2">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
      @foreach($products as $p)
        <div class="rounded-2xl p-4 shadow bg-white">
          <div class="text-sm text-gray-500">{{ $p->category->name ?? '-' }}</div>
          <div class="font-semibold">{{ $p->name }}</div>
          <div class="mt-1 text-sm">Stock: {{ $p->stock }}</div>
          <div class="mt-2 font-bold">Rp {{ number_format($p->price,0,',','.') }}</div>
          <div class="mt-3">
            <a href="{{ route('admin.products.edit',$p) }}" class="underline">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy',$p) }}" class="inline" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button class="text-red-600 underline ms-3">Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
  </div>
</x-app-layout>
