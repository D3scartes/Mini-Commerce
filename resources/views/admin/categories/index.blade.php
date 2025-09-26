<x-app-layout>
  <div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-bold">Categories</h1>
      <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg">New</a>
    </div>

    @if (session('success'))
      <div class="mb-3 rounded bg-green-100 text-green-800 px-3 py-2">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
      <div class="mb-3 rounded bg-red-100 text-red-800 px-3 py-2">{{ $errors->first() }}</div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left p-3">Name</th>
            <th class="p-3 w-44">Actions</th>
          </tr>
        </thead>
        <tbody>
        @forelse($categories as $c)
          <tr class="border-t">
            <td class="p-3">{{ $c->name }}</td>
            <td class="p-3">
              <a href="{{ route('admin.categories.edit',$c) }}" class="underline">Edit</a>
              <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" class="inline" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button class="text-red-600 underline ms-3">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td class="p-3 text-gray-500" colspan="2">No data.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
  </div>
</x-app-layout>
