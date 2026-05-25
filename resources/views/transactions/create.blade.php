@extends('layouts.app')

@section('header', $type === 'in' ? 'Record Stock In' : 'Issue Spare Part')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Transactions
        </a>
    </div>

    @if($errors->has('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="p-8">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="transaction_type" value="{{ $type }}">
                
                <div class="space-y-6">
                    <div>
                        <label for="spare_part_id" class="block text-sm font-medium text-gray-700 mb-1">Select Spare Part</label>
                        <select name="spare_part_id" id="spare_part_id" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('spare_part_id') border-red-500 @enderror" required>
                            <option value="">-- Choose a part --</option>
                            @foreach($spareParts as $part)
                                <option value="{{ $part->id }}" {{ ($selectedPartId == $part->id || old('spare_part_id') == $part->id) ? 'selected' : '' }}>
                                    {{ $part->name }} (PN: {{ $part->part_number }}) - Current Stock: {{ $part->stock_quantity }}
                                </option>
                            @endforeach
                        </select>
                        @error('spare_part_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity to {{ $type === 'in' ? 'Add' : 'Issue' }}</label>
                        <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks / Reason</label>
                        <textarea name="remarks" id="remarks" rows="3" class="block w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ $type === 'in' ? 'e.g. Monthly restock' : 'e.g. Maintenance on CNC Lathe 01' }}">{{ old('remarks') }}</textarea>
                        @error('remarks') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white {{ $type === 'in' ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-red-600 hover:bg-red-700 focus:ring-red-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors uppercase tracking-widest">
                            Confirm {{ $type === 'in' ? 'Stock Entry' : 'Issue Part' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
