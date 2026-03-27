<x-guest-layout title="Sign In">

<div x-data="{
    showPw: false,
    loading: false,
    toast: false,
    toastTimer: null,
    submit() { this.loading = true; },
    showToast() {
        this.toast = true;
        clearTimeout(this.toastTimer);
        this.toastTimer = setTimeout(() => { this.toast = false; }, 3200);
    }
}">

    {{-- ── Toast notification ── --}}
    <div
        x-show="toast"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        class="fixed bottom-6 left-1/2 z-50 flex items-center gap-3 px-4 py-3.5 rounded-2xl"
        style="
            transform: translateX(-50%);
            background: #0f172a;
            border: 1px solid rgba(255,255,255,.1);
            box-shadow: 0 4px 6px rgba(0,0,0,.07), 0 12px 28px rgba(0,0,0,.15);
            min-width: 260px;
            pointer-events: none;
        "
    >
        {{-- Icon --}}
        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
             style="background: rgba(96,165,250,.15);">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="width:14px; height:14px; color:#60a5fa;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        {{-- Text --}}
        <div>
            <p class="text-[13px] font-semibold" style="color:#f8fafc;">Social login coming soon</p>
            <p class="text-[11.5px] mt-0.5" style="color:rgba(255,255,255,.45);">We're actively working on this.</p>
        </div>
    </div>

    {{-- ── Heading ── --}}
    <div class="mb-8">
        <h1 class="text-gray-900 font-bold tracking-tight mb-2" style="font-size: 1.7rem; letter-spacing: -.025em; line-height: 1.15;">
            Welcome back
        </h1>
        <p class="text-[13.5px] leading-relaxed" style="color: #64748b;">
            Sign in to your client portal to continue
        </p>
    </div>

    {{-- ── Session status ── --}}
    @if(session('status'))
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 rounded-xl text-[13px] bg-emerald-50 border border-emerald-200 text-emerald-700">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- ── Global error ── --}}
    @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 rounded-xl text-[13px] bg-red-50 border border-red-200 text-red-700">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5" @submit="submit()">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email" type="email" name="email"
                value="{{ old('email') }}"
                class="auth-input @error('email') has-error @enderror"
                placeholder="you@example.com"
                required autofocus autocomplete="username"
            >
            @error('email')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="auth-label" style="margin-bottom:0;">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-[12px] font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-200">
                        Forgot password?
                    </a>
                @endif
            </div>

            <div class="relative">
                <input
                    id="password"
                    :type="showPw ? 'text' : 'password'"
                    name="password"
                    class="auth-input pr-12 @error('password') has-error @enderror"
                    placeholder="••••••••"
                    required autocomplete="current-password"
                >
                {{-- Eye toggle — full-height tap zone, hover feedback --}}
                <button
                    type="button"
                    @click="showPw = !showPw"
                    class="absolute right-0 top-0 h-full px-4 flex items-center rounded-r-xl transition-colors duration-200"
                    :style="showPw ? 'color:#3b82f6' : 'color:#94a3b8'"
                    :title="showPw ? 'Hide password' : 'Show password'"
                    style="background:transparent; border:none; cursor:pointer;"
                    onmouseenter="this.style.color='#3b82f6'"
                    onmouseleave="this.style.color= (document.getElementById('password').type==='text') ? '#3b82f6' : '#94a3b8'"
                >
                    <svg x-show="!showPw" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg x-show="showPw" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="width:18px;height:18px;" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>

            @error('password')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember me --}}
        <label class="flex items-center gap-2.5 cursor-pointer group w-fit">
            <input id="remember_me" type="checkbox" name="remember" class="auth-check">
            <span class="text-[13px] select-none transition-colors duration-200"
                  style="color:#64748b;"
                  onmouseenter="this.style.color='#1e293b'"
                  onmouseleave="this.style.color='#64748b'">
                Stay signed in for 30 days
            </span>
        </label>

        {{-- Submit --}}
        <button type="submit" class="auth-btn" :disabled="loading">
            <span x-show="!loading">Sign in</span>
            <span x-show="loading" class="flex items-center gap-2.5" x-cloak>
                <span class="spinner"></span>
                Signing in...
            </span>
        </button>

    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-3 my-6">
        <div class="flex-1 h-px" style="background:#e2e8f0;"></div>
        <span class="text-[11.5px] font-medium tracking-wide px-1" style="color:#94a3b8;">or continue with</span>
        <div class="flex-1 h-px" style="background:#e2e8f0;"></div>
    </div>

    {{-- Social --}}
    <div class="grid grid-cols-2 gap-3">

        {{-- Google --}}
        <button type="button" @click="showToast()" class="social-btn social-soon">
            <svg class="flex-shrink-0" width="16" height="16" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            <span>Google</span>
            <span class="soon-badge">Soon</span>
        </button>

        {{-- GitHub --}}
        <button type="button" @click="showToast()" class="social-btn social-soon">
            <svg class="flex-shrink-0" width="16" height="16" fill="#1e293b" viewBox="0 0 24 24">
                <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
            </svg>
            <span>GitHub</span>
            <span class="soon-badge">Soon</span>
        </button>

    </div>

    {{-- Footer --}}
    <div class="mt-7 pt-6 text-center space-y-2.5" style="border-top: 1px solid #f1f5f9;">
        <p class="text-[13.5px]" style="color:#64748b;">
            Don't have an account?
            <a href="{{ route('register') }}"
               class="font-semibold text-blue-600 hover:text-blue-800 ml-0.5 transition-colors duration-200"
               style="text-decoration: underline; text-decoration-color: #bfdbfe; text-underline-offset: 3px;">
                Create one
            </a>
        </p>
        <p class="text-[11px] space-x-2" style="color:#cbd5e1;">
            <a href="#" class="hover:text-slate-400 transition-colors duration-200">Terms</a>
            <span>·</span>
            <a href="#" class="hover:text-slate-400 transition-colors duration-200">Privacy</a>
        </p>
    </div>

</div>

</x-guest-layout>
