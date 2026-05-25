<x-guest-layout>
    <div class="mb-6 text-sm text-slate-400 leading-relaxed">
        {{ __('Enter your registered email address below, and our systems will dispatch a secure cryptographic password reset link to your inbox.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-slate-400 hover:text-blue-400 transition-colors" href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>

            <x-primary-button>
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

