<nav class="sticky top-0 z-50 border-b border-white/[0.07] backdrop-blur-xl bg-fn-bg/85">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="/">
            <img src="/filenewer-logo.svg" alt="Filenewer" width="100" height="50" class="h-[40px] w-auto md:h-[57px]">
        </a>

        <!-- Links -->
        <ul class="hidden md:flex items-center gap-8 list-none">
            <li><a href="/#features"
                    class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Features</a></li>
            <li><a href="/tools"
                    class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Tools</a></li>
            <li><a href="/#security"
                    class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Security</a></li>
            <li><a href="/blog" class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Blog</a>
            </li>
        </ul>

        <!-- CTAs -->
        <div class="flex items-center gap-3">
            @if (auth()->user())

            {{-- <a href="/my-files"
                class="inline-flex gap-2 items-center whitespace-nowrap px-2 md:px-4 py-1 md:py-2 text-sm md:text-sm font-semibold text-white bg-fn-blue rounded-lg hover:bg-fn-blue-l btn-glow transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                </svg>
                <span>My Files</span>
            </a> --}}

            <a href="{{ route('logout') }}"
                class="inline-flex items-center gap-2 px-2 md:px-4 py-1 md:py-2 text-sm md:text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 hover:bg-fn-red/5 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Logout</span>
            </a>

            @else

            <a href="/login"
                class="hidden sm:inline-flex items-center px-2 md:px-4 py-1.5 md:py-2 text-sm md:text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                Sign In
            </a>

            <a href="/signup"
                class="inline-flex items-center px-2 md:px-4 py-1.5 md:py-2 text-sm md:text-sm font-semibold text-white bg-fn-blue rounded-lg hover:bg-fn-blue-l btn-glow transition-all">
                Start Free
            </a>

            @endif
        </div>
    </div>
</nav>
