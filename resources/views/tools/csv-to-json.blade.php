{{-- resources/views/tools/csv-to-json.blade.php --}}
@extends('layouts.base')

@section('title', 'CSV to JSON Converter – Free Online | Filenewer')

@section('content')

<style>
    .drop-zone {
        transition: all 0.25s ease;
    }

    .drop-zone.drag-over {
        border-color: oklch(49% 0.24 264 / 80%);
        background: oklch(49% 0.24 264 / 8%);
        transform: scale(1.01);
    }

    .drop-zone.has-file {
        border-color: oklch(67% 0.18 162 / 60%);
        background: oklch(67% 0.18 162 / 6%);
    }

    .progress-fill {
        height: 100%;
        border-radius: 9999px;
        background: linear-gradient(90deg, oklch(49% 0.24 264), oklch(68% 0.17 210));
        transition: width 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, oklch(100% 0 0 / 20%), transparent);
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(100%);
        }
    }

    .spin {
        animation: spin360 1s linear infinite;
    }

    @keyframes spin360 {
        to {
            transform: rotate(360deg);
        }
    }

    .step-item.done .step-dot {
        background: oklch(67% 0.18 162 / 20%);
        border-color: oklch(67% 0.18 162);
    }

    .step-item.active .step-dot {
        background: oklch(49% 0.24 264 / 20%);
        border-color: oklch(49% 0.24 264);
        box-shadow: 0 0 0 4px oklch(49% 0.24 264 / 15%);
    }

    .step-item.done .step-label {
        color: oklch(67% 0.18 162);
    }

    .step-item.active .step-label {
        color: oklch(56% 0.23 264);
    }

    .tool-glow::before {
        content: '';
        position: absolute;
        top: -180px;
        left: 50%;
        transform: translateX(-50%);
        width: 700px;
        height: 500px;
        background: radial-gradient(ellipse, oklch(49% 0.24 264 / 13%) 0%, transparent 70%);
        pointer-events: none;
    }

    .feat-card {
        transition: all 0.2s ease;
    }

    .feat-card:hover {
        border-color: oklch(49% 0.24 264 / 30%);
        transform: translateY(-2px);
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.85) translateY(10px);
        }

        60% {
            transform: scale(1.04) translateY(-3px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .bounce-in {
        animation: bounceIn 0.45s ease forwards;
    }

    .text-gradient {
        background: linear-gradient(135deg, oklch(56% 0.23 264), oklch(68% 0.17 210));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* JSON preview */
    .json-preview {
        font-family: 'Fira Code', 'Cascadia Code', 'Consolas', monospace;
        font-size: 12px;
        line-height: 1.7;
        tab-size: 2;
    }

    .json-preview .key {
        color: oklch(68% 0.17 210);
    }

    .json-preview .str {
        color: oklch(72% 0.17 162);
    }

    .json-preview .num {
        color: oklch(72% 0.20 55);
    }

    .json-preview .bool {
        color: oklch(68% 0.22 30);
    }

    .json-preview .null {
        color: oklch(60% 0.00 0);
    }

    .copy-btn-success {
        color: oklch(67% 0.18 162) !important;
        border-color: oklch(67% 0.18 162 / 40%) !important;
    }
</style>


{{-- ══ HERO ══ --}}
<section class="relative pt-10 pb-6 overflow-hidden tool-glow">
    <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
        <div
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-fn-cyan/30 bg-fn-cyan/8 text-fn-cyan text-xs font-semibold tracking-widest uppercase mb-5">
            <span>🔄</span> Convert Tools
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight leading-[1.1] mb-4">
            CSV to <span class="text-gradient">JSON Converter</span>
        </h1>
        <p class="text-fn-text2 text-lg max-w-xl mx-auto leading-relaxed mb-4">
            Convert any CSV or TSV file to clean, formatted JSON instantly — with type detection, custom delimiters, and
            a live preview. Free, no account needed.
        </p>
        <div class="flex items-center justify-center gap-6 flex-wrap">
            @foreach(['No account needed', 'Up to 50MB free', 'Deleted after 1 hour', 'Client-side preview'] as $badge)
            <span class="flex items-center gap-1.5 text-fn-text3 text-xs">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ $badge }}
            </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Upload CSV'],['2','Converting'],['3','Download']] as [$n, $label])
                <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-2" id="step-{{ $n }}">
                    <div
                        class="step-dot w-6 h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                        <span class="text-xs font-bold">{{ $n }}</span>
                    </div>
                    <span class="step-label text-xs font-semibold text-fn-text3 transition-colors">{{ $label }}</span>
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
                                class="w-20 h-20 rounded-2xl bg-fn-cyan/10 border border-fn-cyan/20 flex items-center justify-center text-4xl">
                                📊</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your CSV file here</h2>
                        <p class="text-fn-text3 text-sm mb-6">or click to browse — supports .csv and .tsv</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose CSV File
                        </div>
                        <p class="text-fn-text3 text-xs mt-5">Max 50MB free · <a href=""
                                class="text-fn-blue-l hover:underline">200MB on Pro</a></p>
                        <input type="file" id="file-input" accept=".csv,.tsv,text/csv,text/tab-separated-values"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview (shown after selection) --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-cyan/12 border border-fn-cyan/20 flex items-center justify-center text-2xl shrink-0">
                            📊</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">data.csv</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="file-meta">— · CSV File</p>
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

                    {{-- Options --}}
                    <div class="mt-6 grid sm:grid-cols-3 gap-3">
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-2">Delimiter</label>
                            <select id="opt-delimiter"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                <option value="auto">Auto-detect</option>
                                <option value=",">Comma ( , )</option>
                                <option value=";">Semicolon ( ; )</option>
                                <option value="tab">Tab ( \t )</option>
                                <option value="|">Pipe ( | )</option>
                            </select>
                        </div>
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-2">Output Format</label>
                            <select id="opt-format"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                <option value="array">Array of objects</option>
                                <option value="keyed">Keyed by first column</option>
                                <option value="arrays">Array of arrays</option>
                                <option value="col">Columnar object</option>
                            </select>
                        </div>
                        <div
                            class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex flex-col justify-center gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-types" checked
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Auto-detect types</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-header" checked
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">First row is header</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-pretty" checked
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Pretty print JSON</span>
                            </label>
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
                            <polyline points="16 3 21 3 21 8" />
                            <line x1="4" y1="20" x2="21" y2="3" />
                            <polyline points="21 16 21 21 16 21" />
                            <line x1="15" y1="15" x2="21" y2="21" />
                        </svg>
                        Convert to JSON
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-cyan/10 border border-fn-cyan/20 flex items-center justify-center text-3xl">
                            📊</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            { }</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting your file…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 10 seconds</p>

                    <div class="max-w-md mx-auto mb-3">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-xs text-fn-text3 mb-8">
                        <span id="progress-label">Starting…</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>

                    <div class="max-w-xs mx-auto flex flex-col gap-3 text-left">
                        @foreach([
                        ['proc-1', 'Uploading & parsing CSV'],
                        ['proc-2', 'Detecting headers & delimiter'],
                        ['proc-3', 'Inferring data types'],
                        ['proc-4', 'Generating JSON output'],
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
                            <span class="text-xs text-fn-text3">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden py-6">
                    <div class="text-center mb-6">
                        <div
                            class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                            ✅</div>
                        <h2 class="text-2xl font-bold mb-2">Conversion Complete!</h2>
                        <p class="text-fn-text2 text-sm mb-2">Your JSON file is ready.</p>
                        <p class="text-fn-text3 text-xs mb-4">
                            File will be deleted in <span class="text-fn-amber font-semibold font-mono"
                                id="expiry-timer">60:00</span>
                        </p>
                    </div>

                    {{-- Stats row --}}
                    <div class="grid grid-cols-3 gap-3 max-w-sm mx-auto mb-6">
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl text-center">
                            <p class="text-xl font-bold font-mono text-fn-blue-l" id="stat-rows">—</p>
                            <p class="text-fn-text3 text-xs mt-0.5">Rows</p>
                        </div>
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl text-center">
                            <p class="text-xl font-bold font-mono text-fn-cyan" id="stat-cols">—</p>
                            <p class="text-fn-text3 text-xs mt-0.5">Columns</p>
                        </div>
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl text-center">
                            <p class="text-xl font-bold font-mono text-fn-green" id="stat-size">—</p>
                            <p class="text-fn-text3 text-xs mt-0.5">Output size</p>
                        </div>
                    </div>

                    {{-- JSON preview --}}
                    <div class="mb-6 bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-2.5 border-b border-fn-text/7">
                            <div class="flex items-center gap-2 text-xs font-semibold text-fn-text2">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-fn-blue-l">
                                    <polyline points="16 18 22 12 16 6" />
                                    <polyline points="8 6 2 12 8 18" />
                                </svg>
                                JSON Preview <span class="text-fn-text3 font-normal">(first 5 records)</span>
                            </div>
                            <button type="button" id="copy-btn"
                                class="flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-fn-text2 border border-fn-text/15 rounded-lg hover:text-fn-text hover:bg-fn-surface transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                Copy
                            </button>
                        </div>
                        <pre id="json-preview"
                            class="json-preview p-4 text-fn-text2 overflow-x-auto max-h-64 overflow-y-auto"></pre>
                    </div>

                    {{-- File info + download --}}
                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            { }</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">data.json</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="output-size">JSON File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <div class="flex flex-col items-center gap-3">
                        <a id="download-link" href="#"
                            class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5"
                            style="background: oklch(67% 0.18 162);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Download JSON File
                        </a>

                        <div class="flex items-center gap-3 flex-wrap justify-center">
                            <button type="button" onclick="resetConverter()"
                                class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10" />
                                    <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                                </svg>
                                Convert another
                            </button>
                            <a href=""
                                class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                                All tools
                            </a>
                        </div>
                    </div>

                    <p class="mt-6 text-fn-text3 text-xs flex items-center justify-center gap-1.5">
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

{{-- ══ FEATURES ══ --}}
<section class="py-16 border-t border-fn-text/7">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold tracking-tight mb-2">Why Filenewer's CSV to JSON is different</h2>
            <p class="text-fn-text2 text-sm">Most converters spit out strings. Ours gives you real typed data.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
            ['🔍','fn-blue', 'Auto Type Detection', 'Numbers, booleans, nulls and dates are inferred automatically — no
            more quoted integers in your JSON.'],
            ['⚙️','fn-cyan', 'Flexible Delimiters', 'Comma, semicolon, tab, or pipe — auto-detected or manually set.
            Works with any CSV dialect.'],
            ['🗂️','fn-green', 'Multiple Output Shapes', 'Array of objects, keyed by column, columnar object, or raw
            array of arrays — pick what fits your API.'],
            ['👁️','fn-amber', 'Live Preview', 'See the first 5 records of your JSON right in the browser before
            downloading.'],
            ['🔒','fn-red', 'Bank-Grade Security', 'AES-256 encryption in transit. Files permanently deleted within 1
            hour.'],
            ['⚡','fn-blue', 'Instant Results', 'Average conversion under 5 seconds — no queue, no wait, even for large
            files.'],
            ] as [$icon, $color, $title, $desc])
            <div class="feat-card p-6 bg-fn-surface border border-fn-text/8 rounded-xl">
                <div
                    class="w-10 h-10 rounded-xl bg-{{ $color }}/10 border border-{{ $color }}/20 flex items-center justify-center text-xl mb-4">
                    {{ $icon }}</div>
                <h3 class="font-semibold text-sm mb-2">{{ $title }}</h3>
                <p class="text-fn-text3 text-xs leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @foreach([
            ['Is this really free?',
            'Files up to 50MB are completely free with no account needed. Pro plans unlock 200MB files and batch
            conversion.'],
            ['What output formats are available?',
            'Array of objects (most common), keyed object by first column, array of arrays (raw rows), and columnar
            object (one key per column with an array of values).'],
            ['Will my numbers and booleans be correct types in the JSON?',
            'Yes — with type detection enabled, integer and decimal strings become numbers, "true"/"false" become
            booleans, and empty values become null automatically.'],
            ['Does it support TSV and other delimiters?',
            'Yes — choose auto-detect and the tool will identify comma, semicolon, tab, or pipe delimiters
            automatically. You can also set it manually.'],
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

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

    // ── Element refs ──
    const dropZone    = document.getElementById('drop-zone');
    const fileInput   = document.getElementById('file-input');
    const convertBtn  = document.getElementById('convert-btn');
    const filePreview = document.getElementById('file-preview');
    const removeFile  = document.getElementById('remove-file');
    const uploadError = document.getElementById('upload-error');
    const errorText   = document.getElementById('error-text');

    let selectedFile   = null;
    let expiryInterval = null;

    // ── Drag & drop ──
    ['dragenter','dragover'].forEach(evt => {
        dropZone.addEventListener(evt, e => {
            e.preventDefault(); e.stopPropagation();
            dropZone.classList.add('drag-over');
        });
    });

    ['dragleave','dragend','drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => {
            e.preventDefault(); e.stopPropagation();
            dropZone.classList.remove('drag-over');
        });
    });

    dropZone.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file) handleFile(file);
    });

    fileInput.addEventListener('change', e => {
        if (e.target.files[0]) handleFile(e.target.files[0]);
    });

    removeFile.addEventListener('click', e => {
        e.stopPropagation();
        resetFile();
    });

    // ── Handle selected file ──
    function handleFile(file) {
        hideError();

        const validTypes = ['text/csv','text/tab-separated-values','application/csv','application/vnd.ms-excel'];
        const validExts  = ['.csv','.tsv'];
        const ext        = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();

        if (!validTypes.includes(file.type) && !validExts.includes(ext)) {
            showError('Please select a valid CSV or TSV file.');
            return;
        }

        if (file.size > 50 * 1024 * 1024) {
            showError('File exceeds the 50MB free limit.');
            return;
        }

        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · ' + (ext === '.tsv' ? 'TSV' : 'CSV') + ' File';
        document.getElementById('output-name').textContent = file.name.replace(/\.(csv|tsv)$/i, '.json');

        filePreview.classList.remove('hidden');
        filePreview.classList.add('flex');
        dropZone.classList.add('has-file');
        convertBtn.disabled = false;
    }

    function resetFile() {
        selectedFile    = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
        dropZone.classList.remove('has-file');
        convertBtn.disabled = true;
        hideError();
    }

    // ── Convert button ──
    convertBtn.addEventListener('click', startConversion);

    async function startConversion() {
        if (!selectedFile) return;

        hideError();
        showState('converting');
        updateStepIndicator(2);

        const formData = new FormData();
        formData.append('csv',          selectedFile);
        formData.append('delimiter',    document.getElementById('opt-delimiter').value);
        formData.append('format',       document.getElementById('opt-format').value);
        formData.append('auto_types',   document.getElementById('opt-types').checked   ? '1' : '0');
        formData.append('has_header',   document.getElementById('opt-header').checked  ? '1' : '0');
        formData.append('pretty_print', document.getElementById('opt-pretty').checked  ? '1' : '0');
        formData.append('_token',       '{{ csrf_token() }}');

        setProcessStep('proc-1', 'active');
        animateProgress(0, 20, 800, 'Uploading file…');

        const t2 = setTimeout(() => {
            setProcessStep('proc-1', 'done');
            setProcessStep('proc-2', 'active');
            animateProgress(20, 50, 1000, 'Detecting headers & delimiter…');
        }, 1000);

        const t3 = setTimeout(() => {
            setProcessStep('proc-2', 'done');
            setProcessStep('proc-3', 'active');
            animateProgress(50, 75, 1200, 'Inferring data types…');
        }, 2200);

        const t4 = setTimeout(() => {
            setProcessStep('proc-3', 'done');
            setProcessStep('proc-4', 'active');
            animateProgress(75, 90, 1000, 'Generating JSON…');
        }, 3600);

        try {
            const res  = await fetch('', {
                method: 'POST',
                body:   formData,
            });

            clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

            const data = await res.json();

            if (!res.ok || !data.success) {
                throw new Error(data.message || 'Conversion failed. Please try again.');
            }

            setProcessStep('proc-3', 'done');
            setProcessStep('proc-4', 'done');
            animateProgress(90, 100, 400, 'Done!');

            setTimeout(() => {
                document.getElementById('download-link').href       = data.download_url;
                document.getElementById('output-size').textContent  = formatBytes(data.file_size) + ' · JSON File';
                document.getElementById('stat-rows').textContent    = data.row_count.toLocaleString();
                document.getElementById('stat-cols').textContent    = data.col_count.toLocaleString();
                document.getElementById('stat-size').textContent    = formatBytes(data.file_size);

                // Syntax-highlighted preview
                document.getElementById('json-preview').innerHTML = syntaxHighlight(data.preview_json);

                showState('download');
                updateStepIndicator(3);
                startExpiryTimer(3600);
            }, 500);

        } catch (err) {
            clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
            showError(err.message || 'Something went wrong. Please try again.');
            showState('upload');
            updateStepIndicator(1);
        }
    }

    // ── Copy button ──
    document.getElementById('copy-btn').addEventListener('click', function () {
        const text = document.getElementById('json-preview').textContent;
        navigator.clipboard.writeText(text).then(() => {
            this.classList.add('copy-btn-success');
            this.innerHTML = `
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Copied!
            `;
            setTimeout(() => {
                this.classList.remove('copy-btn-success');
                this.innerHTML = `
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    Copy
                `;
            }, 2000);
        });
    });

    // ── Syntax highlighter ──
    function syntaxHighlight(json) {
        if (typeof json !== 'string') json = JSON.stringify(json, null, 2);
        return json
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                let cls = 'num';
                if (/^"/.test(match)) {
                    cls = /:$/.test(match) ? 'key' : 'str';
                } else if (/true|false/.test(match)) {
                    cls = 'bool';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }
                return '<span class="' + cls + '">' + match + '</span>';
            });
    }

    // ── State switcher ──
    function showState(state) {
        ['upload','converting','download'].forEach(s => {
            document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
        });
        if (state === 'download') {
            document.getElementById('state-download').classList.add('bounce-in');
        }
    }

    // ── Step indicator ──
    function updateStepIndicator(active) {
        [1,2,3].forEach(n => {
            const el = document.getElementById('step-' + n);
            el.classList.remove('active','done');
            if (n < active)   el.classList.add('done');
            if (n === active) el.classList.add('active');
        });
    }

    // ── Processing steps ──
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

    // ── Progress bar ──
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

    // ── Expiry countdown ──
    function startExpiryTimer(seconds) {
        clearInterval(expiryInterval);
        let rem = seconds;
        expiryInterval = setInterval(() => {
            rem--;
            const m  = String(Math.floor(rem / 60)).padStart(2,'0');
            const s  = String(rem % 60).padStart(2,'0');
            const el = document.getElementById('expiry-timer');
            if (el) el.textContent = m + ':' + s;
            if (rem <= 0) clearInterval(expiryInterval);
        }, 1000);
    }

    // ── Reset ──
    window.resetConverter = function () {
        resetFile();
        showState('upload');
        updateStepIndicator(1);
        clearInterval(expiryInterval);
        animateProgress(0, 0, 0, 'Starting…');
        ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
    };

    // ── Error helpers ──
    function showError(msg) {
        errorText.textContent = msg;
        uploadError.classList.remove('hidden');
        uploadError.classList.add('flex');
    }
    function hideError() {
        uploadError.classList.add('hidden');
        uploadError.classList.remove('flex');
    }

    // ── Format bytes ──
    function formatBytes(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // ── FAQ accordion ──
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

@endsection
