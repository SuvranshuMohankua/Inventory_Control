@extends('layouts.app')

@section('header', 'Spare Part Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('spare-parts.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Inventory
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('transactions.create', ['spare_part_id' => $sparePart->id, 'type' => 'in']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md text-xs font-bold uppercase tracking-widest hover:bg-green-700 transition-colors">
                Stock In
            </a>
            <a href="{{ route('transactions.create', ['spare_part_id' => $sparePart->id, 'type' => 'out']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md text-xs font-bold uppercase tracking-widest hover:bg-red-700 transition-colors">
                Stock Out
            </a>
            <a href="{{ route('spare-parts.edit', $sparePart) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-xs font-bold uppercase tracking-widest hover:bg-gray-300 transition-colors">
                Edit Details
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Part Information Card -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h4 class="font-bold text-gray-700">Part Specifications</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Part Name</p>
                        <p class="text-lg font-bold text-gray-900">{{ $sparePart->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Part Number</p>
                        <p class="text-sm font-mono bg-gray-100 px-2 py-1 rounded inline-block">{{ $sparePart->part_number }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 border-t pt-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Category</p>
                            <p class="text-sm text-gray-900">{{ $sparePart->category->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Machine</p>
                            <p class="text-sm text-gray-900">{{ $sparePart->machine->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Unit Price</p>
                        <p class="text-xl font-bold text-blue-600">₹{{ number_format($sparePart->unit_price, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Stock Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h4 class="font-bold text-gray-700">Inventory Status</h4>
                </div>
                <div class="p-6">
                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-500">Current Stock</p>
                        <p class="text-5xl font-black {{ $sparePart->stock_quantity <= $sparePart->reorder_point ? 'text-red-600' : 'text-green-600' }}">
                            {{ $sparePart->stock_quantity }}
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">Min: {{ $sparePart->min_stock_level }}</span>
                            <span class="text-gray-500 font-bold">Reorder at: {{ $sparePart->reorder_point }}</span>
                            <span class="text-gray-500">Max: {{ $sparePart->max_stock_level }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                            @php
                                $percentage = min(100, ($sparePart->stock_quantity / max(1, $sparePart->max_stock_level)) * 100);
                            @endphp
                            <div class="{{ $sparePart->stock_quantity <= $sparePart->reorder_point ? 'bg-red-500' : 'bg-green-500' }} h-3 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                        </div>
                        @if($sparePart->stock_quantity <= $sparePart->reorder_point)
                            <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-lg flex items-center text-red-700 text-xs font-bold animate-pulse">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                CRITICAL: Reorder required immediately!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h4 class="font-bold text-gray-700">Transaction History</h4>
                    <span class="text-xs text-gray-500">{{ $sparePart->transactions->count() }} total records</span>
                </div>
                <div class="overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($sparePart->transactions()->latest()->get() as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ $transaction->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(strtolower($transaction->transaction_type) === 'in')
                                            <span class="text-green-600 font-bold text-xs uppercase">Stock In</span>
                                        @else
                                            <span class="text-red-600 font-bold text-xs uppercase">Stock Out</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-center">
                                        {{ strtolower($transaction->transaction_type) === 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 italic">
                                        {{ $transaction->remarks ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                        No transactions recorded for this part.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
