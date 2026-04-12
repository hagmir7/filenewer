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
                @foreach([['1','Input CSV'],['2','Converting'],['3','Download']] as [$n, $label])
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
                            Paste CSV
                        </button>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file">

                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-4xl">
                                    📄</div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your CSV file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">or click to browse from your computer</p>
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
                           <p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>
                            <input type="file" id="file-input" accept=".csv,text/csv"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        {{-- File preview --}}
                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                                📄</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">data.csv</p>
                                <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">— · CSV File</p>
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

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text" class="hidden">
                        <div class="relative">
                            <textarea id="csv-textarea" rows="11" spellcheck="false"
                                placeholder="Paste your CSV here, e.g.&#10;Username;Identifier;First name;Department&#10;booker12;9012;Rachel;Sales&#10;grey07;2070;Laura;Depot"
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
                        <div id="csv-status" class="hidden mt-3 flex items-center gap-2 text-sm font-semibold"></div>
                    </div>{{-- /panel-text --}}

                    {{-- ══ SHARED OPTIONS ══ --}}
                    <div class="mt-5 space-y-3">

                        {{-- Row 1: Dialect + Table name --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- SQL Dialect --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">SQL Dialect</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach([
                                    ['mysql', 'MySQL', '🐬'],
                                    ['postgres', 'PostgreSQL', '🐘'],
                                    ['sqlite', 'SQLite', '🪶'],
                                    ] as [$val, $lbl, $icon])
                                    <button type="button"
                                        class="dialect-btn {{ $val === 'mysql' ? 'active' : '' }} flex flex-col items-center gap-1 py-2.5 px-2 rounded-xl border text-sm font-semibold transition-all"
                                        data-dialect="{{ $val }}">
                                        <span class="text-lg">{{ $icon }}</span>
                                        <span>{{ $lbl }}</span>
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Table name --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-table" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Table Name
                                </label>
                                <input type="text" id="opt-table" value="my_table" placeholder="e.g. users"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Used in <span
                                        class="font-mono text-fn-text2">INSERT INTO <span
                                            id="table-preview">my_table</span> …</span></p>
                            </div>
                        </div>

                        {{-- Row 2: Output mode + Filename --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Output mode --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Output</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach([
                                    ['file', 'Download .sql', '💾'],
                                    ['text', 'Preview SQL', '👁'],
                                    ] as [$val, $lbl, $icon])
                                    <button type="button"
                                        class="output-btn {{ $val === 'file' ? 'active' : '' }} flex items-center gap-2 py-2 px-3 rounded-xl border text-sm font-semibold transition-all"
                                        data-output="{{ $val }}">
                                        <span>{{ $icon }}</span>
                                        <span>{{ $lbl }}</span>
                                    </button>
                                    @endforeach
                                </div>
                                <p class="text-fn-text3 text-sm mt-2" id="output-hint">Returns a downloadable .sql file.
                                </p>
                            </div>

                            {{-- Filename (only relevant for file output) --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl" id="filename-wrap">
                                <label for="opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="e.g. users.sql"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to your table name with .sql extension
                                </p>
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
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        <span id="convert-btn-label">Generate SQL</span>
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📄</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-3xl">
                            🗄️</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Generating your SQL…</h2>
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
                        ['proc-1','Parsing CSV rows & headers'],
                        ['proc-2','Inferring column types'],
                        ['proc-3','Building INSERT statements'],
                        ['proc-4','Generating output'],
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

                {{-- ── STATE: Download / Preview ── --}}
                <div id="state-download" class="hidden py-6">

                    {{-- Success header --}}
                    <div class="text-center mb-6">
                        <div
                            class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                            ✅</div>
                        <h2 class="text-2xl font-bold mb-2">SQL Generated!</h2>
                        <p class="text-fn-text2 text-sm" id="download-subtitle">Your SQL file is ready.</p>
                    </div>

                    {{-- SQL preview (text output mode) --}}
                    <div id="sql-preview-wrap" class="hidden max-w-3xl mx-auto mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span id="dialect-badge"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-sm font-bold border"></span>
                                <p class="text-sm font-semibold text-fn-text2">SQL Preview</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span id="sql-preview-meta" class="text-sm text-fn-text3"></span>
                                <button type="button" id="btn-copy-sql"
                                    class="flex items-center gap-1.5 px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" />
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                    </svg>
                                    <span id="copy-label">Copy</span>
                                </button>
                            </div>
                        </div>
                        <div class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-hidden">
                            <pre id="sql-preview-code"
                                class="p-5 text-sm font-mono text-fn-text2 overflow-auto max-h-72 leading-relaxed whitespace-pre-wrap break-all"></pre>
                        </div>
                    </div>

                    {{-- File download card --}}
                    <div id="file-download-wrap"
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-2xl shrink-0">
                            🗄️</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">output.sql</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">SQL File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <div class="text-center">
                        <a id="download-link" href="#" download="output.sql"
                            class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                            style="background: oklch(67% 0.18 162);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            <span id="download-btn-label">Download SQL</span>
                        </a>

                        <div class="flex items-center justify-center gap-3 flex-wrap mt-1">
                            <button type="button" onclick="resetConverter()"
                                class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10" />
                                    <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                                </svg>
                                Convert another
                            </button>
                            <a href="/tools"
                                class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                                All tools
                            </a>
                        </div>

                        <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            Your file is encrypted and permanently deleted within 1 hour.
                        </p>
                    </div>

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
            ['Which SQL dialects are supported?', 'MySQL, PostgreSQL, and SQLite are all supported. Each dialect uses
            the correct syntax for CREATE TABLE and INSERT statements, including appropriate data types and quoting
            conventions.'],
            ['What does the converter generate?', 'It produces a complete .sql file with a CREATE TABLE statement (based
            on inferred column types) followed by INSERT INTO statements for every row in your CSV.'],
            ['Can I preview the SQL before downloading?', 'Yes — choose "Preview SQL" in the Output options. The
            generated SQL will be displayed inline so you can inspect and copy it before downloading.'],
            ['Does it handle different CSV separators?', 'Yes — comma, semicolon, tab, and pipe separators are all
            auto-detected from your CSV.'],
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

    .dialect-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
    }

    .dialect-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .dialect-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    .output-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
    }

    .output-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .output-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
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
      const csvTA       = document.getElementById('csv-textarea');
      const csvStatus   = document.getElementById('csv-status');
      const tableInput  = document.getElementById('opt-table');
      const tablePreview = document.getElementById('table-preview');
      const outputHint  = document.getElementById('output-hint');
      const filenameWrap = document.getElementById('filename-wrap');

      let selectedFile = null;
      let blobUrl      = null;
      let activeTab    = 'file';
      let activeDialect = 'mysql';
      let activeOutput  = 'file';
      let csvValid      = false;
      let fullSqlText   = ''; // stored for copy button

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

      // ── Table name live preview ──
      tableInput.addEventListener('input', () => {
        tablePreview.textContent = tableInput.value.trim() || 'my_table';
      });

      // ── Dialect buttons ──
      document.querySelectorAll('.dialect-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.dialect-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeDialect = btn.dataset.dialect;
        });
      });

      // ── Output mode buttons ──
      document.querySelectorAll('.output-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.output-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeOutput = btn.dataset.output;
          const isFile = activeOutput === 'file';
          outputHint.textContent = isFile
            ? 'Returns a downloadable .sql file.'
            : 'Displays the generated SQL inline with a copy button.';
          filenameWrap.style.opacity = isFile ? '1' : '0.4';
          document.getElementById('opt-filename').disabled = !isFile;
          document.getElementById('convert-btn-label').textContent = isFile ? 'Generate SQL' : 'Preview SQL';
        });
      });

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
        const ext = file.name.toLowerCase();
        if (!ext.endsWith('.csv') && file.type !== 'text/csv' && file.type !== 'text/plain') {
          showError('Please select a valid CSV file.');
          return;
        }
        if (file.size > 50 * 1024 * 1024) {
          showError('File exceeds the 50MB free limit.');
          return;
        }
        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · CSV File';
        const fnInput = document.getElementById('opt-filename');
        if (!fnInput.value) fnInput.value = file.name.replace(/\.csv$/i, '.sql');
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

      // ── CSV text validation ──
      let validateTimer = null;
      csvTA.addEventListener('input', () => {
        clearTimeout(validateTimer);
        validateTimer = setTimeout(validateCsv, 300);
      });

      function validateCsv() {
        const raw = csvTA.value.trim();
        if (!raw) {
          csvStatus.classList.add('hidden');
          csvValid = false;
          refreshConvertBtn();
          return;
        }
        const lines = raw.split('\n').filter(Boolean);
        if (lines.length < 2) {
          csvValid = false;
          csvStatus.innerHTML = errStatus('Need at least a header row and one data row');
        } else {
          csvValid = true;
          const cols = lines[0].split(/[,;\t|]/).length;
          csvStatus.innerHTML = okStatus(`Valid CSV · ${lines.length - 1} row${lines.length - 1 !== 1 ? 's' : ''} · ${cols} column${cols !== 1 ? 's' : ''}`);
        }
        csvStatus.classList.remove('hidden');
        csvStatus.classList.add('flex');
        refreshConvertBtn();
      }

      function okStatus(msg) {
        return `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green"><polyline points="20 6 9 17 4 12"/></svg><span class="text-fn-green">${msg}</span>`;
      }
      function errStatus(msg) {
        return `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-red"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><span class="text-fn-red">${msg}</span>`;
      }

      // Paste & clear
      document.getElementById('btn-paste').addEventListener('click', async () => {
        try { csvTA.value = await navigator.clipboard.readText(); validateCsv(); } catch (_) {}
      });
      document.getElementById('btn-clear').addEventListener('click', () => {
        csvTA.value = ''; csvStatus.classList.add('hidden'); csvValid = false; refreshConvertBtn();
      });

      function refreshConvertBtn() {
        convertBtn.disabled = activeTab === 'file' ? !selectedFile : !csvValid;
      }

      // ── Convert ──
      convertBtn.addEventListener('click', startConversion);

      async function startConversion() {
        hideError();
        showState('converting');
        updateStepIndicator(2);

        const isFile     = activeTab === 'file';
        const tableName  = tableInput.value.trim() || 'my_table';
        const customFile = document.getElementById('opt-filename').value.trim();
        const outputFilename = customFile
          ? (customFile.toLowerCase().endsWith('.sql') ? customFile : customFile + '.sql')
          : tableName + '.sql';

        let endpoint, fetchBody, fetchHeaders = {};

        if (isFile) {
          // multipart/form-data → /api/tools/csv-file-to-sql
          endpoint = 'https://api.filenewer.com/api/tools/csv-file-to-sql';
          const formData = new FormData();
          formData.append('file',       selectedFile);
          formData.append('table_name', tableName);
          formData.append('dialect',    activeDialect);
          formData.append('output',     activeOutput);
          if (customFile) formData.append('filename', customFile);
          fetchBody = formData;
        } else {
          // application/json → /api/tools/csv-text-to-sql
          endpoint = 'https://api.filenewer.com/api/tools/csv-text-to-sql';
          const payload = {
            csv:        csvTA.value.trim(),
            table_name: tableName,
            dialect:    activeDialect,
            output:     activeOutput,
          };
          if (customFile) payload.filename = customFile;
          fetchBody    = JSON.stringify(payload);
          fetchHeaders = { 'Content-Type': 'application/json' };
        }

        // Animate
        setProcessStep('proc-1', 'active');
        animateProgress(0, 22, 600, 'Parsing CSV rows & headers…');

        const t2 = setTimeout(() => {
          setProcessStep('proc-1', 'done');
          setProcessStep('proc-2', 'active');
          animateProgress(22, 50, 800, 'Inferring column types…');
        }, 700);

        const t3 = setTimeout(() => {
          setProcessStep('proc-2', 'done');
          setProcessStep('proc-3', 'active');
          animateProgress(50, 76, 800, 'Building INSERT statements…');
        }, 1600);

        const t4 = setTimeout(() => {
          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'active');
          animateProgress(76, 90, 600, 'Generating output…');
        }, 2600);

        try {
          const res = await fetch(endpoint, {
            method:  'POST',
            headers: fetchHeaders,
            body:    fetchBody,
          });

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!res.ok) {
            let errMsg = 'Conversion failed. Please try again.';
            try { const d = await res.json(); if (d.error) errMsg = d.error; } catch (_) {}
            throw new Error(errMsg);
          }

          const dialectLabels = { mysql: '🐬 MySQL', postgres: '🐘 PostgreSQL', sqlite: '🪶 SQLite' };
          const dialectColors = {
            mysql:    { bg: 'oklch(62% 0.18 200 / 12%)', border: 'oklch(62% 0.18 200 / 35%)', color: 'oklch(62% 0.18 200)' },
            postgres: { bg: 'oklch(55% 0.20 260 / 12%)', border: 'oklch(55% 0.20 260 / 35%)', color: 'oklch(55% 0.20 260)' },
            sqlite:   { bg: 'oklch(65% 0.15 55  / 12%)', border: 'oklch(65% 0.15 55  / 35%)', color: 'oklch(65% 0.15 55)'  },
          };

          if (activeOutput === 'text') {
            // Response is JSON { sql: "...", table: "...", dialect: "..." }
            const data    = await res.json();
            const sqlText = data.sql ?? '';
            fullSqlText   = sqlText;

            const blob    = new Blob([sqlText], { type: 'text/plain;charset=utf-8;' });
            if (blobUrl) URL.revokeObjectURL(blobUrl);
            blobUrl = URL.createObjectURL(blob);

            const link    = document.getElementById('download-link');
            link.href     = blobUrl;
            link.download = outputFilename;

            // Populate preview
            const previewCode = document.getElementById('sql-preview-code');
            const PREVIEW_LIMIT = 8000;
            previewCode.textContent = sqlText.length > PREVIEW_LIMIT
              ? sqlText.slice(0, PREVIEW_LIMIT) + '\n\n-- … truncated for preview, full file in download …'
              : sqlText;

            const lines = sqlText.split('\n').length;
            document.getElementById('sql-preview-meta').textContent = `${lines} lines · ${formatBytes(blob.size)}`;

            // Dialect badge
            const badge = document.getElementById('dialect-badge');
            const dc    = dialectColors[activeDialect];
            badge.textContent   = dialectLabels[activeDialect];
            badge.style.background   = dc.bg;
            badge.style.borderColor  = dc.border;
            badge.style.color        = dc.color;

            document.getElementById('sql-preview-wrap').classList.remove('hidden');
            document.getElementById('download-subtitle').textContent = 'SQL preview ready — copy or download the file.';

          } else {
            // Response is binary .sql file
            const blob = await res.blob();
            if (blobUrl) URL.revokeObjectURL(blobUrl);
            blobUrl = URL.createObjectURL(blob);

            const link    = document.getElementById('download-link');
            link.href     = blobUrl;
            link.download = outputFilename;

            // Also read for copy support
            fullSqlText = await blob.text();

            document.getElementById('sql-preview-wrap').classList.add('hidden');
            document.getElementById('download-subtitle').textContent = 'Your SQL file is ready.';
            document.getElementById('output-name').textContent = outputFilename;
            document.getElementById('output-size').textContent = formatBytes(blob.size) + ` · ${dialectLabels[activeDialect]} SQL`;
          }

          document.getElementById('output-name').textContent       = outputFilename;
          document.getElementById('output-size').textContent       = formatBytes(new Blob([fullSqlText]).size) + ` · ${dialectLabels[activeDialect]} SQL`;
          document.getElementById('download-btn-label').textContent = 'Download SQL';

          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'done');
          animateProgress(90, 100, 300, 'Done!');

          setTimeout(() => { showState('download'); updateStepIndicator(3); }, 500);

        } catch (err) {
          console.error(err);
          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
          showError(err.message || 'Something went wrong. Please try again.');
          showState('upload');
          updateStepIndicator(1);
        }
      }

      // ── Copy SQL button ──
      document.getElementById('btn-copy-sql').addEventListener('click', async () => {
        if (!fullSqlText) return;
        try {
          await navigator.clipboard.writeText(fullSqlText);
          const label = document.getElementById('copy-label');
          label.textContent = 'Copied!';
          setTimeout(() => { label.textContent = 'Copy'; }, 2000);
        } catch (_) {}
      });

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
        csvTA.value = '';
        csvStatus.classList.add('hidden');
        csvValid    = false;
        fullSqlText = '';
        tableInput.value = 'my_table';
        tablePreview.textContent = 'my_table';
        document.getElementById('opt-filename').value = '';
        document.getElementById('opt-filename').disabled = false;
        filenameWrap.style.opacity = '1';
        // Reset dialect to mysql
        document.querySelectorAll('.dialect-btn').forEach(b => b.classList.remove('active'));
        document.querySelector('.dialect-btn[data-dialect="mysql"]').classList.add('active');
        activeDialect = 'mysql';
        // Reset output to file
        document.querySelectorAll('.output-btn').forEach(b => b.classList.remove('active'));
        document.querySelector('.output-btn[data-output="file"]').classList.add('active');
        activeOutput = 'file';
        outputHint.textContent = 'Returns a downloadable .sql file.';
        document.getElementById('convert-btn-label').textContent = 'Generate SQL';
        document.getElementById('sql-preview-wrap').classList.add('hidden');
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
