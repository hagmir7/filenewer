@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ VIEWER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Input CSV'],['2','Loading'],['3','View & Filter']] as [$n, $label])
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
                            Upload CSV
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
                                    class="w-20 h-20 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-4xl">
                                    📊</div>
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
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free · supports .csv and .tsv</p>
                            <input type="file" id="file-input"
                                accept=".csv,.tsv,.txt,text/csv,text/tab-separated-values"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        {{-- File preview --}}
                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                                📊</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">data.csv</p>
                                <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">—</p>
                            </div>
                            <button type="button" id="remove-file"
                                class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text" class="hidden">
                        <div class="relative">
                            <textarea id="csv-textarea" rows="10" spellcheck="false"
                                placeholder='Paste your CSV content here, e.g.&#10;username,identifier,department,location&#10;booker12,9012,Sales,Manchester&#10;grey07,2070,Depot,London'
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-2xl px-5 py-4 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50 resize-none leading-relaxed"></textarea>
                            <div class="absolute top-3 right-3 flex gap-2">
                                <button type="button" id="btn-paste"
                                    class="flex items-center gap-1.5 px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                        <rect x="8" y="2" width="8" height="4" rx="1" />
                                    </svg>
                                    Paste
                                </button>
                                <button type="button" id="btn-clear"
                                    class="flex items-center gap-1.5 px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    </svg>
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Separator selector --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-sm font-semibold text-fn-text2 shrink-0">Separator</span>
                            <div class="flex gap-1">
                                @foreach([['auto','Auto-detect',''],[',','Comma',','],[';','Semicolon',';'],['\t','Tab','tab'],['|','Pipe','|']]
                                as [$sval, $slabel, $sdisp])
                                <button type="button"
                                    class="sep-btn {{ $sval === 'auto' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                    data-sep="{{ $sval }}">{{ $slabel }}</button>
                                @endforeach
                            </div>
                            <span class="ml-auto text-xs text-fn-text3">Leave on Auto for most files</span>
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
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        View CSV Data
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
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
                            🔍</div>
                    </div>
                    <h2 class="text-xl font-bold mb-2">Loading CSV data…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Parsing rows and detecting column types</p>
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
                        ['proc-1','Reading CSV content'],
                        ['proc-2','Detecting separator & encoding'],
                        ['proc-3','Parsing rows & columns'],
                        ['proc-4','Analysing column stats'],
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

                {{-- ── STATE: Viewer ── --}}
                <div id="state-download" class="hidden">

                    {{-- Top stats row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @foreach([
                        ['stat-total-rows', 'Total rows'],
                        ['stat-filtered-rows','Filtered'],
                        ['stat-columns', 'Columns'],
                        ['stat-page-info', 'Page'],
                        ['stat-separator', 'Separator'],
                        ] as [$sid, $slabel])
                        <div
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface2 border border-fn-text/8 rounded-lg">
                            <span class="text-xs text-fn-text3">{{ $slabel }}</span>
                            <span class="text-sm font-bold text-fn-text" id="{{ $sid }}">—</span>
                        </div>
                        @endforeach
                        <button type="button" onclick="resetConverter()"
                            class="ml-auto flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            New CSV
                        </button>
                    </div>

                    {{-- Filter & sort bar --}}
                    <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-4">
                        <div class="flex flex-wrap items-end gap-3">

                            {{-- Filter --}}
                            <div class="flex-1 min-w-[180px]">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Filter column</label>
                                <select id="opt-filter-col"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-sans focus:outline-none focus:border-fn-blue/40 cursor-pointer">
                                    <option value="">— All columns —</option>
                                </select>
                            </div>
                            <div class="min-w-[130px]">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Operator</label>
                                <select id="opt-filter-op"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-sans focus:outline-none focus:border-fn-blue/40 cursor-pointer">
                                    @foreach([
                                    ['contains', 'Contains'],
                                    ['equals', 'Equals'],
                                    ['starts_with', 'Starts with'],
                                    ['ends_with', 'Ends with'],
                                    ['greater_than', '> Greater than'],
                                    ['less_than', '< Less than'], ['not_empty', 'Not empty' ], ['is_empty', 'Is empty'
                                        ], ] as [$opv, $opl]) <option value="{{ $opv }}">{{ $opl }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="flex-1 min-w-[180px]">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Value</label>
                                <input type="text" id="opt-filter-val" placeholder="Search value…"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            </div>

                            {{-- Sort --}}
                            <div class="min-w-[150px]">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Sort by</label>
                                <select id="opt-sort-col"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-sans focus:outline-none focus:border-fn-blue/40 cursor-pointer">
                                    <option value="">— None —</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Order</label>
                                <div class="flex gap-1">
                                    <button type="button"
                                        class="order-btn active px-2.5 py-1.5 rounded-lg border text-xs font-semibold transition-all"
                                        data-order="asc">↑ Asc</button>
                                    <button type="button"
                                        class="order-btn px-2.5 py-1.5 rounded-lg border text-xs font-semibold transition-all"
                                        data-order="desc">↓ Desc</button>
                                </div>
                            </div>

                            {{-- Apply --}}
                            <div class="flex gap-2 ml-auto">
                                <button type="button" id="btn-reset-filter"
                                    class="px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Reset</button>
                                <button type="button" id="btn-apply"
                                    class="flex items-center gap-1.5 px-4 py-1.5 bg-fn-blue text-white text-xs font-bold rounded-lg hover:bg-fn-blue-l transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Apply
                                </button>
                            </div>
                        </div>

                        {{-- Column visibility --}}
                        <div class="mt-3 pt-3 border-t border-fn-text/8 flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-semibold text-fn-text2 shrink-0">Columns:</span>
                            <div id="column-chips" class="flex flex-wrap gap-1 flex-1"></div>
                            <div class="flex gap-1">
                                <button type="button" id="btn-show-all-cols"
                                    class="text-xs text-fn-blue-l hover:underline font-semibold">Show all</button>
                            </div>
                        </div>
                    </div>

                    {{-- Data table --}}
                    <div class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-auto max-h-[500px]"
                        id="table-wrap">
                        <table id="data-table" class="w-full text-xs"></table>
                    </div>

                    {{-- Loading overlay --}}
                    <div id="table-loading"
                        class="hidden mt-2 flex items-center justify-center gap-2 text-fn-text3 text-xs">
                        <svg class="spin w-3 h-3" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60"
                                stroke-dashoffset="20" stroke-linecap="round" />
                        </svg>
                        Updating…
                    </div>

                    {{-- Pagination + page size --}}
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-fn-text3">Rows per page</span>
                            <select id="opt-page-size"
                                class="bg-fn-surface2 border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1 font-sans focus:outline-none cursor-pointer">
                                @foreach([25, 50, 100, 250, 500] as $ps)
                                <option value="{{ $ps }}" {{ $ps===100 ? 'selected' : '' }}>{{ $ps }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-1" id="pagination-controls">
                            <button type="button" id="btn-first" class="page-btn"><svg width="11" height="11"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="11 17 6 12 11 7" />
                                    <polyline points="18 17 13 12 18 7" />
                                </svg></button>
                            <button type="button" id="btn-prev" class="page-btn"><svg width="11" height="11"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 18 9 12 15 6" />
                                </svg></button>
                            <span class="px-3 text-xs font-mono text-fn-text2" id="page-indicator">1 / 1</span>
                            <button type="button" id="btn-next" class="page-btn"><svg width="11" height="11"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg></button>
                            <button type="button" id="btn-last" class="page-btn"><svg width="11" height="11"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="13 17 18 12 13 7" />
                                    <polyline points="6 17 11 12 6 7" />
                                </svg></button>
                        </div>
                    </div>

                    {{-- Column stats --}}
                    <div class="mt-5">
                        <button type="button" id="btn-toggle-stats"
                            class="flex items-center gap-2 text-sm font-semibold text-fn-text2 hover:text-fn-blue-l transition-colors">
                            <svg id="stats-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"
                                class="transition-transform">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                            Column Statistics
                        </button>
                        <div id="col-stats-wrap" class="hidden mt-3 grid sm:grid-cols-2 lg:grid-cols-3 gap-2"></div>
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
            ['What can I do with this tool?','View CSV data in a clean, paginated table — sort by any column, filter
            rows by value or operator, hide/show columns, and see per-column statistics (type, unique values,
            min/max/mean for numeric columns).'],
            ['What separators are supported?','Comma, semicolon, tab, and pipe. You can also leave it on Auto-detect and
            the tool will figure it out from the first rows.'],
            ['What filter operators are available?','Contains, Equals, Starts with, Ends with, Greater than, Less than,
            Not empty, and Is empty. Greater/Less than work on numeric columns; the rest work on text.'],
            ['Can I sort and filter at the same time?','Yes — filtering and sorting are combined in a single request.
            Set both, click Apply, and the result respects both rules with pagination.'],
            ['Is my file safe and private?','All uploads use AES-256 encryption in transit and are permanently deleted
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

    .sep-btn,
    .order-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .sep-btn.active,
    .order-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .sep-btn:not(.active):hover,
    .order-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    /* Data table */
    #data-table th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: var(--fn-surface);
        padding: 10px 12px;
        text-align: left;
        font-weight: 700;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 15%);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        white-space: nowrap;
        cursor: pointer;
        user-select: none;
        transition: background .15s;
    }

    #data-table th:hover {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 4%);
    }

    #data-table th .th-inner {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    #data-table th .type-badge {
        font-size: 9px;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 4px;
        text-transform: lowercase;
        letter-spacing: 0;
    }

    #data-table th .type-numeric {
        background: oklch(49% 0.24 264 / 15%);
        color: var(--fn-blue-l);
    }

    #data-table th .type-text {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        color: var(--fn-text3);
    }

    #data-table th .sort-arrow {
        color: var(--fn-blue-l);
        font-weight: 700;
    }

    #data-table td {
        padding: 6px 12px;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 5%);
        white-space: nowrap;
        max-width: 280px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-variant-numeric: tabular-nums;
    }

    #data-table td.numeric-cell {
        font-family: monospace;
        text-align: right;
        color: var(--fn-text);
    }

    #data-table tr:hover td {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 3%);
    }

    #data-table tr:last-child td {
        border-bottom: none;
    }

    #data-table .row-num {
        color: var(--fn-text3);
        font-family: monospace;
        font-size: 10px;
        text-align: right;
        width: 40px;
    }

    /* Pagination */
    .page-btn {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface2);
        color: var(--fn-text3);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
        cursor: pointer;
    }

    .page-btn:hover:not(:disabled) {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 30%);
    }

    .page-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    /* Column chip */
    .col-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 12%);
        background: var(--fn-surface);
        color: var(--fn-text2);
        cursor: pointer;
        transition: all .15s;
        user-select: none;
    }

    .col-chip.hidden-col {
        opacity: 0.4;
        text-decoration: line-through;
    }

    .col-chip:hover {
        border-color: oklch(49% 0.24 264 / 30%);
    }

    /* Stats card */
    .stat-card {
        padding: 10px 14px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        border-radius: 10px;
    }

    .stat-card .stat-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .stat-card .stat-name {
        font-size: 12px;
        font-weight: 700;
        color: var(--fn-text);
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .stat-card .stat-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 2px 8px;
        font-size: 11px;
    }

    .stat-card .stat-label {
        color: var(--fn-text3);
    }

    .stat-card .stat-val {
        color: var(--fn-text2);
        font-family: monospace;
        font-weight: 600;
        text-align: right;
    }
</style>

@push('footer')
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

  let selectedFile = null;
  let activeTab    = 'file';
  let activeSep    = 'auto';
  let activeOrder  = 'asc';
  let hiddenCols   = new Set();
  let lastResponse = null;
  let currentPage  = 1;
  let colStats     = {};

  // ── Tabs ──
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

  // ── Separator ──
  document.querySelectorAll('.sep-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.sep-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeSep = btn.dataset.sep;
    });
  });

  // ── Order buttons ──
  document.querySelectorAll('.order-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.order-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeOrder = btn.dataset.order;
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
    const name = file.name.toLowerCase();
    if (!name.endsWith('.csv') && !name.endsWith('.tsv') && !name.endsWith('.txt') &&
        !['text/csv', 'text/tab-separated-values', 'text/plain'].includes(file.type)) {
      showError('Please select a valid CSV, TSV, or text file.');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · CSV File';
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

  // ── Text area ──
  csvTA.addEventListener('input', refreshConvertBtn);
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { csvTA.value = await navigator.clipboard.readText(); refreshConvertBtn(); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    csvTA.value = '';
    refreshConvertBtn();
  });

  function refreshConvertBtn() {
    if (activeTab === 'file') {
      convertBtn.disabled = !selectedFile;
    } else {
      convertBtn.disabled = !csvTA.value.trim();
    }
  }

  // ── Load CSV ──
  convertBtn.addEventListener('click', () => loadCsv(true));

  async function loadCsv(firstLoad = false) {
    hideError();

    if (firstLoad) {
      showState('converting');
      updateStepIndicator(2);
      scrollToCard();

      // Animate process steps
      setProcessStep('proc-1', 'active');
      animateProgress(0, 25, 400, 'Reading CSV content…');
      window._ct2 = setTimeout(() => {
        setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
        animateProgress(25, 55, 500, 'Detecting separator & encoding…');
      }, 500);
      window._ct3 = setTimeout(() => {
        setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
        animateProgress(55, 80, 500, 'Parsing rows & columns…');
      }, 1100);
      window._ct4 = setTimeout(() => {
        setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
        animateProgress(80, 92, 400, 'Analysing column stats…');
      }, 1700);
    } else {
      showTableLoading(true);
    }

    try {
      const pageSize = parseInt(document.getElementById('opt-page-size')?.value) || 100;

      let res;
      if (activeTab === 'file') {
        const fd = new FormData();
        fd.append('file', selectedFile);
        if (activeSep !== 'auto') fd.append('separator', activeSep);
        fd.append('page', currentPage);
        fd.append('page_size', pageSize);

        // Filter & sort (only when in viewer state)
        if (!firstLoad) {
          const fCol = document.getElementById('opt-filter-col').value;
          const fVal = document.getElementById('opt-filter-val').value;
          const fOp  = document.getElementById('opt-filter-op').value;
          if (fCol && (fVal || fOp === 'not_empty' || fOp === 'is_empty')) {
            fd.append('filter_column',   fCol);
            fd.append('filter_value',    fVal);
            fd.append('filter_operator', fOp);
          }
          const sCol = document.getElementById('opt-sort-col').value;
          if (sCol) {
            fd.append('sort_by',    sCol);
            fd.append('sort_order', activeOrder);
          }
          // Columns (only send if some are hidden)
          if (hiddenCols.size > 0 && lastResponse) {
            const visible = lastResponse.columns.filter(c => !hiddenCols.has(c));
            if (visible.length > 0) fd.append('columns', visible.join(','));
          }
        }

        res = await fetch('https://api.filenewer.com/api/tools/csv-viewer-file', {
          method: 'POST', body: fd,
        });
      } else {
        const payload = {
          csv:       csvTA.value,
          page:      currentPage,
          page_size: pageSize,
        };
        if (activeSep !== 'auto') payload.separator = activeSep;

        if (!firstLoad) {
          const fCol = document.getElementById('opt-filter-col').value;
          const fVal = document.getElementById('opt-filter-val').value;
          const fOp  = document.getElementById('opt-filter-op').value;
          if (fCol && (fVal || fOp === 'not_empty' || fOp === 'is_empty')) {
            payload.filter_column   = fCol;
            payload.filter_value    = fVal;
            payload.filter_operator = fOp;
          }
          const sCol = document.getElementById('opt-sort-col').value;
          if (sCol) {
            payload.sort_by    = sCol;
            payload.sort_order = activeOrder;
          }
          if (hiddenCols.size > 0 && lastResponse) {
            const visible = lastResponse.columns.filter(c => !hiddenCols.has(c));
            if (visible.length > 0) payload.columns = visible.join(',');
          }
        }

        res = await fetch('https://api.filenewer.com/api/tools/csv-viewer-text', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body:    JSON.stringify(payload),
        });
      }

      if (firstLoad) {
        clearTimeout(window._ct2); clearTimeout(window._ct3); clearTimeout(window._ct4);
      }

      if (!res.ok) {
        let msg = 'Failed to load CSV. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const data = await res.json();

      // Preserve col_stats across requests (API doesn't always return them after filtering)
      if (data.col_stats && Object.keys(data.col_stats).length > 0) {
        colStats = data.col_stats;
      }

      lastResponse = data;
      renderViewer(data, firstLoad);

      if (firstLoad) {
        setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
        animateProgress(92, 100, 250, 'Done!');
        setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);
      } else {
        showTableLoading(false);
      }

    } catch (err) {
      console.error(err);
      if (firstLoad) {
        clearTimeout(window._ct2); clearTimeout(window._ct3); clearTimeout(window._ct4);
        showError(err.message || 'Something went wrong. Please try again.');
        showState('upload');
        updateStepIndicator(1);
      } else {
        showTableLoading(false);
        showViewerError(err.message);
      }
    }
  }

  // ── Render viewer ──
  function renderViewer(data, firstLoad) {
    const columns     = data.columns ?? [];
    const rows        = data.rows ?? [];
    const total       = data.total_rows ?? 0;
    const filtered    = data.filtered_rows ?? total;

    // Stats row
    document.getElementById('stat-total-rows').textContent    = total.toLocaleString();
    document.getElementById('stat-filtered-rows').textContent = filtered.toLocaleString();
    document.getElementById('stat-columns').textContent       = (data.total_columns ?? columns.length);
    document.getElementById('stat-page-info').textContent     = (data.page ?? 1) + ' / ' + (data.total_pages ?? 1);
    document.getElementById('stat-separator').textContent     = data.separator ?? 'auto';

    // Filter / sort column options (only populate on first load)
    if (firstLoad) {
      const filterSel = document.getElementById('opt-filter-col');
      const sortSel   = document.getElementById('opt-sort-col');
      filterSel.innerHTML = '<option value="">— All columns —</option>';
      sortSel.innerHTML   = '<option value="">— None —</option>';
      columns.forEach(col => {
        const o1 = document.createElement('option'); o1.value = col; o1.textContent = col; filterSel.appendChild(o1);
        const o2 = document.createElement('option'); o2.value = col; o2.textContent = col; sortSel.appendChild(o2);
      });

      // Column chips
      renderColumnChips(columns);
    }

    // Pagination
    document.getElementById('page-indicator').textContent = (data.page ?? 1) + ' / ' + (data.total_pages ?? 1);
    document.getElementById('btn-first').disabled = !data.has_prev;
    document.getElementById('btn-prev').disabled  = !data.has_prev;
    document.getElementById('btn-next').disabled  = !data.has_next;
    document.getElementById('btn-last').disabled  = !data.has_next;

    // Table
    renderTable(columns, rows, data.sort);

    // Column stats
    renderColStats();
  }

  function renderTable(columns, rows, sort) {
    const table = document.getElementById('data-table');
    table.innerHTML = '';

    // Header
    const thead = document.createElement('thead');
    const trh   = document.createElement('tr');
    const rowHeader = document.createElement('th');
    rowHeader.style.width = '40px';
    rowHeader.style.cursor = 'default';
    rowHeader.innerHTML = '<span style="color:var(--fn-text3)">#</span>';
    trh.appendChild(rowHeader);

    columns.forEach(col => {
      const stat = colStats[col] ?? {};
      const type = stat.type ?? 'text';
      const isSorted = sort?.by === col;
      const arrow = isSorted ? (sort.order === 'asc' ? '↑' : '↓') : '';

      const th = document.createElement('th');
      th.dataset.col = col;
      th.innerHTML = `
        <div class="th-inner">
          <span class="col-name"></span>
          <span class="type-badge type-${type}">${type}</span>
          ${arrow ? `<span class="sort-arrow">${arrow}</span>` : ''}
        </div>`;
      th.querySelector('.col-name').textContent = col;
      th.addEventListener('click', () => sortByColumn(col));
      trh.appendChild(th);
    });
    thead.appendChild(trh);
    table.appendChild(thead);

    // Body
    const tbody = document.createElement('tbody');
    const rowOffset = ((lastResponse?.page ?? 1) - 1) * (lastResponse?.page_size ?? 100);

    if (rows.length === 0) {
      const tr = document.createElement('tr');
      const td = document.createElement('td');
      td.colSpan = columns.length + 1;
      td.style.textAlign = 'center';
      td.style.padding = '40px 20px';
      td.style.color = 'var(--fn-text3)';
      td.innerHTML = '<div style="font-size:24px;margin-bottom:4px;opacity:.3;">∅</div>No rows match your filter';
      tr.appendChild(td);
      tbody.appendChild(tr);
    } else {
      rows.forEach((row, idx) => {
        const tr = document.createElement('tr');
        const numTd = document.createElement('td');
        numTd.className = 'row-num';
        numTd.textContent = rowOffset + idx + 1;
        tr.appendChild(numTd);

        columns.forEach(col => {
          const td = document.createElement('td');
          const val = row[col] ?? '';
          td.textContent = val === null || val === undefined ? '' : String(val);
          td.title = td.textContent;
          if (colStats[col]?.type === 'numeric') td.classList.add('numeric-cell');
          tr.appendChild(td);
        });
        tbody.appendChild(tr);
      });
    }
    table.appendChild(tbody);
  }

  // ── Header click → sort ──
  function sortByColumn(col) {
    const sortSel = document.getElementById('opt-sort-col');
    if (sortSel.value === col) {
      // Toggle order
      activeOrder = activeOrder === 'asc' ? 'desc' : 'asc';
    } else {
      sortSel.value = col;
      activeOrder = 'asc';
    }
    document.querySelectorAll('.order-btn').forEach(b => {
      b.classList.toggle('active', b.dataset.order === activeOrder);
    });
    currentPage = 1;
    loadCsv(false);
  }

  // ── Column chips ──
  function renderColumnChips(columns) {
    const wrap = document.getElementById('column-chips');
    wrap.innerHTML = '';
    columns.forEach(col => {
      const chip = document.createElement('span');
      chip.className = 'col-chip' + (hiddenCols.has(col) ? ' hidden-col' : '');
      chip.innerHTML = `<span></span>`;
      chip.querySelector('span').textContent = col;
      chip.addEventListener('click', () => {
        if (hiddenCols.has(col)) hiddenCols.delete(col);
        else hiddenCols.add(col);
        chip.classList.toggle('hidden-col');
        currentPage = 1;
        loadCsv(false);
      });
      wrap.appendChild(chip);
    });
  }

  document.getElementById('btn-show-all-cols').addEventListener('click', () => {
    hiddenCols.clear();
    if (lastResponse) {
      renderColumnChips(lastResponse.columns);
      loadCsv(false);
    }
  });

  // ── Column stats card ──
  function renderColStats() {
    const wrap = document.getElementById('col-stats-wrap');
    wrap.innerHTML = '';
    if (!colStats || Object.keys(colStats).length === 0) return;

    Object.entries(colStats).forEach(([name, stat]) => {
      const card = document.createElement('div');
      card.className = 'stat-card';
      const isNumeric = stat.type === 'numeric';
      let rows = `
        <div class="stat-label">Type</div><div class="stat-val">${stat.type ?? '—'}</div>
        <div class="stat-label">Unique</div><div class="stat-val">${(stat.unique ?? 0).toLocaleString()}</div>
        <div class="stat-label">Empty</div><div class="stat-val">${stat.empty_count ?? 0}</div>
      `;
      if (isNumeric) {
        rows += `
          <div class="stat-label">Min</div><div class="stat-val">${fmtNum(stat.min)}</div>
          <div class="stat-label">Max</div><div class="stat-val">${fmtNum(stat.max)}</div>
          <div class="stat-label">Mean</div><div class="stat-val">${fmtNum(stat.mean)}</div>
          <div class="stat-label">Sum</div><div class="stat-val">${fmtNum(stat.sum)}</div>
        `;
      }
      card.innerHTML = `
        <div class="stat-header">
          <span class="type-badge type-${stat.type ?? 'text'}" style="font-size:9px;font-weight:700;padding:1px 5px;border-radius:4px;${isNumeric ? 'background:oklch(49% 0.24 264 / 15%);color:var(--fn-blue-l);' : 'background:oklch(var(--fn-text-l,80%) 0 0 / 10%);color:var(--fn-text3);'}">${stat.type ?? 'text'}</span>
          <span class="stat-name"></span>
        </div>
        <div class="stat-grid">${rows}</div>`;
      card.querySelector('.stat-name').textContent = name;
      wrap.appendChild(card);
    });
  }

  function fmtNum(v) {
    if (v === null || v === undefined) return '—';
    if (Number.isInteger(v)) return v.toLocaleString();
    return Number(v).toLocaleString(undefined, { maximumFractionDigits: 2 });
  }

  // Stats collapse
  document.getElementById('btn-toggle-stats').addEventListener('click', () => {
    const wrap = document.getElementById('col-stats-wrap');
    const chev = document.getElementById('stats-chevron');
    const isOpen = !wrap.classList.contains('hidden');
    if (isOpen) {
      wrap.classList.add('hidden');
      chev.style.transform = '';
    } else {
      wrap.classList.remove('hidden');
      chev.style.transform = 'rotate(180deg)';
    }
  });

  // ── Filter/sort actions ──
  document.getElementById('btn-apply').addEventListener('click', () => {
    currentPage = 1;
    loadCsv(false);
  });
  document.getElementById('btn-reset-filter').addEventListener('click', () => {
    document.getElementById('opt-filter-col').value = '';
    document.getElementById('opt-filter-val').value = '';
    document.getElementById('opt-filter-op').value  = 'contains';
    document.getElementById('opt-sort-col').value   = '';
    activeOrder = 'asc';
    document.querySelectorAll('.order-btn').forEach(b => b.classList.toggle('active', b.dataset.order === 'asc'));
    hiddenCols.clear();
    if (lastResponse) renderColumnChips(lastResponse.columns);
    currentPage = 1;
    loadCsv(false);
  });

  // ── Pagination ──
  document.getElementById('btn-first').addEventListener('click', () => { currentPage = 1; loadCsv(false); });
  document.getElementById('btn-prev').addEventListener('click',  () => { if (currentPage > 1) { currentPage--; loadCsv(false); } });
  document.getElementById('btn-next').addEventListener('click',  () => {
    if (lastResponse?.has_next) { currentPage++; loadCsv(false); }
  });
  document.getElementById('btn-last').addEventListener('click',  () => {
    if (lastResponse?.total_pages) { currentPage = lastResponse.total_pages; loadCsv(false); }
  });
  document.getElementById('opt-page-size').addEventListener('change', () => {
    currentPage = 1;
    loadCsv(false);
  });

  function showTableLoading(show) {
    document.getElementById('table-loading').classList.toggle('hidden', !show);
  }

  function showViewerError(msg) {
    // Lightweight inline error
    const table = document.getElementById('data-table');
    table.innerHTML = `<tbody><tr><td colspan="99" style="padding:20px;color:var(--fn-red);text-align:center;">${msg}</td></tr></tbody>`;
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
    resetFile();
    csvTA.value = '';
    hiddenCols = new Set();
    lastResponse = null;
    currentPage = 1;
    colStats = {};
    activeSep = 'auto';
    activeOrder = 'asc';
    document.querySelectorAll('.sep-btn').forEach(b => b.classList.toggle('active', b.dataset.sep === 'auto'));
    document.querySelectorAll('.order-btn').forEach(b => b.classList.toggle('active', b.dataset.order === 'asc'));
    document.getElementById('opt-filter-col').value = '';
    document.getElementById('opt-filter-val').value = '';
    document.getElementById('opt-filter-op').value  = 'contains';
    document.getElementById('opt-sort-col').value   = '';
    document.getElementById('opt-page-size').value  = '100';
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
