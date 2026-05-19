<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product Settings</h2>
                <p class="text-sm text-gray-500">Add product codes and names used across receiving/release workflows.</p>
            </div>
            <a href="{{ route('warehouse.dashboard') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 rounded">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
                <form method="POST" action="{{ route('warehouse.settings.products.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="text-sm text-gray-700">Product Code</label>
                        <input name="product_code" type="text" required class="w-full px-3 py-2 border rounded" placeholder="e.g., PROD001">
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Product Name</label>
                        <input name="product_name" type="text" required class="w-full px-3 py-2 border rounded" placeholder="Product name">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Add Product</button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Existing Products</h3>
                @if($products->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Code</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Supplier</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $p)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-800">{{ $p->product_code }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                            <form method="POST" action="{{ route('warehouse.settings.products.update', $p->id) }}" class="flex gap-2 items-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="product_name" value="{{ $p->product_name }}" class="px-2 py-1 border rounded text-sm">
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-600">
                                                <select name="supplier_id" class="px-2 py-1 border rounded text-sm">
                                                    <option value="">-- None --</option>
                                                    @foreach($suppliers as $s)
                                                        <option value="{{ $s->id }}" @if($p->supplier_id == $s->id) selected @endif>{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                        </td>
                                        <td class="px-4 py-2 text-center text-sm">
                                                <div class="flex gap-2 justify-center">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Save</button>
                                            </form>
                                            <form method="POST" action="{{ route('warehouse.settings.products.destroy', $p->id) }}" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $products->links() }}</div>
                @else
                    <p class="text-sm text-gray-500">No products found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
