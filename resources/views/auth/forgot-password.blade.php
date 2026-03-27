<x-guest-layout title="Reset Password">

<div x-data="{ loading: false, submit() { this.loading = true; } }">

    {{-- Heading --}}
    <div class="mb-8">
        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-5">
            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-1.5">Forgot your password?</h1>
        <p class="text-sm text-gray-500 leading-relaxed">
            No problem. Enter your email and we'll send you a reset link right away.
        </p>
    </div>

    {{-- Session status --}}
    @if(session('status'))
        <div class="mb-5 flex items-center gap-2.5 px-4 py-3 rounded-xl text-sm bg-emerald-50 border border-emerald-200 text-emerald-700">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" @submit="submit()">
        @csrf

        <div>
            <label for="email" class="auth-label">Email address</label>
            <input
                id="email" type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') has-error @enderror"
                placeholder="you@example.com" required autofocus
            >
            @error('email')
                <p class="auth-error">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button type="submit" class="auth-btn" :disabled="loading">
            <span x-show="!loading">Send reset link</span>
            <span x-show="loading" class="flex items-center gap-2" x-cloak>
                <span class="spinner"></span>
                Sending...
            </span>
        </button>

    </form>

    <div class="mt-7 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to sign in
        </a>
    </div>

</div>

</x-guest-layout>
