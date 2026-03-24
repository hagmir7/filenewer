@extends('layouts.base')

@section('content')

<!-- ══════════════════════ HERO ══════════════════════ -->
<section id="hero" class="relative pt-10 pb-10 text-center overflow-hidden hero-glow hero-grid">
    <div class="max-w-6xl mx-auto px-6 relative z-10">



        <!-- Badge -->
        <div
            class="animate-fade-up opacity-0 delay-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-purple-500/40 bg-purple-500/10 text-purple-400 text-xs font-semibold tracking-wide uppercase mb-7">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse-dot"></span>
            Free Image Tool
        </div>

        <!-- H1 -->
        <h1
            class="animate-fade-up opacity-0 delay-1 text-4xl sm:text-5xl lg:text-[4rem] font-bold tracking-[-0.035em] leading-[1.1] max-w-3xl mx-auto mb-5">
            Compress Images<br />Up to <span class="text-gradient">90% Smaller</span>
        </h1>

        <!-- Sub -->
        <p class="animate-fade-up opacity-0 delay-2 text-fn-text2 text-lg max-w-xl mx-auto mb-10 leading-relaxed">
            Reduce JPG, PNG, and WebP file sizes without visible quality loss. Drag, drop, done — bulk compress up to 20
            images at once, right in your browser.
        </p>

        <!-- Benefit pills -->
        <div class="animate-fade-up opacity-0 delay-3 flex flex-wrap justify-center gap-x-7 gap-y-3">
            <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                JPG · PNG · WebP
            </div>
            <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Bulk compress 20 images
            </div>
            <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Adjustable quality slider
            </div>
            <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                100% processed in browser
            </div>
        </div>

    </div>
</section>

<!-- ══════════════════════ TOOL ══════════════════════ -->
<section id="tool" class="py-16 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="tool-heading">
    <div class="max-w-5xl mx-auto px-6">
        <h2 id="tool-heading" class="sr-only">Image Compressor Tool</h2>

        <!-- ─ Options Bar ─ -->
        <div class="flex flex-wrap items-center gap-5 mb-6 bg-fn-bg border border-white/[0.07] rounded-2xl px-6 py-4">

            <!-- Quality Slider -->
            <div class="flex items-center gap-3 flex-1 min-w-[200px]">
                <label class="text-fn-text3 text-xs font-medium whitespace-nowrap">Quality</label>
                <input id="quality-slider" type="range" min="10" max="100" value="82"
                    class="flex-1 accent-purple-500 cursor-pointer h-1.5 rounded-full" />
                <span id="quality-val" class="text-fn-text2 text-xs font-mono font-semibold w-8 text-right">82%</span>
            </div>

            <!-- Output Format -->
            <div class="flex items-center gap-2">
                <label class="text-fn-text3 text-xs font-medium whitespace-nowrap">Output</label>
                <select id="output-format"
                    class="bg-fn-surface border border-white/[0.07] text-fn-text2 text-xs font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-purple-500/50 cursor-pointer">
                    <option value="original">Same as input</option>
                    <option value="image/jpeg">Force JPG</option>
                    <option value="image/png">Force PNG</option>
                    <option value="image/webp">Force WebP</option>
                </select>
            </div>

            <!-- Max dimension -->
            <div class="flex items-center gap-2">
                <label class="text-fn-text3 text-xs font-medium whitespace-nowrap">Max Width/Height</label>
                <select id="max-dim"
                    class="bg-fn-surface border border-white/[0.07] text-fn-text2 text-xs font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-purple-500/50 cursor-pointer">
                    <option value="0">No resize</option>
                    <option value="3840">4K (3840px)</option>
                    <option value="1920">1080p (1920px)</option>
                    <option value="1280">720p (1280px)</option>
                    <option value="800">800px</option>
                    <option value="400">400px (thumbnail)</option>
                </select>
            </div>

            <!-- Download All -->
            <button id="download-all-btn" disabled
                class="ml-auto inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 hover:-translate-y-0.5 transition-all disabled:opacity-30 disabled:cursor-not-allowed disabled:translate-y-0">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Download All
            </button>

        </div>

        <!-- ─ Drop Zone ─ -->
        <div id="drop-zone"
            class="relative border-2 border-dashed border-white/[0.10] rounded-2xl bg-fn-bg transition-all duration-200 cursor-pointer hover:border-purple-500/50 hover:bg-purple-500/[0.03] group"
            role="button" aria-label="Upload images">

            <!-- Empty state -->
            <div id="drop-empty" class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <div
                    class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-5 bg-purple-500/10 border border-purple-500/20 group-hover:border-purple-500/40 transition-colors">
                    🖼️</div>
                <p class="text-fn-text2 font-semibold text-base mb-2">Drop images here or click to browse</p>
                <p class="text-fn-text3 text-sm mb-5">Supports JPG, PNG, WebP · Up to 20 images · Max 25 MB each</p>
                <label for="file-input"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all cursor-pointer">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    Select Images
                </label>
            </div>

            <!-- Results grid (shown after upload) -->
            <div id="results-grid" class="hidden p-5">

                <!-- Stats bar -->
                <div id="stats-bar" class="flex flex-wrap items-center gap-5 mb-5 px-1">
                    <div class="flex items-center gap-2">
                        <span class="text-fn-text3 text-xs">Images:</span>
                        <span id="stat-count" class="text-fn-text2 text-xs font-mono font-semibold">0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-fn-text3 text-xs">Original:</span>
                        <span id="stat-original" class="text-fn-text2 text-xs font-mono font-semibold">0 KB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-fn-text3 text-xs">Compressed:</span>
                        <span id="stat-compressed" class="text-fn-text2 text-xs font-mono font-semibold">0 KB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-fn-text3 text-xs">Saved:</span>
                        <span id="stat-saved" class="text-fn-green text-xs font-mono font-bold">0%</span>
                    </div>
                    <div class="ml-auto flex items-center gap-2">
                        <button id="add-more-btn"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add More
                        </button>
                        <button id="clear-all-btn"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 transition-all">
                            Clear All
                        </button>
                    </div>
                </div>

                <!-- Cards -->
                <div id="image-cards" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>

            </div>

            <input type="file" id="file-input" accept="image/jpeg,image/png,image/webp" multiple class="hidden" />
        </div>

        <!-- Processing indicator -->
        <div id="processing-bar"
            class="hidden mt-4 flex items-center gap-3 px-5 py-3 bg-fn-bg border border-white/[0.07] rounded-xl">
            <svg class="animate-spin w-4 h-4 text-purple-400 flex-shrink-0" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
            </svg>
            <span class="text-fn-text2 text-xs font-medium">Compressing images…</span>
            <span id="progress-text" class="text-fn-text3 text-xs font-mono ml-auto">0 / 0</span>
        </div>

    </div>
</section>

<!-- ══════════════════════ HOW IT WORKS ══════════════════════ -->
<section id="how" class="py-24 bg-fn-bg" aria-labelledby="how-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">Simple Process</p>
            <h2 id="how-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Three steps to smaller
                images</h2>
            <p class="text-fn-text2 text-lg max-w-lg mx-auto leading-relaxed">No accounts, no uploads to servers.
                Everything runs right in your browser — fast, private, and free.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-px border border-white/[0.07] rounded-2xl overflow-hidden">

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">01</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-purple-500/10 border border-purple-500/25">
                    📂</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Upload Your Images</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Drag and drop up to 20 JPG, PNG, or WebP files at once.
                    Or click to open a file picker. All formats accepted up to 25 MB each.</p>
            </div>

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">02</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-blue/10 border border-fn-blue/25">
                    🎚️</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Set Quality &amp; Options</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Dial in your target quality (10–100%), choose an output
                    format, and optionally cap the maximum width or height for resizing.</p>
            </div>

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">03</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-green/10 border border-fn-green/25">
                    ⬇️</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Download Compressed Files</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Download images individually or grab everything as a
                    single ZIP. See exactly how much space you saved per image before downloading.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ FEATURES ══════════════════════ -->
<section id="features" class="py-24 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="features-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-16">
            <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">What's Included</p>
            <h2 id="features-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Built for web
                performance and bulk workflows</h2>
            <p class="text-fn-text2 text-lg max-w-lg leading-relaxed">Whether you're optimizing a single hero image or a
                folder of product photos, Filenewer handles it.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-purple-500/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">📦</div>
                <h3 class="font-semibold text-base mb-2">Bulk Compression</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Process up to 20 images in one go. Drag a whole folder,
                    adjust quality once, and download everything. No repetitive single-file uploads.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-purple-500/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🎚️</div>
                <h3 class="font-semibold text-base mb-2">Adjustable Quality</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Slide between 10% and 100% quality. The tool shows
                    real-time before/after file sizes so you can find the perfect compression/quality balance.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-purple-500/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🔄</div>
                <h3 class="font-semibold text-base mb-2">Format Conversion</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Convert between JPG, PNG, and WebP on the fly. Force
                    all outputs to WebP for maximum web performance with the same visual quality.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-purple-500/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">📐</div>
                <h3 class="font-semibold text-base mb-2">Smart Resizing</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Cap images at a max dimension (e.g. 1920px) while
                    preserving aspect ratio. Ideal for creating web-ready thumbnails or reducing oversized camera
                    photos.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-purple-500/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">👁️</div>
                <h3 class="font-semibold text-base mb-2">Before/After Preview</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Each image card shows a thumbnail, original size,
                    compressed size, and percentage saved at a glance — so you know exactly what you're getting.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-purple-500/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🔒</div>
                <h3 class="font-semibold text-base mb-2">Fully Private</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">All compression happens in your browser using the
                    Canvas API. Your images never leave your device — no uploads, no storage, no privacy risk.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ FAQ ══════════════════════ -->
<section id="faq" class="py-24 bg-fn-bg" aria-labelledby="faq-heading">
    <div class="max-w-3xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">FAQ</p>
            <h2 id="faq-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Common questions</h2>
        </div>

        <div class="flex flex-col gap-3">

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    What image formats are supported?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">Input supports JPG/JPEG, PNG, and WebP. You
                    can also convert between these formats on output — for example, uploading a PNG and downloading it
                    as a compressed WebP for better web performance.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Will I notice any quality loss?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">At quality settings of 75–85%, compression is
                    virtually indistinguishable to the naked eye on most images, while reducing file size by 40–80%.
                    Below 60%, you may notice softening on fine textures. The default setting of 82% is optimized for
                    this balance.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Are my images uploaded to your servers?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">No. Compression is performed entirely in your
                    browser using the HTML5 Canvas API and the File API. Your images are never sent to Filenewer's
                    servers — they stay on your device at all times.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Why does my PNG get larger after compression?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">PNG uses lossless compression, so applying
                    JPEG-style quality reduction and re-encoding can sometimes result in a larger or equal size for
                    already-optimized PNGs. The best approach for PNGs is to convert them to WebP or JPG instead, which
                    you can do with the Output Format option.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Can I compress more than 20 images at once?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">The free tool supports up to 20 images per
                    session. For unlimited bulk processing, automated pipelines, or API access for integrating
                    compression into your workflow, upgrade to a Pro account.</p>
            </details>

        </div>
    </div>
</section>

<!-- ══════════════════════ RELATED TOOLS ══════════════════════ -->
<x-tools-section />

<!-- ══════════════════════ CTA ══════════════════════ -->
<section id="cta" class="py-24 bg-fn-surface border-y border-white/[0.07] text-center relative overflow-hidden"
    aria-labelledby="cta-heading">
    <div
        class="absolute top-[-300px] left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-[radial-gradient(ellipse_at_center,rgba(37,99,235,0.14)_0%,transparent_65%)] pointer-events-none">
    </div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">Get More</p>
        <h2 id="cta-heading" class="text-3xl sm:text-4xl font-bold tracking-tight max-w-2xl mx-auto mb-4">Need unlimited
            bulk compression or API access?</h2>
        <p class="text-fn-text2 text-lg max-w-md mx-auto leading-relaxed mb-10">
            Upgrade to Pro for unlimited images per batch, automated compression pipelines, and a REST API for your own
            applications.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="/signup"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-white bg-fn-blue rounded-xl hover:bg-fn-blue-l btn-glow hover:-translate-y-0.5 transition-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                </svg>
                Start Free — No Sign-up Needed
            </a>
            <a href="/pricing"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] transition-all">
                View Pro Plans
            </a>
        </div>
        <p class="text-fn-text3 text-xs mt-5">✓ Free to use &nbsp;·&nbsp; ✓ No uploads to server &nbsp;·&nbsp; ✓ No
            account needed</p>
    </div>
</section>

<!-- ══════════════════════ SCRIPT ══════════════════════ -->
@push('scripts')
{{-- JSZip for Download All --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
    (function () {

    // ── DOM refs ──────────────────────────────────────────────
    const dropZone       = document.getElementById('drop-zone');
    const fileInput      = document.getElementById('file-input');
    const dropEmpty      = document.getElementById('drop-empty');
    const resultsGrid    = document.getElementById('results-grid');
    const imageCards     = document.getElementById('image-cards');
    const processingBar  = document.getElementById('processing-bar');
    const progressText   = document.getElementById('progress-text');
    const downloadAllBtn = document.getElementById('download-all-btn');
    const clearAllBtn    = document.getElementById('clear-all-btn');
    const addMoreBtn     = document.getElementById('add-more-btn');
    const qualitySlider  = document.getElementById('quality-slider');
    const qualityVal     = document.getElementById('quality-val');
    const outputFormat   = document.getElementById('output-format');
    const maxDimSel      = document.getElementById('max-dim');
    const statCount      = document.getElementById('stat-count');
    const statOriginal   = document.getElementById('stat-original');
    const statCompressed = document.getElementById('stat-compressed');
    const statSaved      = document.getElementById('stat-saved');

    const MAX_FILES = 20;
    const MAX_BYTES = 25 * 1024 * 1024; // 25 MB

    // ── State ─────────────────────────────────────────────────
    // { id, file, originalSize, compressedBlob, compressedSize, status: 'pending'|'done'|'error' }
    let items = [];
    let idCounter = 0;

    // ── Helpers ───────────────────────────────────────────────
    function fmtSize(bytes) {
        if (bytes < 1024)       return bytes + ' B';
        if (bytes < 1024*1024)  return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024*1024)).toFixed(2) + ' MB';
    }

    function fmtPct(orig, comp) {
        if (!orig) return '0%';
        const saved = ((orig - comp) / orig) * 100;
        return (saved >= 0 ? '−' : '+') + Math.abs(saved).toFixed(1) + '%';
    }

    function savedColor(orig, comp) {
        const pct = orig ? ((orig - comp) / orig) * 100 : 0;
        if (pct >= 40) return 'text-fn-green';
        if (pct >= 10) return 'text-fn-amber';
        return 'text-fn-text3';
    }

    function getOutputMime(file) {
        const fmt = outputFormat.value;
        if (fmt === 'original') return file.type || 'image/jpeg';
        return fmt;
    }

    function getExt(mime) {
        return { 'image/jpeg': 'jpg', 'image/png': 'png', 'image/webp': 'webp' }[mime] || 'jpg';
    }

    function stemName(filename, mime) {
        const dot = filename.lastIndexOf('.');
        const stem = dot > 0 ? filename.slice(0, dot) : filename;
        return stem + '_compressed.' + getExt(mime);
    }

    // ── Compress single image ─────────────────────────────────
    function compressImage(file) {
        return new Promise((resolve, reject) => {
            const mime    = getOutputMime(file);
            const quality = parseInt(qualitySlider.value) / 100;
            const maxDim  = parseInt(maxDimSel.value) || 0;

            const img = new Image();
            const url = URL.createObjectURL(file);
            img.onload = () => {
                URL.revokeObjectURL(url);
                let { width, height } = img;

                // Resize if needed
                if (maxDim > 0 && (width > maxDim || height > maxDim)) {
                    if (width >= height) { height = Math.round(height * maxDim / width); width = maxDim; }
                    else                 { width  = Math.round(width  * maxDim / height); height = maxDim; }
                }

                const canvas = document.createElement('canvas');
                canvas.width = width; canvas.height = height;
                const ctx = canvas.getContext('2d');
                // White bg for JPG (no transparency)
                if (mime === 'image/jpeg') { ctx.fillStyle = '#ffffff'; ctx.fillRect(0,0,width,height); }
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(blob => {
                    if (blob) resolve(blob);
                    else reject(new Error('Compression failed'));
                }, mime, quality);
            };
            img.onerror = () => { URL.revokeObjectURL(url); reject(new Error('Could not load image')); };
            img.src = url;
        });
    }

    // ── Render card ───────────────────────────────────────────
    function renderCard(item) {
        let existing = imageCards.querySelector(`[data-id="${item.id}"]`);
        if (!existing) {
            existing = document.createElement('div');
            existing.dataset.id = item.id;
            imageCards.appendChild(existing);
        }

        existing.className = 'bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden hover:border-white/[0.14] transition-colors';

        if (item.status === 'pending') {
            existing.innerHTML = `
                <div class="aspect-video bg-fn-bg flex items-center justify-center">
                    <svg class="animate-spin w-5 h-5 text-purple-400" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                </div>
                <div class="p-4">
                    <p class="text-fn-text2 text-xs font-medium truncate mb-1">${escHtml(item.file.name)}</p>
                    <p class="text-fn-text3 text-xs">Compressing…</p>
                </div>`;
            return;
        }

        if (item.status === 'error') {
            existing.innerHTML = `
                <div class="aspect-video bg-fn-bg flex items-center justify-center text-fn-red text-2xl">⚠️</div>
                <div class="p-4">
                    <p class="text-fn-text2 text-xs font-medium truncate mb-1">${escHtml(item.file.name)}</p>
                    <p class="text-fn-red text-xs">Failed to compress</p>
                </div>`;
            return;
        }

        // Done
        const thumbUrl = URL.createObjectURL(item.compressedBlob);
        const sc = savedColor(item.originalSize, item.compressedSize);
        existing.innerHTML = `
            <div class="aspect-video bg-fn-bg overflow-hidden">
                <img src="${thumbUrl}" alt="${escHtml(item.file.name)}" class="w-full h-full object-contain" loading="lazy" />
            </div>
            <div class="p-4">
                <p class="text-fn-text2 text-xs font-medium truncate mb-2">${escHtml(item.file.name)}</p>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3 text-xs font-mono">
                        <span class="text-fn-text3">${fmtSize(item.originalSize)}</span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-text3"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        <span class="text-fn-text2 font-semibold">${fmtSize(item.compressedSize)}</span>
                    </div>
                    <span class="text-xs font-bold font-mono ${sc}">${fmtPct(item.originalSize, item.compressedSize)}</span>
                </div>
                <!-- Savings bar -->
                <div class="w-full bg-fn-bg rounded-full h-1 mb-3 overflow-hidden">
                    <div class="h-1 rounded-full bg-fn-green transition-all" style="width:${Math.max(0, Math.min(100, ((item.originalSize - item.compressedSize) / item.originalSize) * 100)).toFixed(1)}%"></div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="download-single flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] transition-all" data-id="${item.id}">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download
                    </button>
                    <button class="remove-item inline-flex items-center justify-center w-8 h-8 text-fn-text3 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 transition-all" data-id="${item.id}">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            </div>`;
    }

    function escHtml(s) {
        return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ── Update global stats ───────────────────────────────────
    function updateStats() {
        const done  = items.filter(i => i.status === 'done');
        const origTotal = items.reduce((s, i) => s + i.originalSize, 0);
        const compTotal = done.reduce((s, i) => s + i.compressedSize, 0);
        const pct = origTotal > 0 ? ((origTotal - compTotal) / origTotal * 100).toFixed(1) : 0;

        statCount.textContent      = items.length;
        statOriginal.textContent   = fmtSize(origTotal);
        statCompressed.textContent = fmtSize(compTotal);
        statSaved.textContent      = `−${pct}%`;

        downloadAllBtn.disabled = done.length === 0;
    }

    // ── Process files ─────────────────────────────────────────
    async function processFiles(files) {
        const allowed = Array.from(files).filter(f =>
            ['image/jpeg','image/png','image/webp'].includes(f.type) && f.size <= MAX_BYTES
        );

        const available = MAX_FILES - items.length;
        const toProcess = allowed.slice(0, available);
        if (!toProcess.length) return;

        // Show results view
        dropEmpty.classList.add('hidden');
        resultsGrid.classList.remove('hidden');
        processingBar.classList.remove('hidden');

        // Register items
        toProcess.forEach(file => {
            const id = ++idCounter;
            items.push({ id, file, originalSize: file.size, compressedBlob: null, compressedSize: 0, status: 'pending' });
            renderCard(items.at(-1));
        });
        updateStats();

        // Compress sequentially
        let done = 0;
        for (const item of items.filter(i => i.status === 'pending')) {
            progressText.textContent = `${++done} / ${toProcess.length}`;
            try {
                const blob = await compressImage(item.file);
                item.compressedBlob = blob;
                item.compressedSize = blob.size;
                item.status = 'done';
            } catch (e) {
                item.status = 'error';
            }
            renderCard(item);
            updateStats();
        }

        processingBar.classList.add('hidden');
    }

    // ── Recompress all on settings change ─────────────────────
    async function recompressAll() {
        if (!items.length) return;
        processingBar.classList.remove('hidden');
        let done = 0;
        for (const item of items) {
            item.status = 'pending';
            renderCard(item);
            progressText.textContent = `${++done} / ${items.length}`;
            try {
                const blob = await compressImage(item.file);
                item.compressedBlob = blob;
                item.compressedSize = blob.size;
                item.status = 'done';
            } catch (e) { item.status = 'error'; }
            renderCard(item);
            updateStats();
        }
        processingBar.classList.add('hidden');
    }

    // ── Download single ───────────────────────────────────────
    function downloadSingle(id) {
        const item = items.find(i => i.id === id);
        if (!item || !item.compressedBlob) return;
        const mime = getOutputMime(item.file);
        const a = document.createElement('a');
        a.href = URL.createObjectURL(item.compressedBlob);
        a.download = stemName(item.file.name, mime);
        a.click();
        URL.revokeObjectURL(a.href);
    }

    // ── Download all as ZIP ───────────────────────────────────
    async function downloadAll() {
        const done = items.filter(i => i.status === 'done');
        if (!done.length) return;
        const zip = new JSZip();
        done.forEach(item => {
            const mime = getOutputMime(item.file);
            zip.file(stemName(item.file.name, mime), item.compressedBlob);
        });
        const blob = await zip.generateAsync({ type: 'blob' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'compressed-images.zip';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    // ── Remove item ───────────────────────────────────────────
    function removeItem(id) {
        items = items.filter(i => i.id !== id);
        const card = imageCards.querySelector(`[data-id="${id}"]`);
        if (card) card.remove();
        updateStats();
        if (!items.length) {
            dropEmpty.classList.remove('hidden');
            resultsGrid.classList.add('hidden');
        }
    }

    // ── Clear all ─────────────────────────────────────────────
    function clearAll() {
        items = [];
        imageCards.innerHTML = '';
        dropEmpty.classList.remove('hidden');
        resultsGrid.classList.add('hidden');
        downloadAllBtn.disabled = true;
        updateStats();
    }

    // ── Event listeners ───────────────────────────────────────
    // Drop zone click → file input
    dropZone.addEventListener('click', (e) => {
        if (e.target.closest('button') || e.target.closest('a') || e.target.closest('.download-single') || e.target.closest('.remove-item')) return;
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) processFiles(fileInput.files);
        fileInput.value = '';
    });

    // Drag & drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-purple-500/60', 'bg-purple-500/[0.04]');
    });
    dropZone.addEventListener('dragleave', (e) => {
        if (!dropZone.contains(e.relatedTarget)) {
            dropZone.classList.remove('border-purple-500/60', 'bg-purple-500/[0.04]');
        }
    });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-purple-500/60', 'bg-purple-500/[0.04]');
        if (e.dataTransfer.files.length) processFiles(e.dataTransfer.files);
    });

    // Card delegation
    imageCards.addEventListener('click', (e) => {
        const dl  = e.target.closest('.download-single');
        const rem = e.target.closest('.remove-item');
        if (dl)  downloadSingle(parseInt(dl.dataset.id));
        if (rem) removeItem(parseInt(rem.dataset.id));
    });

    // Options — re-compress
    let recompressDebounce;
    qualitySlider.addEventListener('input', () => {
        qualityVal.textContent = qualitySlider.value + '%';
        clearTimeout(recompressDebounce);
        recompressDebounce = setTimeout(recompressAll, 400);
    });
    outputFormat.addEventListener('change', recompressAll);
    maxDimSel.addEventListener('change', recompressAll);

    // Buttons
    downloadAllBtn.addEventListener('click', downloadAll);
    clearAllBtn.addEventListener('click', clearAll);
    addMoreBtn.addEventListener('click', () => fileInput.click());

})();
</script>
@endpush

@endsection
