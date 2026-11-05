<section id="tools" class="py-10 sm:py-16 lg:py-24 bg-fn-surface border-y border-white/[0.07]"
    aria-labelledby="tools-heading">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-7 sm:mb-10 lg:mb-16">
            <p class="text-fn-blue-l text-xs sm:text-sm font-semibold uppercase tracking-widest mb-2 sm:mb-3">
                Popular Tools
            </p>
            <h2 id="tools-heading"
                class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight leading-tight mb-3 sm:mb-4">
                Start with the tools used most
            </h2>
            <p class="text-fn-text2 text-sm sm:text-base lg:text-lg max-w-lg mx-auto leading-relaxed">
                From PDF conversion to invoice generation — free online file tools our users reach for every day.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            {{-- PDF to Word --}}
            <article
                class="tool-card relative flex flex-col min-w-0 bg-fn-bg border border-white/[0.07] rounded-xl p-4 sm:p-5 lg:p-6 hover:border-fn-blue/40 hover:shadow-card-hover sm:hover:-translate-y-1 focus-within:border-fn-blue/40 transition-all">
                <div class="flex items-center gap-2.5 mb-3 sm:mb-4">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-red-500/15 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="M10 8v8h2a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2" />
                            <path d="M3 12h2a2 2 0 1 0 0-4H3v8" />
                            <path d="M17 12h3M21 8h-4v8" />
                        </svg>
                    </div>
                    <h3 class="min-w-0 font-semibold text-sm leading-snug">
                        PDF to Word Converter
                    </h3>
                </div>

                <p class="flex-1 text-fn-text3 text-xs sm:text-sm leading-relaxed">
                    Convert any PDF into a fully editable Word document. Preserves layout, fonts, and tables with
                    industry-leading accuracy.
                </p>

                <a href="/tools/pdf-to-word"
                    class="group inline-flex items-center self-start gap-1.5 mt-4 py-1.5 text-xs sm:text-sm font-semibold text-fn-blue-l rounded focus-visible:outline-2 focus-visible:outline-fn-blue focus-visible:outline-offset-4">
                    Use Tool
                    <span class="sr-only">— PDF to Word Converter</span>
                    <svg class="w-3 h-3 shrink-0 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </article>

            {{-- CSV to SQL --}}
            <article
                class="tool-card relative flex flex-col min-w-0 bg-fn-bg border border-white/[0.07] rounded-xl p-4 sm:p-5 lg:p-6 hover:border-fn-blue/40 hover:shadow-card-hover sm:hover:-translate-y-1 focus-within:border-fn-blue/40 transition-all">
                <div class="flex items-center gap-2.5 mb-3 sm:mb-4">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-fn-green/15 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1-2-2v-14a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2" />
                            <path d="M10 12l4 5M10 17l4-5" />
                        </svg>
                    </div>
                    <h3 class="min-w-0 font-semibold text-sm leading-snug">
                        CSV to SQL Converter
                    </h3>
                </div>

                <p class="flex-1 text-fn-text3 text-xs sm:text-sm leading-relaxed">
                    Upload any CSV and get clean, ready-to-run SQL INSERT statements. A must-have free tool for
                    developers and data analysts.
                </p>

                <a href="/tools/csv-to-sql"
                    class="group inline-flex items-center self-start gap-1.5 mt-4 py-1.5 text-xs sm:text-sm font-semibold text-fn-blue-l rounded focus-visible:outline-2 focus-visible:outline-fn-blue focus-visible:outline-offset-4">
                    Use Tool
                    <span class="sr-only">— CSV to SQL Converter</span>
                    <svg class="w-3 h-3 shrink-0 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </article>

            {{-- Invoice Generator --}}
            <article
                class="tool-card relative flex flex-col min-w-0 bg-fn-bg border border-white/[0.07] rounded-xl p-4 sm:p-5 lg:p-6 hover:border-fn-blue/40 hover:shadow-card-hover sm:hover:-translate-y-1 focus-within:border-fn-blue/40 transition-all">
                <div class="flex items-center gap-2.5 mb-3 sm:mb-4">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-fn-blue/15 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path
                                d="M19 12v7a1.78 1.78 0 0 1-3.1 1.4a1.65 1.65 0 0 0-2.6 0a1.65 1.65 0 0 1-2.6 0a1.65 1.65 0 0 0-2.6 0A1.78 1.78 0 0 1 5 19V5a2 2 0 0 1 2-2h7l5 5v4" />
                            <path d="M9 7h1M9 11h6M9 15h6" />
                        </svg>
                    </div>
                    <h3 class="min-w-0 font-semibold text-sm leading-snug">
                        Invoice PDF Generator
                    </h3>
                </div>

                <p class="flex-1 text-fn-text3 text-xs sm:text-sm leading-relaxed">
                    Create professional branded invoices in seconds. Download as PDF and send immediately — no account
                    needed.
                </p>

                <a href="/tools/invoice-generator"
                    class="group inline-flex items-center self-start gap-1.5 mt-4 py-1.5 text-xs sm:text-sm font-semibold text-fn-blue-l rounded focus-visible:outline-2 focus-visible:outline-fn-blue focus-visible:outline-offset-4">
                    Use Tool
                    <span class="sr-only">— Invoice PDF Generator</span>
                    <svg class="w-3 h-3 shrink-0 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </article>

            {{-- Image Compressor --}}
            <article
                class="tool-card relative flex flex-col min-w-0 bg-fn-bg border border-white/[0.07] rounded-xl p-4 sm:p-5 lg:p-6 hover:border-fn-blue/40 hover:shadow-card-hover sm:hover:-translate-y-1 focus-within:border-fn-blue/40 transition-all">
                <div class="flex items-center gap-2.5 mb-3 sm:mb-4">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-purple-500/15 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="M15 8h.01" />
                            <path d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6" />
                            <path d="M3 16l5-5c.928-.893 2.072-.893 3 0l5 5" />
                            <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3" />
                        </svg>
                    </div>
                    <h3 class="min-w-0 font-semibold text-sm leading-snug">
                        Image Compressor
                    </h3>
                </div>

                <p class="flex-1 text-fn-text3 text-xs sm:text-sm leading-relaxed">
                    Reduce image file size by up to 90% without visible quality loss. Supports JPG, PNG, and WebP for
                    web performance and bulk processing.
                </p>

                <a href="/tools/compress-image"
                    class="group inline-flex items-center self-start gap-1.5 mt-4 py-1.5 text-xs sm:text-sm font-semibold text-fn-blue-l rounded focus-visible:outline-2 focus-visible:outline-fn-blue focus-visible:outline-offset-4">
                    Use Tool
                    <span class="sr-only">— Image Compressor</span>
                    <svg class="w-3 h-3 shrink-0 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </article>
        </div>

        <div class="text-center mt-6 sm:mt-10">
            <a href="/tools"
                class="inline-flex items-center justify-center gap-2 px-4 sm:px-7 py-2 sm:py-3 text-xs sm:text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg sm:rounded-xl hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] focus-visible:outline-2 focus-visible:outline-fn-blue focus-visible:outline-offset-4 transition-all">
                View All Tools
                <svg class="shrink-0" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</section>
