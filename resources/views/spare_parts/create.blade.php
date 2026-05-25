@extends('layouts.app')

@section('header', 'Add Spare Part')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('spare-parts.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="p-8">
            <form action="{{ route('spare-parts.store') }}" method="POST">
                @csrf
                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Basic Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Part Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="e.g. Ball Bearing 6204" required>
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="part_number" class="block text-sm font-medium text-gray-700 mb-1">Part Number (Unique)</label>
                                <input type="text" name="part_number" id="part_number" value="{{ old('part_number') }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('part_number') border-red-500 @enderror" placeholder="e.g. SKF-6204-2Z" required>
                                @error('part_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Category & Machine -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" id="category_id" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="machine_id" class="block text-sm font-medium text-gray-700 mb-1">Target Machine</label>
                            <select name="machine_id" id="machine_id" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('machine_id') border-red-500 @enderror" required>
                                <option value="">Select Machine</option>
                                @foreach($machines as $machine)
                                    <option value="{{ $machine->id }}" {{ old('machine_id') == $machine->id ? 'selected' : '' }}>{{ $machine->name }} ({{ $machine->code }})</option>
                                @endforeach
                            </select>
                            @error('machine_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Inventory Details -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Inventory Levels & Pricing</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Initial Stock</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="min_stock_level" class="block text-sm font-medium text-gray-700 mb-1">Min Stock Level</label>
                                <input type="number" name="min_stock_level" id="min_stock_level" value="{{ old('min_stock_level', 5) }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="max_stock_level" class="block text-sm font-medium text-gray-700 mb-1">Max Stock Level</label>
                                <input type="number" name="max_stock_level" id="max_stock_level" value="{{ old('max_stock_level', 50) }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="reorder_point" class="block text-sm font-medium text-gray-700 mb-1">Reorder Point</label>
                                <input type="number" name="reorder_point" id="reorder_point" value="{{ old('reorder_point', 10) }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <p class="mt-1 text-xs text-gray-500">Threshold to trigger low stock alert.</p>
                            </div>
                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-1">Unit Price ($)</label>
                                <input type="number" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="0.00" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Add Part to Inventory
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
