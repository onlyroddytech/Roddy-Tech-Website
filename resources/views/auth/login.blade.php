<x-guest-layout title="Sign In">

    <h1 class="text-2xl font-bold text-white tracking-tight mb-1">Welcome back</h1>
    <p class="text-sm mb-8" style="color: rgba(255,255,255,0.4);">Sign in to your client portal</p>

    {{-- Session status --}}
    @if(session('status'))
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 rounded-xl text-sm"
             style="background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.2); color: #34d399;">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="auth-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="auth-input" placeholder="you@example.com" required autofocus autocomplete="username">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="auth-label" style="margin-bottom:0;">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-[11px] font-medium transition"
                       style="color: rgba(99,102,241,0.8);"
                       onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='rgba(99,102,241,0.8)'">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                   class="auth-input" placeholder="••••••••" required autocomplete="current-password">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded" style="accent-color: #6366f1;">
            <label for="remember_me" class="text-xs" style="color: rgba(255,255,255,0.45);">
                Keep me signed in for 30 days
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn">Sign in</button>
    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-3 my-6">
        <div class="flex-1 h-px" style="background: rgba(255,255,255,0.08);"></div>
        <span class="text-[11px]" style="color: rgba(255,255,255,0.25);">or</span>
        <div class="flex-1 h-px" style="background: rgba(255,255,255,0.08);"></div>
    </div>

    <p class="text-center text-[13px]" style="color: rgba(255,255,255,0.35);">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium ml-1 transition"
           style="color: #818cf8;"
           onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#818cf8'">
            Create one
        </a>
    </p>

    <p class="text-center text-[11px] mt-5" style="color: rgba(255,255,255,0.2);">
        <a href="{{ route('home') }}" class="hover:underline">← Back to roddy.tech</a>
    </p>

</x-guest-layout>
