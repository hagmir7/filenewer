@extends('layouts.base')

@section('content')
<div class="min-h-screen flex">

    <!-- ══ LEFT PANEL — Branding ══ -->
    <div
        class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative flex-col justify-between p-12 bg-fn-surface border-r border-fn-text/7 overflow-hidden panel-glow panel-glow-b grid-bg">

        <!-- Logo -->
        <a href="/" class="flex items-center gap-2.5 font-bold text-xl tracking-tight relative z-10">
            <div class="w-9 h-9 bg-fn-blue rounded-xl flex items-center justify-center shrink-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="9" y1="13" x2="15" y2="13" />
                    <line x1="9" y1="17" x2="13" y2="17" />
                </svg>
            </div>
            Filenewer
        </a>

        <!-- Center content -->
        <div class="relative z-10 space-y-10">
            <div>
                <p class="text-fn-cyan text-xs font-semibold uppercase tracking-widest mb-4">Password Recovery</p>
                <h2 class="text-3xl xl:text-4xl font-bold tracking-tight leading-[1.15] mb-5">
                    Happens to<br />
                    the best<br />
                    <span class="text-fn-text3">of us.</span>
                </h2>
                <p class="text-fn-text2 text-base leading-relaxed max-w-xs">
                    Enter your email and we'll send you a secure link to reset your password in seconds.
                </p>
            </div>

            <!-- Steps visual -->
            <div class="space-y-3">
                <p class="text-xs font-semibold text-fn-text3 uppercase tracking-widest">How it works</p>

                <div class="flex items-start gap-3 p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl">
                    <div
                        class="w-8 h-8 rounded-lg bg-fn-blue/15 flex items-center justify-center text-fn-blue font-bold text-sm shrink-0">
                        1</div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <p class="text-sm font-medium">Enter your email address</p>
                        <p class="text-xs text-fn-text3 mt-0.5">The one linked to your Filenewer account</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl">
                    <div
                        class="w-8 h-8 rounded-lg bg-fn-blue/15 flex items-center justify-center text-fn-blue font-bold text-sm shrink-0">
                        2</div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <p class="text-sm font-medium">Check your inbox</p>
                        <p class="text-xs text-fn-text3 mt-0.5">A reset link will arrive within a minute</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl">
                    <div
                        class="w-8 h-8 rounded-lg bg-fn-blue/15 flex items-center justify-center text-fn-blue font-bold text-sm shrink-0">
                        3</div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <p class="text-sm font-medium">Set a new password</p>
                        <p class="text-xs text-fn-text3 mt-0.5">Back in your dashboard in no time</p>
                    </div>
                </div>
            </div>

            <!-- Security note -->
            <div class="flex items-center gap-3 p-4 bg-fn-green/5 border border-fn-green/15 rounded-xl">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="text-fn-green shrink-0" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <p class="text-xs text-fn-text2 leading-relaxed">Reset links expire after 60 minutes and can only be
                    used once for your security.</p>
            </div>
        </div>

        <!-- Bottom brand -->
        <div class="relative z-10">
            <p class="text-fn-text3 text-sm font-medium italic">"Smarter File Processing."</p>
            <p class="text-fn-text3 text-xs mt-1">— The Filenewer Team</p>
        </div>
    </div>

    <!-- ══ RIGHT PANEL — Form ══ -->
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 relative overflow-hidden">

        <!-- Subtle bg glow -->
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-[radial-gradient(ellipse,oklch(68%_0.17_210_/_5%)_0%,transparent_70%)] pointer-events-none">
        </div>

        <div class="w-full max-w-md animate-fade-up opacity-0">

            <!-- Mobile logo -->
            <div class="flex lg:hidden items-center justify-center gap-2 mb-8">
                <div class="w-8 h-8 bg-fn-blue rounded-lg flex items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-tight">Filenewer</span>
            </div>

            <!-- ══ SUCCESS STATE (shown after submission) ══ -->
            @if (session('status'))
            <div id="success-state" class="text-center">
                <!-- Icon -->
                <div
                    class="w-16 h-16 bg-fn-green/10 border border-fn-green/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-green" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight mb-2">Check your email</h1>
                <p class="text-fn-text3 text-sm mb-2">We sent a password reset link to</p>
                <p class="text-fn-text font-semibold text-sm mb-6">{{ session('email') ?? 'your email address' }}</p>

                <div class="p-4 bg-fn-green/5 border border-fn-green/15 rounded-xl text-left mb-6">
                    <p class="text-xs text-fn-text2 leading-relaxed">{{ session('status') }}</p>
                </div>

                <p class="text-xs text-fn-text3 mb-6">
                    Didn't receive the email? Check your spam folder or
                    <a href="/forgot-password" class="text-fn-blue-l hover:underline font-medium">try again</a>.
                </p>

                <a href="/login"
                    class="flex items-center justify-center gap-2 w-full py-3 bg-fn-surface border border-fn-text/10 text-fn-text2 font-semibold text-sm rounded-xl transition-all hover:-translate-y-0.5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    Back to Sign In
                </a>
            </div>

            @else

            <!-- ══ FORM STATE ══ -->

            <!-- Back link -->
            <a href="/login"
                class="inline-flex items-center gap-1.5 text-xs text-fn-text3 hover:text-fn-text2 transition-colors mb-8 font-medium">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Back to Sign In
            </a>

            <!-- Icon + Header -->
            <div class="mb-8">
                <div
                    class="w-12 h-12 bg-fn-blue/10 border border-fn-blue/20 rounded-xl flex items-center justify-center mb-5">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-blue" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 9.9-1" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight mb-1.5">Forgot your password?</h1>
                <p class="text-fn-text3 text-sm">No worries — enter your email and we'll send you a reset link.</p>
            </div>

            <!-- Error banner -->
            @if ($errors->any())
            <div
                class="mb-5 flex items-start gap-3 px-4 py-3 bg-fn-red/10 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="text-fn-red shrink-0 mt-0.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <ul class="space-y-0.5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form -->
            <form id="forgot-form" class="space-y-4" action="" method="POST">
                @csrf

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-fn-text2 block" for="email">Email address</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-fn-text3 w-4 h-4 pointer-events-none"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        <input id="email" name="email" type="email" placeholder="john@company.com" autocomplete="email"
                            value="{{ old('email') }}" autofocus
                            class="input-field w-full pl-10 pr-4 py-2.5 bg-fn-surface border {{ $errors->has('email') ? 'border-fn-red' : 'border-fn-text/10' }} rounded-xl text-fn-text text-sm placeholder:text-fn-text3 font-sans" />
                    </div>
                    @error('email')
                    <p class="text-xs text-fn-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" id="submit-btn"
                    class="btn-primary w-full py-3 bg-fn-blue hover:bg-fn-blue-l text-white font-semibold text-sm rounded-xl transition-all hover:-translate-y-0.5 mt-2 flex items-center justify-center gap-2">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        id="btn-icon" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <span id="btn-text">Send Reset Link</span>
                    <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60"
                            stroke-dashoffset="20" stroke-linecap="round" />
                    </svg>
                </button>
            </form>

            <!-- Sign up link -->
            <p class="text-center text-sm text-fn-text3 mt-6">
                Remember your password?
                <a href="/login" class="text-fn-blue-l font-semibold hover:underline ml-1">Sign in</a>
            </p>

            <!-- Trust badges -->
            <div class="flex items-center justify-center gap-5 mt-8 pt-6 border-t border-fn-text/7">
                <div class="flex items-center gap-1.5 text-fn-text3 text-xs">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    SSL Secured
                </div>
                <div class="flex items-center gap-1.5 text-fn-text3 text-xs">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    GDPR Compliant
                </div>
                <div class="flex items-center gap-1.5 text-fn-text3 text-xs">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Encrypted Session
                </div>
            </div>

            @endif

        </div>
    </div>
</div>

<script>
    document.getElementById('forgot-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const spinner = document.getElementById('btn-spinner');
        btn.disabled = true;
        btnText.textContent = 'Sending…';
        btnIcon.classList.add('hidden');
        spinner.classList.remove('hidden');
    });
</script>
@endsection
