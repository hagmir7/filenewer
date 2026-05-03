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
                @foreach([['1','Upload Files'],['2','Merging'],['3','Download']] as [$n, $label])
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
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-green/40 hover:bg-fn-green/4 relative transition-colors">
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
                        <h2 class="text-lg font-bold mb-2">Drop your Excel files here</h2>
                        <p class="text-fn-text3 text-sm mb-2">Supports .xlsx and .xls — select 2 or more files</p>
                        <p class="text-fn-text3 text-xs mb-6">You can drag &amp; drop multiple files at once, or click
                            to browse</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose Excel Files
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 50MB per file · up to 20 files</p>
                        <input type="file" id="file-input"
                            accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                            multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File list --}}
                    <div id="file-list-wrap" class="hidden mt-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2" id="file-count-label">0 files selected</p>
                            <div class="flex gap-1.5">
                                <label
                                    class="flex items-center gap-1.5 px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all cursor-pointer">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" y1="3" x2="12" y2="15" />
                                    </svg>
                                    Add more
                                    <input type="file" id="add-more-input" accept=".xlsx,.xls" multiple
                                        class="sr-only" />
                                </label>
                                <button type="button" id="btn-clear-all"
                                    class="px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear
                                    all</button>
                            </div>
                        </div>
                        <div id="file-list" class="flex flex-col gap-2 max-h-60 overflow-y-auto pr-1"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold text-fn-text2">Merge Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">

                            {{-- Left: merge mode --}}
                            <div class="flex flex-col gap-3">

                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Merge mode</label>
                                    <div class="flex flex-col gap-1.5">
                                        @foreach([
                                        ['mode-stack', 'stack', '📋', 'Stack rows', 'Append same-named sheets row by
                                        row', true],
                                        ['mode-separate', 'separate_sheets', '📑', 'Separate sheets', 'One tab per file
                                        — keep files distinct', false],
                                        ['mode-sideby', 'side_by_side', '↔️', 'Side by side', 'Place files horizontally
                                        for comparison', false],
                                        ] as [$mid, $mval, $micon, $mlabel, $mdesc, $mdefault])
                                        <label id="{{ $mid }}-wrap"
                                            class="mode-card {{ $mdefault ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 border rounded-xl cursor-pointer transition-all">
                                            <input type="radio" name="merge_mode" value="{{ $mval }}" {{ $mdefault
                                                ? 'checked' : '' }} class="sr-only" />
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

                                <div>
                                    <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Output filename
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-filename" placeholder="merged.xlsx"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>

                            </div>

                            {{-- Right: stack options --}}
                            <div id="stack-options" class="flex flex-col gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Stack
                                        options</label>
                                    <div class="flex flex-col gap-1.5">
                                        @foreach([
                                        ['opt-source-col', 'Add source column', 'Prepend filename column to each merged
                                        row', true],
                                        ['opt-skip-empty', 'Skip empty sheets', 'Ignore sheets with no data rows',
                                        true],
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

                                {{-- Source column name (shown only when source col enabled) --}}
                                <div id="source-col-name-wrap">
                                    <label for="opt-source-col-name"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Source column
                                        name</label>
                                    <input type="text" id="opt-source-col-name" value="_source_file"
                                        placeholder="_source_file"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                    <p class="text-xs text-fn-text3 mt-1">Column added to identify which file each row
                                        came from</p>
                                </div>

                                {{-- Summary sheet note --}}
                                <div
                                    class="flex items-start gap-2 p-3 bg-fn-blue/6 border border-fn-blue/15 rounded-xl">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-fn-blue-l shrink-0 mt-0.5">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    <p class="text-xs text-fn-text2 leading-relaxed">Every output includes a <span
                                            class="font-semibold font-mono">_Merge Summary</span> sheet listing every
                                        file, sheet, row count, and column count merged.</p>
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
                        <span id="merge-btn-label">Merge Excel Files</span>
                    </button>
                </div>

                {{-- ── STATE: Merging ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-3 mb-8 flex-wrap">
                        <div id="merging-icons" class="flex items-center gap-2"></div>
                        <div class="flex gap-1 mx-2">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <line x1="3" y1="9" x2="21" y2="9" />
                                <line x1="3" y1="15" x2="21" y2="15" />
                                <line x1="9" y1="3" x2="9" y2="21" />
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold mb-2" id="merging-title">Merging Excel Files…</h2>
                    <p class="text-fn-text3 text-sm mb-8" id="converting-subtitle">Reading sheets, aligning columns
                        &amp; writing workbook</p>

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
                        ['proc-1', 'Reading all Excel files'],
                        ['proc-2', 'Parsing sheets &amp; columns'],
                        ['proc-3', 'Applying merge strategy'],
                        ['proc-4', 'Writing output workbook'],
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
                            <span class="text-sm text-fn-text3">{!! $plabel !!}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Merge Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6" id="download-subtitle">Your merged workbook is ready to open
                        in Excel or Google Sheets.</p>

                    {{-- Result chips --}}
                    <div id="result-info-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Merge details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-chips"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📊</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">merged.xlsx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Excel Workbook</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    {{-- Sheets out list --}}
                    <div id="sheets-out-wrap" class="hidden max-w-sm mx-auto mb-6 text-left">
                        <p class="text-xs font-semibold text-fn-text2 mb-2">Sheets in output</p>
                        <div class="flex flex-wrap gap-1.5" id="sheets-out-list"></div>
                    </div>

                    <a id="download-link" href="#" download="merged.xlsx"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Merged File
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Merge another batch
                        </button>
                    </div>

                    <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your files are encrypted and permanently deleted within 1 hour.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ══ MODES REFERENCE ══ --}}
<section class="py-12 border-t border-fn-text/7 bg-fn-surface2">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-lg font-bold mb-1 text-center">Merge Modes Explained</h2>
        <p class="text-fn-text3 text-sm text-center mb-6">Three strategies to combine your Excel files</p>
        <div class="grid sm:grid-cols-3 gap-4">
            @foreach([
            ['📋', 'Stack rows', 'stack', 'fn-green', 'Sheets with the same name are combined row by row — all January
            "Sales" sheets stack into one "Sales" sheet. Best for monthly reports or log files with identical
            structure.'],
            ['📑', 'Separate sheets', 'separate_sheets', 'fn-blue-l', 'Each file gets its own tab in the output
            workbook. Sheet names are prefixed with the source filename to avoid collisions. Best for keeping files
            distinct inside one workbook.'],
            ['↔️', 'Side by side', 'side_by_side', 'fn-purple', 'Files are placed horizontally on the same sheet with a
            label column separating each. Best for comparisons — budget vs actuals, forecast vs results.'],
            ] as [$icon, $name, $val, $color, $desc])
            <div class="p-5 bg-fn-surface border border-fn-text/8 rounded-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <span class="text-2xl">{{ $icon }}</span>
                    <div>
                        <p class="font-bold text-sm">{{ $name }}</p>
                        <code class="text-xs font-mono text-fn-text3">{{ $val }}</code>
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
            ['How many files can I merge at once?', 'You can merge up to 20 Excel files in a single request, with a
            maximum of 50MB per file. There is no hard limit on total rows — the output workbook will contain all data
            from all files.'],
            ['What happens when sheets have different column names in Stack mode?', 'In stack mode, columns are aligned
            by name. If a file has extra columns not present in other files, those columns are included with blank
            values for rows from files that do not have them. This ensures no data is lost.'],
            ['What is the _Merge Summary sheet?', 'Every output workbook includes a _Merge Summary as the first tab. It
            lists every source file, the sheets that were processed, and the row and column counts for each. This gives
            you an audit trail of exactly what went into the merge.'],
            ['What does the source column do?', 'In stack mode, enabling "Add source column" prepends a column to every
            merged row containing the original filename. This lets you filter or group by source after merging. You can
            rename the column with the source column name field.'],
            ['Can I reorder the files before merging?', 'Yes — after selecting files you can drag them into your
            preferred order using the handle on the left of each file row. The files are merged in the order they are
            listed, which affects row order in stack mode and tab order in separate sheets mode.'],
            ['Are my files safe and private?', 'All uploads use AES-256 encryption in transit and are permanently
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

    .file-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: var(--fn-surface);
        border: 1px solid oklch(0% 0 0 / 8%);
        border-radius: 12px;
        transition: background .12s;
    }

    .file-row.drag-over-row {
        border-color: oklch(49% 0.24 264 / 50%);
        background: oklch(49% 0.24 264 / 5%);
    }

    .file-row .drag-handle {
        cursor: grab;
        color: var(--fn-text3);
        flex-shrink: 0;
    }

    .file-row .drag-handle:active {
        cursor: grabbing;
    }

    .sheet-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        background: oklch(67% 0.18 162 / 8%);
        border: 1px solid oklch(67% 0.18 162 / 25%);
        color: oklch(55% 0.18 162);
    }

    .sheet-pill.is-summary {
        background: oklch(62% 0.20 250 / 8%);
        border-color: oklch(62% 0.20 250 / 25%);
        color: oklch(50% 0.20 250);
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

    .chip-files .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-files {
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

    .chip-sheets .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-sheets {
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
  const addMore     = document.getElementById('add-more-input');
  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let fileList = []; // Array of File objects in display order
  let blobUrl  = null;

  // ── Mode cards ──
  document.querySelectorAll('input[name="merge_mode"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.mode-card').forEach(c => c.classList.remove('active'));
      radio.closest('.mode-card').classList.add('active');
      const isStack = radio.value === 'stack';
      document.getElementById('stack-options').style.opacity  = isStack ? '1' : '0.4';
      document.getElementById('stack-options').style.pointerEvents = isStack ? '' : 'none';
      updateMergeBtn(radio.value);
    });
  });

  function updateMergeBtn(mode) {
    const labels = { stack: 'Merge Excel Files', separate_sheets: 'Merge into Separate Sheets', side_by_side: 'Merge Side by Side' };
    document.getElementById('merge-btn-label').textContent = labels[mode] || 'Merge Excel Files';
  }

  // ── Source col toggle ──
  document.getElementById('opt-source-col').addEventListener('change', function () {
    document.getElementById('source-col-name-wrap').style.opacity      = this.checked ? '1' : '0.4';
    document.getElementById('source-col-name-wrap').style.pointerEvents = this.checked ? '' : 'none';
  });

  // ── Drop zone ──
  ['dragenter', 'dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave', 'dragend', 'drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', e => { addFiles(Array.from(e.dataTransfer.files)); });
  fileInput.addEventListener('change', e => { addFiles(Array.from(e.target.files)); fileInput.value = ''; });
  addMore.addEventListener('change', e => { addFiles(Array.from(e.target.files)); addMore.value = ''; });
  document.getElementById('btn-clear-all').addEventListener('click', clearAll);

  function addFiles(newFiles) {
    hideError();
    const valid = newFiles.filter(f => f.name.match(/\.(xlsx|xls)$/i));
    const tooBig = valid.filter(f => f.size > 50 * 1024 * 1024);
    if (tooBig.length) { showError(`${tooBig.map(f => f.name).join(', ')} exceed${tooBig.length === 1 ? 's' : ''} the 50MB limit.`); }

    const ok = valid.filter(f => f.size <= 50 * 1024 * 1024);
    // Deduplicate by name+size
    ok.forEach(f => {
      if (!fileList.find(x => x.name === f.name && x.size === f.size)) fileList.push(f);
    });

    if (fileList.length > 20) {
      fileList = fileList.slice(0, 20);
      showError('Maximum 20 files — extra files were removed.');
    }

    renderFileList();
    refreshConvertBtn();
  }

  function renderFileList() {
    const wrap = document.getElementById('file-list-wrap');
    const list = document.getElementById('file-list');

    if (fileList.length === 0) { wrap.classList.add('hidden'); return; }
    wrap.classList.remove('hidden');
    document.getElementById('file-count-label').textContent = `${fileList.length} file${fileList.length !== 1 ? 's' : ''} selected`;

    list.innerHTML = '';
    fileList.forEach((file, idx) => {
      const row = document.createElement('div');
      row.className    = 'file-row';
      row.draggable    = true;
      row.dataset.idx  = idx;
      row.innerHTML = `
        <div class="drag-handle" title="Drag to reorder">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="8" y1="18" x2="16" y2="18"/></svg>
        </div>
        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: oklch(67% 0.18 162 / 10%); border: 1px solid oklch(67% 0.18 162 / 20%)">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: oklch(55% 0.18 162)"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-semibold truncate file-row-name">${escHtml(file.name)}</p>
          <p class="text-xs text-fn-text3">${formatBytes(file.size)}</p>
        </div>
        <span class="text-xs text-fn-text3 shrink-0 font-mono">#${idx + 1}</span>
        <button type="button" class="remove-btn shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>`;

      // Remove button
      row.querySelector('.remove-btn').addEventListener('click', () => {
        fileList.splice(idx, 1);
        renderFileList();
        refreshConvertBtn();
      });

      // Drag-to-reorder
      let dragSrc = null;
      row.addEventListener('dragstart', e => { dragSrc = idx; e.dataTransfer.effectAllowed = 'move'; row.style.opacity = '0.5'; });
      row.addEventListener('dragend',   () => { row.style.opacity = ''; document.querySelectorAll('.file-row').forEach(r => r.classList.remove('drag-over-row')); });
      row.addEventListener('dragover',  e => { e.preventDefault(); e.dataTransfer.dropEffect = 'move'; row.classList.add('drag-over-row'); });
      row.addEventListener('dragleave', () => row.classList.remove('drag-over-row'));
      row.addEventListener('drop', e => {
        e.preventDefault();
        if (dragSrc === null || dragSrc === idx) return;
        const moved = fileList.splice(dragSrc, 1)[0];
        fileList.splice(idx, 0, moved);
        renderFileList();
      });

      list.appendChild(row);
    });
  }

  function clearAll() {
    fileList = [];
    renderFileList();
    refreshConvertBtn();
    hideError();
  }

  function refreshConvertBtn() {
    convertBtn.disabled = fileList.length < 2;
    document.getElementById('merge-btn-label').textContent =
      fileList.length < 2
        ? `Select at least 2 files (${fileList.length} selected)`
        : { stack: 'Merge Excel Files', separate_sheets: 'Merge into Separate Sheets', side_by_side: 'Merge Side by Side' }[document.querySelector('input[name="merge_mode"]:checked').value] || 'Merge Excel Files';
  }

  // ── Merge ──
  convertBtn.addEventListener('click', startMerge);

  async function startMerge() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const mode        = document.querySelector('input[name="merge_mode"]:checked').value;
    const addSrcCol   = document.getElementById('opt-source-col').checked;
    const srcColName  = document.getElementById('opt-source-col-name').value.trim() || '_source_file';
    const skipEmpty   = document.getElementById('opt-skip-empty').checked;
    const customFile  = document.getElementById('opt-filename').value.trim();

    const outName = customFile
      ? (customFile.toLowerCase().endsWith('.xlsx') ? customFile : customFile + '.xlsx')
      : 'merged.xlsx';

    const modeLabels = { stack: 'stacking rows', separate_sheets: 'creating separate sheets', side_by_side: 'placing side by side' };
    document.getElementById('converting-subtitle').textContent =
      `${fileList.length} files — ${modeLabels[mode] || 'merging'}`;

    // Build merging icons (up to 3 file icons)
    const iconsEl = document.getElementById('merging-icons');
    iconsEl.innerHTML = '';
    fileList.slice(0, 3).forEach((f, i) => {
      const div = document.createElement('div');
      div.className = 'w-12 h-12 rounded-xl flex items-center justify-center text-xs font-bold shrink-0';
      div.style.cssText = 'background: oklch(67% 0.18 162 / 10%); border: 1px solid oklch(67% 0.18 162 / 20%); color: oklch(55% 0.18 162)';
      div.textContent = f.name.replace(/\.(xlsx|xls)$/i, '').substring(0, 3).toUpperCase();
      iconsEl.appendChild(div);
      if (i < Math.min(fileList.length, 3) - 1) {
        const sep = document.createElement('span');
        sep.className = 'text-fn-text3 text-xs font-bold';
        sep.textContent = '+';
        iconsEl.appendChild(sep);
      }
    });
    if (fileList.length > 3) {
      const more = document.createElement('span');
      more.className = 'text-fn-text3 text-xs font-semibold ml-1';
      more.textContent = `+${fileList.length - 3} more`;
      iconsEl.appendChild(more);
    }

    const fd = new FormData();
    fileList.forEach(f => fd.append('files[]', f));
    fd.append('mode',            mode);
    fd.append('add_source_col',  addSrcCol);
    fd.append('source_col_name', srcColName);
    fd.append('skip_empty',      skipEmpty);

    setProcessStep('proc-1', 'active');
    animateProgress(0, 22, 500, 'Reading all Excel files…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(22, 50, 700, 'Parsing sheets & columns…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(50, 78, 800, `Applying ${mode.replace('_', ' ')} strategy…`);
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 92, 600, 'Writing output workbook…');
    }, 2300);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/merge-excel', {
        method: 'POST',
        body:   fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Merge failed. Please check your files and try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      // Headers
      const filesMerged = res.headers.get('X-Files-Merged') || fileList.length;
      const totalRows   = res.headers.get('X-Total-Rows')   || null;
      const sheetsOut   = res.headers.get('X-Sheets-Out')   || null;
      const sizeKb      = res.headers.get('X-Size-KB')      || null;
      const resMode     = res.headers.get('X-Mode')         || mode;

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent =
        (sizeKb ? (sizeKb / 1024).toFixed(2) + ' MB' : formatBytes(blob.size)) + ' · Excel Workbook';

      document.getElementById('download-subtitle').textContent =
        `${filesMerged} file${filesMerged != 1 ? 's' : ''} merged successfully — ready to open in Excel or Google Sheets.`;

      renderResultChips({ filesMerged, totalRows, resMode });
      renderSheetsOut(sheetsOut);

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

  function renderResultChips({ filesMerged, totalRows, resMode }) {
    const wrap = document.getElementById('result-info-wrap');
    const list = document.getElementById('result-chips');
    list.innerHTML = '';

    const chips = [['chip-files', 'Files merged', filesMerged + '']];
    if (totalRows) chips.push(['chip-rows', 'Total rows', Number(totalRows).toLocaleString()]);
    if (resMode)   chips.push(['chip-mode', 'Mode', resMode.replace('_', ' ')]);

    chips.forEach(([cls, label, val]) => {
      const chip = document.createElement('div');
      chip.className = 'chip-item ' + cls;
      chip.innerHTML = `<span class="chip-dot"></span><span class="chip-label"></span><span style="opacity:.6;margin-left:2px;font-family:monospace;font-size:10px;">${val}</span>`;
      chip.querySelector('.chip-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  function renderSheetsOut(sheetsStr) {
    const wrap = document.getElementById('sheets-out-wrap');
    const list = document.getElementById('sheets-out-list');
    if (!sheetsStr) { wrap.classList.add('hidden'); return; }

    const sheets = sheetsStr.split(',').map(s => s.trim()).filter(Boolean);
    list.innerHTML = '';
    sheets.forEach(s => {
      const pill = document.createElement('span');
      pill.className = 'sheet-pill' + (s === '_Merge Summary' ? ' is-summary' : '');
      pill.textContent = s;
      list.appendChild(pill);
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
    clearAll();
    document.getElementById('opt-filename').value       = '';
    document.getElementById('opt-source-col-name').value = '_source_file';
    document.getElementById('opt-source-col').checked  = true;
    document.getElementById('opt-skip-empty').checked  = true;
    document.getElementById('source-col-name-wrap').style.opacity = '1';
    document.getElementById('source-col-name-wrap').style.pointerEvents = '';
    document.getElementById('stack-options').style.opacity = '1';
    document.getElementById('stack-options').style.pointerEvents = '';
    // Reset mode to stack
    document.querySelector('input[name="merge_mode"][value="stack"]').checked = true;
    document.querySelectorAll('.mode-card').forEach(c => c.classList.remove('active'));
    document.getElementById('mode-stack-wrap').classList.add('active');
    document.getElementById('result-info-wrap').classList.add('hidden');
    document.getElementById('sheets-out-wrap').classList.add('hidden');
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

  // Init
  refreshConvertBtn();

});
</script>
@endpush

@endsection
