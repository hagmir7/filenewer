@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Upload PDF'],['2','Splitting'],['3','Download']] as [$n, $label])
                <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-2" id="step-{{ $n }}">
                    <div
                        class="step-dot w-6 h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                        <span class="text-sm font-bold">{{ $n }}</span>
                    </div>
                    <span class="step-label text-sm font-semibold text-fn-text3 transition-colors">{{ $label }}</span>
                </div>
                @if($n !== '3')
                <div class="w-10 h-px bg-fn-text/10 mx-2"></div>
                @endif
                @endforeach
            </div>

            <div class="p-8 lg:p-10">

                {{-- ── STATE: Upload ── --}}
                <div id="state-upload">

                    {{-- Drop zone --}}
                    <div id="drop-zone"
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                        <div class="flex items-center justify-center mb-5">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-4xl">
                                📕</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-6">or click to browse from your computer</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                        <input type="file" id="file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.pdf</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">—</p>
                        </div>
                        <button type="button" id="remove-file"
                            class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    {{-- Split mode selector --}}
                    <div class="mt-5">
                        <label class="text-sm font-semibold text-fn-text2 block mb-3">Split Mode</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach([
                            ['page', '📄', 'Every page', 'One PDF per page'],
                            ['chunk', '📚', 'Every N pages', 'Groups of N pages'],
                            ['range', '📏', 'Page ranges', 'Custom ranges like 1-3, 4-6'],
                            ['pages', '🎯', 'Specific pages','Individual pages like 1, 3, 5'],
                            ] as [$mval, $micon, $mname, $mdesc])
                            <button type="button"
                                class="mode-card {{ $mval === 'page' ? 'active' : '' }} flex flex-col items-start gap-1 p-3 rounded-xl border text-left transition-all"
                                data-mode="{{ $mval }}">
                                <div class="flex items-center gap-1.5 w-full">
                                    <span class="text-base">{{ $micon }}</span>
                                    <span class="text-sm font-bold">{{ $mname }}</span>
                                </div>
                                <span class="text-xs leading-tight opacity-70">{{ $mdesc }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mode-specific options --}}
                    <div class="mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">

                        {{-- Page mode (no extra options) --}}
                        <div id="mode-opts-page" class="mode-opts">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-fn-blue-l">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="16" x2="12" y2="12" />
                                        <line x1="12" y1="8" x2="12.01" y2="8" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-fn-text2">Every page as a separate PDF</p>
                                    <p class="text-xs text-fn-text3 mt-0.5">A 10-page PDF becomes 10 separate files in a
                                        zip archive.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Chunk mode --}}
                        <div id="mode-opts-chunk" class="mode-opts hidden">
                            <label for="opt-chunk" class="text-xs font-semibold text-fn-text2 block mb-2">
                                Chunk Size — <span id="chunk-val" class="text-fn-blue-l">3</span> pages per file
                            </label>
                            <input type="range" id="opt-chunk" min="1" max="50" value="3" step="1"
                                class="w-full accent-fn-blue cursor-pointer mb-2" />
                            <div class="flex justify-between text-fn-text3 text-xs">
                                <span>1</span><span>10</span><span>25</span><span>50</span>
                            </div>
                            <p class="text-xs text-fn-text3 mt-2">
                                A 10-page PDF with chunk size <span id="chunk-example">3</span> produces
                                <span id="chunk-result" class="font-bold text-fn-text2">4 files</span>
                                (<span id="chunk-breakdown">3+3+3+1</span> pages).
                            </p>
                        </div>

                        {{-- Range mode --}}
                        <div id="mode-opts-range" class="mode-opts hidden">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-fn-text2">Page Ranges</label>
                                <button type="button" id="btn-add-range"
                                    class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-blue-l hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                    Add range
                                </button>
                            </div>
                            <div id="ranges-list" class="space-y-2"></div>
                            <p class="text-xs text-fn-text3 mt-2">Each range becomes one output file. Page numbers are
                                1-based.</p>
                        </div>

                        {{-- Pages mode --}}
                        <div id="mode-opts-pages" class="mode-opts hidden">
                            <label for="opt-pages" class="text-xs font-semibold text-fn-text2 block mb-2">
                                Specific Pages
                            </label>
                            <input type="text" id="opt-pages" placeholder="1, 3, 5, 7"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <p class="text-xs text-fn-text3 mt-2">Comma-separated page numbers. Each page becomes its
                                own PDF.</p>
                        </div>

                    </div>

                    {{-- Password (for encrypted PDFs) --}}
                    <div class="mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl max-w-sm">
                        <label for="opt-password" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                            PDF Password
                            <span class="font-normal text-fn-text3 ml-1">(if encrypted)</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="opt-password" placeholder="Leave blank if not protected"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <button type="button" id="toggle-password"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors">
                                <svg id="eye-show" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg id="eye-hide" class="hidden" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Error banner --}}
                    <div id="upload-error"
                        class="hidden mt-4 items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-fn-red shrink-0" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="error-text">Something went wrong.</span>
                    </div>

                    {{-- Convert button --}}
                    <button id="convert-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7" />
                            <path d="M12 3v12" />
                            <path d="M8 11l4 4 4-4" />
                        </svg>
                        Split PDF
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-3xl">
                            📕</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-3xl">
                            📦</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Splitting your PDF…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes just a few seconds</p>

                    <div class="max-w-md mx-auto mb-3">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-sm text-fn-text3 mb-8">
                        <span id="progress-label">Starting…</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>

                    <div class="max-w-xs mx-auto flex flex-col gap-3 text-left">
                        @foreach([
                        ['proc-1','Uploading & validating PDF'],
                        ['proc-2','Analysing page structure'],
                        ['proc-3','Generating split files'],
                        ['proc-4','Packaging into zip archive'],
                        ] as [$pid, $plabel])
                        <div class="flex items-center gap-3" id="{{ $pid }}">
                            <div
                                class="step-dot w-5 h-5 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center shrink-0 transition-all duration-300">
                                <svg class="check-icon hidden w-3 h-3 text-fn-green" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <svg class="spin-icon hidden w-3 h-3 text-fn-blue-l spin" viewBox="0 0 24 24"
                                    fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"
                                        stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round" />
                                </svg>
                            </div>
                            <span class="text-sm text-fn-text3">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Split Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6" id="result-subtitle">Your split PDFs are ready.</p>

                    {{-- Parts table --}}
                    <div id="parts-preview" class="hidden max-w-2xl mx-auto mb-6 text-left">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-semibold text-fn-text2">
                                <span id="parts-count">0</span> file<span id="parts-plural">s</span> generated
                            </p>
                            <span class="text-xs text-fn-text3" id="parts-total-size">—</span>
                        </div>
                        <div class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-auto max-h-64">
                            <table id="parts-table" class="w-full text-xs"></table>
                        </div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            📦</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">split_pages.zip</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">ZIP Archive</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="split_pages.zip"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download ZIP Archive
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Split another PDF
                        </button>
                    </div>

                    <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your file is encrypted and permanently deleted within 1 hour.
                    </p>
                </div>

            </div>{{-- /card body --}}
        </div>{{-- /card --}}
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @foreach([
            ['What are the different split modes?', 'Four modes: Every page (one PDF per page), Every N pages (groups of
            N), Page ranges (custom ranges like 1-3, 4-6), and Specific pages (individual pages like 1, 3, 5). Pick
            whichever matches how you want to break up your document.'],
            ['How do page ranges work?', 'Each range becomes one output PDF. For example, ranges 1-3, 4-6, 7-10 produce
            three files: pages 1-3 in the first, 4-6 in the second, and 7-10 in the third. Ranges can overlap if
            needed.'],
            ['Can I split an encrypted PDF?', 'Yes — enter the PDF password in the optional password field before
            splitting. The split output files will be plain (unencrypted).'],
            ['What if I specify a page number that doesn\'t exist?', 'The API will return an error if any page or range
            is out of bounds. Check your PDF\'s total page count first if you\'re unsure.'],
            ['Is my file safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ] as [$q, $a])
            <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                <button type="button"
                    class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left hover:bg-fn-surface2 transition-colors">
                    <span class="font-semibold text-sm">{{ $q }}</span>
                    <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div class="faq-body hidden px-5 pb-4">
                    <p class="text-fn-text2 text-sm leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<x-tools-content :tool="$tool" />

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ STYLES ══ --}}
<style>
    .mode-card {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text2);
    }

    .mode-card:hover {
        border-color: oklch(49% 0.24 264 / 30%);
        color: var(--fn-text);
    }

    .mode-card.active {
        border-color: oklch(49% 0.24 264 / 50%);
        background: oklch(49% 0.24 264 / 7%);
        color: var(--fn-text);
    }

    .range-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        background: var(--fn-surface);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        border-radius: 10px;
    }

    .range-row .range-order {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: oklch(49% 0.24 264 / 10%);
        color: var(--fn-blue-l);
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .range-row input[type="number"] {
        width: 72px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        color: var(--fn-text);
        font-size: 13px;
        font-family: monospace;
        border-radius: 6px;
        padding: 4px 8px;
        text-align: center;
    }

    .range-row input[type="number"]:focus {
        outline: none;
        border-color: oklch(49% 0.24 264 / 40%);
    }

    .range-row .range-dash {
        color: var(--fn-text3);
        font-weight: 600;
    }

    .range-row .range-pages {
        margin-left: auto;
        font-size: 11px;
        color: var(--fn-text3);
    }

    .range-row .range-remove {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface2);
        color: var(--fn-text3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .15s;
    }

    .range-row .range-remove:hover {
        color: var(--fn-red);
        border-color: oklch(62% 0.22 25 / 30%);
        background: oklch(62% 0.22 25 / 6%);
    }

    /* Parts table */
    #parts-table th {
        background: oklch(var(--fn-surface2-l, 22%) 0 0 / 1);
        padding: 6px 10px;
        text-align: left;
        font-weight: 700;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        font-size: 11px;
        white-space: nowrap;
    }

    #parts-table td {
        padding: 5px 10px;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 6%);
        font-size: 12px;
    }

    #parts-table td.num {
        font-family: monospace;
        color: var(--fn-text3);
        white-space: nowrap;
    }

    #parts-table td.fname {
        max-width: 280px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #parts-table tr:last-child td {
        border-bottom: none;
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  // ── Refs ──
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let selectedFile = null;
  let blobUrl      = null;
  let activeMode   = 'page';
  let ranges       = [[1, 3]]; // default range when switching to range mode

  // ── Mode selector ──
  document.querySelectorAll('.mode-card').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.mode-card').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeMode = btn.dataset.mode;

      // Show/hide options
      document.querySelectorAll('.mode-opts').forEach(el => el.classList.add('hidden'));
      document.getElementById('mode-opts-' + activeMode).classList.remove('hidden');

      // Initialize ranges if empty when switching to range mode
      if (activeMode === 'range' && ranges.length === 0) {
        ranges = [[1, 3]];
        renderRanges();
      }
      if (activeMode === 'range') renderRanges();

      refreshConvertBtn();
    });
  });

  // ── Chunk slider ──
  const chunkSlider = document.getElementById('opt-chunk');
  chunkSlider.addEventListener('input', () => {
    const n = parseInt(chunkSlider.value) || 1;
    document.getElementById('chunk-val').textContent = n;
    document.getElementById('chunk-example').textContent = n;
    // Calculate breakdown for 10-page example
    const example = 10;
    const fullChunks = Math.floor(example / n);
    const remainder  = example % n;
    const total      = fullChunks + (remainder > 0 ? 1 : 0);
    const breakdown  = Array(fullChunks).fill(n).concat(remainder > 0 ? [remainder] : []).join('+');
    document.getElementById('chunk-result').textContent = total + ' file' + (total !== 1 ? 's' : '');
    document.getElementById('chunk-breakdown').textContent = breakdown;
  });

  // ── Range mode ──
  document.getElementById('btn-add-range').addEventListener('click', () => {
    const last = ranges[ranges.length - 1];
    const nextStart = last ? last[1] + 1 : 1;
    ranges.push([nextStart, nextStart + 2]);
    renderRanges();
  });

  function renderRanges() {
    const list = document.getElementById('ranges-list');
    list.innerHTML = '';

    if (ranges.length === 0) {
      const empty = document.createElement('p');
      empty.className = 'text-xs text-fn-text3 italic';
      empty.textContent = 'Click "Add range" to create your first page range.';
      list.appendChild(empty);
      return;
    }

    ranges.forEach((rng, idx) => {
      const row = document.createElement('div');
      row.className = 'range-row';
      const pageCount = Math.max(0, (rng[1] ?? 0) - (rng[0] ?? 0) + 1);
      row.innerHTML = `
        <span class="range-order">${idx + 1}</span>
        <label class="text-xs text-fn-text3">From</label>
        <input type="number" min="1" value="${rng[0]}" class="range-from" />
        <span class="range-dash">–</span>
        <label class="text-xs text-fn-text3">to</label>
        <input type="number" min="1" value="${rng[1]}" class="range-to" />
        <span class="range-pages">${pageCount} page${pageCount !== 1 ? 's' : ''}</span>
        <button type="button" class="range-remove" title="Remove range">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>`;
      row.querySelector('.range-from').addEventListener('input', e => {
        ranges[idx][0] = parseInt(e.target.value) || 1;
        updateRangePages(row, ranges[idx]);
      });
      row.querySelector('.range-to').addEventListener('input', e => {
        ranges[idx][1] = parseInt(e.target.value) || 1;
        updateRangePages(row, ranges[idx]);
      });
      row.querySelector('.range-remove').addEventListener('click', () => {
        ranges.splice(idx, 1);
        renderRanges();
      });
      list.appendChild(row);
    });
  }

  function updateRangePages(row, rng) {
    const count = Math.max(0, (rng[1] ?? 0) - (rng[0] ?? 0) + 1);
    row.querySelector('.range-pages').textContent = count + ' page' + (count !== 1 ? 's' : '');
  }

  // ── Drag & drop ──
  ['dragenter', 'dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave', 'dragend', 'drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
  fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
  removeFile.addEventListener('click', e => { e.stopPropagation(); resetFile(); });

  function handleFile(file) {
    hideError();
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
      showError('Please select a valid PDF file.');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · PDF Document';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');
    refreshConvertBtn();
  }

  function resetFile() {
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    refreshConvertBtn();
    hideError();
  }

  function refreshConvertBtn() {
    convertBtn.disabled = !selectedFile;
  }

  // ── Password toggle ──
  document.getElementById('toggle-password').addEventListener('click', () => {
    const input  = document.getElementById('opt-password');
    const isPass = input.type === 'password';
    input.type   = isPass ? 'text' : 'password';
    document.getElementById('eye-show').classList.toggle('hidden', isPass);
    document.getElementById('eye-hide').classList.toggle('hidden', !isPass);
  });

  // ── Split ──
  convertBtn.addEventListener('click', startSplit);

  async function startSplit() {
    if (!selectedFile) return;
    hideError();

    // Validate mode-specific input
    if (activeMode === 'range' && ranges.length === 0) {
      showError('Please add at least one page range.');
      return;
    }
    if (activeMode === 'pages') {
      const pagesText = document.getElementById('opt-pages').value.trim();
      if (!pagesText) {
        showError('Please enter at least one page number.');
        return;
      }
    }

    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const fd = new FormData();
    fd.append('file',     selectedFile);
    fd.append('split_by', activeMode);
    fd.append('output',   'zip');

    if (activeMode === 'chunk') {
      fd.append('chunk_size', chunkSlider.value);
    } else if (activeMode === 'range') {
      fd.append('ranges', JSON.stringify(ranges));
    } else if (activeMode === 'pages') {
      const pages = document.getElementById('opt-pages').value
        .split(',')
        .map(s => parseInt(s.trim()))
        .filter(n => !isNaN(n) && n > 0);
      fd.append('pages', JSON.stringify(pages));
    }

    const password = document.getElementById('opt-password').value.trim();
    if (password) fd.append('password', password);

    // Also get JSON metadata in a second call so we can show parts table
    const metadataFd = new FormData();
    for (const [k, v] of fd.entries()) {
      if (k === 'output') metadataFd.append('output', 'json');
      else metadataFd.append(k, v);
    }

    // Animate
    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 600, 'Uploading & validating PDF…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 50, 700, 'Analysing page structure…');
    }, 700);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(50, 78, 900, 'Generating split files…');
    }, 1500);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 90, 600, 'Packaging into zip archive…');
    }, 2500);

    try {
      // Run file + metadata requests in parallel
      const [fileRes, metaRes] = await Promise.all([
        fetch('https://api.filenewer.com/api/tools/pdf-split', { method: 'POST', body: fd }),
        fetch('https://api.filenewer.com/api/tools/pdf-split', { method: 'POST', body: metadataFd }).catch(() => null),
      ]);

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!fileRes.ok) {
        let msg = 'Split failed. Please try again.';
        try { const d = await fileRes.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await fileRes.blob();

      // Parse metadata if available
      let metadata = null;
      if (metaRes && metaRes.ok) {
        try { metadata = await metaRes.json(); } catch(_) {}
      }

      const baseName     = selectedFile.name.replace(/\.pdf$/i, '');
      const zipFilename  = `${baseName}_split.zip`;

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link    = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = zipFilename;

      document.getElementById('output-name').textContent = zipFilename;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · ZIP Archive';

      // Render parts table from metadata
      if (metadata && metadata.parts) {
        renderPartsTable(metadata);
        document.getElementById('result-subtitle').textContent =
          `${metadata.total_parts} file${metadata.total_parts !== 1 ? 's' : ''} generated · split by ${metadata.split_by}.`;
      } else {
        document.getElementById('parts-preview').classList.add('hidden');
      }

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(90, 100, 300, 'Done!');

      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function renderPartsTable(metadata) {
    const wrap  = document.getElementById('parts-preview');
    const table = document.getElementById('parts-table');
    const parts = metadata.parts ?? [];

    document.getElementById('parts-count').textContent = parts.length;
    document.getElementById('parts-plural').textContent = parts.length === 1 ? '' : 's';

    const totalSizeKb = parts.reduce((sum, p) => sum + (p.size_kb || 0), 0);
    document.getElementById('parts-total-size').textContent = formatSizeKb(totalSizeKb) + ' total';

    table.innerHTML = `
      <thead>
        <tr>
          <th style="width:40px;">#</th>
          <th>Filename</th>
          <th style="width:80px; text-align:center;">Pages</th>
          <th style="width:100px; text-align:right;">Size</th>
        </tr>
      </thead>`;
    const tbody = document.createElement('tbody');
    parts.forEach(p => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="num">${p.index}</td>
        <td class="fname"></td>
        <td style="text-align:center; color:var(--fn-blue-l); font-weight:600;">${p.start_page === p.end_page ? 'p.' + p.start_page : p.start_page + '-' + p.end_page}</td>
        <td style="text-align:right; color:var(--fn-text3); font-family:monospace;">${formatSizeKb(p.size_kb || 0)}</td>`;
      tr.querySelector('.fname').textContent = p.filename;
      tr.querySelector('.fname').title = p.filename;
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);
    wrap.classList.remove('hidden');
  }

  // ── Helpers ──
  function scrollToCard() {
    // Scroll to the top of the converter card so user sees progress
    const card = document.querySelector('#state-converting')?.closest('.bg-fn-surface');
    if (card) {
      const top = card.getBoundingClientRect().top + window.pageYOffset - 80;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  }

  function showState(state) {
    ['upload', 'converting', 'download'].forEach(s => {
      document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
    });
    if (state === 'download') document.getElementById('state-download').classList.add('bounce-in');
  }

  function updateStepIndicator(active) {
    [1, 2, 3].forEach(n => {
      const el = document.getElementById('step-' + n);
      el.classList.remove('active', 'done');
      if (n < active)   el.classList.add('done');
      if (n === active) el.classList.add('active');
    });
  }

  function setProcessStep(id, state) {
    const el = document.getElementById(id);
    if (!el) return;
    const dot   = el.querySelector('.step-dot');
    const check = el.querySelector('.check-icon');
    const spin  = el.querySelector('.spin-icon');
    check.classList.add('hidden');
    spin.classList.add('hidden');
    dot.style.borderColor = '';
    dot.style.background  = '';
    if (state === 'active') {
      spin.classList.remove('hidden');
      dot.style.borderColor = 'oklch(49% 0.24 264)';
      dot.style.background  = 'oklch(49% 0.24 264 / 15%)';
    }
    if (state === 'done') {
      check.classList.remove('hidden');
      dot.style.borderColor = 'oklch(67% 0.18 162)';
      dot.style.background  = 'oklch(67% 0.18 162 / 15%)';
    }
  }

  function animateProgress(from, to, duration, label) {
    document.getElementById('progress-label').textContent = label;
    const start = performance.now();
    function step(now) {
      const t   = Math.min((now - start) / duration, 1);
      const pct = Math.round(from + (to - from) * t);
      document.getElementById('progress-fill').style.width = pct + '%';
      document.getElementById('progress-pct').textContent  = pct + '%';
      if (t < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  window.resetConverter = function () {
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    resetFile();
    document.getElementById('opt-password').value = '';
    document.getElementById('opt-pages').value = '';
    document.getElementById('opt-chunk').value = 3;
    document.getElementById('chunk-val').textContent = '3';
    document.getElementById('chunk-example').textContent = '3';
    document.getElementById('chunk-result').textContent = '4 files';
    document.getElementById('chunk-breakdown').textContent = '3+3+3+1';
    ranges = [[1, 3]];
    // Reset mode to 'page'
    document.querySelectorAll('.mode-card').forEach(b => b.classList.remove('active'));
    document.querySelector('.mode-card[data-mode="page"]').classList.add('active');
    activeMode = 'page';
    document.querySelectorAll('.mode-opts').forEach(el => el.classList.add('hidden'));
    document.getElementById('mode-opts-page').classList.remove('hidden');
    document.getElementById('parts-preview').classList.add('hidden');
    showState('upload');
    updateStepIndicator(1);
    animateProgress(0, 0, 0, 'Starting…');
    ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
  };

  function showError(msg) {
    errorText.textContent = msg;
    uploadError.classList.remove('hidden');
    uploadError.classList.add('flex');
  }
  function hideError() {
    uploadError.classList.add('hidden');
    uploadError.classList.remove('flex');
  }

  function formatBytes(bytes) {
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }
  function formatSizeKb(kb) {
    if (!kb && kb !== 0) return '—';
    if (kb >= 1024) return (kb / 1024).toFixed(2) + ' MB';
    return Math.round(kb) + ' KB';
  }

  // Initialize
  renderRanges();

  // ── FAQ ──
  document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const body   = btn.nextElementSibling;
      const icon   = btn.querySelector('.faq-icon');
      const isOpen = !body.classList.contains('hidden');
      document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
      document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
      if (!isOpen) {
        body.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
      }
    });
  });

}); // end DOMContentLoaded
</script>
@endpush

@endsection
