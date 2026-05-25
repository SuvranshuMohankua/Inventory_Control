@extends('layouts.app')

@section('header', 'Inventory Transactions')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Recent Stock Movements</h3>
            <p class="text-xs text-gray-500">Track and audit all inventory changes.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('transactions.export') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export CSV
            </a>
            <a href="{{ route('transactions.create', ['type' => 'in']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150 shadow-sm">

                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Stock In
            </a>
            <a href="{{ route('transactions.create', ['type' => 'out']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                Stock Out
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg border border-gray-200 mb-6 shadow-sm">
        <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter by Type</label>
                <select name="type" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-50 text-blue-600 px-4 py-2 rounded-md text-sm font-bold hover:bg-blue-600 hover:text-white transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>


    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Part Info</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $transaction->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $transaction->sparePart->name }}</div>
                        <div class="text-xs text-gray-500">PN: {{ $transaction->sparePart->part_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(strtolower($transaction->transaction_type) === 'in')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Stock In
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Stock Out
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                        {{ $transaction->quantity }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500 italic truncate max-w-xs">{{ $transaction->remarks ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $transaction->user->name ?? 'System Admin' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                        No transactions recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
