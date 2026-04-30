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
                @foreach([['1','Input SQL'],['2','Converting'],['3','Download']] as [$n, $label])
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
                            Paste SQL
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .sql
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">SQL source</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Sample</button>
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

                        <textarea id="sql-textarea" rows="12" spellcheck="false"
                            placeholder='Paste SQL with CREATE TABLE and/or INSERT INTO statements, e.g.&#10;&#10;CREATE TABLE users (&#10;  id INTEGER PRIMARY KEY,&#10;  username TEXT NOT NULL,&#10;  age INTEGER&#10;);&#10;&#10;INSERT INTO users VALUES (1, &#39;alice&#39;, 30);&#10;INSERT INTO users VALUES (2, &#39;bob&#39;, 25);'
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>

                        <div class="flex items-center justify-between text-xs mt-1.5">
                            <span id="sql-status" class="text-fn-text3">Paste SQL with CREATE TABLE or INSERT
                                statements</span>
                            <span id="sql-meta" class="text-fn-text3/70">0 chars · 0 lines</span>
                        </div>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-fn-purple">
                                        <ellipse cx="12" cy="5" rx="9" ry="3" />
                                        <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5" />
                                        <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your SQL file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .sql files — or click to browse</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose SQL File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input" accept=".sql,application/sql,text/sql,text/plain"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" class="text-fn-purple">
                                    <ellipse cx="12" cy="5" rx="9" ry="3" />
                                    <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5" />
                                    <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">database.sql</p>
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
                    </div>

                    {{-- Detected tables preview --}}
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
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2" id="detected-sheets"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">Output Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Output filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="database.xlsx"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Extra sheets</label>
                                <div class="flex flex-col gap-1.5">
                                    @foreach([
                                    ['opt-stats', 'Summary sheet', 'File stats overview', true],
                                    ['opt-schema', 'Schema sheet', 'Column types & constraints', true],
                                    ] as [$tid, $tlabel, $tdesc, $tdefault])
                                    <label
                                        class="flex items-center gap-2 cursor-pointer select-none px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg hover:border-fn-blue/25 transition-colors">
                                        <div class="toggle-wrap relative w-8 h-4 shrink-0">
                                            <input type="checkbox" id="{{ $tid }}" {{ $tdefault ? 'checked' : '' }}
                                                class="sr-only peer" />
                                            <div
                                                class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                            </div>
                                            <div
                                                class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-fn-text2">{{ $tlabel }}</p>
                                            <p class="text-xs text-fn-text3 leading-tight">{{ $tdesc }}</p>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
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
                            class="w-16 h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" class="text-fn-purple">
                                <ellipse cx="12" cy="5" rx="9" ry="3" />
                                <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5" />
                                <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3" />
                            </svg>
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

                    <h2 class="text-xl font-bold mb-2">Converting SQL to Excel…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Parsing tables, schemas, and INSERT data</p>

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
                        ['proc-1','Reading SQL content'],
                        ['proc-2','Parsing CREATE TABLE schemas'],
                        ['proc-3','Extracting INSERT data'],
                        ['proc-4','Building Excel workbook'],
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
                    <p class="text-fn-text2 text-sm mb-6">Your Excel file is ready with one sheet per table.</p>

                    {{-- Sheets generated --}}
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
                            <p class="font-semibold text-sm truncate" id="output-name">database.xlsx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Excel Workbook</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="database.xlsx"
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

            </div>
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @foreach([
            ['What SQL syntax is supported?', 'Standard CREATE TABLE statements (with or without IF NOT EXISTS) for
            schema, and INSERT INTO statements for data — both `INSERT INTO table VALUES (...)` and `INSERT INTO table
            (cols) VALUES (...)` forms. Single-line comments (`--`) and block comments (`/* */`) are stripped
            automatically.'],
            ['How are multiple tables handled?', 'Each table in your SQL becomes its own sheet in the Excel workbook,
            named after the table. The Schema sheet (if enabled) lists every table with its columns, types, and
            constraints in one consolidated view.'],
            ['What about NULL values and quoted strings?', 'NULL becomes an empty cell. Single-quoted strings have
            escaped quotes (`it\'\'s`) handled correctly. Numeric values are auto-detected and right-aligned. Booleans
            (TRUE/FALSE) are converted appropriately.'],
            ['What\'s in the Schema sheet?', 'For each CREATE TABLE statement found, the Schema sheet lists every column
            with its declared SQL type (TEXT, INTEGER, etc.) and any constraints (PRIMARY KEY, NOT NULL, AUTOINCREMENT,
            FOREIGN KEY, defaults). Useful for documenting database structures.'],
            ['Is my SQL safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
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
<x-tools-section />

<style>
    .tab-btn {
        color: var(--fn-text3);
    }

    .tab-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0 / 12%);
    }

    .sheet-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 600;
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

    .sheet-summary .sheet-dot {
        background: oklch(62% 0.20 250);
    }

    .sheet-summary {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .sheet-schema .sheet-dot {
        background: oklch(60% 0.22 295);
    }

    .sheet-schema {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .sheet-table .sheet-dot {
        background: oklch(67% 0.18 162);
    }

    .sheet-table {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_SQL = `-- Users table with sample data
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  email TEXT,
  age INTEGER,
  department TEXT,
  active BOOLEAN DEFAULT TRUE
);

INSERT INTO users (id, username, email, age, department, active) VALUES (1, 'booker12', 'booker@mail.com', 30, 'Sales', TRUE);
INSERT INTO users (id, username, email, age, department, active) VALUES (2, 'grey07', 'grey@mail.com', 25, 'Depot', TRUE);
INSERT INTO users (id, username, email, age, department, active) VALUES (3, 'johnson81', NULL, 35, 'Engineering', FALSE);

-- Orders table
CREATE TABLE orders (
  id INTEGER PRIMARY KEY,
  user_id INTEGER,
  product TEXT,
  quantity INTEGER,
  price REAL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO orders VALUES (1, 1, 'Widget', 5, 19.99);
INSERT INTO orders VALUES (2, 1, 'Gadget', 2, 49.50);
INSERT INTO orders VALUES (3, 2, 'Gizmo', 10, 5.00);
`;

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
  const sqlTA       = document.getElementById('sql-textarea');

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
    sqlTA.value = SAMPLE_SQL;
    sqlTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { sqlTA.value = await navigator.clipboard.readText(); sqlTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    sqlTA.value = '';
    sqlTA.dispatchEvent(new Event('input'));
  });

  // ── Textarea input ──
  sqlTA.addEventListener('input', () => {
    const v = sqlTA.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('sql-meta').textContent = v.length.toLocaleString() + ' chars · ' + lines + ' lines';

    // Live SQL detection status
    const status = document.getElementById('sql-status');
    if (!v.trim()) {
      status.innerHTML = '<span class="text-fn-text3">Paste SQL with CREATE TABLE or INSERT statements</span>';
    } else {
      const stats = analyzeSql(v);
      const tableCount = stats.tables.length;
      const insertCount = stats.totalInserts;
      if (tableCount > 0 || insertCount > 0) {
        const parts = [];
        if (tableCount > 0)  parts.push(`${tableCount} table${tableCount !== 1 ? 's' : ''}`);
        if (insertCount > 0) parts.push(`${insertCount} INSERT${insertCount !== 1 ? 's' : ''}`);
        status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Detected ${parts.join(' · ')}
        </span>`;
      } else {
        status.innerHTML = '<span class="text-fn-amber">No CREATE TABLE or INSERT statements detected — server will try to parse anyway</span>';
      }
    }

    refreshConvertBtn();
    clearTimeout(detectTimer);
    detectTimer = setTimeout(refreshDetection, 250);
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
    if (!name.match(/\.(sql|txt)$/)) {
      showError('Please select a valid SQL file (.sql).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · SQL';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');

    // Read file for client-side detection (only if reasonable size)
    if (file.size < 5 * 1024 * 1024) {
      try {
        const text = await file.text();
        detectFromText(text);
      } catch(_) {}
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
    if (activeTab === 'text') convertBtn.disabled = !sqlTA.value.trim();
    else                      convertBtn.disabled = !selectedFile;
  }

  // ── Detection preview ──
  function refreshDetection() {
    if (activeTab === 'text') {
      const v = sqlTA.value.trim();
      if (!v) { document.getElementById('detected-content').classList.add('hidden'); return; }
      detectFromText(v);
    }
  }

  function detectFromText(sql) {
    const stats = analyzeSql(sql);
    const wrap = document.getElementById('detected-content');
    const list = document.getElementById('detected-sheets');
    list.innerHTML = '';

    const sheets = [];
    if (document.getElementById('opt-stats').checked) {
      sheets.push(['summary', 'Summary', '—']);
    }
    if (document.getElementById('opt-schema').checked && stats.tables.length > 0) {
      sheets.push(['schema', 'Schema', stats.tables.length + ' tables']);
    }
    stats.tables.forEach(t => {
      sheets.push(['table', t.name, t.inserts + ' rows']);
    });

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

  // Lightweight SQL analyzer — strips comments, finds CREATE TABLE + INSERT INTO statements
  function analyzeSql(sql) {
    // Strip block comments and line comments
    let cleaned = sql
      .replace(/\/\*[\s\S]*?\*\//g, '')   // /* ... */
      .replace(/--[^\n]*/g, '');           // -- ...

    const tables = {};

    // CREATE TABLE
    const createRe = /CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"\[]?([\w]+)[`"\]]?\s*\(/gi;
    let m;
    while ((m = createRe.exec(cleaned)) !== null) {
      const name = m[1];
      if (!tables[name]) tables[name] = { name, inserts: 0 };
    }

    // INSERT INTO
    const insertRe = /INSERT\s+INTO\s+[`"\[]?([\w]+)[`"\]]?/gi;
    let totalInserts = 0;
    while ((m = insertRe.exec(cleaned)) !== null) {
      const name = m[1];
      if (!tables[name]) tables[name] = { name, inserts: 0 };
      tables[name].inserts++;
      totalInserts++;
    }

    return {
      tables: Object.values(tables),
      totalInserts,
    };
  }

  // Re-detect when toggles change
  document.getElementById('opt-stats').addEventListener('change', refreshDetection);
  document.getElementById('opt-schema').addEventListener('change', refreshDetection);

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const customFilename = document.getElementById('opt-filename').value.trim();
    const includeStats   = document.getElementById('opt-stats').checked;
    const includeSchema  = document.getElementById('opt-schema').checked;

    let outName;
    if (customFilename) {
      outName = customFilename.toLowerCase().endsWith('.xlsx') ? customFilename : customFilename + '.xlsx';
    } else if (activeTab === 'file' && selectedFile) {
      outName = selectedFile.name.replace(/\.(sql|txt)$/i, '') + '.xlsx';
    } else {
      outName = 'database.xlsx';
    }

    let endpoint, fetchBody, fetchHeaders = {};
    let sqlForDetection = '';

    if (activeTab === 'file') {
      endpoint = 'https://api.filenewer.com/api/tools/sql-file-to-excel/';
      const fd = new FormData();
      fd.append('file',           selectedFile);
      fd.append('include_stats',  includeStats);
      fd.append('include_schema', includeSchema);
      if (customFilename) fd.append('output_filename', outName);
      fetchBody = fd;
      try {
        if (selectedFile.size < 5 * 1024 * 1024) sqlForDetection = await selectedFile.text();
      } catch(_) {}
    } else {
      endpoint = 'https://api.filenewer.com/api/tools/sql-text-to-excel/';
      sqlForDetection = sqlTA.value;
      const payload = {
        sql:            sqlTA.value,
        include_stats:  includeStats,
        include_schema: includeSchema,
      };
      if (customFilename) payload.output_filename = outName;
      fetchBody    = JSON.stringify(payload);
      fetchHeaders = { 'Content-Type': 'application/json' };
    }

    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 500, 'Reading SQL content…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 55, 700, 'Parsing CREATE TABLE schemas…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 80, 700, 'Extracting INSERT data…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(80, 92, 500, 'Building Excel workbook…');
    }, 2200);

    try {
      const res = await fetch(endpoint, { method: 'POST', headers: fetchHeaders, body: fetchBody });
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
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

      // Render result sheet chips from client-side analysis
      if (sqlForDetection.trim()) {
        renderResultSheets(sqlForDetection, includeStats, includeSchema);
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

  function renderResultSheets(sql, includeStats, includeSchema) {
    const stats = analyzeSql(sql);
    const wrap = document.getElementById('result-sheets-wrap');
    const list = document.getElementById('result-sheets');
    list.innerHTML = '';

    const sheets = [];
    if (includeStats) sheets.push(['summary', 'Summary', '—']);
    if (includeSchema && stats.tables.length > 0) sheets.push(['schema', 'Schema', stats.tables.length + ' tables']);
    stats.tables.forEach(t => sheets.push(['table', t.name, t.inserts + ' rows']));

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
    check.classList.add('hidden'); spin.classList.add('hidden');
    dot.style.borderColor = ''; dot.style.background = '';
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
      const t = Math.min((now - start) / duration, 1);
      const pct = Math.round(from + (to - from) * t);
      document.getElementById('progress-fill').style.width = pct + '%';
      document.getElementById('progress-pct').textContent = pct + '%';
      if (t < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  window.resetConverter = function () {
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    resetFile();
    sqlTA.value = '';
    sqlTA.dispatchEvent(new Event('input'));
    document.getElementById('opt-filename').value = '';
    document.getElementById('opt-stats').checked  = true;
    document.getElementById('opt-schema').checked = true;
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
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const body = btn.nextElementSibling;
      const icon = btn.querySelector('.faq-icon');
      const isOpen = !body.classList.contains('hidden');
      document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
      document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
      if (!isOpen) { body.classList.remove('hidden'); icon.style.transform = 'rotate(180deg)'; }
    });
  });

});
</script>
@endpush

@endsection
