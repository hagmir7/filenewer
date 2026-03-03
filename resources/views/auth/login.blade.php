@extends('layouts.base')


@section('content')
<div class="min-h-screen flex ">

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
                <p class="text-fn-cyan text-xs font-semibold uppercase tracking-widest mb-4">Welcome back</p>
                <h2 class="text-3xl xl:text-4xl font-bold tracking-tight leading-[1.15] mb-5">
                    Your files are<br />
                    waiting for<br />
                    <span class="text-fn-text3">you.</span>
                </h2>
                <p class="text-fn-text2 text-base leading-relaxed max-w-xs">
                    Sign in to access your tools, saved files, and processing history from anywhere.
                </p>
            </div>

            <!-- Recent activity visual -->
            <div class="space-y-3">
                <p class="text-xs font-semibold text-fn-text3 uppercase tracking-widest">Recent Activity</p>

                <div class="flex items-center gap-3 p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl">
                    <div class="w-8 h-8 rounded-lg bg-fn-red/15 flex items-center justify-center text-sm shrink-0">📕
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">report_Q4.pdf → Word</p>
                        <p class="text-xs text-fn-text3">2 hours ago</p>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-green shrink-0" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>

                <div class="flex items-center gap-3 p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl">
                    <div class="w-8 h-8 rounded-lg bg-fn-green/15 flex items-center justify-center text-sm shrink-0">🟩
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">users_export.csv → SQL</p>
                        <p class="text-xs text-fn-text3">Yesterday</p>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-green shrink-0" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>

                <div class="flex items-center gap-3 p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl">
                    <div class="w-8 h-8 rounded-lg bg-fn-blue/15 flex items-center justify-center text-sm shrink-0">🧾
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">invoice_Nov_2025.pdf</p>
                        <p class="text-xs text-fn-text3">3 days ago</p>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-green shrink-0" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
            </div>

            <!-- Security note -->
            <div class="flex items-center gap-3 p-4 bg-fn-green/5 border border-fn-green/15 rounded-xl">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="text-fn-green shrink-0" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <p class="text-xs text-fn-text2 leading-relaxed">Your session is protected with AES-256 encryption and
                    automatically expires after 30 days of inactivity.</p>
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

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight mb-1.5">Welcome back</h1>
                <p class="text-fn-text3 text-sm">Sign in to continue to your dashboard</p>
            </div>

            <!-- Error banner (hidden by default) -->
            <div id="error-banner"
                class="hidden mb-5 flex items-center gap-3 px-4 py-3 bg-fn-red/10 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="text-fn-red shrink-0" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span id="error-msg">Invalid email or password. Please try again.</span>
            </div>

            <!-- Social sign-ins -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                <button
                    class="social-btn flex items-center justify-center gap-2.5 px-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-sm font-medium text-fn-text2 transition-all cursor-pointer">
                    <svg width="17" height="17" viewBox="0 0 24 24">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>
                    Google
                </button>
                <button
                    class="social-btn flex items-center justify-center gap-2.5 px-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-sm font-medium text-fn-text2 transition-all cursor-pointer">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" class="text-fn-text">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                    GitHub
                </button>
            </div>

            <!-- Divider -->
            <div class="flex items-center gap-3 mb-6">
                <div class="flex-1 h-px bg-fn-text/8"></div>
                <span class="text-fn-text3 text-xs font-medium">or sign in with email</span>
                <div class="flex-1 h-px bg-fn-text/8"></div>
            </div>

            <!-- Form -->
            <form id="login-form" class="space-y-4" onsubmit="handleLogin(event)">

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
                        <input id="email" type="email" placeholder="john@company.com" autocomplete="email"
                            class="input-field w-full pl-10 pr-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-fn-text text-sm placeholder:text-fn-text3 font-sans" />
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-semibold text-fn-text2" for="password">Password</label>
                        <a href="/forgot-password" class="text-xs text-fn-blue-l hover:underline font-medium">Forgot
                            password?</a>
                    </div>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-fn-text3 w-4 h-4 pointer-events-none"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <input id="password" type="password" placeholder="Enter your password"
                            autocomplete="current-password"
                            class="input-field w-full pl-10 pr-11 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-fn-text text-sm placeholder:text-fn-text3 font-sans" />
                        <button type="button" onclick="togglePwd('password','eye-login')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text2 transition-colors">
                            <svg id="eye-login" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember me -->
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" id="remember"
                        class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface cursor-pointer accent-fn-blue" />
                    <label for="remember" class="text-xs text-fn-text3 cursor-pointer select-none">Keep me signed in for
                        30 days</label>
                </div>

                <!-- Submit -->
                <button type="submit" id="submit-btn"
                    class="btn-primary w-full py-3 bg-fn-blue hover:bg-fn-blue-l text-white font-semibold text-sm rounded-xl transition-all hover:-translate-y-0.5 mt-2 flex items-center justify-center gap-2">
                    <span id="btn-text">Sign In</span>
                    <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60"
                            stroke-dashoffset="20" stroke-linecap="round" />
                    </svg>
                </button>

            </form>

            <!-- Sign up link -->
            <p class="text-center text-sm text-fn-text3 mt-6">
                Don't have an account?
                <a href="/signup" class="text-fn-blue-l font-semibold hover:underline ml-1">Sign up free</a>
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

        </div>
    </div>
</div>

<script>
    function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ?
                `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>` :
                `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        }

        function handleLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            const errorBanner = document.getElementById('error-banner');

            // Loading state
            btn.disabled = true;
            btnText.textContent = 'Signing in…';
            spinner.classList.remove('hidden');
            errorBanner.classList.add('hidden');

            // Simulate async login
            setTimeout(() => {
                btn.disabled = false;
                btnText.textContent = 'Sign In';
                spinner.classList.add('hidden');

                // Demo: show error state (replace with real auth logic)
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                if (!email || !password) {
                    errorBanner.classList.remove('hidden');
                    errorBanner.classList.add('flex');
                    document.getElementById('error-msg').textContent = 'Please fill in all fields.';
                    document.getElementById('login-form').classList.add('shake');
                    setTimeout(() => document.getElementById('login-form').classList.remove('shake'), 400);
                }
                // On success: window.location.href = '/dashboard';
            }, 1400);
        }
</script>
@endsection
