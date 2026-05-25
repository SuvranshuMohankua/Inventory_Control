@extends('layouts.app')

@section('header', 'Spare Parts')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Inventory Items</h3>
            <p class="text-xs text-gray-500">Manage and track your machine spares.</p>
        </div>
        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
        <div class="flex space-x-2">
            <a href="{{ route('spare-parts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150 shadow-sm shadow-blue-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Part
            </a>
        </div>
        @endif
    </div>

    <!-- Advanced Search & Filter -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 mb-8 shadow-sm">
        <form action="{{ route('spare-parts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-1">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Search</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Part name or #..." class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-10">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
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
                <button type="submit" class="bg-blue-600 text-white px-4 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                    Apply
                </button>
                <a href="{{ route('spare-parts.export-pdf', request()->all()) }}" class="px-4 py-2.5 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition-all shadow-sm">
                    Export PDF
                </a>
                <a href="{{ route('spare-parts.export-csv', request()->all()) }}" class="px-4 py-2.5 bg-green-50 text-green-600 rounded-lg text-sm font-bold hover:bg-green-600 hover:text-white transition-all shadow-sm">
                    Export CSV
                </a>
                <a href="{{ route('spare-parts.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-200 transition-all">
                    Reset
                </a>

            </div>
        </form>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Info</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Machine</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold {{ $part->stock_quantity <= $part->reorder_point ? 'text-red-600' : 'text-green-600' }}">
                                {{ $part->stock_quantity }} in stock
                            </span>
                            <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1">
                                @php
                                    $percentage = min(100, ($part->stock_quantity / max(1, $part->max_stock_level)) * 100);
                                @endphp
                                <div class="{{ $part->stock_quantity <= $part->reorder_point ? 'bg-red-500' : 'bg-green-500' }} h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        ₹{{ number_format($part->unit_price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('spare-parts.show', $part) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-md transition-colors" title="View details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                            <a href="{{ route('spare-parts.edit', $part) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-md transition-colors" title="Edit part">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('spare-parts.destroy', $part) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this spare part?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-md transition-colors" title="Delete part">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        No spare parts found in inventory.
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
