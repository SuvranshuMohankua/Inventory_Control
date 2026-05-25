@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome to InvControl, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-500 max-w-2xl">Welcome to your central hub for real-time inventory levels, critical stock thresholds, and operational records.</p>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-blue-50 to-transparent opacity-50 flex items-center justify-center">
            <svg class="w-32 h-32 text-blue-100" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"></path></svg>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Categories Stat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Categories</p>
                    <p class="text-2xl font-black text-gray-900">{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Machines Stat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-indigo-100 text-indigo-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Machines</p>
                    <p class="text-2xl font-black text-gray-900">{{ \App\Models\Machine::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Spare Parts Stat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Items</p>
                    <p class="text-2xl font-black text-gray-900">{{ \App\Models\SparePart::sum('stock_quantity') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Value Stat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Value</p>
                    @php
                        $totalValue = \App\Models\SparePart::selectRaw('SUM(stock_quantity * unit_price) as total')->value('total');
                    @endphp
                    <p class="text-2xl font-black text-gray-900">₹{{ number_format($totalValue ?? 0, 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Items / Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h4 class="font-bold text-gray-700">Quick Actions</h4>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                        <a href="{{ route('categories.create') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-blue-50 transition-colors group">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 group-hover:text-white">Add New Category</p>
                                <p class="text-xs text-gray-500">Group your spare parts logically.</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('machines.create') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-indigo-50 transition-colors group">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 group-hover:text-white">Register New Machine</p>
                                <p class="text-xs text-gray-500">Track which parts belong to which machine.</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('spare-parts.create') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-green-50 transition-colors group">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Add Spare Part</p>
                                <p class="text-xs text-gray-500">Increase your inventory stock.</p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('transactions.create', ['type' => 'out']) }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-red-50 transition-colors group">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Issue Spare Part (Stock Out)</p>
                                <p class="text-xs text-gray-500">Record a part withdrawal for maintenance.</p>
                            </div>
                        </a>

                        <a href="{{ route('transactions.create', ['type' => 'in']) }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-green-50 transition-colors group">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Replenish Stock (Stock In)</p>
                                <p class="text-xs text-gray-500">Record stock addition or new orders.</p>
                            </div>
                        </a>

                        <a href="{{ route('spare-parts.index') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-blue-50 transition-colors group">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Browse Parts Inventory</p>
                                <p class="text-xs text-gray-500">Search and filter your machinery spares.</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stock Alert Section -->
        <div class="bg-gray rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h4 class="font-bold text-black-700">Stock Alerts</h4>
                @php
                    $lowStockParts = \App\Models\SparePart::whereColumn('stock_quantity', '<=', 'reorder_point')->get();
                @endphp
                <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">{{ $lowStockParts->count() }} Items Low</span>
            </div>
            <div class="p-6">
                @if($lowStockParts->count() > 0)
                    <div class="space-y-4 max-h-64 overflow-y-auto">
                        @foreach($lowStockParts as $part)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-3 animate-pulse"></div>
                                    <div>
                                        <p class="text-sm font-bold text-black-800">{{ $part->name }}</p>
                                        <p class="text-xs text-red-600">Stock: {{ $part->stock_quantity }} / Reorder: {{ $part->reorder_point }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('transactions.create', ['spare_part_id' => $part->id, 'type' => 'in']) }}" class="text-xs font-bold bg-white border border-red-200 text-red-600 px-3 py-1 rounded hover:bg-red-600 hover:text-white transition-colors">
                                    Restock
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-48 text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-gray-500 italic">All stock levels are healthy.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
