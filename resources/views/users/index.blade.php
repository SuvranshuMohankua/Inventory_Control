@extends('layouts.app')

@section('header', 'User Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Application Users</h3>
            <p class="text-xs text-gray-500">Configure roles and operational permissions for your team.</p>
        </div>
    </div>

    @if($errors->has('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ $errors->first('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Details</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Address</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Current Role</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Change Role Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">Registered: {{ $user->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold leading-5 
                            @if($user->isAdmin()) bg-indigo-100 text-indigo-800
                            @elseif($user->isManager()) bg-amber-100 text-amber-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.update-role', $user->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="text-xs rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-1 pl-2 pr-8">
                                    <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-blue-700 font-bold transition-all shadow-sm">
                                    Update
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 italic">Self (Active Session)</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
