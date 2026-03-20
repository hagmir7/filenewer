@extends('layouts.base')


@section('content')



<!-- ══ HERO ══ -->
<section class="relative pt-20 pb-14 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">

        <div class="animate-fade-up opacity-0 text-center mb-14">
            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-fn-blue/30 bg-fn-blue/10 text-fn-blue-l text-xs font-semibold tracking-widest uppercase mb-5">
                <span class="w-1.5 h-1.5 rounded-full bg-fn-blue-l animate-pulse"></span>
                The Filenewer Blog
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-[3.6rem] font-normal tracking-tight leading-[1.1] mb-4">
                Guides, tips &amp; insights on<br />
                <span class="text-gradient italic">smarter file processing</span>
            </h1>
            <p class="text-fn-text2 text-lg max-w-xl mx-auto leading-relaxed">
                Tutorials, deep-dives, and product updates from the Filenewer team — helping you work faster with
                files.
            </p>
        </div>


    </div>
</section>

<!-- ══ FEATURED POST ══ -->
<section class="pb-6">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-5">Featured Article</p>

        <a href="/blog/how-to-convert-pdf-to-word-online"
            class="blog-card group block bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300 shadow-lg">
            <div class="grid lg:grid-cols-2">
                <!-- Image area -->
                <div
                    class="feat-img relative h-56 lg:h-auto min-h-[280px] flex items-center justify-center overflow-hidden">
                    <!-- Decorative pattern -->
                    <div class="absolute inset-0 opacity-30"
                        style="background-image: radial-gradient(oklch(56% 0.23 264 / 20%) 1px, transparent 1px); background-size: 24px 24px;">
                    </div>
                    <div class="relative z-10 text-center px-8">
                        <div
                            class="w-20 h-20 rounded-2xl bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-4xl mx-auto mb-4">
                            📕</div>
                        <span
                            class="inline-block px-3 py-1 bg-fn-blue/15 border border-fn-blue/30 rounded-full text-fn-blue-l text-xs font-semibold">PDF
                            Tools</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8 lg:p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <span
                                class="px-2.5 py-1 bg-fn-blue/10 border border-fn-blue/20 rounded-full text-fn-blue-l text-xs font-semibold">Featured</span>
                            <span class="text-fn-text3 text-xs">8 min read</span>
                        </div>
                        <h2
                            class="card-title font-serif text-2xl lg:text-3xl font-normal leading-snug tracking-tight mb-4 transition-colors duration-200">
                            How to Convert PDF to Word Online Without Losing Formatting
                        </h2>
                        <p class="text-fn-text2 text-sm leading-relaxed mb-6">
                            PDF to Word conversion sounds simple until you lose all your tables, headers, and fonts.
                            In this deep-dive, we explain how Filenewer's engine preserves every element — and how
                            you can do it in under 10 seconds.
                        </p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-xs font-bold text-fn-blue-l">
                                AL</div>
                            <div>
                                <p class="text-xs font-semibold">Alex Liu</p>
                                <p class="text-xs text-fn-text3">Feb 20, 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-fn-blue-l text-sm font-semibold">
                            Read article
                            <svg class="card-arrow w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7" />
                                <polyline points="7 7 17 7 17 17" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>

<!-- ══ BLOG GRID ══ -->
<section class="py-12">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-7">Latest Articles</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card 1 -->
            <a href="/blog/csv-to-sql-complete-guide"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">
                <div class="card-img-1 h-44 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient(oklch(56% 0.23 264 / 25%) 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">🟩</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2.5 py-0.5 bg-fn-green/10 border border-fn-green/20 rounded-full text-fn-green text-xs font-semibold">Tutorial</span>
                        <span class="text-fn-text3 text-xs">6 min read</span>
                    </div>
                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        CSV to SQL: The Complete Guide for Developers
                    </h3>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-5">Learn how to convert CSV files to SQL
                        INSERT statements instantly, handle edge cases, and automate the process with Filenewer's
                        API.</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-fn-green/20 flex items-center justify-center text-xs font-bold text-fn-green">
                                MK</div>
                            <span class="text-xs text-fn-text3">Maria K. · Feb 18</span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="/blog/compress-images-without-quality-loss"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">
                <div class="card-img-2 h-44 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient(oklch(68% 0.17 210 / 25%) 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">🖼️</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2.5 py-0.5 bg-fn-cyan/10 border border-fn-cyan/20 rounded-full text-fn-cyan text-xs font-semibold">Tips</span>
                        <span class="text-fn-text3 text-xs">5 min read</span>
                    </div>
                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        Compress Images Without Losing Quality: A Visual Guide
                    </h3>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-5">WebP vs PNG vs JPG — which format wins in
                        2026? We tested 500 images so you don't have to.</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-fn-cyan/20 flex items-center justify-center text-xs font-bold text-fn-cyan">
                                JR</div>
                            <span class="text-xs text-fn-text3">James R. · Feb 15</span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="/blog/automate-invoice-generation"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">
                <div class="card-img-3 h-44 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient(oklch(67% 0.18 162 / 25%) 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">🧾</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2.5 py-0.5 bg-fn-green/10 border border-fn-green/20 rounded-full text-fn-green text-xs font-semibold">Automation</span>
                        <span class="text-fn-text3 text-xs">7 min read</span>
                    </div>
                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        How to Automate Invoice Generation for Your Business
                    </h3>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-5">Stop creating invoices manually. Use
                        Filenewer's document generator with your own data to produce batch PDFs in one click.</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-fn-green/20 flex items-center justify-center text-xs font-bold text-fn-green">
                                SP</div>
                            <span class="text-xs text-fn-text3">Sara P. · Feb 12</span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="/blog/pdf-security-encryption-guide"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">
                <div class="card-img-4 h-44 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient(oklch(59% 0.22 27 / 25%) 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">🔐</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2.5 py-0.5 bg-fn-red/10 border border-fn-red/20 rounded-full text-fn-red text-xs font-semibold">Security</span>
                        <span class="text-fn-text3 text-xs">9 min read</span>
                    </div>
                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        PDF Security & Encryption: Everything You Need to Know
                    </h3>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-5">Password protection, AES encryption,
                        permissions, and redaction — a complete guide to keeping your PDF files secure.</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-fn-red/20 flex items-center justify-center text-xs font-bold text-fn-red">
                                DW</div>
                            <span class="text-xs text-fn-text3">Dan W. · Feb 8</span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 5 -->
            <a href="/blog/batch-file-processing-with-api"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">
                <div class="card-img-5 h-44 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient(oklch(73% 0.17 72 / 25%) 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">⚡</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2.5 py-0.5 bg-fn-amber/10 border border-fn-amber/20 rounded-full text-fn-amber text-xs font-semibold">Developer</span>
                        <span class="text-fn-text3 text-xs">11 min read</span>
                    </div>
                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        Batch File Processing at Scale Using the Filenewer API
                    </h3>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-5">Process thousands of files
                        programmatically. A practical guide with code examples in Node.js, Python, and PHP.</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-fn-amber/20 flex items-center justify-center text-xs font-bold text-fn-amber">
                                TC</div>
                            <span class="text-xs text-fn-text3">Tom C. · Feb 5</span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Card 6 -->
            <a href="/blog/filenewer-2026-product-updates"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">
                <div class="card-img-6 h-44 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient(oklch(56% 0.23 264 / 25%) 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">🚀</span>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2.5 py-0.5 bg-fn-blue/10 border border-fn-blue/20 rounded-full text-fn-blue-l text-xs font-semibold">Updates</span>
                        <span class="text-fn-text3 text-xs">4 min read</span>
                    </div>
                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        Filenewer in 2026: New Tools, Faster Processing & More
                    </h3>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-5">A look at everything new — OCR, bulk ZIP
                        downloads, the redesigned dashboard, and what's coming next quarter.</p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-fn-blue/20 flex items-center justify-center text-xs font-bold text-fn-blue-l">
                                FN</div>
                            <span class="text-xs text-fn-text3">Filenewer Team · Feb 1</span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>

        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center gap-2 mt-14">
            <button
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-fn-blue text-white text-sm font-semibold">1</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 text-sm font-medium hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">2</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 text-sm font-medium hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">3</button>
            <span class="text-fn-text3 text-sm px-1">…</span>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 text-sm font-medium hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">8</button>
            <button
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- ══ NEWSLETTER ══ -->
<section class="py-20 mt-8 border-t border-fn-text/7">
    <div class="max-w-6xl mx-auto px-6">
        <div
            class="bg-fn-surface border border-fn-text/7 rounded-2xl p-10 lg:p-14 relative overflow-hidden text-center">
            <!-- Glow -->
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_50%_-20%,oklch(49%_0.24_264_/_12%)_0%,transparent_65%)] pointer-events-none">
            </div>

            <div class="relative z-10 max-w-lg mx-auto">
                <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">Stay Updated</p>
                <h2 class="font-serif text-2xl sm:text-3xl font-normal tracking-tight mb-3">
                    Get file tips straight to your inbox
                </h2>
                <p class="text-fn-text2 text-sm leading-relaxed mb-7">
                    Join 12,000+ readers. No spam, just practical guides on file tools, automation, and productivity
                    — every two weeks.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 max-w-sm mx-auto">
                    <input type="email" placeholder="your@email.com"
                        class="nl-input flex-1 px-4 py-2.5 bg-fn-bg border border-fn-text/10 rounded-xl text-fn-text text-sm placeholder:text-fn-text3 font-sans transition-all" />
                    <button
                        class="px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all hover:-translate-y-0.5 whitespace-nowrap">
                        Subscribe Free
                    </button>
                </div>
                <p class="text-fn-text3 text-xs mt-3">Unsubscribe any time · No spam ever</p>
            </div>
        </div>
    </div>
</section>


<script>
    // Category filter pills
    document.querySelectorAll('.cat-pill').forEach(pill => {
      pill.addEventListener('click', () => {
        document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
      });
    });
</script>


@endsection
