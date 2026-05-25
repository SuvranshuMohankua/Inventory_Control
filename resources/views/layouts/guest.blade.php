<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>InvControl - Secure Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { 
                font-family: 'Outfit', sans-serif; 
                background-color: #020617; /* Slate 950 */
                overflow-x: hidden;
            }
            .mono-code {
                font-family: 'JetBrains Mono', monospace;
            }
            
            /* Animations */
            @keyframes pulse-slow {
                0%, 100% { opacity: 0.15; transform: scale(1) translate(0px, 0px); }
                33% { opacity: 0.25; transform: scale(1.1) translate(30px, -50px); }
                66% { opacity: 0.1; transform: scale(0.9) translate(-30px, 50px); }
            }
            @keyframes float-telemetry-1 {
                0%, 100% { transform: translateY(0px) rotate(1deg); }
                50% { transform: translateY(-12px) rotate(-0.5deg); }
            }
            @keyframes float-telemetry-2 {
                0%, 100% { transform: translateY(0px) rotate(-1deg); }
                50% { transform: translateY(-8px) rotate(1deg); }
            }
            @keyframes float-telemetry-3 {
                0%, 100% { transform: translateY(0px) rotate(0.5deg); }
                50% { transform: translateY(-15px) rotate(-1deg); }
            }

            /* Ambient Glow Nodes */
            .glow-node-1 {
                animation: pulse-slow 20s infinite ease-in-out;
            }
            .glow-node-2 {
                animation: pulse-slow 24s infinite ease-in-out reverse;
            }
            .glow-node-3 {
                animation: pulse-slow 18s infinite ease-in-out 2s;
            }

            /* Custom form overrides for industrial premium look */
            input, select {
                background-color: rgba(255, 255, 255, 0.04) !important;
                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                color: #f1f5f9; /* Removed !important to allow browser native text color inversion on dropdown hover */
                border-radius: 12px !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            input:focus, select:focus {
                border-color: #3b82f6 !important; /* Blue 500 */
                box-shadow: 0 0 15px rgba(59, 130, 246, 0.3) !important;
                transform: translateY(-2px) !important;
                background-color: rgba(255, 255, 255, 0.07) !important;
            }
            label {
                color: #94a3b8 !important; /* Slate 400 */
                font-weight: 600 !important;
                font-size: 0.825rem !important;
                text-transform: uppercase !important;
                letter-spacing: 0.06em !important;
            }
            button[type="submit"], .btn-submit {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
                border: none !important;
                color: white !important;
                border-radius: 12px !important;
                font-weight: 700 !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                box-shadow: 0 4px 20px rgba(37, 99, 235, 0.25) !important;
            }
            button[type="submit"]:hover, .btn-submit:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 25px rgba(37, 99, 235, 0.45) !important;
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            }
            button[type="submit"]:active, .btn-submit:active {
                transform: translateY(-1px) !important;
            }
            
            /* Text Color overrides for light-mode default classes in dark glassmorphism */
            #auth-layout-container text,
            #auth-layout-container a,
            #auth-layout-container p,
            #auth-layout-container span,
            #auth-layout-container label,
            #auth-layout-container div:not(.bg-blue-600):not(.bg-green-500) {
                color: #cbd5e1; /* slate 300 */
            }
            #auth-layout-container a {
                text-decoration: underline !important;
                font-weight: 600;
            }
            #auth-layout-container a:hover {
                color: #60a5fa !important; /* blue 400 */
            }
            #auth-layout-container h1,
            #auth-layout-container h2 {
                color: #f8fafc !important; /* slate 50 */
            }
            #auth-layout-container .text-red-500,
            #auth-layout-container .text-red-600,
            #auth-layout-container ul li {
                color: #f87171 !important; /* red 400 */
            }
            #auth-layout-container input[type="checkbox"] {
                background-color: transparent !important;
                border: 1px solid rgba(255,255,255,0.2) !important;
                border-radius: 4px !important;
                cursor: pointer;
            }
            #auth-layout-container input[type="checkbox"]:checked {
                background-color: #2563eb !important;
                border-color: #2563eb !important;
            }
            #auth-layout-container select option {
                background-color: #0f172a;
                color: #f1f5f9;
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="auth-layout-container" class="state-default min-h-screen flex flex-col md:flex-row relative z-10 overflow-hidden">
            
            <!-- Shifting Ambient Background Spheres -->
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-blue-600/10 blur-[120px] glow-node-1 pointer-events-none -z-10"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-purple-600/10 blur-[130px] glow-node-2 pointer-events-none -z-10"></div>
            <div class="absolute top-[30%] right-[20%] w-[400px] h-[400px] rounded-full bg-cyan-500/5 blur-[100px] glow-node-3 pointer-events-none -z-10"></div>

            <!-- Left column: Cyber-industrial telemetry HUD (55% width) -->
            <div class="hidden md:flex flex-col justify-between w-[55%] p-12 lg:p-16 border-r border-slate-900 bg-slate-950/40 backdrop-blur-sm relative">
                <!-- Header Branding -->
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tight leading-none">InvControl</h2>
                        <span class="text-[10px] text-blue-500 font-bold tracking-widest uppercase mono-code">terminal // system</span>
                    </div>
                </div>

                <!-- Central Content: interactive Robot Mascot & Telemetry HUD Cards -->
                <div class="my-auto space-y-12 py-10">
                    
                    <!-- Bot Container -->
                    <div class="relative">
                        <!-- Robot SVG -->
                        <svg viewBox="0 0 200 200" width="165" height="165" class="invbot-svg mx-auto transition-all duration-500 drop-shadow-[0_15px_30px_rgba(59,130,246,0.15)]">
                            <!-- Shadow -->
                            <ellipse cx="100" cy="180" rx="42" ry="6" class="bot-shadow fill-slate-900/60" />

                            <!-- Tracks/Base -->
                            <rect x="65" y="160" width="70" height="15" rx="7" class="fill-slate-800 stroke-slate-700 stroke-[3]" />
                            <circle cx="77" cy="167.5" r="4" class="fill-blue-500" />
                            <circle cx="100" cy="167.5" r="4" class="fill-blue-500 animate-pulse" />
                            <circle cx="123" cy="167.5" r="4" class="fill-blue-500" />

                            <!-- Neck -->
                            <rect x="94" y="130" width="12" height="35" rx="3" class="fill-slate-700 stroke-slate-600 stroke-[3] neck-bar transition-all duration-300" />

                            <!-- Arms -->
                            <g class="bot-left-arm transition-all duration-500 origin-[65px_110px]">
                                <circle cx="65" cy="110" r="7" class="fill-slate-700 stroke-slate-600 stroke-[2]" />
                                <path d="M 65 110 L 35 130" class="stroke-slate-600 stroke-[6] stroke-linecap-round" />
                                <path d="M 35 130 Q 25 130 30 140" class="stroke-blue-400 stroke-[3] fill-none" />
                                <path d="M 35 130 Q 35 120 40 140" class="stroke-blue-400 stroke-[3] fill-none" />
                            </g>

                            <g class="bot-right-arm transition-all duration-500 origin-[135px_110px]">
                                <circle cx="135" cy="110" r="7" class="fill-slate-700 stroke-slate-600 stroke-[2]" />
                                <path d="M 135 110 L 165 130" class="stroke-slate-600 stroke-[6] stroke-linecap-round" />
                                <path d="M 165 130 Q 175 130 170 140" class="stroke-blue-400 stroke-[3] fill-none" />
                                <path d="M 165 130 Q 165 120 160 140" class="stroke-blue-400 stroke-[3] fill-none" />
                            </g>

                            <!-- Antenna -->
                            <path d="M 100 65 L 100 35" class="stroke-slate-600 stroke-[4] transition-all duration-500 origin-bottom bot-antenna" />
                            <circle cx="100" cy="28" r="6" class="fill-blue-500 transition-all duration-500 bot-bulb" />

                            <!-- Head -->
                            <rect x="62" y="65" width="76" height="70" rx="20" class="fill-slate-800 stroke-slate-700 stroke-[4] transition-all duration-300 bot-head" />

                            <!-- Screen Face -->
                            <rect x="71" y="75" width="58" height="42" rx="12" class="fill-slate-950 stroke-slate-900 stroke-[2]" />

                            <!-- Glowing Lens/Eye -->
                            <g class="bot-eye-group transition-all duration-300">
                                <circle cx="100" cy="96" r="14" class="fill-blue-950/80 stroke-blue-500 stroke-[2] bot-eye-outer transition-all duration-300" />
                                <circle cx="100" cy="96" r="8" class="fill-blue-400/20 bot-eye-glow transition-all duration-300 animate-pulse" />
                                <circle cx="100" cy="96" r="4" class="fill-blue-400 transition-all duration-300 bot-eye-iris" />
                                <circle cx="97.5" cy="93.5" r="1.5" class="fill-white" />
                            </g>

                            <!-- Query marks (Forgot State) -->
                            <g class="bot-query transition-all duration-300 opacity-0 pointer-events-none">
                                <text x="35" y="55" class="fill-amber-400 font-extrabold text-3xl animate-bounce" style="font-family: 'Outfit';">?</text>
                                <text x="145" y="60" class="fill-amber-400 font-extrabold text-3xl animate-bounce" style="font-family: 'Outfit'; animation-delay: 0.3s">?</text>
                            </g>
                        </svg>
                    </div>

                    <!-- Glowing HUD telemetry cards -->
                    <div class="grid grid-cols-1 gap-4 max-w-lg mx-auto">
                        <!-- Telemetry 1 -->
                        <div class="hud-card p-4 rounded-2xl bg-white/[0.015] border border-white/5 shadow-2xl flex items-center space-x-4 transition-all hover:bg-white/[0.03]" style="animation: float-telemetry-1 7s infinite ease-in-out;">
                            <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-0.5">
                                    <span class="text-xs uppercase tracking-widest text-slate-500 font-black mono-code">SYS // DIAGNOSTICS</span>
                                    <span class="flex h-2 w-2 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                    </span>
                                </div>
                                <p class="text-sm font-bold text-slate-300 truncate">CNC Milling Unit #2: Connection established</p>
                            </div>
                        </div>

                        <!-- Telemetry 2 -->
                        <div class="hud-card p-4 rounded-2xl bg-white/[0.015] border border-white/5 shadow-2xl flex items-center space-x-4 transition-all hover:bg-white/[0.03]" style="animation: float-telemetry-2 6s infinite ease-in-out 1s;">
                            <div class="w-9 h-9 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-0.5">
                                    <span class="text-xs uppercase tracking-widest text-slate-500 font-black mono-code">INVENTORY // ANALYSIS</span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-500/10 text-blue-400 font-bold border border-blue-500/20 mono-code">99.8% ACC</span>
                                </div>
                                <p class="text-sm font-bold text-slate-300 truncate">Spares catalog auto-synced with machine mapping</p>
                            </div>
                        </div>

                        <!-- Telemetry 3 -->
                        <div class="hud-card p-4 rounded-2xl bg-white/[0.015] border border-white/5 shadow-2xl flex items-center space-x-4 transition-all hover:bg-white/[0.03]" style="animation: float-telemetry-3 8s infinite ease-in-out 0.5s;">
                            <div class="w-9 h-9 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-0.5">
                                    <span class="text-xs uppercase tracking-widest text-slate-500 font-black mono-code">SECURITY // GATEWAY</span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-cyan-500/10 text-cyan-400 font-bold border border-cyan-500/20 mono-code">AES 256</span>
                                </div>
                                <p class="text-sm font-bold text-slate-300 truncate">SSL session active. Authentication active.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer details -->
                <div class="flex justify-between items-center border-t border-white/5 pt-6 text-slate-500 text-xs tracking-wider">
                    <span class="mono-code">INVCONTROL v1.2.0</span>
                    <span>OPTIMUM SPARES AUTOMATION</span>
                </div>
            </div>

            <!-- Right column: The Glassmorphic Console Form Panel -->
            <div class="flex-1 flex flex-col justify-center items-center p-8 sm:p-12 relative">
                
                <!-- Tiny Brand Label on Mobile -->
                <div class="md:hidden flex items-center space-x-2.5 mb-8">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight">InvControl</h1>
                </div>

                <div class="w-full sm:max-w-md px-8 py-10 bg-slate-900/40 border border-white/10 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden relative">
                    
                    <!-- Top subtle cyan line -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

                    <!-- Page title header -->
                    <div class="mb-8 text-center sm:text-left">
                        <span class="text-xs font-black tracking-widest text-blue-400 uppercase mono-code mb-1 block">
                            @if(Request::is('login'))
                                ACCOUNT ACCESS
                            @elseif(Request::is('register'))
                                SYSTEM ONBOARDING
                            @elseif(Request::is('forgot-password'))
                                RECOVERY DEPLOYMENT
                            @else
                                ACCESS CREDENTIALS
                            @endif
                        </span>
                        <h2 class="text-3xl font-extrabold text-slate-100 tracking-tight">
                            @if(Request::is('login'))
                                Welcome Back
                            @elseif(Request::is('register'))
                                Get Started
                            @elseif(Request::is('forgot-password'))
                                Forgot Password
                            @else
                                Reset Password
                            @endif
                        </h2>
                        <p class="text-slate-400 text-sm mt-2">
                            @if(Request::is('login'))
                                Please verify your identity to access InvControl.
                            @elseif(Request::is('register'))
                                Register staff or admin roles to catalog spares.
                            @elseif(Request::is('forgot-password'))
                                Provide your registered email for password recovery.
                            @else
                                Set your new system access password.
                            @endif
                        </p>
                    </div>

                    <!-- Slot Content -->
                    <div class="space-y-6">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer label -->
                <p class="mt-8 text-slate-500 text-xs uppercase tracking-widest font-black mono-code">SECURE ACCESS CONSOLE</p>
            </div>
            
        </div>

        <!-- Custom SVG styling rules inside stylesheet -->
        <style>
            /* Mascot Animation Rules */
            .invbot-svg {
                animation: bot-float 4.5s ease-in-out infinite;
            }
            .bot-antenna {
                transform-origin: 100px 65px;
                transition: transform 0.4s ease-in-out;
            }
            .bot-bulb {
                transition: fill 0.3s ease;
            }
            .bot-head {
                transition: transform 0.3s ease-in-out;
            }
            .bot-eye-outer {
                transform-origin: 100px 96px;
                transition: stroke 0.3s, fill 0.3s, transform 0.3s;
            }
            .bot-eye-iris {
                transform-origin: 100px 96px;
                transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94), fill 0.3s;
            }
            
            /* Robot Eye blinking keyframes */
            @keyframes eye-blink {
                0%, 90%, 100% { transform: scaleY(1); }
                95% { transform: scaleY(0.1); }
            }
            .state-default .bot-eye-outer,
            .state-default .bot-eye-iris {
                animation: eye-blink 5s infinite;
            }

            /* Floating Robot Keyframes */
            @keyframes bot-float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-6px); }
            }

            /* Mascot interactive states */
            /* 1. Typing State: eye shifts side-to-side, antenna moves slightly */
            .state-typing .bot-eye-iris {
                transform: translate(-3.5px, 0.5px) scale(0.95);
            }
            .state-typing .bot-antenna {
                transform: rotate(8deg);
            }
            .state-typing .bot-head {
                transform: rotate(1deg) translateY(-2px);
            }

            /* 2. Password State: arms slide UP to shield eyes, bulb and eye turn red */
            .state-password .bot-left-arm {
                transform: translate(22px, -33px) rotate(138deg);
            }
            .state-password .bot-right-arm {
                transform: translate(-22px, -33px) rotate(-138deg);
            }
            .state-password .bot-eye-outer {
                stroke: #ef4444;
                fill: #450a0a;
                transform: scale(0.9);
            }
            .state-password .bot-eye-iris {
                fill: #ef4444;
                transform: scale(0);
            }
            .state-password .bot-bulb {
                fill: #ef4444;
            }

            /* 3. Forgot State: bulb amber, antenna droops, showing query marks */
            .state-forgot .bot-query {
                opacity: 1;
                pointer-events: auto;
            }
            .state-forgot .bot-antenna {
                transform: rotate(-22deg);
            }
            .state-forgot .bot-bulb {
                fill: #f59e0b;
                animation: pulse 1s infinite alternate;
            }
            .state-forgot .bot-eye-outer {
                stroke: #f59e0b;
                fill: #78350f;
            }
            .state-forgot .bot-eye-iris {
                fill: #f59e0b;
                transform: scale(0.8);
            }
            .state-forgot .neck-bar {
                transform: translateY(2px);
            }
            .state-forgot .bot-head {
                transform: rotate(-3deg) translateY(2px);
            }
            .state-forgot .bot-left-arm {
                transform: rotate(10deg);
            }
            .state-forgot .bot-right-arm {
                transform: rotate(-10deg);
            }
        </style>

        <!-- Dynamic State Interaction Script -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const container = document.getElementById('auth-layout-container');
                const inputs = document.querySelectorAll('input, select');
                
                // Set default state based on route
                if (window.location.pathname.includes('forgot-password')) {
                    container.className = 'state-forgot min-h-screen flex flex-col md:flex-row relative z-10 overflow-hidden';
                } else if (window.location.pathname.includes('reset-password')) {
                    container.className = 'state-forgot min-h-screen flex flex-col md:flex-row relative z-10 overflow-hidden';
                }

                inputs.forEach(input => {
                    input.addEventListener('focus', () => {
                        // Keep forgot password state locked if we're on those screens
                        if (window.location.pathname.includes('forgot-password') || window.location.pathname.includes('reset-password')) return;
                        
                        if (input.type === 'password') {
                            container.className = 'state-password min-h-screen flex flex-col md:flex-row relative z-10 overflow-hidden';
                        } else {
                            container.className = 'state-typing min-h-screen flex flex-col md:flex-row relative z-10 overflow-hidden';
                        }
                    });

                    input.addEventListener('blur', () => {
                        if (window.location.pathname.includes('forgot-password') || window.location.pathname.includes('reset-password')) return;
                        
                        setTimeout(() => {
                            const activeEl = document.activeElement;
                            if (!activeEl || (activeEl.tagName !== 'INPUT' && activeEl.tagName !== 'SELECT')) {
                                container.className = 'state-default min-h-screen flex flex-col md:flex-row relative z-10 overflow-hidden';
                            }
                        }, 50);
                    });
                });
            });
        </script>
    </body>
</html>
