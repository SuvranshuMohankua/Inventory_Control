<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InvControl - Smart Spares Automation</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #020617; 
            background-image: linear-gradient(rgba(2, 6, 23, 0.35), rgba(2, 6, 23, 0.65)), url('{{ asset('images/landing-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #cbd5e1;
            overflow-x: hidden;
        }
        .mono-code {
            font-family: 'JetBrains Mono', monospace;
        }
        .glass-nav {
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Laser Grid overlay */
        .laser-grid {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Animations */
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.15; transform: scale(1) translate(0px, 0px); }
            33% { opacity: 0.25; transform: scale(1.1) translate(40px, -60px); }
            66% { opacity: 0.1; transform: scale(0.9) translate(-40px, 60px); }
        }
        @keyframes float-hero-card-1 {
            0%, 100% { transform: translateY(0px) rotate(2deg); }
            50% { transform: translateY(-15px) rotate(-1deg); }
        }
        @keyframes float-hero-card-2 {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }
        @keyframes float-hero-card-3 {
            0%, 100% { transform: translateY(0px) rotate(1deg); }
            50% { transform: translateY(-12px) rotate(-2deg); }
        }

        /* Ambient Glowing Nodes */
        .glow-node-1 { animation: pulse-slow 22s infinite ease-in-out; }
        .glow-node-2 { animation: pulse-slow 28s infinite ease-in-out reverse; }
        .glow-node-3 { animation: pulse-slow 20s infinite ease-in-out 3s; }

        /* Floating Hero Cards */
        .float-card-1 { animation: float-hero-card-1 6s infinite ease-in-out; }
        .float-card-2 { animation: float-hero-card-2 7.5s infinite ease-in-out 0.8s; }
        .float-card-3 { animation: float-hero-card-3 5.5s infinite ease-in-out 1.5s; }

        /* General Frosted Cards */
        .cyber-card {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cyber-card:hover {
            transform: translateY(-8px);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.1);
            background: rgba(15, 23, 42, 0.55);
        }

        /* Glowing text gradient */
        .text-glow-gradient {
            background: linear-gradient(135deg, #60a5fa 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Cyber Buttons */
        .btn-glow-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-glow-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.5);
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .btn-glow-secondary {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-glow-secondary:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body class="selection:bg-blue-900/50 selection:text-blue-200">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <span class="text-xl font-black tracking-tight text-white block leading-none">InvControl</span>
                    <span class="text-[9px] text-blue-400 font-bold tracking-widest uppercase mono-code">terminal // core</span>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-8 text-xs font-black uppercase tracking-widest text-slate-400">
                <a href="#features" class="hover:text-blue-400 transition-colors">Features</a>
                <a href="#how-it-works" class="hover:text-blue-400 transition-colors">How it Works</a>
                <a href="#benefits" class="hover:text-blue-400 transition-colors">Benefits</a>
            </div>

            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 btn-glow-primary text-white rounded-full font-bold text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 btn-glow-primary text-white rounded-full font-bold text-sm">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-40 pb-32 overflow-hidden laser-grid min-h-screen flex items-center">
        <!-- Glowing mesh gradients -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-blue-600/10 blur-[120px] glow-node-1 pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-purple-600/10 blur-[130px] glow-node-2 pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10 w-full">
            <!-- Left Info Panel -->
            <div class="lg:col-span-7 text-center lg:text-left">
                <span class="inline-block px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-xs font-black tracking-widest text-blue-400 uppercase mono-code mb-6">
                    SYSTEM ACTIVATED // SPARES AUTOMATION
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                    Smart Inventory Control <br> 
                    <span class="text-glow-gradient">for Modern Workshops</span>
                </h1>
                <p class="max-w-xl mx-auto lg:mx-0 text-lg text-slate-400 mb-10 leading-relaxed">
                    Effortlessly track machine-specific spares, monitor stock levels in real-time with digital diagnostics, and automate alerts to avoid critical downtime.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 btn-glow-primary text-white rounded-full font-bold text-lg text-center">Start Managing Spares</a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-4 btn-glow-secondary text-slate-300 rounded-full font-bold text-lg text-center">Access Terminal</a>
                </div>
            </div>

            <!-- Right Graphic: Interactive Floating Telemetry Cards -->
            <div class="lg:col-span-5 relative h-[380px] lg:h-[450px] flex items-center justify-center">
                <!-- Floating Card 1 -->
                <div class="float-card-1 absolute top-4 left-6 sm:left-12 w-64 p-4 rounded-2xl bg-slate-900/60 border border-white/5 backdrop-blur-md shadow-2xl flex items-center space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-[9px] font-black uppercase text-slate-500 block leading-none mb-1 mono-code">PART // SYNC</span>
                        <p class="text-sm font-extrabold text-white truncate">Ball Bearings 6204</p>
                        <p class="text-[10px] text-green-400 font-bold flex items-center mt-0.5"><span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1 animate-pulse"></span> STOCK OK // 45 units</p>
                    </div>
                </div>

                <!-- Floating Card 2 -->
                <div class="float-card-2 absolute bottom-8 right-4 sm:right-10 w-64 p-4 rounded-2xl bg-slate-900/60 border border-white/5 backdrop-blur-md shadow-2xl flex items-center space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-[9px] font-black uppercase text-slate-500 block leading-none mb-1 mono-code">ALERT // TRIGGER</span>
                        <p class="text-sm font-extrabold text-white truncate">CNC Router Milling #3</p>
                        <p class="text-[10px] text-red-400 font-bold flex items-center mt-0.5"><span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1 animate-pulse"></span> LOW STOCK // 2 units</p>
                    </div>
                </div>

                <!-- Floating Card 3 -->
                <div class="float-card-3 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 p-4 rounded-2xl bg-slate-900/80 border border-blue-500/20 backdrop-blur-md shadow-2xl flex items-center space-x-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center text-cyan-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-[9px] font-black uppercase text-slate-500 block leading-none mb-1 mono-code">SYSTEM // STATUS</span>
                        <p class="text-sm font-extrabold text-slate-300 truncate">Inventory Accuracy</p>
                        <p class="text-lg font-black text-white mt-0.5">99.8% ACC</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-28 relative">
        <div class="absolute top-[20%] right-[-10%] w-[400px] h-[400px] rounded-full bg-cyan-500/5 blur-[100px] glow-node-3 pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <span class="text-xs font-black uppercase tracking-[0.3em] text-blue-500 mb-4 block mono-code">InvControl MODULES</span>
                <h3 class="text-4xl font-extrabold text-white">Full-Spectrum Inventory Diagnostics</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 cyber-card rounded-3xl">
                    <div class="w-14 h-14 bg-blue-500/10 text-blue-400 rounded-2xl flex items-center justify-center mb-6 border border-blue-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-100 mb-3">Real-Time Tracking</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Instantly view current stock counts for every spare part across your entire workshop warehouse.</p>
                </div>
                <!-- Feature 2 -->
                <div class="p-8 cyber-card rounded-3xl">
                    <div class="w-14 h-14 bg-purple-500/10 text-purple-400 rounded-2xl flex items-center justify-center mb-6 border border-purple-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-100 mb-3">Low Stock Alerts</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Automated telemetry alerts trigger when parts hit critical levels, ensuring you never run out of vital machinery parts.</p>
                </div>
                <!-- Feature 3 -->
                <div class="p-8 cyber-card rounded-3xl">
                    <div class="w-14 h-14 bg-cyan-500/10 text-cyan-400 rounded-2xl flex items-center justify-center mb-6 border border-cyan-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-100 mb-3">Machine Mapping</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Assign parts specifically to registered machinery, making it easy to see which exact spares fit what machine.</p>
                </div>
                <!-- Feature 4 -->
                <div class="p-8 cyber-card rounded-3xl">
                    <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center mb-6 border border-emerald-500/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-100 mb-3">Cryptographic Logs</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Keep a detailed ledger of every stock issue and return, fully logged with user identity metrics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-28 bg-slate-900/20 border-t border-b border-white/5 relative laser-grid">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-24">
                <span class="text-xs font-black uppercase tracking-[0.3em] text-blue-500 mb-4 block mono-code">LOGISTICS ARCHITECTURE</span>
                <h3 class="text-4xl font-extrabold text-white">Three Steps to Systems Integration</h3>
            </div>
            
            <div class="relative flex flex-col md:flex-row justify-between items-start space-y-16 md:space-y-0 md:space-x-12">
                <!-- Step 1 -->
                <div class="flex-1 text-center relative w-full">
                    <div class="w-16 h-16 bg-slate-900 border border-blue-500/30 shadow-xl rounded-2xl flex items-center justify-center text-2xl font-black text-blue-400 mx-auto mb-8 relative z-10">1</div>
                    <h4 class="text-xl font-bold text-slate-200 mb-4">Register Workshop Machinery</h4>
                    <p class="text-slate-400 text-sm px-4">Catalog equipment templates and create unique diagnostic identifiers for each physical machine.</p>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-[1px] bg-gradient-to-r from-blue-500/30 to-purple-500/15 -z-0"></div>
                </div>
                <!-- Step 2 -->
                <div class="flex-1 text-center relative w-full">
                    <div class="w-16 h-16 bg-slate-900 border border-purple-500/30 shadow-xl rounded-2xl flex items-center justify-center text-2xl font-black text-purple-400 mx-auto mb-8 relative z-10">2</div>
                    <h4 class="text-xl font-bold text-slate-200 mb-4">Add Spares catalog</h4>
                    <p class="text-slate-400 text-sm px-4">Map your digital spare parts list directly to categories and their respective machine templates.</p>
                    <div class="hidden md:block absolute top-8 left-1/2 w-full h-[1px] bg-gradient-to-r from-purple-500/30 to-transparent -z-0"></div>
                </div>
                <!-- Step 3 -->
                <div class="flex-1 text-center relative w-full">
                    <div class="w-16 h-16 bg-slate-900 border border-emerald-500/30 shadow-xl rounded-2xl flex items-center justify-center text-2xl font-black text-emerald-400 mx-auto mb-8 relative z-10">3</div>
                    <h4 class="text-xl font-bold text-slate-200 mb-4">Issue Stock Movements</h4>
                    <p class="text-slate-400 text-sm px-4">Record issuance and stock-in transactions. Let the core automation system process reorders.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-28">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-slate-900/50 border border-white/5 backdrop-blur-2xl rounded-[3rem] p-12 md:p-20 flex flex-col md:flex-row items-center justify-between shadow-2xl overflow-hidden relative">
                
                <div class="md:w-1/2 mb-10 md:mb-0 relative z-10 text-center md:text-left">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">Why Optimize with InvControl?</h2>
                    <ul class="space-y-6">
                        <li class="flex items-center text-slate-300">
                            <div class="w-6 h-6 bg-blue-500/10 border border-blue-500/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0 text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-lg font-medium"><span class="text-white font-bold mr-2">Eradicate Workshop Downtime:</span> Always keep critical spares ready for operations.</span>
                        </li>
                        <li class="flex items-center text-slate-300">
                            <div class="w-6 h-6 bg-purple-500/10 border border-purple-500/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0 text-purple-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-lg font-medium"><span class="text-white font-bold mr-2">Halt Over-Ordering:</span> Maintain inventory metrics and cut redundant parts overhead.</span>
                        </li>
                        <li class="flex items-center text-slate-300">
                            <div class="w-6 h-6 bg-emerald-500/10 border border-emerald-500/30 rounded-full flex items-center justify-center mr-4 flex-shrink-0 text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-lg font-medium"><span class="text-white font-bold mr-2">Full Diagnostic Visibility:</span> Comprehensive ledger maps operator stock issuances.</span>
                        </li>
                    </ul>
                </div>

                <div class="md:w-1/3 relative z-10">
                    <div class="p-8 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl shadow-2xl transform rotate-3 border border-blue-400/20">
                        <p class="text-3xl font-black text-white mb-2 italic">"99.8%"</p>
                        <p class="text-blue-100 text-sm font-semibold tracking-wide">Stock audit precision level logged across active operators.</p>
                    </div>
                </div>
                
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] opacity-30"></div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-28 bg-gradient-to-br from-blue-900/30 to-indigo-900/30 border-t border-white/5 relative overflow-hidden text-center">
        <div class="absolute inset-0 laser-grid opacity-10"></div>
        <div class="max-w-4xl mx-auto px-6 relative z-10">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-8 tracking-tight">Deploy Spares Optimization Today</h2>
            <p class="text-slate-400 text-lg mb-10 max-w-xl mx-auto">Join advanced manufacturing operators who trust InvControl to automate spare parts diagnostics.</p>
            <a href="{{ route('register') }}" class="px-12 py-5 btn-glow-primary text-white rounded-full font-black text-xl">
                Onboard Free Terminal
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-slate-950 border-t border-white/5 relative z-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-8 md:mb-0 text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start space-x-3 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-lg font-black text-white">InvControl</span>
                </div>
                <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mono-code">&copy; {{ date('Y') }} InvControl System. All rights reserved.</p>
            </div>
            
            <div class="text-center md:text-right">
                <p class="text-slate-400 text-sm font-black uppercase tracking-widest mb-2 mono-code">VER. 1.2.0 // DEPLOYED</p>
                <p class="text-slate-500 text-xs font-semibold">Developed for Optimum Inventory Control of Machine Spares.</p>
            </div>
        </div>
    </footer>
</body>
</html>
