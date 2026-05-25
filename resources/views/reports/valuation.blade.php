@extends('layouts.app')

@section('header', 'Stock Valuation Report')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Financial Stock Valuation</h3>
            <p class="text-xs text-gray-500">Comprehensive breakdown of inventory capital allocations.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('reports.valuation.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150 shadow-sm shadow-green-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Valuation PDF
            </a>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition ease-in-out duration-150">
                Back to Reports
            </a>
        </div>
    </div>

    <!-- Stats Summary Card -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Assets Count</span>
            <h4 class="text-3xl font-black text-gray-900 mt-1">{{ $spareParts->count() }} Spares</h4>
        </div>
        <div class="border-l border-gray-200 pl-6">
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Accumulated Stock</span>
            <h4 class="text-3xl font-black text-gray-900 mt-1">{{ $spareParts->sum('stock_quantity') }} Units</h4>
        </div>
        <div class="border-l border-gray-200 pl-6">
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Asset Valuation</span>
            <h4 class="text-3xl font-black text-green-600 mt-1">₹{{ number_format($spareParts->sum('total_value'), 2) }}</h4>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Info</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Machine</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">In-Stock Quantity</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Capital Value</th>
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
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                        ₹{{ number_format($part->unit_price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                        {{ $part->stock_quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                        ₹{{ number_format($part->total_value, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        No spare parts found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
