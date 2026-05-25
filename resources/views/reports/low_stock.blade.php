@extends('layouts.app')

@section('header', 'Low Stock Report')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Low Stock Inventory</h3>
            <p class="text-xs text-gray-500">List of machine spares that require immediate replenishment.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('reports.low-stock.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150 shadow-sm shadow-red-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Low Stock PDF
            </a>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition ease-in-out duration-150">
                Back to Reports
            </a>
        </div>
    </div>

    <!-- Filtering Bar -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 mb-8 shadow-sm">
        <form action="{{ route('reports.low-stock') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Machine</label>
                <select name="machine_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Machines</option>
                    @foreach(\App\Models\Machine::all() as $machine)
                        <option value="{{ $machine->id }}" {{ request('machine_id') == $machine->id ? 'selected' : '' }}>{{ $machine->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Category</label>
                <select name="category_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 transition-all shadow-md">
                    Apply Filters
                </button>
                <a href="{{ route('reports.low-stock') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-200 transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Info</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Machine</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Levels</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($spareParts as $part)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">{{ $part->name }}</div>
                        <div class="text-xs text-gray-500">PN: {{ $part->part_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $part->category->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $part->machine->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col items-center">
                            <span class="text-sm font-bold text-red-600">
                                {{ $part->stock_quantity }} / {{ $part->reorder_point }} (Reorder)
                            </span>
                            <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1">
                                @php
                                    $percentage = min(100, ($part->stock_quantity / max(1, $part->max_stock_level)) * 100);
                                @endphp
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-[10px] text-gray-400 mt-1">Min: {{ $part->min_stock_level }} | Max: {{ $part->max_stock_level }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        ₹{{ number_format($part->unit_price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('transactions.create', ['type' => 'in', 'spare_part_id' => $part->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                            Restock
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        No low stock spare parts found!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $spareParts->links() }}
    </div>
</div>
@endsection
