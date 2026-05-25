@extends('layouts.app')

@section('header', 'Reports & Analytics')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- General Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Unique Spares</p>
                <h4 class="text-2xl font-bold text-gray-900">{{ $totalParts }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Stock Quantity</p>
                <h4 class="text-2xl font-bold text-gray-900">{{ $totalStock }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
            <div class="p-3 bg-green-50 text-green-600 rounded-lg mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Valuation</p>
                <h4 class="text-2xl font-bold text-gray-900">₹{{ number_format($totalValue, 2) }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
            <div class="p-3 bg-red-50 text-red-600 rounded-lg mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Low Stock Spares</p>
                <h4 class="text-2xl font-bold text-gray-900">{{ $lowStockCount }}</h4>
            </div>
        </div>
    </div>

    <!-- Quick Reports Links Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-8 mb-8 text-white shadow-lg">
        <h3 class="text-xl font-bold mb-2">Available Reports</h3>
        <p class="text-blue-100 text-sm mb-6 max-w-2xl">Access prepared data exports, valuation logs, and low stock reports. Download direct PDF reports ready for print and presentation.</p>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('reports.low-stock') }}" class="px-5 py-3 bg-white text-blue-700 font-bold rounded-lg text-sm hover:bg-blue-50 transition-colors shadow-md">
                View Low Stock Report
            </a>
            <a href="{{ route('reports.valuation') }}" class="px-5 py-3 bg-indigo-500 text-white border border-indigo-400 font-bold rounded-lg text-sm hover:bg-indigo-600 transition-colors shadow-md">
                View Valuation Report
            </a>
            <a href="{{ route('reports.valuation.export') }}" class="px-5 py-3 bg-green-500 text-white font-bold rounded-lg text-sm hover:bg-green-600 transition-colors shadow-md flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Full Valuation PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Machine-wise Valuation -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Valuation by Machine</h3>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Top Machine Allocation</span>
            </div>
            <div class="space-y-4">
                @forelse($machines as $machine)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700">{{ $machine->name }} ({{ $machine->code }})</span>
                        <span class="text-gray-900 font-semibold">₹{{ number_format($machine->total_value, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        @php
                            $machinePercent = $totalValue > 0 ? ($machine->total_value / $totalValue) * 100 : 0;
                        @endphp
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $machinePercent }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $machine->total_parts }} different spare parts</span>
                </div>
                @empty
                <p class="text-sm text-gray-500 italic">No machine statistics available.</p>
                @endforelse
            </div>
        </div>

        <!-- Category-wise Valuation -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Valuation by Category</h3>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Top Spares Category</span>
            </div>
            <div class="space-y-4">
                @forelse($categories as $category)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-gray-700">{{ $category->name }}</span>
                        <span class="text-gray-900 font-semibold">₹{{ number_format($category->total_value, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        @php
                            $categoryPercent = $totalValue > 0 ? ($category->total_value / $totalValue) * 100 : 0;
                        @endphp
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $categoryPercent }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $category->total_parts }} different spare parts</span>
                </div>
                @empty
                <p class="text-sm text-gray-500 italic">No category statistics available.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Critical Low Stock Panel -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Critical Stock Warning List</h3>
                <p class="text-xs text-gray-500">The following parts are critically below or at reorder point.</p>
            </div>
            <a href="{{ route('reports.low-stock') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold flex items-center transition-colors">
                View all low stock
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="text-left text-xs font-bold uppercase text-gray-400 tracking-wider">
                        <th class="pb-3">Part Details</th>
                        <th class="pb-3">Machine</th>
                        <th class="pb-3 text-center">Stock Level</th>
                        <th class="pb-3 text-center">Reorder Point</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($lowStockParts as $part)
                    <tr>
                        <td class="py-3">
                            <div class="font-bold text-gray-900">{{ $part->name }}</div>
                            <div class="text-xs text-gray-500">PN: {{ $part->part_number }}</div>
                        </td>
                        <td class="py-3 text-gray-600">{{ $part->machine->name ?? 'N/A' }}</td>
                        <td class="py-3 text-center">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                {{ $part->stock_quantity }} in stock
                            </span>
                        </td>
                        <td class="py-3 text-center font-semibold text-gray-700">{{ $part->reorder_point }}</td>
                        <td class="py-3 text-right">
                            <a href="{{ route('transactions.create', ['type' => 'in', 'spare_part_id' => $part->id]) }}" class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded text-xs font-bold hover:bg-blue-600 hover:text-white transition-all">
                                Restock
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400 italic">
                            All spare parts are well-stocked! Excellent!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
