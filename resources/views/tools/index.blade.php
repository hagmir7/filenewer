@extends('layouts.base')


@section('content')
    <!-- ══ HERO ══ -->
        <section class="relative pt-16 pb-12 overflow-hidden hero-glow">
            <div class="absolute inset-0 grid-lines pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-6 relative z-10">

                <div class="animate-fade-up opacity-0 text-center mb-10">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-fn-blue/30 bg-fn-blue/10 text-fn-blue-l text-xs font-semibold tracking-widest uppercase mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-fn-blue-l animate-pulse"></span>
                        50+ Free Tools
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-bold tracking-tight leading-[1.1] mb-4">
                        All <span class="text-gradient">Online File Tools</span><br class="hidden sm:block" /> in One Place
                    </h1>
                    <p class="text-fn-text2 text-lg max-w-xl mx-auto leading-relaxed">
                        Convert, compress, generate, and process any file — instantly, securely, and for free. No
                        installation. No account needed for most tools.
                    </p>
                </div>

                <!-- Search bar -->
                <div class="animate-fade-up opacity-0 delay-2 max-w-2xl mx-auto mb-6">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-fn-text3 w-5 h-5 pointer-events-none"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <input id="global-search" type="text" placeholder="Search tools… e.g. PDF, compress, invoice, CSV"
                            class="search-input w-full pl-12 pr-14 py-3.5 bg-fn-surface border border-fn-text/10 rounded-2xl text-fn-text text-base placeholder:text-fn-text3 font-sans transition-all" />
                        <kbd
                            class="absolute right-4 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1 px-2 py-1 bg-fn-surface2 border border-fn-text/10 rounded-md text-fn-text3 text-xs font-mono">⌘K</kbd>
                    </div>
                    <!-- Search result count -->
                    <p id="search-count" class="text-fn-text3 text-xs text-center mt-2.5 h-4"></p>
                </div>

                <!-- Stats bar -->
                <div class="animate-fade-up opacity-0 delay-3 flex items-center justify-center gap-8 flex-wrap">
                    <div class="flex items-center gap-2 text-fn-text3 text-sm">
                        <span class="w-2 h-2 rounded-full bg-fn-green"></span>
                        <span><strong class="text-fn-text font-semibold">54</strong> tools available</span>
                    </div>
                    <div class="flex items-center gap-2 text-fn-text3 text-sm">
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l"></span>
                        <span><strong class="text-fn-text font-semibold">6</strong> categories</span>
                    </div>
                    <div class="flex items-center gap-2 text-fn-text3 text-sm">
                        <span class="w-2 h-2 rounded-full bg-fn-cyan"></span>
                        <span><strong class="text-fn-text font-semibold">2M+</strong> files processed</span>
                    </div>
                    <div class="flex items-center gap-2 text-fn-text3 text-sm">
                        <span class="w-2 h-2 rounded-full bg-fn-amber"></span>
                        <span><strong class="text-fn-text font-semibold">100%</strong> free to start</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- ══ MAIN LAYOUT ══ -->
        <div class="max-w-7xl mx-auto px-6 pb-24">
            <div class="flex gap-8">
                <!-- ── TOOL GRID ── -->
                <main class="flex-1 min-w-0 pt-2">

                    <!-- Mobile filter button -->
                    <div class="flex items-center justify-between mb-5 lg:hidden">
                        <p class="text-fn-text3 text-sm" id="mobile-count">Showing 54 tools</p>
                        <button id="mobile-filter-btn"
                            class="flex items-center gap-2 px-3 py-2 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text2 text-sm font-medium">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                            </svg>
                            Filters
                        </button>
                    </div>

                    <!-- Sort row -->
                    <div class="flex items-center justify-between mb-7 hidden lg:flex">
                        <p class="text-fn-text3 text-sm" id="result-count">Showing <strong
                                class="text-fn-text font-semibold">54</strong> tools</p>
                        <div class="flex items-center gap-2">
                            <span class="text-fn-text3 text-xs">Sort:</span>
                            <select id="sort-select"
                                class="bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-medium rounded-lg px-3 py-1.5 font-sans focus:outline-none focus:border-fn-blue/50 cursor-pointer">
                                <option value="popular">Most Popular</option>
                                <option value="newest">Newest First</option>
                                <option value="az">A → Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- ─── SECTION: PDF Tools ─── -->
                    <div class="tool-section mb-10" data-section="pdf">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-8 h-8 rounded-lg bg-fn-red/15 border border-fn-red/25 flex items-center justify-center text-base shrink-0">
                                📕</div>
                            <h2 class="text-base font-bold tracking-tight">PDF Tools</h2>
                            <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-xs font-mono">14</span>
                            <div class="flex-1 h-px bg-fn-text/7"></div>
                        </div>
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">

                            <a href="/tools/pdf-to-word"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="popular" data-name="pdf to word converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    📕</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">PDF to Word</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert PDF to editable DOCX preserving
                                        all layout & fonts.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/pdf-to-excel"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="pdf to excel converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    📗</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">PDF to Excel</h3>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Extract tables from PDF directly into
                                        editable XLSX spreadsheets.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/pdf-to-jpg"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="pdf to jpg converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    🖼️</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">PDF to JPG</h3>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert each PDF page into a
                                        high-resolution JPG image.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/word-to-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="popular" data-name="word to pdf converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    📄</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Word to PDF</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert DOCX files to print-ready PDF
                                        in one click.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/merge-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="merge pdf files">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    📎</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Merge PDF</h3>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Combine multiple PDF files into one in
                                        any order you choose.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/split-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="split pdf file">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    ✂️</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Split PDF</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Extract pages or split a large PDF into
                                        smaller files.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/compress-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="popular" data-name="compress pdf reduce size">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    🗜️</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Compress PDF</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Reduce PDF file size by up to 90%
                                        without visible quality loss.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/pdf-to-png"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="new" data-name="pdf to png converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    🟥</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">PDF to PNG</h3>
                                        <span
                                            class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Export each PDF page as a
                                        transparent-background PNG file.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/encrypt-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="encrypt protect pdf password">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    🔒</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Encrypt PDF</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Password-protect any PDF with AES-256
                                        encryption.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/ocr-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="new api" data-name="ocr pdf extract text scanned">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    🔍</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">OCR PDF</h3>
                                        <span
                                            class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Extract text from scanned PDFs using
                                        AI-powered OCR.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/rotate-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="rotate pdf pages">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    🔄</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Rotate PDF</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Rotate individual or all pages in a PDF
                                        to any orientation.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/watermark-pdf"
                                class="tool-card accent-pdf bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="pdf" data-tags="" data-name="add watermark pdf">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">
                                    💧</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Watermark PDF</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Add text or image watermarks to any PDF
                                        document.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                        </div>
                    </div>

                    <!-- ─── SECTION: Image Tools ─── -->
                    <div class="tool-section mb-10" data-section="image">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-8 h-8 rounded-lg bg-fn-purple/15 border border-fn-purple/25 flex items-center justify-center text-base shrink-0">
                                🖼️</div>
                            <h2 class="text-base font-bold tracking-tight">Image Tools</h2>
                            <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-xs font-mono">11</span>
                            <div class="flex-1 h-px bg-fn-text/7"></div>
                        </div>
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">

                            <a href="/tools/image-compressor"
                                class="tool-card accent-image bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="image" data-tags="popular" data-name="image compressor compress jpg png webp">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                                    🗜️</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Image Compressor</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Reduce image size by up to 90% — JPG,
                                        PNG, WebP supported.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/convert-image"
                                class="tool-card accent-image bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="image" data-tags="" data-name="image converter jpg png webp gif">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                                    🔀</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Image Converter</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert between JPG, PNG, WebP, GIF,
                                        AVIF, and SVG formats.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/resize-image"
                                class="tool-card accent-image bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="image" data-tags="" data-name="resize image dimensions width height">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                                    📐</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Resize Image</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Resize images to exact dimensions or by
                                        percentage, in bulk.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/remove-background"
                                class="tool-card accent-image bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="image" data-tags="new popular api" data-name="remove background image transparent">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                                    ✂️</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Remove Background</h3>
                                        <span
                                            class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">AI-powered background removal. Instant
                                        transparent PNG output.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/crop-image"
                                class="tool-card accent-image bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="image" data-tags="" data-name="crop image editor">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                                    🪟</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Crop Image</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Crop images with free selection, aspect
                                        ratio lock, or preset sizes.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/jpg-to-pdf"
                                class="tool-card accent-image bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="image" data-tags="popular" data-name="jpg to pdf image to pdf">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                                    📷</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">JPG to PDF</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Turn one or multiple images into a
                                        single PDF document.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                        </div>
                    </div>

                    <!-- ─── SECTION: Data & CSV ─── -->
                    <div class="tool-section mb-10" data-section="data">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-8 h-8 rounded-lg bg-fn-green/15 border border-fn-green/25 flex items-center justify-center text-base shrink-0">
                                📊</div>
                            <h2 class="text-base font-bold tracking-tight">Data & CSV Tools</h2>
                            <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-xs font-mono">8</span>
                            <div class="flex-1 h-px bg-fn-text/7"></div>
                        </div>
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">

                            <a href="/tools/csv-to-sql"
                                class="tool-card accent-data bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="data" data-tags="popular api" data-name="csv to sql converter insert statements">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg shrink-0">
                                    🟩</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">CSV to SQL</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert CSV to SQL INSERT statements
                                        instantly. MySQL, PostgreSQL, SQLite.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/csv-to-json"
                                class="tool-card accent-data bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="data" data-tags="popular api" data-name="csv to json converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg shrink-0">
                                    📋</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">CSV to JSON</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Transform CSV data into clean,
                                        formatted JSON with one click.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/excel-to-csv"
                                class="tool-card accent-data bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="data" data-tags="" data-name="excel to csv xlsx converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg shrink-0">
                                    📗</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Excel to CSV</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Export any XLSX sheet to a clean,
                                        delimiter-configurable CSV.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/json-formatter"
                                class="tool-card accent-data bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="data" data-tags="new" data-name="json formatter validator beautify">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg shrink-0">
                                    🔧</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">JSON Formatter</h3>
                                        <span
                                            class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Validate, format, and minify JSON data
                                        with syntax highlighting.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/csv-to-xml"
                                class="tool-card accent-data bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="data" data-tags="" data-name="csv to xml converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg shrink-0">
                                    📄</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">CSV to XML</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert CSV rows into structured,
                                        tag-configurable XML output.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                        </div>
                    </div>

                    <!-- ─── SECTION: Document Generators ─── -->
                    <div class="tool-section mb-10" data-section="doc">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-8 h-8 rounded-lg bg-fn-blue/15 border border-fn-blue/25 flex items-center justify-center text-base shrink-0">
                                🧾</div>
                            <h2 class="text-base font-bold tracking-tight">Document Generators</h2>
                            <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-xs font-mono">7</span>
                            <div class="flex-1 h-px bg-fn-text/7"></div>
                        </div>
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">

                            <a href="/tools/invoice-generator"
                                class="tool-card accent-doc bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="doc" data-tags="popular" data-name="invoice pdf generator create invoice">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    🧾</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Invoice Generator</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Create professional PDF invoices in
                                        seconds. Branded & print-ready.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/contract-generator"
                                class="tool-card accent-doc bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="doc" data-tags="" data-name="contract generator pdf template">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    📃</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Contract Generator</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Generate NDA, freelance, and service
                                        contracts as ready-to-sign PDFs.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/receipt-generator"
                                class="tool-card accent-doc bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="doc" data-tags="new" data-name="receipt generator pdf">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    🧾</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">Receipt Generator</h3>
                                        <span
                                            class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Create professional payment receipts as
                                        downloadable PDFs instantly.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/report-generator"
                                class="tool-card accent-doc bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="doc" data-tags="api" data-name="report generator pdf business report">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    📊</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">Report Generator</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Turn structured data into professional
                                        PDF reports via API or UI.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                        </div>
                    </div>

                    <!-- ─── SECTION: Word & Docs ─── -->
                    <div class="tool-section mb-10" data-section="word">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-8 h-8 rounded-lg bg-fn-blue-l/15 border border-fn-blue-l/25 flex items-center justify-center text-base shrink-0">
                                📝</div>
                            <h2 class="text-base font-bold tracking-tight">Word & Document Tools</h2>
                            <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-xs font-mono">9</span>
                            <div class="flex-1 h-px bg-fn-text/7"></div>
                        </div>
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">

                            <a href="/tools/docx-to-pdf"
                                class="tool-card accent-word bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="word" data-tags="popular" data-name="word docx to pdf converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    📝</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">DOCX to PDF</h3>
                                        <span
                                            class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert Word documents to pixel-perfect
                                        PDFs with all styles intact.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/docx-to-txt"
                                class="tool-card accent-word bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="word" data-tags="" data-name="word docx to txt text extractor">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    📋</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">DOCX to TXT</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Extract plain text from Word documents,
                                        stripping all formatting.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/txt-to-pdf"
                                class="tool-card accent-word bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="word" data-tags="" data-name="text txt to pdf converter">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    📄</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm leading-snug mb-1">TXT to PDF</h3>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Convert plain text files into clean,
                                        readable PDF documents.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                            <a href="/tools/html-to-pdf"
                                class="tool-card accent-word bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                                data-cat="word" data-tags="api new" data-name="html to pdf converter webpage">
                                <div
                                    class="w-10 h-10 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-lg shrink-0">
                                    🌐</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h3 class="font-semibold text-sm leading-snug">HTML to PDF</h3>
                                        <span
                                            class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                    </div>
                                    <p class="text-fn-text3 text-xs leading-relaxed">Render any HTML file or URL as a
                                        high-fidelity PDF document.</p>
                                </div>
                                <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7" />
                                    <polyline points="7 7 17 7 17 17" />
                                </svg>
                            </a>

                        </div>
                    </div>



                </main>
            </div>
        </div>


        <script>
            const allCards = document.querySelectorAll('.tool-card');
            const sections = document.querySelectorAll('.tool-section');
            const resultCount = document.getElementById('result-count');
            const mobileCount = document.getElementById('mobile-count');
            const emptyState  = document.getElementById('empty-state');
            const searchInput = document.getElementById('global-search');
            const searchCount = document.getElementById('search-count');

            // ── Category filter ──
            document.querySelectorAll('.cat-item').forEach(btn => {
              btn.addEventListener('click', () => {
                document.querySelectorAll('.cat-item').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterTools();
              });
            });

            // ── Search ──
            searchInput.addEventListener('input', filterTools);

            // ── Cmd+K focus ──
            document.addEventListener('keydown', e => {
              if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
              }
            });

            function filterTools() {
              const query      = searchInput.value.toLowerCase().trim();
              const activeCat  = document.querySelector('.cat-item.active')?.dataset.cat || 'all';
              const showNew    = document.getElementById('filter-new').checked;
              const showPop    = document.getElementById('filter-popular').checked;
              const showApi    = document.getElementById('filter-api').checked;

              let visible = 0;

              allCards.forEach(card => {
                const cat    = card.dataset.cat || '';
                const tags   = card.dataset.tags || '';
                const name   = card.dataset.name || '';

                const catMatch   = activeCat === 'all' || cat === activeCat;
                const queryMatch = !query || name.includes(query);
                const newMatch   = !showNew    || tags.includes('new');
                const popMatch   = !showPop    || tags.includes('popular');
                const apiMatch   = !showApi    || tags.includes('api');

                const show = catMatch && queryMatch && newMatch && popMatch && apiMatch;
                card.classList.toggle('hidden-card', !show);
                if (show) visible++;
              });

              // Hide/show sections based on whether they have visible cards
              sections.forEach(sec => {
                const hasCat  = activeCat === 'all' || sec.dataset.section === activeCat;
                const hasVis  = [...sec.querySelectorAll('.tool-card')].some(c => !c.classList.contains('hidden-card'));
                sec.style.display = (hasCat && hasVis) ? '' : 'none';
              });

              // Update counts
              const countText = `Showing <strong class="text-fn-text font-semibold">${visible}</strong> tool${visible !== 1 ? 's' : ''}`;
              if (resultCount) resultCount.innerHTML = countText;
              if (mobileCount) mobileCount.textContent = `Showing ${visible} tools`;

              // Search feedback
              if (query && searchCount) {
                searchCount.textContent = `${visible} result${visible !== 1 ? 's' : ''} for "${query}"`;
              } else if (searchCount) {
                searchCount.textContent = '';
              }

              // Empty state
              emptyState.classList.toggle('visible', visible === 0);
            }

            // ── Filter checkboxes ──
            ['filter-new','filter-popular','filter-api','filter-free'].forEach(id => {
              document.getElementById(id).addEventListener('change', filterTools);
            });

            // ── Clear search ──
            function clearSearch() {
              searchInput.value = '';
              filterTools();
              searchInput.focus();
            }

            // ── Mobile filter drawer ──
            const overlay = document.createElement('div');
            overlay.className = 'filter-overlay';
            document.body.appendChild(overlay);

            const drawer = document.createElement('div');
            drawer.className = 'filter-drawer p-6';
            drawer.innerHTML = document.querySelector('aside').innerHTML;
            document.body.appendChild(drawer);

            document.getElementById('mobile-filter-btn')?.addEventListener('click', () => {
              overlay.classList.add('open');
              drawer.classList.add('open');
            });
            overlay.addEventListener('click', () => {
              overlay.classList.remove('open');
              drawer.classList.remove('open');
            });
        </script>
@endsection

