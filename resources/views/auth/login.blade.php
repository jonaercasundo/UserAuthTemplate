<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <!-- Welcome Header -->
    <div class="text-center mb-10">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welcome Back</h1>
        <p class="text-gray-500 text-sm mt-1">Access your business command center</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Email Address</label>
            <input id="email" 
                class="block w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200 text-gray-900 placeholder:text-gray-400" 
                type="email" name="email" :value="old('email')" 
                placeholder="name@company.com"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2 ml-1">
                <label for="password" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <input id="password" 
                class="block w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200 text-gray-900 placeholder:text-gray-400"
                type="password"
                name="password"
                placeholder="••••••••"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-blue-600 shadow-sm focus:ring-blue-500/20 transition-all" name="remember">
                <span class="ms-3 text-sm font-medium text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full py-4 bg-black text-white rounded-2xl font-bold text-sm tracking-wide hover:bg-gray-800 transform active:scale-[0.98] transition-all duration-200 shadow-xl shadow-black/10">
            {{ __('Sign In to MCI') }}
        </button>
    </form>

    <!-- Footer -->
    <p class="text-center mt-10 text-[11px] text-gray-400 font-medium tracking-tight">
        By signing in, you agree to our 
        <a href="#" class="text-gray-900 underline underline-offset-4 decoration-gray-200 hover:decoration-gray-400 transition-colors">Terms of Service</a>
    </p>
</x-guest-layout>