<x-guest-layout title="Create Account">

<div
    x-data="{
        showPw: false,
        showPwConfirm: false,
        loading: false,
        toast: false,
        toastTimer: null,
        submit() { this.loading = true; },
        showToast() {
            this.toast = true;
            clearTimeout(this.toastTimer);
            this.toastTimer = setTimeout(() => { this.toast = false; }, 3200);
        }
    }"
>

    {{-- ── Heading ── --}}
    <div class="mb-7">
        <h1 class="font-bold text-gray-900 mb-1.5" style="font-size:1.6rem; letter-spacing:-.02em;">
            Create your account
        </h1>
        <p class="text-[13.5px] text-slate-500 leading-relaxed">Join the Roddy Technologies client portal</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" @submit="submit()">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="auth-label">Full name</label>
            <input
                id="name" type="text" name="name" value="{{ old('name') }}"
                class="auth-input @error('name') has-error @enderror"
                placeholder="John Doe" required autofocus autocomplete="name"
            >
            @error('name')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email" type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') has-error @enderror"
                placeholder="you@example.com" required autocomplete="username"
            >
            @error('email')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="auth-label">Password</label>
            <div class="relative">
                <input
                    id="password" :type="showPw ? 'text' : 'password'" name="password"
                    class="auth-input pr-11 @error('password') has-error @enderror"
                    placeholder="Min. 8 characters" required autocomplete="new-password"
                >
                <button type="button" @click="showPw = !showPw"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-0.5">
                    <svg x-show="!showPw" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg x-show="showPw" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="password_confirmation" class="auth-label">Confirm password</label>
            <div class="relative">
                <input
                    id="password_confirmation" :type="showPwConfirm ? 'text' : 'password'" name="password_confirmation"
                    class="auth-input pr-11 @error('password_confirmation') has-error @enderror"
                    placeholder="Re-enter password" required autocomplete="new-password"
                >
                <button type="button" @click="showPwConfirm = !showPwConfirm"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-0.5">
                    <svg x-show="!showPwConfirm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg x-show="showPwConfirm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn" :disabled="loading">
            <span x-show="!loading">Create account</span>
            <span x-show="loading" class="flex items-center gap-2" x-cloak>
                <span class="spinner"></span>
                Creating account...
            </span>
        </button>

    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-3 my-6">
        <div class="flex-1 h-px bg-slate-200/80"></div>
        <span class="text-[11.5px] text-slate-400 font-medium px-1 tracking-wide">or continue with</span>
        <div class="flex-1 h-px bg-slate-200/80"></div>
    </div>

    {{-- Toast --}}
    <div
        x-show="toast" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        class="fixed bottom-6 left-1/2 z-50 flex items-center gap-3 px-4 py-3.5 rounded-2xl"
        style="transform:translateX(-50%); background:#0f172a; border:1px solid rgba(255,255,255,.1); box-shadow:0 4px 6px rgba(0,0,0,.07),0 12px 28px rgba(0,0,0,.15); min-width:260px; pointer-events:none;"
    >
        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(96,165,250,.15);">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;color:#60a5fa;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-[13px] font-semibold" style="color:#f8fafc;">Social login coming soon</p>
            <p class="text-[11.5px] mt-0.5" style="color:rgba(255,255,255,.45);">We're actively working on this.</p>
        </div>
    </div>

    {{-- Social --}}
    <div class="grid grid-cols-2 gap-3">
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
        <button type="button" @click="showToast()" class="social-btn social-soon">
            <svg class="flex-shrink-0" width="16" height="16" fill="#1e293b" viewBox="0 0 24 24">
                <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
            </svg>
            <span>GitHub</span>
            <span class="soon-badge">Soon</span>
        </button>
    </div>

    {{-- Footer --}}
    <div class="mt-7 pt-6 border-t border-slate-100 text-center space-y-2.5">
        <p class="text-[13.5px] text-slate-500">
            Already have an account?
            <a href="{{ route('login') }}"
               class="font-semibold text-blue-600 hover:text-blue-800 transition-colors ml-0.5 underline underline-offset-2 decoration-blue-200 hover:decoration-blue-600">
               Sign in
            </a>
        </p>
        <p class="text-[11px] text-slate-300 space-x-2">
            <a href="#" class="hover:text-slate-400 transition-colors">Terms</a>
            <span>·</span>
            <a href="#" class="hover:text-slate-400 transition-colors">Privacy</a>
        </p>
    </div>

</div>

</x-guest-layout>
