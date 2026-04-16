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
                @foreach([['1','Input JSON'],['2','Converting'],['3','Download']] as [$n, $label])
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

                    {{-- ── Mode tabs ── --}}
                    <div
                        class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-6 w-fit">
                        <button type="button" id="tab-file"
                            class="tab-btn active flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload File
                        </button>
                        <button type="button" id="tab-text"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 7 4 4 20 4 20 7" />
                                <line x1="9" y1="20" x2="15" y2="20" />
                                <line x1="12" y1="4" x2="12" y2="20" />
                            </svg>
                            Paste JSON
                        </button>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file">

                        {{-- Drop zone --}}
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-4xl">
                                    📋</div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your JSON file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">or click to browse from your computer</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose JSON File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>
                            <input type="file" id="file-input" accept=".json,application/json"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        {{-- File preview --}}
                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                                📋</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">data.json</p>
                                <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">— · JSON File</p>
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

                        {{-- File options --}}
                        <div class="mt-4 grid sm:grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="file-opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="file-opt-filename" placeholder="e.g. export.csv"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to your JSON filename with .csv
                                    extension</p>
                            </div>
                            <div
                                class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex flex-col justify-center gap-2">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-fn-amber/10 border border-fn-amber/20 text-fn-amber text-sm font-bold">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                        </svg>
                                        JSON
                                    </div>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" class="text-fn-text3">
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                        <polyline points="12 5 19 12 12 19" />
                                    </svg>
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-fn-green/10 border border-fn-green/20 text-fn-green text-sm font-bold">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <line x1="3" y1="9" x2="21" y2="9" />
                                            <line x1="3" y1="15" x2="21" y2="15" />
                                            <line x1="9" y1="3" x2="9" y2="21" />
                                        </svg>
                                        CSV
                                    </div>
                                </div>
                                <p class="text-fn-text3 text-sm">JSON array of objects converted to flat,
                                    comma-separated rows.</p>
                            </div>
                        </div>

                    </div>{{-- /panel-file --}}

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text" class="hidden">

                        {{-- Textarea --}}
                        <div class="relative">
                            <textarea id="json-textarea" rows="12" spellcheck="false"
                                placeholder='Paste your JSON here, e.g.&#10;[&#10;  { "name": "Alice", "age": 30, "city": "Paris" },&#10;  { "name": "Bob",   "age": 25, "city": "London" }&#10;]'
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-2xl px-5 py-4 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50 resize-none leading-relaxed"></textarea>
                            <div class="absolute top-3 right-3 flex gap-2">
                                <button type="button" id="btn-paste"
                                    class="flex items-center gap-1.5 px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                                    </svg>
                                    Paste
                                </button>
                                <button type="button" id="btn-clear"
                                    class="flex items-center gap-1.5 px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg>
                                    Clear
                                </button>
                            </div>
                        </div>

                        {{-- JSON validation status --}}
                        <div id="json-status" class="hidden mt-3 flex items-center gap-2 text-sm font-semibold"></div>

                        {{-- Text options --}}
                        <div class="mt-4 grid sm:grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="text-opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="text-opt-filename" placeholder="e.g. export.csv"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to <span
                                        class="font-mono">output.csv</span></p>
                            </div>
                            <div
                                class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex flex-col justify-center gap-1.5">
                                <p class="text-sm font-semibold text-fn-text2">Expected format</p>
                                <p class="text-fn-text3 text-sm leading-relaxed">An array of objects: <span
                                        class="font-mono text-fn-text2 bg-fn-surface px-1 py-0.5 rounded">[{…},
                                        {…}]</span>. All keys across objects become CSV column headers.</p>
                            </div>
                        </div>

                    </div>{{-- /panel-text --}}

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
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Convert to CSV
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-3xl">
                            📋</div>
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

                    <h2 class="text-xl font-bold mb-2">Converting your JSON…</h2>
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
                        ['proc-1','Uploading & parsing JSON'],
                        ['proc-2','Flattening structure & extracting keys'],
                        ['proc-3','Building CSV rows'],
                        ['proc-4','Generating output file'],
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
                    <p class="text-fn-text2 text-sm mb-8">Your CSV file is ready.</p>

                    {{-- CSV preview (text mode only) --}}
                    <div id="csv-preview-wrap" class="hidden max-w-2xl mx-auto mb-6 text-left">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-semibold text-fn-text2">CSV Preview</p>
                            <span id="csv-preview-meta" class="text-sm text-fn-text3"></span>
                        </div>
                        <div class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-auto max-h-52">
                            <table id="csv-preview-table" class="w-full text-sm border-collapse"></table>
                        </div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📊</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">output.csv</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">CSV File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="output.csv"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download CSV
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
            ['Is this really free?', 'Files up to 50MB are completely free with no account needed. Pro plans unlock
            200MB files and batch conversion.'],
            ['What JSON structure is supported?', 'The converter expects an array of objects — for example
            [{"name":"Alice","age":30},{"name":"Bob","age":25}]. Each object becomes a row and each unique key becomes a
            column header.'],
            ['What if my objects have different keys?', 'No problem. The converter collects all unique keys across every
            object and uses them as headers. Missing values in any row are left as empty cells.'],
            ['Can I paste JSON directly without a file?', 'Yes — switch to the Paste JSON tab, drop your JSON text into
            the editor, and convert instantly. You\'ll get an inline table preview plus a .csv download.'],
            ['Is my data safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
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
    .tab-btn {
        color: var(--fn-text3);
    }

    .tab-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0 / 12%);
    }

    #csv-preview-table th {
        background: oklch(var(--fn-surface2-l, 22%) var(--fn-surface2-c, 0) var(--fn-surface2-h, 0) / 1);
        padding: 6px 10px;
        text-align: left;
        font-weight: 700;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        white-space: nowrap;
    }

    #csv-preview-table td {
        padding: 5px 10px;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 6%);
        white-space: nowrap;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #csv-preview-table tr:last-child td {
        border-bottom: none;
    }

    #csv-preview-table tr:hover td {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 4%);
    }
</style>

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      // ── Refs ──
      const tabFile     = document.getElementById('tab-file');
      const tabText     = document.getElementById('tab-text');
      const panelFile   = document.getElementById('panel-file');
      const panelText   = document.getElementById('panel-text');
      const dropZone    = document.getElementById('drop-zone');
      const fileInput   = document.getElementById('file-input');
      const convertBtn  = document.getElementById('convert-btn');
      const filePreview = document.getElementById('file-preview');
      const removeFile  = document.getElementById('remove-file');
      const uploadError = document.getElementById('upload-error');
      const errorText   = document.getElementById('error-text');
      const jsonTA      = document.getElementById('json-textarea');
      const jsonStatus  = document.getElementById('json-status');
      const btnPaste    = document.getElementById('btn-paste');
      const btnClear    = document.getElementById('btn-clear');

      let selectedFile = null;
      let blobUrl      = null;
      let activeTab    = 'file'; // 'file' | 'text'
      let jsonValid    = false;

      // ── Tab switching ──
      tabFile.addEventListener('click', () => switchTab('file'));
      tabText.addEventListener('click', () => switchTab('text'));

      function switchTab(tab) {
        activeTab = tab;
        tabFile.classList.toggle('active', tab === 'file');
        tabText.classList.toggle('active', tab === 'text');
        panelFile.classList.toggle('hidden', tab !== 'file');
        panelText.classList.toggle('hidden', tab !== 'text');
        hideError();
        refreshConvertBtn();
      }

      function refreshConvertBtn() {
        if (activeTab === 'file') {
          convertBtn.disabled = !selectedFile;
        } else {
          convertBtn.disabled = !jsonValid;
        }
      }

      // ── Drag & drop (file tab) ──
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
        if (!file.name.toLowerCase().endsWith('.json') && file.type !== 'application/json') {
          showError('Please select a valid JSON file.');
          return;
        }
        if (file.size > 50 * 1024 * 1024) {
          showError('File exceeds the 50MB free limit.');
          return;
        }
        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · JSON File';
        const filenameInput = document.getElementById('file-opt-filename');
        if (!filenameInput.value) filenameInput.value = file.name.replace(/\.json$/i, '.csv');
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

      // ── JSON textarea (text tab) ──
      let validateTimer = null;

      jsonTA.addEventListener('input', () => {
        clearTimeout(validateTimer);
        validateTimer = setTimeout(validateJson, 300);
      });

      function validateJson() {
        const raw = jsonTA.value.trim();
        if (!raw) {
          jsonStatus.classList.add('hidden');
          jsonValid = false;
          refreshConvertBtn();
          return;
        }
        try {
          const parsed = JSON.parse(raw);
          if (!Array.isArray(parsed)) throw new Error('Root must be an array');
          if (parsed.length === 0) throw new Error('Array is empty');
          if (typeof parsed[0] !== 'object' || Array.isArray(parsed[0])) throw new Error('Array items must be objects');
          jsonValid = true;
          jsonStatus.innerHTML = `
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green"><polyline points="20 6 9 17 4 12"/></svg>
            <span class="text-fn-green">Valid JSON · ${parsed.length} row${parsed.length !== 1 ? 's' : ''} · ${Object.keys(parsed[0]).length} keys detected</span>`;
        } catch (e) {
          jsonValid = false;
          jsonStatus.innerHTML = `
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-red"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="text-fn-red">${e.message}</span>`;
        }
        jsonStatus.classList.remove('hidden');
        jsonStatus.classList.add('flex');
        refreshConvertBtn();
      }

      // Paste & clear buttons
      btnPaste.addEventListener('click', async () => {
        try {
          const text = await navigator.clipboard.readText();
          jsonTA.value = text;
          validateJson();
        } catch (_) {}
      });
      btnClear.addEventListener('click', () => {
        jsonTA.value = '';
        jsonStatus.classList.add('hidden');
        jsonValid = false;
        refreshConvertBtn();
      });

      // ── Convert ──
      convertBtn.addEventListener('click', startConversion);

      async function startConversion() {
        hideError();
        showState('converting');
        updateStepIndicator(2);

        const isFile = activeTab === 'file';

        const endpoint = isFile
          ? 'https://api.filenewer.com/api/tools/json-file-to-csv'
          : 'https://api.filenewer.com/api/tools/json-text-to-csv';

        const customFilename = isFile
          ? document.getElementById('file-opt-filename').value.trim()
          : document.getElementById('text-opt-filename').value.trim();

        const outputFilename = customFilename
          ? (customFilename.toLowerCase().endsWith('.csv') ? customFilename : customFilename + '.csv')
          : (isFile ? (selectedFile?.name.replace(/\.json$/i, '.csv') ?? 'output.csv') : 'output.csv');

        // File tab → multipart/form-data; Text tab → application/json (matching Postman)
        let fetchBody, fetchHeaders = {};
        if (isFile) {
          const formData = new FormData();
          formData.append('file', selectedFile);
          formData.append('output', 'file');
          if (customFilename) formData.append('filename', customFilename);
          fetchBody = formData;
          // Let browser set Content-Type + boundary automatically
        } else {
          const payload = { json: JSON.parse(jsonTA.value.trim()), output: 'file' };
          if (customFilename) payload.filename = customFilename;
          fetchBody    = JSON.stringify(payload);
          fetchHeaders = { 'Content-Type': 'application/json' };
        }

        // Animate
        setProcessStep('proc-1', 'active');
        animateProgress(0, 25, 600, isFile ? 'Uploading JSON file…' : 'Parsing JSON text…');

        const t2 = setTimeout(() => {
          setProcessStep('proc-1', 'done');
          setProcessStep('proc-2', 'active');
          animateProgress(25, 55, 800, 'Flattening structure & extracting keys…');
        }, 700);

        const t3 = setTimeout(() => {
          setProcessStep('proc-2', 'done');
          setProcessStep('proc-3', 'active');
          animateProgress(55, 78, 700, 'Building CSV rows…');
        }, 1600);

        const t4 = setTimeout(() => {
          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'active');
          animateProgress(78, 90, 500, 'Generating output file…');
        }, 2400);

        try {
          const res = await fetch(endpoint, { method: 'POST', headers: fetchHeaders, body: fetchBody });

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!res.ok) {
            let errMsg = 'Conversion failed. Please try again.';
            try { const d = await res.json(); if (d.error) errMsg = d.error; } catch (_) {}
            throw new Error(errMsg);
          }

          // API always returns binary CSV file (output=file)
          const blob    = await res.blob();
          const csvText = await blob.text(); // also read as text for preview

          if (blobUrl) URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(blob);

          const link    = document.getElementById('download-link');
          link.href     = blobUrl;
          link.download = outputFilename;

          document.getElementById('output-name').textContent = outputFilename;
          document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · CSV File';

          // Build preview for text/paste mode
          const previewWrap = document.getElementById('csv-preview-wrap');
          if (!isFile) {
            renderCsvPreview(csvText);
            previewWrap.classList.remove('hidden');
          } else {
            previewWrap.classList.add('hidden');
          }

          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'done');
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

      // ── CSV table preview ──
      function renderCsvPreview(csvText) {
        const lines   = csvText.trim().split('\n').filter(Boolean);
        const headers = parseCsvLine(lines[0]);
        const rows    = lines.slice(1, 11); // show up to 10 data rows
        const total   = lines.length - 1;

        document.getElementById('csv-preview-meta').textContent =
          `${total} row${total !== 1 ? 's' : ''} · ${headers.length} column${headers.length !== 1 ? 's' : ''}${total > 10 ? ' · showing first 10' : ''}`;

        const table = document.getElementById('csv-preview-table');
        table.innerHTML = '';

        const thead = document.createElement('thead');
        const trh   = document.createElement('tr');
        headers.forEach(h => {
          const th = document.createElement('th');
          th.textContent = h;
          trh.appendChild(th);
        });
        thead.appendChild(trh);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        rows.forEach(line => {
          const cells = parseCsvLine(line);
          const tr    = document.createElement('tr');
          headers.forEach((_, i) => {
            const td = document.createElement('td');
            td.textContent = cells[i] ?? '';
            td.title       = cells[i] ?? '';
            tr.appendChild(td);
          });
          tbody.appendChild(tr);
        });
        table.appendChild(tbody);
      }

      function parseCsvLine(line) {
        const result = [];
        let cur = '', inQ = false;
        for (let i = 0; i < line.length; i++) {
          const ch = line[i];
          if (ch === '"') {
            if (inQ && line[i + 1] === '"') { cur += '"'; i++; }
            else inQ = !inQ;
          } else if (ch === ',' && !inQ) {
            result.push(cur); cur = '';
          } else {
            cur += ch;
          }
        }
        result.push(cur);
        return result;
      }

      // ── Helpers ──
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
        jsonTA.value = '';
        jsonStatus.classList.add('hidden');
        jsonValid = false;
        document.getElementById('file-opt-filename').value = '';
        document.getElementById('text-opt-filename').value = '';
        document.getElementById('csv-preview-wrap').classList.add('hidden');
        switchTab('file');
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
