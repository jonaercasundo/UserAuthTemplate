<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Create Warehouse Task
            </h2>
            <a href="{{ route('operation.dashboard') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- FORM CARD -->
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">

                <div class="p-8">

                    <!-- Header -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">New Warehouse Task</h3>
                        <p class="text-gray-600 text-sm">Fill in the details below to create a new warehouse task</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('warehouse.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Item Name -->
                        <div>
                            <label for="item_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                Item Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="item_name" 
                                name="item_name"
                                placeholder="e.g., Industrial Boxes, Packaging Materials"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('item_name') border-red-500 @enderror"
                                value="{{ old('item_name') }}"
                                required
                            >
                            @error('item_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-semibold text-gray-900 mb-2">
                                Quantity
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity"
                                placeholder="e.g., 100"
                                min="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('quantity') border-red-500 @enderror"
                                value="{{ old('quantity') }}"
                                required
                            >
                            @error('quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                                Notes
                                <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <textarea 
                                id="notes" 
                                name="notes"
                                placeholder="Add any additional details about this task..."
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('operation.dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                Cancel
                            </a>
                            <button 
                                type="submit"
                                class="px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2"
                            >
                                <span>✓</span>
                                <span>Create Task</span>
                            </button>
                        </div>

                    </form>

                </div>

            </div>

            <!-- INFO CARD -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <div class="text-2xl">ℹ️</div>
                    <div>
                        <h4 class="font-semibold text-blue-900 text-sm">Task Information</h4>
                        <p class="text-blue-800 text-xs mt-1">
                            Each task will be assigned a unique task code (WT-XXXXXX) and set to "Pending" status. You can track and update the status from the dashboard.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
