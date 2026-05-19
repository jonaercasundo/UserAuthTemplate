@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-4">Suppliers</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded mb-4">{{ session('warning') }}</div>
        @endif

        <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
            <strong class="font-semibold">Supplier Portal:</strong>
            View each supplier’s products, current unit costs, inventory value, and price variance against the warehouse average.
            Use the <span class="font-semibold">Portal</span> button on the supplier table to compare supplier pricing before ordering.
        </div>

        @php
            $formAction = isset($editingSupplier)
                ? route('warehouse.settings.suppliers.update', $editingSupplier->id)
                : route('warehouse.settings.suppliers.store');
            $formMethod = isset($editingSupplier) ? 'PUT' : 'POST';
            $formTitle = isset($editingSupplier) ? 'Edit Supplier' : 'New Supplier';
        @endphp

        <div class="mb-6 rounded-lg border border-gray-200 bg-white shadow-sm p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $formTitle }}</h3>
                    <p class="text-sm text-gray-500">{{ isset($editingSupplier) ? 'Update supplier details or cancel editing.' : 'Add a new supplier to use across receiving and inventory workflows.' }}</p>
                </div>
                @isset($editingSupplier)
                    <a href="{{ route('warehouse.settings.suppliers') }}" class="text-sm text-indigo-600 hover:underline">Cancel edit</a>
                @endisset
            </div>

            <form method="POST" action="{{ $formAction }}" class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                @csrf
                @if(isset($editingSupplier))
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input name="name" value="{{ old('name', $editingSupplier->name ?? '') }}" placeholder="Supplier name" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact</label>
                    <input name="contact" value="{{ old('contact', $editingSupplier->contact ?? '') }}" placeholder="Contact" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('contact')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input name="email" value="{{ old('email', $editingSupplier->email ?? '') }}" type="email" placeholder="Email" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-3 text-right">
                    <button type="submit" class="inline-flex items-center justify-center rounded bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">{{ isset($editingSupplier) ? 'Update Supplier' : 'Add Supplier' }}</button>
                </div>
            </form>
        </div>

        @if($suppliers->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Contact</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Products</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($suppliers as $s)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $s->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $s->contact }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $s->email }}</td>
                                <td class="px-4 py-2 text-center text-sm text-gray-700">{{ $s->inventories_count }}</td>
                                <td class="px-4 py-2 text-center text-sm space-y-2">
                                    <a href="{{ route('warehouse.settings.suppliers.show', $s->id) }}" class="inline-flex items-center px-3 py-1 rounded bg-slate-50 text-slate-700 hover:bg-slate-100">Portal</a>
                                    <a href="{{ route('warehouse.settings.suppliers.edit', $s->id) }}" class="inline-flex items-center px-3 py-1 rounded bg-blue-50 text-blue-700 hover:bg-blue-100">Edit</a>
                                    <form method="POST" action="{{ route('warehouse.settings.suppliers.destroy', $s->id) }}" onsubmit="return confirm('Delete this supplier?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 rounded bg-red-50 text-red-700 hover:bg-red-100">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $suppliers->links() }}</div>
        @else
            <div class="text-gray-600">No suppliers yet.</div>
        @endif
    </div>
@endsection
