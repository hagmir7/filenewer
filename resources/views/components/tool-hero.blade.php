<section class="relative overflow-hidden pt-6 pb-6 sm:pt-8 sm:pb-8 hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6">
        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb"
            class="flex flex-wrap items-center gap-x-1.5 gap-y-2 mb-5 sm:mb-6 text-xs sm:text-sm text-fn-text3 [&>svg]:shrink-0">
            <a href="/" class="hover:text-fn-text transition-colors">Home</a>

            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="9 18 15 12 9 6" />
            </svg>

            <a href="/tools" class="hover:text-fn-text transition-colors">Tools</a>

            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="9 18 15 12 9 6" />
            </svg>

            <a href="/tools?category={{ $tool->category->slug }}"
                class="min-w-0 break-words hover:text-fn-text transition-colors">
                {{ $tool->category->title }}
            </a>

            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="9 18 15 12 9 6" />
            </svg>

            <span aria-current="page" class="min-w-0 break-words text-fn-text2">
                {{ $tool->name }}
            </span>
        </nav>

        {{-- Tool heading --}}
        <div class="flex items-start gap-3 sm:gap-5 mb-5 sm:mb-6">
            <div
                class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-2xl sm:text-3xl shrink-0 [&>svg]:w-6 [&>svg]:h-6 sm:[&>svg]:w-8 sm:[&>svg]:h-8">
                {!! $tool->icon !!}
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1.5 mb-2">
                    <h1
                        class="w-full sm:w-auto text-lg sm:text-xl md:text-2xl font-bold tracking-tight leading-tight break-words">
                        {{ $tool->title }}
                    </h1>

                    @if(str_contains($tool->tags ?? '', 'popular'))
                    <span
                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-fn-amber/10 border border-fn-amber/30 text-fn-amber text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path
                                d="M12 12c2 -2.96 0 -7 -1 -8c0 3.038 -1.773 4.741 -3 6c-1.226 1.26 -2 3.24 -2 5a6 6 0 1 0 12 0c0 -1.532 -1.056 -3.94 -2 -5c-1.786 3 -2.791 3 -4 2z" />
                        </svg>
                        Popular
                    </span>
                    @endif

                    @if(str_contains($tool->tags ?? '', 'new'))
                    <span
                        class="inline-flex items-center px-2 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">
                        New
                    </span>
                    @endif
                </div>

                <p class="max-w-xl text-xs sm:text-sm text-fn-text3 leading-relaxed break-words">
                    {{ $tool->description }}
                </p>
            </div>
        </div>

        {{-- Quick stats --}}
        <div
            class="grid grid-cols-2 sm:flex sm:flex-wrap gap-x-3 gap-y-3 sm:gap-x-6 text-[11px] sm:text-sm text-fn-text3">
            <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                <svg class="shrink-0" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <span>Secure &amp; private</span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                <svg class="shrink-0" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <span>Fast processing</span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                <svg class="shrink-0" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                <span>No sign-up required</span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                <svg class="shrink-0" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                <span>Free to use</span>
            </div>
        </div>
    </div>
</section>
