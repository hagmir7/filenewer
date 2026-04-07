<section class="relative pt-8 pb-8 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-5xl mx-auto px-6 relative z-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-fn-text3 mb-6">
            <a href="/" class="hover:text-fn-text transition-colors">Home</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <a href="/tools" class="hover:text-fn-text transition-colors">Tools</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <a href="/tools?category={{ $tool->category->slug }}" class="hover:text-fn-text transition-colors">
                {{ $tool->category->title }}
            </a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <span class="text-fn-text2">{{ $tool->name }}</span>
        </nav>

        {{-- Tool heading --}}
        <div class="flex items-start gap-5 mb-6">
            <div
                class="w-14 h-14 rounded-2xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-3xl shrink-0">
                {{ $tool->icon }}
            </div>
            <div>
                <div class="flex items-center gap-3 mb-1 flex-wrap">
                    <h1 class="text-2xl font-bold tracking-tight">{{ $tool->title }}</h1>
                    @if(str_contains($tool->tags ?? '', 'popular'))
                    <span
                        class="px-2 py-0.5 bg-fn-amber/10 border border-fn-amber/30 text-fn-amber text-sm font-semibold rounded-full">🔥
                        Popular</span>
                    @endif
                    @if(str_contains($tool->tags ?? '', 'new'))
                    <span
                        class="px-2 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-sm font-semibold rounded-full">New</span>
                    @endif
                </div>
                <p class="text-fn-text3 text-sm leading-relaxed max-w-xl">{{ $tool->description }}</p>
            </div>
        </div>

        {{-- Quick stats --}}
        <div class="flex items-center gap-6 flex-wrap">
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <span>Secure &amp; private</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <span>Fast processing</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                <span>No sign-up required</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                <span>Free to use</span>
            </div>
        </div>

    </div>
</section>
