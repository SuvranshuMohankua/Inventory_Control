<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>InvControl - Optimum Inventory</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #020617 !important; /* Slate 950 */
            color: #cbd5e1 !important; /* Slate 300 */
        }
        .mono-code {
            font-family: 'JetBrains Mono', monospace;
        }
        
        /* Premium custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #020617;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 99px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }

        /* Sidebar Styling overrides */
        aside {
            background-color: #020617 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        aside .border-b, aside .border-t {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }
        aside a {
            color: #94a3b8 !important; /* Slate 400 */
            font-weight: 600;
            border-radius: 12px;
            margin: 4px 16px;
            transition: all 0.3s ease;
        }
        aside a:hover {
            color: #3b82f6 !important; /* Blue 500 */
            background-color: rgba(255, 255, 255, 0.03) !important;
        }
        .sidebar-link-active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.15) 0%, rgba(37, 99, 235, 0.02) 100%) !important;
            color: #60a5fa !important;
            border-right: 4px solid #3b82f6 !important;
            border-radius: 12px 0 0 12px !important;
        }

        /* Transform standard Breeze cards into futuristic neon cards */
        .bg-white {
            background-color: rgba(15, 23, 42, 0.45) !important; /* Slate 900 */
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35) !important;
            border-radius: 20px !important;
        }
        .border-gray-200 {
            border-color: rgba(255, 255, 255, 0.06) !important;
        }
        .border-gray-100 {
            border-color: rgba(255, 255, 255, 0.04) !important;
        }
        .bg-gray-50 {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* Headers and titles */
        header.bg-white {
            background-color: rgba(2, 6, 23, 0.7) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        header h2 {
            color: #f8fafc !important; /* Slate 50 */
            font-weight: 800 !important;
            letter-spacing: -0.02em;
        }

        /* Data Tables styling overrides */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        th {
            background-color: rgba(15, 23, 42, 0.8) !important;
            color: #94a3b8 !important; /* Slate 400 */
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        td {
            color: #e2e8f0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
        }
        tr:hover, tr:hover td {
            background-color: #0f172a !important; /* Dark theme row highlight */
        }

        /* Input fields and selects inside the dashboard */
        input, select, textarea {
            background-color: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #f1f5f9; /* Removed !important to allow browser native text color inversion on dropdown hover */
            border-radius: 12px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3) !important;
            background-color: rgba(255, 255, 255, 0.06) !important;
        }
        
        /* Select option details without important to let browser invert colors on hover */
        select option {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        /* Text colors */
        .text-gray-900, .text-gray-800, .text-gray-700 {
            color: #f8fafc !important;
        }
        .text-gray-600, .text-gray-500, .text-gray-400 {
            color: #94a3b8 !important;
        }
        
        /* Status indicator tags */
        .bg-green-100 {
            background-color: rgba(34, 197, 94, 0.15) !important;
            color: #4ade80 !important;
            border: 1px solid rgba(34, 197, 94, 0.25) !important;
        }
        .bg-red-100 {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #f87171 !important;
            border: 1px solid rgba(239, 68, 68, 0.25) !important;
        }
        .bg-yellow-100 {
            background-color: rgba(234, 179, 8, 0.15) !important;
            color: #facc15 !important;
            border: 1px solid rgba(234, 179, 8, 0.25) !important;
        }
        .bg-indigo-100 {
            background-color: rgba(99, 102, 241, 0.15) !important;
            color: #818cf8 !important;
            border: 1px solid rgba(99, 102, 241, 0.25) !important;
        }
        .bg-amber-100 {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.25) !important;
        }
        
        /* Primary buttons */
        .bg-blue-600, .bg-indigo-600, a.bg-blue-600 {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25) !important;
            transition: all 0.3s ease !important;
        }
        .bg-blue-600:hover, .bg-indigo-600:hover, a.bg-blue-600:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4) !important;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        }

        /* Danger buttons */
        .bg-red-600, .bg-red-700 {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.25) !important;
        }
        .bg-red-600:hover, .bg-red-700:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4) !important;
        }

        /* Neutral buttons */
        .bg-gray-100, .bg-gray-200 {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
            border-radius: 12px !important;
        }
        .bg-gray-100:hover, .bg-gray-200:hover {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #f1f5f9 !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-xl font-black tracking-tight text-gray-800">InvControl</span>
                </div>
            </div>

            <nav class="flex-1 py-6 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('/') || Request::is('dashboard') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('categories.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('categories*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Categories
                </a>

                <a href="{{ route('machines.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('machines*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                    Machines
                </a>

                <a href="{{ route('spare-parts.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('spare-parts*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Spare Parts
                </a>

                <a href="{{ route('transactions.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('transactions*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Transactions
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('reports*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Reports
                </a>

                @if(Auth::user()->isAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors {{ Request::is('users*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Users
                </a>
                @endif
            </nav>
            
            <div class="p-4 border-t border-gray-200">
                @auth
                    <div class="flex items-center p-3 rounded-lg bg-gray-50 border border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold mr-3 shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ date('l, d M Y') }}</span>
                    </div>
                </div>
            </header>

            <main class="p-8">
                @if(session('success'))
                    <div class="max-w-7xl mx-auto mb-6">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
