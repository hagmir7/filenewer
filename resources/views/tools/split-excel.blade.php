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
                @foreach([['1','Upload File'],['2','Splitting'],['3','Download']] as [$n, $label])
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
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-green/40 hover:bg-fn-green/4 relative transition-colors">
                        <div class="flex items-center justify-center mb-5">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-fn-green">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <line x1="3" y1="9" x2="21" y2="9" />
                                    <line x1="3" y1="15" x2="21" y2="15" />
                                    <line x1="9" y1="3" x2="9" y2="21" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your Excel workbook here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .xlsx and .xls files — or click to browse</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose Excel File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                        <input type="file" id="file-input"
                            accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                            style="background: oklch(67% 0.18 162 / 12%); border: 1px solid oklch(67% 0.18 162 / 22%)">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" style="color: oklch(55% 0.18 162)">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <line x1="3" y1="9" x2="21" y2="9" />
                                <line x1="3" y1="15" x2="21" y2="15" />
                                <line x1="9" y1="3" x2="9" y2="21" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">workbook.xlsx</p>
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

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold text-fn-text2">Split Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">

                            {{-- Left: split mode --}}
                            <div class="flex flex-col gap-3">

                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Split mode</label>
                                    <div class="flex flex-col gap-1.5">
                                        @foreach([
                                        ['split-sheet', 'sheet', '📑', 'One file per sheet', 'Each tab becomes its own
                                        .xlsx file', true],
                                        ['split-chunk', 'chunk', '✂️', 'Split by row count', 'Divide each sheet every N
                                        rows', false],
                                        ['split-sheets', 'sheets', '🎯', 'Extract specific sheets', 'Choose which sheets
                                        to extract by name', false],
                                        ] as [$mid, $mval, $micon, $mlabel, $mdesc, $mdefault])
                                        <label id="{{ $mid }}-wrap"
                                            class="mode-card {{ $mdefault ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 border rounded-xl cursor-pointer transition-all">
                                            <input type="radio" name="split_by" value="{{ $mval }}" {{ $mdefault
                                                ? 'checked' : '' }} class="sr-only split-mode-radio" />
                                            <span class="text-xl shrink-0">{{ $micon }}</span>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-bold text-fn-text">{{ $mlabel }}</p>
                                                <p class="text-xs text-fn-text3 leading-tight">{{ $mdesc }}</p>
                                            </div>
                                            <div
                                                class="shrink-0 w-4 h-4 rounded-full border-2 border-fn-text/20 mode-radio-dot flex items-center justify-center transition-all">
                                                <div
                                                    class="w-2 h-2 rounded-full bg-fn-blue scale-0 mode-radio-fill transition-transform">
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            {{-- Right: dynamic options per mode --}}
                            <div class="flex flex-col gap-3">

                                {{-- Chunk size (shown for chunk mode) --}}
                                <div id="opt-chunk-wrap" class="hidden flex flex-col gap-1.5">
                                    <label for="opt-chunk-size" class="text-xs font-semibold text-fn-text2 block">
                                        Rows per chunk
                                    </label>
                                    <input type="number" id="opt-chunk-size" value="100" min="1" max="100000" step="1"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40" />
                                    <p class="text-xs text-fn-text3">Each sheet is divided into parts of this many rows.
                                        Headers are preserved in every chunk.</p>
                                </div>

                                {{-- Sheet name picker (shown for sheets mode) --}}
                                <div id="opt-sheets-wrap" class="hidden flex flex-col gap-1.5">
                                    <label class="text-xs font-semibold text-fn-text2 block">
                                        Sheet names to extract
                                        <span class="font-normal text-fn-text3 ml-1">(one per line)</span>
                                    </label>
                                    <textarea id="opt-sheets-input" rows="4" spellcheck="false"
                                        placeholder="Sales&#10;HR&#10;Finance"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50 resize-none leading-relaxed"></textarea>
                                    <p class="text-xs text-fn-text3">Sheet names are case-sensitive. Leave blank to
                                        extract all sheets.</p>
                                </div>

                                {{-- Default helper (shown for sheet mode) --}}
                                <div id="opt-sheet-help" class="flex flex-col gap-2">
                                    <div
                                        class="p-3 bg-fn-blue/6 border border-fn-blue/15 rounded-xl flex items-start gap-2">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-fn-blue-l shrink-0 mt-0.5">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" y1="8" x2="12" y2="12" />
                                            <line x1="12" y1="16" x2="12.01" y2="16" />
                                        </svg>
                                        <p class="text-xs text-fn-text2 leading-relaxed">Each sheet in your workbook
                                            becomes a separate <span class="font-mono font-semibold">.xlsx</span> file.
                                            All files are bundled into a <span
                                                class="font-mono font-semibold">.zip</span> archive for download.</p>
                                    </div>
                                    <div
                                        class="p-3 bg-fn-surface border border-fn-text/8 rounded-xl flex items-start gap-2">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-fn-green shrink-0 mt-0.5">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                            <polyline points="22 4 12 14.01 9 11.01" />
                                        </svg>
                                        <p class="text-xs text-fn-text2 leading-relaxed">Upload first to preview the
                                            sheets inside your workbook before splitting.</p>
                                    </div>
                                </div>

                                {{-- Output mode --}}
                                <div>
                                    <label for="opt-output"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Output</label>
                                    <select id="opt-output"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="zip" selected>Download .zip of .xlsx files</option>
                                        <option value="json">Metadata only (JSON preview)</option>
                                    </select>
                                </div>

                                {{-- Output filename --}}
                                <div>
                                    <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Output filename
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-filename" placeholder="split_sheets.zip"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
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
                        <span id="split-btn-label">Split Excel File</span>
                    </button>
                </div>

                {{-- ── STATE: Splitting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center"
                            style="background: oklch(67% 0.18 162 / 10%); border: 1px solid oklch(67% 0.18 162 / 22%)">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" style="color: oklch(55% 0.18 162)" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <line x1="3" y1="9" x2="21" y2="9" />
                                <line x1="3" y1="15" x2="21" y2="15" />
                                <line x1="9" y1="3" x2="9" y2="21" />
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
                        <div class="flex items-center gap-1.5">
                            <div class="w-9 h-11 rounded-lg bg-fn-green/10 border border-fn-green/20 flex items-center justify-center"
                                style="font-size:10px; color: oklch(55% 0.18 162); font-weight:700">S1</div>
                            <div class="w-9 h-11 rounded-lg bg-fn-green/10 border border-fn-green/20 flex items-center justify-center"
                                style="font-size:10px; color: oklch(55% 0.18 162); font-weight:700">S2</div>
                            <div class="w-9 h-11 rounded-lg bg-fn-green/10 border border-fn-green/20 flex items-center justify-center"
                                style="font-size:10px; color: oklch(55% 0.18 162); font-weight:700">S3</div>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold mb-2" id="splitting-title">Splitting Excel File…</h2>
                    <p class="text-fn-text3 text-sm mb-8" id="converting-subtitle">Reading workbook &amp; extracting
                        sheets</p>

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
                        ['proc-1', 'Reading workbook'],
                        ['proc-2', 'Applying split strategy'],
                        ['proc-3', 'Writing output files'],
                        ['proc-4', 'Packaging .zip archive'],
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
                <div id="state-download" class="hidden py-4">

                    {{-- ZIP download state --}}
                    <div id="zip-result" class="hidden text-center py-4">
                        <div
                            class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                            ✅</div>
                        <h2 class="text-2xl font-bold mb-2">Split Complete!</h2>
                        <p class="text-fn-text2 text-sm mb-6" id="zip-subtitle">Your files are ready inside a .zip
                            archive.</p>

                        <div id="result-info-wrap" class="hidden max-w-2xl mx-auto mb-6">
                            <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Split details</p>
                            <div class="flex flex-wrap gap-2 justify-start" id="result-chips"></div>
                        </div>

                        <div
                            class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                                🗜️</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="output-name">split_sheets.zip</p>
                                <p class="text-fn-text3 text-sm mt-0.5" id="output-size">ZIP Archive</p>
                            </div>
                            <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                        </div>

                        <a id="download-link" href="#" download="split_sheets.zip"
                            class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                            style="background: oklch(67% 0.18 162);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Download ZIP
                        </a>
                    </div>

                    {{-- JSON / metadata result --}}
                    <div id="json-result" class="hidden">
                        <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-base">
                                    ✅</div>
                                <div>
                                    <p class="font-bold text-sm" id="json-result-title">Metadata preview</p>
                                    <p class="text-fn-text3 text-xs" id="json-result-meta">—</p>
                                </div>
                            </div>
                            <button type="button" id="btn-copy-json"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg hover:text-fn-text transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                Copy JSON
                            </button>
                        </div>

                        {{-- Parts table --}}
                        <div id="parts-table-wrap" class="hidden mb-4 overflow-x-auto">
                            <table class="w-full text-xs border-collapse">
                                <thead>
                                    <tr class="border-b border-fn-text/10 bg-fn-surface2">
                                        <th class="text-left py-2 px-3 font-bold text-fn-text2">#</th>
                                        <th class="text-left py-2 px-3 font-bold text-fn-text2">Filename</th>
                                        <th class="text-left py-2 px-3 font-bold text-fn-text2">Sheet</th>
                                        <th class="text-right py-2 px-3 font-bold text-fn-text2">Rows</th>
                                        <th class="text-right py-2 px-3 font-bold text-fn-text2">Cols</th>
                                        <th class="text-right py-2 px-3 font-bold text-fn-text2">Size</th>
                                    </tr>
                                </thead>
                                <tbody id="parts-tbody" class="divide-y divide-fn-text/7"></tbody>
                            </table>
                        </div>

                        <pre id="json-preview"
                            class="bg-fn-surface2 border border-fn-text/10 rounded-xl px-4 py-3 text-xs font-mono text-fn-text2 overflow-auto max-h-80 leading-relaxed whitespace-pre-wrap"></pre>
                    </div>

                    <div class="flex items-center justify-center gap-3 flex-wrap mt-6">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Split another file
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


{{-- ══ SPLIT MODES ══ --}}
<section class="py-12 border-t border-fn-text/7 bg-fn-surface2">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-lg font-bold mb-1 text-center">Split Modes Explained</h2>
        <p class="text-fn-text3 text-sm text-center mb-6">Three ways to break your workbook into parts</p>
        <div class="grid sm:grid-cols-3 gap-4">
            @foreach([
            ['📑', 'One file per sheet', 'sheet', 'Each tab in the workbook becomes its own .xlsx file, named after the
            sheet. Best for workbooks where each sheet represents a different dataset, region, or time period.'],
            ['✂️', 'Split by row count', 'chunk', 'Every sheet is divided into chunks of N rows, with the header row
            preserved in each chunk. Best for large sheets that need to be imported into systems with row limits.'],
            ['🎯', 'Extract sheets', 'sheets', 'Pick exactly which sheet names to extract. Only those sheets are
            included in the output ZIP. Best for pulling specific sheets from a large workbook without the rest.'],
            ] as [$icon, $name, $val, $desc])
            <div class="p-5 bg-fn-surface border border-fn-text/8 rounded-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <span class="text-2xl">{{ $icon }}</span>
                    <div>
                        <p class="font-bold text-sm">{{ $name }}</p>
                        <code class="text-xs font-mono text-fn-text3">split_by={{ $val }}</code>
                    </div>
                </div>
                <p class="text-xs text-fn-text2 leading-relaxed">{{ $desc }}</p>
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
            ['What format are the output files?', 'Each part is saved as a standard .xlsx file. In zip output mode all
            parts are bundled into a single .zip archive for download. In JSON mode you receive metadata only — no files
            are generated.'],
            ['Does splitting by chunk preserve headers?', 'Yes. When splitting by row count (chunk mode), the header row
            from the first row of each sheet is automatically included at the top of every chunk file. This means each
            chunk is a standalone, fully-labelled spreadsheet.'],
            ['What happens with hidden sheets?', 'Hidden sheets are included in the output by default. If you want to
            exclude them, use the "Extract specific sheets" mode and list only the visible sheet names you need.'],
            ['Can I extract just one sheet?', 'Yes — use "Extract specific sheets" mode and enter a single sheet name.
            You will receive a ZIP containing just that one .xlsx file.'],
            ['What is the JSON / metadata output?', 'Selecting "Metadata only" returns a JSON object listing every part
            that would be generated — including filename, sheet name, row count, column count, and estimated size in KB
            — without producing any files. Useful for previewing a split before downloading.'],
            ['Is my Excel file safe and private?', 'All uploads use AES-256 encryption in transit and are permanently
            deleted within 1 hour. We never read, share, or store your content.'],
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
    .mode-card {
        border-color: oklch(0% 0 0 / 10%);
        background: var(--fn-surface);
        transition: all .15s;
    }

    .mode-card.active {
        border-color: oklch(49% 0.24 264 / 50%);
        background: oklch(49% 0.24 264 / 7%);
    }

    .mode-card.active .mode-radio-dot {
        border-color: oklch(49% 0.24 264);
    }

    .mode-card.active .mode-radio-fill {
        transform: scale(1);
    }

    .chip-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 600;
    }

    .chip-item .chip-dot {
        width: 8px;
        height: 8px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .chip-parts .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-parts {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .chip-rows .chip-dot {
        background: oklch(67% 0.18 162);
    }

    .chip-rows {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }

    .chip-mode .chip-dot {
        background: oklch(72% 0.18 55);
    }

    .chip-mode {
        color: oklch(72% 0.18 55);
        border-color: oklch(72% 0.18 55 / 30%);
        background: oklch(72% 0.18 55 / 6%);
    }

    .chip-size .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-size {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let selectedFile = null;
  let blobUrl      = null;

  // ── Split mode cards ──
  const MODE_PANELS = {
    sheet:  ['opt-sheet-help'],
    chunk:  ['opt-chunk-wrap'],
    sheets: ['opt-sheets-wrap'],
  };

  document.querySelectorAll('.split-mode-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      // Update card active states
      document.querySelectorAll('.mode-card').forEach(c => c.classList.remove('active'));
      radio.closest('.mode-card').classList.add('active');

      // Show/hide panels
      Object.values(MODE_PANELS).flat().forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.classList.add('hidden'); el.style.display = ''; }
      });
      (MODE_PANELS[radio.value] || []).forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.remove('hidden');
      });

      // Update proc-4 label for JSON mode
      updateProc4Label(document.getElementById('opt-output').value, radio.value);
      updateBtnLabel(radio.value, document.getElementById('opt-output').value);
    });
  });

  document.getElementById('opt-output').addEventListener('change', function () {
    const mode = document.querySelector('input[name="split_by"]:checked').value;
    updateProc4Label(this.value, mode);
    updateBtnLabel(mode, this.value);
    // Hide filename field when JSON
    document.getElementById('opt-filename').closest('div').style.opacity      = this.value === 'json' ? '0.4' : '1';
    document.getElementById('opt-filename').closest('div').style.pointerEvents = this.value === 'json' ? 'none' : '';
  });

  function updateProc4Label(output, mode) {
    const el = document.querySelector('#proc-4 span');
    if (el) el.textContent = output === 'json' ? 'Returning metadata JSON' : 'Packaging .zip archive';
  }

  function updateBtnLabel(mode, output) {
    const labels = {
      sheet:  output === 'json' ? 'Preview split by sheet' : 'Split by sheet',
      chunk:  output === 'json' ? 'Preview split by chunk' : 'Split by row count',
      sheets: output === 'json' ? 'Preview sheet extraction' : 'Extract sheets',
    };
    document.getElementById('split-btn-label').textContent = labels[mode] || 'Split Excel File';
  }

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

  function handleFile(file) {
    hideError();
    if (!file.name.match(/\.(xlsx|xls)$/i)) {
      showError('Please select a valid Excel file (.xlsx or .xls).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · Excel Workbook';
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

  // ── Split ──
  convertBtn.addEventListener('click', startSplit);

  async function startSplit() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const splitBy    = document.querySelector('input[name="split_by"]:checked').value;
    const output     = document.getElementById('opt-output').value;
    const chunkSize  = document.getElementById('opt-chunk-size').value;
    const sheetsRaw  = document.getElementById('opt-sheets-input').value.trim();
    const customFile = document.getElementById('opt-filename').value.trim();

    // Build sheet names JSON array
    let sheetsJson = null;
    if (splitBy === 'sheets' && sheetsRaw) {
      const names = sheetsRaw.split('\n').map(s => s.trim()).filter(Boolean);
      sheetsJson  = JSON.stringify(names);
    }

    const outName = output === 'json' ? null
      : (customFile
          ? (customFile.toLowerCase().endsWith('.zip') ? customFile : customFile + '.zip')
          : `split_${splitBy === 'chunk' ? 'chunks' : 'sheets'}.zip`);

    const subtitleMap = {
      sheet:  'Reading workbook — splitting into one file per sheet',
      chunk:  `Reading workbook — splitting every ${chunkSize} rows`,
      sheets: `Reading workbook — extracting selected sheets`,
    };
    document.getElementById('converting-subtitle').textContent = subtitleMap[splitBy] || 'Processing…';
    document.getElementById('splitting-title').textContent =
      splitBy === 'chunk' ? 'Splitting by Row Count…' :
      splitBy === 'sheets' ? 'Extracting Sheets…' : 'Splitting by Sheet…';

    const fd = new FormData();
    fd.append('file',     selectedFile);
    fd.append('split_by', splitBy);
    fd.append('output',   output);
    if (splitBy === 'chunk')  fd.append('chunk_size', chunkSize);
    if (sheetsJson)           fd.append('sheets',     sheetsJson);

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 400, 'Reading workbook…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 52, 700, 'Applying split strategy…');
    }, 500);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(52, 78, 700, 'Writing output files…');
    }, 1300);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 92, 500, output === 'json' ? 'Returning metadata JSON…' : 'Packaging .zip archive…');
    }, 2100);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/split-excel', {
        method: 'POST',
        body:   fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Split failed. Please check your file and try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(92, 100, 300, 'Done!');

      if (output === 'json') {
        const data = await res.json();
        showJsonResult(data, splitBy);
      } else {
        const blob = await res.blob();
        if (blobUrl) URL.revokeObjectURL(blobUrl);
        blobUrl = URL.createObjectURL(blob);

        const link = document.getElementById('download-link');
        link.href     = blobUrl;
        link.download = outName;
        document.getElementById('output-name').textContent = outName;
        document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · ZIP Archive';
        document.getElementById('zip-subtitle').textContent =
          `Your split files are ready — download the .zip and extract to get individual .xlsx files.`;
        showZipResult(splitBy, null, null);
      }

      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function showZipResult(splitBy, totalParts, totalRows) {
    document.getElementById('zip-result').classList.remove('hidden');
    document.getElementById('json-result').classList.add('hidden');

    const wrap = document.getElementById('result-info-wrap');
    const list = document.getElementById('result-chips');
    list.innerHTML = '';

    const modeLabel = { sheet: 'by sheet', chunk: 'by chunk', sheets: 'extracted' }[splitBy] || splitBy;
    const chips = [['chip-mode', 'Mode', modeLabel]];
    if (totalParts) chips.push(['chip-parts', 'Parts', totalParts + '']);
    if (totalRows)  chips.push(['chip-rows',  'Rows',  Number(totalRows).toLocaleString()]);

    chips.forEach(([cls, label, val]) => {
      const chip = document.createElement('div');
      chip.className = 'chip-item ' + cls;
      chip.innerHTML = `<span class="chip-dot"></span><span class="chip-label"></span><span style="opacity:.6;margin-left:2px;font-family:monospace;font-size:10px;">${val}</span>`;
      chip.querySelector('.chip-label').textContent = label;
      list.appendChild(chip);
    });
    if (chips.length) wrap.classList.remove('hidden');
  }

  function showJsonResult(data, splitBy) {
    document.getElementById('zip-result').classList.add('hidden');
    document.getElementById('json-result').classList.remove('hidden');

    document.getElementById('json-result-title').textContent =
      `${data.total_parts} part${data.total_parts !== 1 ? 's' : ''} — ${(data.split_by || splitBy).replace('_', ' ')} mode`;
    document.getElementById('json-result-meta').textContent =
      `${data.parts?.length || 0} entries`;

    // Parts table
    if (data.parts && data.parts.length) {
      const tbody = document.getElementById('parts-tbody');
      tbody.innerHTML = '';
      data.parts.forEach(p => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-fn-surface transition-colors';
        tr.innerHTML = `
          <td class="py-2 px-3 text-fn-text3">${p.index}</td>
          <td class="py-2 px-3 font-mono text-fn-text2 truncate max-w-xs">${escHtml(p.filename)}</td>
          <td class="py-2 px-3 text-fn-text2">${escHtml(p.sheet || '—')}</td>
          <td class="py-2 px-3 text-right font-mono text-fn-text2">${Number(p.rows).toLocaleString()}</td>
          <td class="py-2 px-3 text-right font-mono text-fn-text2">${p.cols}</td>
          <td class="py-2 px-3 text-right font-mono text-fn-text3">${p.size_kb} KB</td>`;
        tbody.appendChild(tr);
      });
      document.getElementById('parts-table-wrap').classList.remove('hidden');
    }

    document.getElementById('json-preview').textContent = JSON.stringify(data, null, 2);
  }

  // ── Copy JSON ──
  document.getElementById('btn-copy-json').addEventListener('click', async () => {
    try {
      const text = document.getElementById('json-preview').textContent;
      await navigator.clipboard.writeText(text);
      const btn = document.getElementById('btn-copy-json');
      btn.textContent = '✓ Copied!';
      setTimeout(() => { btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy JSON'; }, 2000);
    } catch(_) {}
  });

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
      const t   = Math.min((now - start) / duration, 1);
      const pct = Math.round(from + (to - from) * t);
      document.getElementById('progress-fill').style.width = pct + '%';
      document.getElementById('progress-pct').textContent  = pct + '%';
      if (t < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  window.resetConverter = function () {
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    resetFile();
    document.getElementById('opt-filename').value      = '';
    document.getElementById('opt-chunk-size').value    = '100';
    document.getElementById('opt-sheets-input').value  = '';
    document.getElementById('opt-output').value        = 'zip';
    // Reset mode to sheet
    document.querySelector('input[name="split_by"][value="sheet"]').checked = true;
    document.querySelectorAll('.mode-card').forEach(c => c.classList.remove('active'));
    document.getElementById('split-sheet-wrap').classList.add('active');
    // Reset panels
    Object.values(MODE_PANELS).flat().forEach(id => {
      const el = document.getElementById(id);
      if (el) el.classList.add('hidden');
    });
    document.getElementById('opt-sheet-help').classList.remove('hidden');
    // Reset filename opacity
    document.getElementById('opt-filename').closest('div').style.opacity = '1';
    document.getElementById('opt-filename').closest('div').style.pointerEvents = '';
    // Reset btn label
    document.getElementById('split-btn-label').textContent = 'Split Excel File';
    // Reset result panels
    document.getElementById('result-info-wrap').classList.add('hidden');
    document.getElementById('zip-result').classList.add('hidden');
    document.getElementById('json-result').classList.add('hidden');
    document.getElementById('parts-table-wrap').classList.add('hidden');
    // Reset proc-4 label
    const proc4 = document.querySelector('#proc-4 span');
    if (proc4) proc4.textContent = 'Packaging .zip archive';
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
      const body   = btn.nextElementSibling;
      const icon   = btn.querySelector('.faq-icon');
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
