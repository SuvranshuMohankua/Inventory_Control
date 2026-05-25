<x-guest-layout>
    <style>
        #auth-layout-container .peer:checked ~ .peer-checked\:text-blue-400 {
            color: #60a5fa !important;
        }
        #auth-layout-container .peer:checked ~ .peer-checked\:text-amber-400 {
            color: #fbbf24 !important;
        }
        #auth-layout-container .peer:checked ~ .peer-checked\:text-indigo-400 {
            color: #818cf8 !important;
        }
        #auth-layout-container .peer:checked ~ .peer-checked\:bg-blue-500\/10 {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        #auth-layout-container .peer:checked ~ .peer-checked\:bg-amber-500\/10 {
            background-color: rgba(245, 158, 11, 0.1) !important;
        }
        #auth-layout-container .peer:checked ~ .peer-checked\:bg-indigo-500\/10 {
            background-color: rgba(99, 102, 241, 0.1) !important;
        }
    </style>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label :value="__('Select Account Role')" class="mb-2 text-slate-400 font-bold text-xs tracking-wider" />
            
            <div class="grid grid-cols-1 gap-3 mt-1">
                <!-- Staff Option Card -->
                <label class="relative flex items-start p-3.5 rounded-xl border border-white/5 bg-slate-950/20 hover:bg-slate-900/40 cursor-pointer transition-all group">
                    <input type="radio" name="role" value="staff" class="sr-only peer" {{ old('role', 'staff') === 'staff' ? 'checked' : '' }} required>
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-500/80 peer-checked:bg-blue-500/[0.02] transition-all pointer-events-none"></div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-800 text-slate-400 peer-checked:bg-blue-500/10 peer-checked:text-blue-400 group-hover:text-slate-300 transition-colors mr-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-bold text-slate-200 group-hover:text-white transition-colors">Staff / Operator</span>
                        <span class="block text-xs text-slate-400 mt-0.5 leading-relaxed">Log inventory transactions and view stock levels.</span>
                    </div>
                </label>

                <!-- Manager Option Card -->
                <label class="relative flex items-start p-3.5 rounded-xl border border-white/5 bg-slate-950/20 hover:bg-slate-900/40 cursor-pointer transition-all group">
                    <input type="radio" name="role" value="manager" class="sr-only peer" {{ old('role') === 'manager' ? 'checked' : '' }}>
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-amber-500/80 peer-checked:bg-amber-500/[0.02] transition-all pointer-events-none"></div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-800 text-slate-400 peer-checked:bg-amber-500/10 peer-checked:text-amber-400 group-hover:text-slate-300 transition-colors mr-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-bold text-slate-200 group-hover:text-white transition-colors">Oversight Manager</span>
                        <span class="block text-xs text-slate-400 mt-0.5 leading-relaxed">Manage spare parts, edit stock points, and view reports.</span>
                    </div>
                </label>

                <!-- Admin Option Card -->
                <label class="relative flex items-start p-3.5 rounded-xl border border-white/5 bg-slate-950/20 hover:bg-slate-900/40 cursor-pointer transition-all group">
                    <input type="radio" name="role" value="admin" class="sr-only peer" {{ old('role') === 'admin' ? 'checked' : '' }}>
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-indigo-500/80 peer-checked:bg-indigo-500/[0.02] transition-all pointer-events-none"></div>
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-800 text-slate-400 peer-checked:bg-indigo-500/10 peer-checked:text-indigo-400 group-hover:text-slate-300 transition-colors mr-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <span class="block text-sm font-bold text-slate-200 group-hover:text-white transition-colors">System Administrator</span>
                        <span class="block text-xs text-slate-400 mt-0.5 leading-relaxed">Full system override: manage users, parts, categories and settings.</span>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-slate-400 hover:text-blue-400 transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

