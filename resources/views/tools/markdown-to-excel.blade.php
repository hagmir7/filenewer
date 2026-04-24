@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
<script src="https://cdn.jsdelivr.net/npm/marked@12.0.0/marked.min.js" defer></script>
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Input Markdown'],['2','Converting'],['3','Download']] as [$n, $label])
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

                    {{-- Mode tabs --}}
                    <div
                        class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-6 w-fit">
                        <button type="button" id="tab-text"
                            class="tab-btn active flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 7 4 4 20 4 20 7" />
                                <line x1="9" y1="20" x2="15" y2="20" />
                                <line x1="12" y1="4" x2="12" y2="20" />
                            </svg>
                            Write / Paste
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .md
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">Markdown source</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample"
                                    class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    Sample
                                </button>
                                <button type="button" id="btn-paste"
                                    class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                        <rect x="8" y="2" width="8" height="4" rx="1" />
                                    </svg>
                                    Paste
                                </button>
                                <button type="button" id="btn-clear"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                            </div>
                        </div>

                        <textarea id="md-textarea" rows="12" spellcheck="false"
                            placeholder='Paste Markdown with tables, lists, headings…&#10;&#10;# Sales Report&#10;&#10;| Product | Sales | Revenue |&#10;|---------|-------|--------|&#10;| Apple   | 100   | 500    |&#10;| Banana  | 200   | 400    |&#10;&#10;- Task item&#10;- [x] Done&#10;- [ ] Todo'
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                        <div class="flex items-center justify-between text-fn-text3 text-xs mt-1.5">
                            <span id="md-meta">0 characters · 0 lines</span>
                            <span class="text-fn-text3/70">Tables become sheets · lists go to a Lists sheet · code to
                                Code sheet</span>
                        </div>
                    </div>{{-- /panel-text --}}

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center">
                                    <span class="font-mono font-black text-3xl text-fn-green">M↓</span>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your Markdown file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .md and .markdown — or click to browse</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose Markdown File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input" accept=".md,.markdown,text/markdown,text/plain"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center shrink-0">
                                <span class="font-mono font-black text-base text-fn-green">M↓</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">document.md</p>
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
                    </div>{{-- /panel-file --}}

                    {{-- Content detection preview --}}
                    <div id="detected-content"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-blue/15 rounded-xl">
                        <div class="flex items-center gap-2 mb-3">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-blue-l">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                            <p class="text-sm font-semibold text-fn-text2">Your Excel file will contain</p>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2" id="detected-sheets"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-fn-text2">Output Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            {{-- Output filename --}}
                            <div>
                                <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Output filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="output.xlsx"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            </div>

                            {{-- Stats toggle --}}
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Summary sheet</label>
                                <label
                                    class="flex items-center gap-2.5 cursor-pointer select-none px-3 py-2 bg-fn-surface border border-fn-text/10 rounded-lg hover:border-fn-blue/25 transition-colors">
                                    <div class="toggle-wrap relative w-8 h-4 shrink-0">
                                        <input type="checkbox" id="opt-stats" checked class="sr-only peer" />
                                        <div
                                            class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                        </div>
                                        <div
                                            class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-fn-text2">Include summary sheet</span>
                                </label>
                            </div>
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
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <line x1="3" y1="9" x2="21" y2="9" />
                            <line x1="3" y1="15" x2="21" y2="15" />
                            <line x1="9" y1="3" x2="9" y2="21" />
                        </svg>
                        Convert to Excel
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center">
                            <span class="font-mono font-black text-2xl text-fn-green">M↓</span>
                        </div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            📊</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting to Excel…</h2>
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
                        ['proc-1','Uploading Markdown content'],
                        ['proc-2','Extracting tables & headings'],
                        ['proc-3','Building sheets & styling'],
                        ['proc-4','Generating Excel file'],
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
                    <h2 class="text-2xl font-bold mb-2">Conversion Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6">Your Excel file is ready with multiple sheets.</p>

                    {{-- Sheets generated preview --}}
                    <div id="result-sheets-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Sheets generated</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-sheets"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📊</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">output.xlsx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Excel Workbook</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="output.xlsx"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Excel File
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Convert another
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
            ['How are Markdown tables converted?','Each Markdown table becomes its own sheet in the Excel workbook —
            named after the closest heading above it. Header rows are styled in bold white on blue, rows alternate light
            blue and white for readability, numeric columns get auto-detected and right-aligned, and a totals row is
            added with auto-sums.'],
            ['What happens to headings, lists and code?','Headings go into a "Structure" sheet with level indicators.
            Bullet lists, numbered lists, and task lists (- [ ] and - [x]) all collect in a single "Lists" sheet with
            their completion status. Code blocks land in a "Code" sheet with their detected language. Regular paragraphs
            go into a "Content" sheet.'],
            ['What is the summary sheet?','The first sheet of the workbook gives you a high-level count of tables,
            headings, lists, code blocks, and paragraphs in your document — essentially a dashboard for the content. You
            can turn it off if you only want the content sheets.'],
            ['Can I paste Markdown instead of uploading a file?','Yes — use the "Write / Paste" tab to paste or type
            Markdown directly. Your Excel file is generated with the same structure either way.'],
            ['Is my content safe and private?','All uploads use AES-256 encryption in transit and are permanently
            deleted within 1 hour. We never read, share or store your content.'],
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
    .tab-btn {
        color: var(--fn-text3);
    }

    .tab-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0 / 12%);
    }

    /* Sheet tab chips */
    .sheet-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 600;
        background: var(--fn-surface);
    }

    .sheet-chip .sheet-dot {
        width: 8px;
        height: 8px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .sheet-chip .sheet-count {
        font-family: monospace;
        font-size: 10px;
        color: var(--fn-text3);
        margin-left: auto;
        padding-left: 4px;
    }

    /* Color variants matching the Excel tab colors */
    .sheet-summary .sheet-dot {
        background: oklch(62% 0.20 250);
    }

    .sheet-summary {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .sheet-structure .sheet-dot {
        background: oklch(42% 0.22 264);
    }

    .sheet-structure {
        color: oklch(52% 0.22 264);
        border-color: oklch(52% 0.22 264 / 30%);
        background: oklch(42% 0.22 264 / 8%);
    }

    .sheet-table .sheet-dot {
        background: oklch(67% 0.18 162);
    }

    .sheet-table {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }

    .sheet-lists .sheet-dot {
        background: oklch(72% 0.18 60);
    }

    .sheet-lists {
        color: oklch(72% 0.18 60);
        border-color: oklch(72% 0.18 60 / 30%);
        background: oklch(72% 0.18 60 / 6%);
    }

    .sheet-code .sheet-dot {
        background: oklch(45% 0.04 250);
    }

    .sheet-code {
        color: var(--fn-text2);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 15%);
        background: oklch(var(--fn-text-l, 80%) 0 0 / 4%);
    }

    .sheet-content .sheet-dot {
        background: oklch(67% 0.18 162);
    }

    .sheet-content {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_MD = `# Sales Report Q1

## Summary
This quarter showed strong performance across all regions.

## Regional Breakdown

| Region  | Revenue | Growth |
|---------|---------|--------|
| EMEA    | 1200000 | 18     |
| APAC    | 850000  | 22     |
| America | 2100000 | 12     |

## Product Performance

| Product | Units Sold | Revenue |
|---------|-----------|---------|
| Apple   | 100       | 500     |
| Banana  | 200       | 400     |
| Cherry  | 150       | 750     |

## Action Items

- [x] Close Q1 books
- [x] Publish report to stakeholders
- [ ] Schedule Q2 planning session
- [ ] Update sales targets

## Notes

- Strong growth in APAC region
- Weather impacted European sales in Jan
- New product launch scheduled for Q2

\`\`\`python
def calculate_growth(current, previous):
    return (current - previous) / previous * 100
\`\`\`
`;

  // ── Refs ──
  const tabText     = document.getElementById('tab-text');
  const tabFile     = document.getElementById('tab-file');
  const panelText   = document.getElementById('panel-text');
  const panelFile   = document.getElementById('panel-file');
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');
  const mdTA        = document.getElementById('md-textarea');

  let selectedFile = null;
  let blobUrl      = null;
  let activeTab    = 'text';
  let detectTimer  = null;

  // ── Tabs ──
  tabText.addEventListener('click', () => switchTab('text'));
  tabFile.addEventListener('click', () => switchTab('file'));

  function switchTab(tab) {
    activeTab = tab;
    tabText.classList.toggle('active', tab === 'text');
    tabFile.classList.toggle('active', tab === 'file');
    panelText.classList.toggle('hidden', tab !== 'text');
    panelFile.classList.toggle('hidden', tab !== 'file');
    hideError();
    refreshConvertBtn();
    refreshDetection();
  }

  // ── Sample / Paste / Clear ──
  document.getElementById('btn-sample').addEventListener('click', () => {
    mdTA.value = SAMPLE_MD;
    mdTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { mdTA.value = await navigator.clipboard.readText(); mdTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    mdTA.value = '';
    mdTA.dispatchEvent(new Event('input'));
  });

  // ── Textarea input ──
  mdTA.addEventListener('input', () => {
    const v = mdTA.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('md-meta').textContent = v.length.toLocaleString() + ' characters · ' + lines + ' lines';
    refreshConvertBtn();
    // Debounce detection
    clearTimeout(detectTimer);
    detectTimer = setTimeout(refreshDetection, 300);
  });

  // ── File drop zone ──
  ['dragenter', 'dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave', 'dragend', 'drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
  fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
  removeFile.addEventListener('click', e => { e.stopPropagation(); resetFile(); });

  async function handleFile(file) {
    hideError();
    const name = file.name.toLowerCase();
    if (!name.match(/\.(md|markdown|txt)$/)) {
      showError('Please select a valid Markdown file (.md or .markdown).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · Markdown';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');

    // Read the file to allow detection preview
    try {
      const text = await file.text();
      detectFromText(text, selectedFile.name);
    } catch (_) {
      document.getElementById('detected-content').classList.add('hidden');
    }

    refreshConvertBtn();
  }

  function resetFile() {
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    document.getElementById('detected-content').classList.add('hidden');
    refreshConvertBtn();
    hideError();
  }

  function refreshConvertBtn() {
    if (activeTab === 'text') {
      convertBtn.disabled = !mdTA.value.trim();
    } else {
      convertBtn.disabled = !selectedFile;
    }
  }

  // ── Client-side detection preview ──
  function refreshDetection() {
    if (activeTab === 'text') {
      const v = mdTA.value.trim();
      if (!v) { document.getElementById('detected-content').classList.add('hidden'); return; }
      detectFromText(v);
    }
  }

  function detectFromText(md, filename) {
    const stats = analyzeMarkdown(md);
    const wrap  = document.getElementById('detected-content');
    const list  = document.getElementById('detected-sheets');
    list.innerHTML = '';

    const sheets = [];
    if (document.getElementById('opt-stats').checked) {
      sheets.push(['summary',   'Summary',   '—']);
    }
    if (stats.headings > 0) sheets.push(['structure', 'Structure', stats.headings]);
    stats.tables.forEach((t, i) => {
      sheets.push(['table', t.name || 'Table ' + (i + 1), t.rows + ' rows']);
    });
    if (stats.listItems > 0) sheets.push(['lists',   'Lists',   stats.listItems]);
    if (stats.codeBlocks > 0) sheets.push(['code',   'Code',    stats.codeBlocks]);
    if (stats.paragraphs > 0) sheets.push(['content','Content', stats.paragraphs]);

    if (sheets.length === 0) {
      wrap.classList.add('hidden');
      return;
    }

    sheets.forEach(([variant, label, count]) => {
      const chip = document.createElement('div');
      chip.className = 'sheet-chip sheet-' + variant;
      chip.innerHTML = `
        <span class="sheet-dot"></span>
        <span class="sheet-label"></span>
        <span class="sheet-count">${count}</span>`;
      chip.querySelector('.sheet-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  // Lightweight Markdown analyzer — no heavy parsing, just counting
  function analyzeMarkdown(md) {
    const lines = md.split('\n');
    let headings = 0;
    let paragraphs = 0;
    let codeBlocks = 0;
    let listItems = 0;
    const tables = [];

    let inCode = false;
    let currentHeadingText = '';
    let paragraphBuf = '';
    let tableBuf = null; // { name, rows }

    function flushParagraph() {
      if (paragraphBuf.trim()) paragraphs++;
      paragraphBuf = '';
    }
    function flushTable() {
      if (tableBuf) tables.push(tableBuf);
      tableBuf = null;
    }

    for (let i = 0; i < lines.length; i++) {
      const line = lines[i];
      // Code fence
      if (line.match(/^```/)) {
        if (!inCode) { flushParagraph(); flushTable(); codeBlocks++; }
        inCode = !inCode;
        continue;
      }
      if (inCode) continue;

      // Heading
      const hMatch = line.match(/^(#{1,6})\s+(.+)$/);
      if (hMatch) {
        flushParagraph(); flushTable();
        headings++;
        currentHeadingText = hMatch[2].trim();
        continue;
      }

      // Table row
      if (line.match(/^\s*\|.*\|\s*$/)) {
        // Check for separator row (next line)
        if (!tableBuf && i + 1 < lines.length && lines[i + 1].match(/^\s*\|?[\s:|-]+\|?\s*$/)) {
          tableBuf = { name: currentHeadingText || 'Table ' + (tables.length + 1), rows: 0 };
          i++; // skip separator
          continue;
        }
        if (tableBuf) { tableBuf.rows++; continue; }
      } else if (tableBuf) {
        flushTable();
      }

      // List items (- * + or 1.)
      if (line.match(/^[\s]*[-*+]\s+/) || line.match(/^[\s]*\d+\.\s+/)) {
        flushParagraph();
        listItems++;
        continue;
      }

      // Empty line
      if (!line.trim()) {
        flushParagraph();
        continue;
      }

      // Setext heading (current line is text, next is === or ---)
      if (i + 1 < lines.length && lines[i + 1].match(/^(=+|-{3,})\s*$/)) {
        flushParagraph(); flushTable();
        headings++;
        currentHeadingText = line.trim();
        i++; // skip underline
        continue;
      }

      // HR
      if (line.match(/^(-{3,}|\*{3,}|_{3,})\s*$/)) {
        flushParagraph();
        continue;
      }

      // Paragraph text
      paragraphBuf += line + ' ';
    }
    flushParagraph();
    flushTable();

    return { headings, paragraphs, codeBlocks, listItems, tables };
  }

  // Re-detect when stats toggle changes
  document.getElementById('opt-stats').addEventListener('change', refreshDetection);

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const customFilename = document.getElementById('opt-filename').value.trim();
    const includeStats   = document.getElementById('opt-stats').checked;

    // Default output filename
    let outName;
    if (customFilename) {
      outName = customFilename.toLowerCase().endsWith('.xlsx') ? customFilename : customFilename + '.xlsx';
    } else if (activeTab === 'file' && selectedFile) {
      outName = selectedFile.name.replace(/\.(md|markdown|txt)$/i, '') + '.xlsx';
    } else {
      outName = 'output.xlsx';
    }

    let fetchBody, fetchHeaders = {};
    let mdForDetection = '';

    if (activeTab === 'file') {
      const fd = new FormData();
      fd.append('file',            selectedFile);
      fd.append('include_stats',   includeStats);
      if (customFilename) fd.append('output_filename', outName);
      fetchBody = fd;
      try { mdForDetection = await selectedFile.text(); } catch(_) {}
    } else {
      mdForDetection = mdTA.value;
      const payload = {
        markdown:        mdTA.value,
        include_stats:   includeStats,
      };
      if (customFilename) payload.output_filename = outName;
      fetchBody    = JSON.stringify(payload);
      fetchHeaders = { 'Content-Type': 'application/json' };
    }

    // Animate
    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 500, 'Uploading Markdown content…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 55, 700, 'Extracting tables & headings…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 80, 700, 'Building sheets & styling…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(80, 92, 500, 'Generating Excel file…');
    }, 2200);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/markdown-to-excel', {
        method: 'POST',
        headers: fetchHeaders,
        body: fetchBody,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch (_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · Excel Workbook';

      // Render sheets preview (client-side computed from the markdown)
      if (mdForDetection.trim()) {
        renderResultSheets(mdForDetection, includeStats);
      } else {
        document.getElementById('result-sheets-wrap').classList.add('hidden');
      }

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(92, 100, 300, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function renderResultSheets(md, includeStats) {
    const stats = analyzeMarkdown(md);
    const wrap  = document.getElementById('result-sheets-wrap');
    const list  = document.getElementById('result-sheets');
    list.innerHTML = '';

    const sheets = [];
    if (includeStats) sheets.push(['summary', 'Summary', '—']);
    if (stats.headings > 0) sheets.push(['structure', 'Structure', stats.headings + ' headings']);
    stats.tables.forEach((t, i) => {
      sheets.push(['table', t.name || 'Table ' + (i + 1), t.rows + ' rows']);
    });
    if (stats.listItems > 0)  sheets.push(['lists',   'Lists',   stats.listItems + ' items']);
    if (stats.codeBlocks > 0) sheets.push(['code',    'Code',    stats.codeBlocks + ' blocks']);
    if (stats.paragraphs > 0) sheets.push(['content', 'Content', stats.paragraphs + ' para']);

    if (sheets.length === 0) { wrap.classList.add('hidden'); return; }

    sheets.forEach(([variant, label, count]) => {
      const chip = document.createElement('div');
      chip.className = 'sheet-chip sheet-' + variant;
      chip.innerHTML = `
        <span class="sheet-dot"></span>
        <span class="sheet-label"></span>
        <span class="sheet-count">${count}</span>`;
      chip.querySelector('.sheet-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  // ── Helpers ──
  function scrollToCard() {
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
    mdTA.value = '';
    mdTA.dispatchEvent(new Event('input'));
    document.getElementById('opt-filename').value = '';
    document.getElementById('opt-stats').checked  = true;
    document.getElementById('detected-content').classList.add('hidden');
    document.getElementById('result-sheets-wrap').classList.add('hidden');
    switchTab('text');
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
