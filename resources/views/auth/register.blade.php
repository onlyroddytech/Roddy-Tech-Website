<x-guest-layout title="Create Account">

    <h1 class="text-2xl font-bold text-white tracking-tight mb-1">Create your account</h1>
    <p class="text-sm mb-8" style="color: rgba(255,255,255,0.4);">Join the Roddy Technologies client portal</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="auth-label">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="auth-input" placeholder="John Doe" required autofocus autocomplete="name">
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="auth-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="auth-input" placeholder="you@example.com" required autocomplete="username">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password"
                   class="auth-input" placeholder="Min. 8 characters" required autocomplete="new-password">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="password_confirmation" class="auth-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="auth-input" placeholder="Re-enter password" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="auth-btn">Create account</button>
    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-3 my-6">
        <div class="flex-1 h-px" style="background: rgba(255,255,255,0.08);"></div>
        <span class="text-[11px]" style="color: rgba(255,255,255,0.25);">or</span>
        <div class="flex-1 h-px" style="background: rgba(255,255,255,0.08);"></div>
    </div>

    <p class="text-center text-[13px]" style="color: rgba(255,255,255,0.35);">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium ml-1 transition"
           style="color: #818cf8;"
           onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#818cf8'">
            Sign in
        </a>
    </p>

    <p class="text-center text-[11px] mt-5" style="color: rgba(255,255,255,0.2);">
        <a href="{{ route('home') }}" class="hover:underline">← Back to roddy.tech</a>
    </p>

</x-guest-layout>
