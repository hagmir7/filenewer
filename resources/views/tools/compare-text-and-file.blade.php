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
                @foreach([['1','Input'],['2','Comparing'],['3','Result']] as [$n, $label])
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
                        <button type="button" id="tab-text"
                            class="tab-btn active flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 7 4 4 20 4 20 7" />
                                <line x1="9" y1="20" x2="15" y2="20" />
                                <line x1="12" y1="4" x2="12" y2="20" />
                            </svg>
                            Compare Text
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Compare Files
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">

                        <div class="grid md:grid-cols-2 gap-3">
                            {{-- Text 1 --}}
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-fn-text2">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-fn-blue/10 border border-fn-blue/20 text-fn-blue-l font-bold text-xs">A</span>
                                        Original
                                    </label>
                                    <div class="flex gap-1">
                                        <button type="button" data-paste-target="text1-area"
                                            class="paste-btn flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                                <rect x="8" y="2" width="8" height="4" rx="1" />
                                            </svg>
                                            Paste
                                        </button>
                                        <button type="button" data-clear-target="text1-area"
                                            class="clear-btn px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                                    </div>
                                </div>
                                <textarea id="text1-area" rows="12" spellcheck="false"
                                    placeholder="Paste the original text here…"
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                                <div class="flex justify-between text-fn-text3 text-xs mt-1.5">
                                    <span id="text1-meta">0 lines · 0 chars</span>
                                </div>
                            </div>
                            {{-- Text 2 --}}
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-fn-text2">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-fn-green/10 border border-fn-green/20 text-fn-green font-bold text-xs">B</span>
                                        Modified
                                    </label>
                                    <div class="flex gap-1">
                                        <button type="button" data-paste-target="text2-area"
                                            class="paste-btn flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                                <rect x="8" y="2" width="8" height="4" rx="1" />
                                            </svg>
                                            Paste
                                        </button>
                                        <button type="button" data-clear-target="text2-area"
                                            class="clear-btn px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                                    </div>
                                </div>
                                <textarea id="text2-area" rows="12" spellcheck="false"
                                    placeholder="Paste the modified text here…"
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                                <div class="flex justify-between text-fn-text3 text-xs mt-1.5">
                                    <span id="text2-meta">0 lines · 0 chars</span>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /panel-text --}}

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div class="grid md:grid-cols-2 gap-3">

                            {{-- File 1 --}}
                            <div>
                                <label class="text-sm font-semibold text-fn-text2 mb-2 flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-fn-blue/10 border border-fn-blue/20 text-fn-blue-l font-bold text-xs">A</span>
                                    Original File
                                </label>
                                <div id="drop-zone-1" data-slot="1"
                                    class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-8 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                    <div
                                        class="w-14 h-14 mx-auto rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-2xl mb-3">
                                        📄</div>
                                    <h2 class="text-sm font-bold mb-1">Drop file A here</h2>
                                    <p class="text-fn-text3 text-xs mb-3">or click to browse</p>
                                    <div
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-fn-blue text-white text-xs font-semibold rounded-lg pointer-events-none">
                                        Choose File
                                    </div>
                                    <input type="file" data-slot="1"
                                        class="file-input absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                                <div id="file-preview-1" data-slot="1"
                                    class="hidden mt-3 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-base shrink-0">
                                        📄</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-xs truncate file-name"></p>
                                        <p class="text-fn-text3 text-xs mt-0.5 file-meta">—</p>
                                    </div>
                                    <button type="button" data-remove-slot="1"
                                        class="remove-file w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- File 2 --}}
                            <div>
                                <label class="text-sm font-semibold text-fn-text2 mb-2 flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-fn-green/10 border border-fn-green/20 text-fn-green font-bold text-xs">B</span>
                                    Modified File
                                </label>
                                <div id="drop-zone-2" data-slot="2"
                                    class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-8 text-center cursor-pointer hover:border-fn-green/40 hover:bg-fn-green/4 relative">
                                    <div
                                        class="w-14 h-14 mx-auto rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-2xl mb-3">
                                        📄</div>
                                    <h2 class="text-sm font-bold mb-1">Drop file B here</h2>
                                    <p class="text-fn-text3 text-xs mb-3">or click to browse</p>
                                    <div
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-fn-blue text-white text-xs font-semibold rounded-lg pointer-events-none">
                                        Choose File
                                    </div>
                                    <input type="file" data-slot="2"
                                        class="file-input absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                                <div id="file-preview-2" data-slot="2"
                                    class="hidden mt-3 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-base shrink-0">
                                        📄</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-xs truncate file-name"></p>
                                        <p class="text-fn-text3 text-xs mt-0.5 file-meta">—</p>
                                    </div>
                                    <button type="button" data-remove-slot="2"
                                        class="remove-file w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>{{-- /panel-file --}}

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">

                        <div class="flex flex-wrap items-center gap-4">
                            {{-- Compare mode --}}
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-fn-text2 shrink-0">Compare by</span>
                                <div class="flex gap-1">
                                    @foreach([['line','Line'],['word','Word'],['char','Char'],['sentence','Sentence']]
                                    as [$cval, $clabel])
                                    <button type="button"
                                        class="mode-btn {{ $cval === 'line' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                        data-mode="{{ $cval }}">{{ $clabel }}</button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="w-px h-5 bg-fn-text/10 hidden sm:block"></div>

                            {{-- Output format --}}
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-fn-text2 shrink-0">View</span>
                                <div class="flex gap-1">
                                    @foreach([['side_by_side','Side by
                                    side'],['unified','Unified'],['html','Inline'],['json','Raw JSON']] as [$fval,
                                    $flabel])
                                    <button type="button"
                                        class="format-btn {{ $fval === 'side_by_side' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                        data-format="{{ $fval }}">{{ $flabel }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-5">
                            {{-- Ignore toggles --}}
                            @foreach([
                            ['opt-ignore-case','Ignore case'],
                            ['opt-ignore-whitespace','Ignore whitespace'],
                            ['opt-ignore-blank','Ignore blank lines'],
                            ] as [$tid, $tlabel])
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <div class="toggle-wrap relative w-8 h-4">
                                    <input type="checkbox" id="{{ $tid }}" class="sr-only peer" />
                                    <div
                                        class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                    </div>
                                    <div
                                        class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-fn-text2">{{ $tlabel }}</span>
                            </label>
                            @endforeach

                            {{-- Context lines --}}
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-fn-text2">Context</span>
                                <input type="number" id="opt-context" value="3" min="0" max="20"
                                    class="w-14 bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1 font-mono focus:outline-none focus:border-fn-blue/40" />
                                <span class="text-xs text-fn-text3">lines</span>
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

                    {{-- Compare button --}}
                    <button id="convert-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 3h5v5" />
                            <path d="M4 20 21 3" />
                            <path d="M21 16v5h-5" />
                            <path d="m15 15 6 6" />
                            <path d="M4 4l5 5" />
                        </svg>
                        Compare
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
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            📄</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Comparing…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Analysing differences between A and B</p>

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
                        ['proc-1','Uploading inputs'],
                        ['proc-2','Tokenising content'],
                        ['proc-3','Computing diff'],
                        ['proc-4','Rendering result'],
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

                {{-- ── STATE: Result ── --}}
                <div id="state-download" class="hidden">

                    {{-- Summary header --}}
                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <div id="verdict-badge"
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-sm font-bold">
                            <span id="verdict-icon">✅</span>
                            <span id="verdict-text">Identical</span>
                        </div>
                        <div
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <span class="text-xs text-fn-text3">Similarity</span>
                            <span class="text-sm font-bold text-fn-text" id="similarity-val">—</span>
                        </div>
                        <div class="ml-auto flex items-center gap-2">
                            <button type="button" id="btn-copy-result"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                <span id="copy-result-label">Copy diff</span>
                            </button>
                            <a id="download-link" href="#" download="diff.txt"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-green/10 border border-fn-green/25 text-fn-green text-xs font-semibold rounded-lg hover:bg-fn-green/20 transition-all">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>

                    {{-- Stats grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-5">
                        @foreach([
                        ['stat-added','+ Added','text-fn-green'],
                        ['stat-removed','- Removed','text-fn-red'],
                        ['stat-changed','~ Changed','text-fn-amber'],
                        ['stat-unchanged','= Unchanged','text-fn-text3'],
                        ] as [$sid,$slabel,$scolor])
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl text-center">
                            <p class="text-xs text-fn-text3 mb-0.5">{{ $slabel }}</p>
                            <p class="text-xl font-bold {{ $scolor }}" id="{{ $sid }}">0</p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Diff output --}}
                    <div id="diff-output-wrap"
                        class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-auto max-h-[500px]">
                        <div id="diff-output" class="font-mono text-xs leading-relaxed"></div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-5 flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            New comparison
                        </button>
                    </div>

                    <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your content is encrypted and permanently deleted within 1 hour.
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
            ['What does this tool do?','It compares two pieces of text or two files and highlights the differences
            line-by-line, word-by-word, character-by-character, or sentence-by-sentence. You get a similarity
            percentage, stats on what was added/removed/changed, and a visual diff.'],
            ['What compare modes are supported?','Four: Line (best for code, config, documents), Word (best for prose
            and essays), Char (fine-grained string diff), and Sentence (best for paragraphs and articles).'],
            ['What view formats can I use?','Side by side (two-column view with A and B next to each other), Unified
            (Git-style single column), Inline (HTML diff with highlights), and Raw JSON (structured array of changes for
            developers).'],
            ['Can I ignore case or whitespace?','Yes — toggle Ignore case, Ignore whitespace, and Ignore blank lines to
            tune what counts as a real difference. Useful when comparing code that has formatting changes but the same
            logic.'],
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

    .mode-btn,
    .format-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .mode-btn.active,
    .format-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .mode-btn:not(.active):hover,
    .format-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    /* Diff rendering */
    .diff-row {
        display: flex;
        align-items: flex-start;
        padding: 2px 12px;
        min-height: 20px;
        border-left: 2px solid transparent;
    }

    .diff-row .ln {
        width: 40px;
        flex-shrink: 0;
        color: var(--fn-text3);
        font-size: 11px;
        text-align: right;
        padding-right: 8px;
        user-select: none;
    }

    .diff-row .sign {
        width: 16px;
        flex-shrink: 0;
        font-weight: 700;
        user-select: none;
    }

    .diff-row .content {
        flex: 1;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .diff-row.add {
        background: oklch(67% 0.18 162 / 8%);
        border-left-color: oklch(67% 0.18 162);
    }

    .diff-row.add .sign,
    .diff-row.add .content {
        color: oklch(67% 0.18 162);
    }

    .diff-row.remove {
        background: oklch(62% 0.22 25 / 8%);
        border-left-color: oklch(62% 0.22 25);
    }

    .diff-row.remove .sign,
    .diff-row.remove .content {
        color: oklch(62% 0.22 25);
    }

    .diff-row.hunk {
        background: oklch(49% 0.24 264 / 6%);
        color: var(--fn-blue-l);
        font-weight: 600;
    }

    .diff-row.equal .content {
        color: var(--fn-text2);
    }

    /* Side-by-side */
    .sbs-grid {
        display: grid;
        grid-template-columns: 40px 1fr 40px 1fr;
        font-size: 12px;
    }

    .sbs-cell {
        padding: 2px 8px;
        white-space: pre-wrap;
        word-break: break-word;
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 4%);
    }

    .sbs-ln {
        color: var(--fn-text3);
        font-size: 11px;
        text-align: right;
        user-select: none;
    }

    .sbs-cell.left {
        border-right: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
    }

    .sbs-cell.add {
        background: oklch(67% 0.18 162 / 10%);
        color: oklch(67% 0.18 162);
    }

    .sbs-cell.remove {
        background: oklch(62% 0.22 25 / 10%);
        color: oklch(62% 0.22 25);
    }

    .sbs-cell.change {
        background: oklch(80% 0.16 80 / 10%);
        color: oklch(65% 0.16 80);
    }

    /* Verdict */
    .verdict-match {
        background: oklch(67% 0.18 162 / 10%);
        border-color: oklch(67% 0.18 162 / 30%);
        color: oklch(67% 0.18 162);
    }

    .verdict-diff {
        background: oklch(75% 0.15 55 / 10%);
        border-color: oklch(75% 0.15 55 / 30%);
        color: oklch(65% 0.15 55);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  // ── Refs ──
  const tabText     = document.getElementById('tab-text');
  const tabFile     = document.getElementById('tab-file');
  const panelText   = document.getElementById('panel-text');
  const panelFile   = document.getElementById('panel-file');
  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');
  const text1Area   = document.getElementById('text1-area');
  const text2Area   = document.getElementById('text2-area');

  let activeTab    = 'text';
  let activeMode   = 'line';
  let activeFormat = 'side_by_side';
  let files        = { 1: null, 2: null };
  let rawDiffText  = '';
  let blobUrl      = null;

  // ── Tab switching ──
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
  }

  // ── Mode / Format buttons ──
  document.querySelectorAll('.mode-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeMode = btn.dataset.mode;
    });
  });
  document.querySelectorAll('.format-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.format-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeFormat = btn.dataset.format;
    });
  });

  // ── Text areas meta + enable button ──
  [text1Area, text2Area].forEach((ta, i) => {
    ta.addEventListener('input', () => {
      const lines = ta.value ? ta.value.split('\n').length : 0;
      const chars = ta.value.length;
      document.getElementById(`text${i+1}-meta`).textContent = `${lines} line${lines !== 1 ? 's' : ''} · ${chars} char${chars !== 1 ? 's' : ''}`;
      refreshConvertBtn();
    });
  });

  // Paste/Clear buttons
  document.querySelectorAll('.paste-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
      try {
        const text = await navigator.clipboard.readText();
        const target = document.getElementById(btn.dataset.pasteTarget);
        target.value = text;
        target.dispatchEvent(new Event('input'));
      } catch(_) {}
    });
  });
  document.querySelectorAll('.clear-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = document.getElementById(btn.dataset.clearTarget);
      target.value = '';
      target.dispatchEvent(new Event('input'));
    });
  });

  // ── File drop zones ──
  document.querySelectorAll('.drop-zone').forEach(dz => {
    const slot = dz.dataset.slot;
    ['dragenter','dragover'].forEach(evt => {
      dz.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dz.classList.add('drag-over'); });
    });
    ['dragleave','dragend','drop'].forEach(evt => {
      dz.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dz.classList.remove('drag-over'); });
    });
    dz.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(slot, e.dataTransfer.files[0]); });
  });

  document.querySelectorAll('.file-input').forEach(input => {
    input.addEventListener('change', e => {
      if (e.target.files[0]) handleFile(e.target.dataset.slot, e.target.files[0]);
    });
  });

  document.querySelectorAll('.remove-file').forEach(btn => {
    btn.addEventListener('click', e => {
      e.stopPropagation();
      resetFile(btn.dataset.removeSlot);
    });
  });

  function handleFile(slot, file) {
    hideError();
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    files[slot] = file;
    const preview = document.getElementById(`file-preview-${slot}`);
    preview.querySelector('.file-name').textContent = file.name;
    preview.querySelector('.file-meta').textContent = formatBytes(file.size) + ' · ' + (file.type || file.name.split('.').pop().toUpperCase());
    preview.classList.remove('hidden');
    preview.classList.add('flex');
    document.getElementById(`drop-zone-${slot}`).classList.add('has-file');
    refreshConvertBtn();
  }

  function resetFile(slot) {
    files[slot] = null;
    const preview = document.getElementById(`file-preview-${slot}`);
    const dz = document.getElementById(`drop-zone-${slot}`);
    const input = dz.querySelector('.file-input');
    input.value = '';
    preview.classList.add('hidden');
    preview.classList.remove('flex');
    dz.classList.remove('has-file');
    refreshConvertBtn();
  }

  function refreshConvertBtn() {
    if (activeTab === 'text') {
      convertBtn.disabled = !(text1Area.value && text2Area.value);
    } else {
      convertBtn.disabled = !(files[1] && files[2]);
    }
  }

  // ── Compare ──
  convertBtn.addEventListener('click', startCompare);

  async function startCompare() {
    hideError();
    showState('converting');
    updateStepIndicator(2);

    const isFile = activeTab === 'file';
    const endpoint = isFile
      ? 'https://api.filenewer.com/api/tools/file-compare'
      : 'https://api.filenewer.com/api/tools/text-compare';

    // We always ask the API for JSON so we can render our own UI + show stats + diff array.
    // The user's "View" format controls how we render the result client-side.
    // For JSON raw view we still send json; for unified/side_by_side we render from differences array.
    const apiOutputFormat = 'json';

    const ignoreCase       = document.getElementById('opt-ignore-case').checked;
    const ignoreWhitespace = document.getElementById('opt-ignore-whitespace').checked;
    const ignoreBlankLines = document.getElementById('opt-ignore-blank').checked;
    const contextLines     = parseInt(document.getElementById('opt-context').value) || 3;

    let fetchBody, fetchHeaders = {};
    if (isFile) {
      const fd = new FormData();
      fd.append('file1',              files[1]);
      fd.append('file2',              files[2]);
      fd.append('compare_mode',       activeMode);
      fd.append('ignore_case',        ignoreCase);
      fd.append('ignore_whitespace',  ignoreWhitespace);
      fd.append('ignore_blank_lines', ignoreBlankLines);
      fd.append('context_lines',      contextLines);
      fd.append('output_format',      apiOutputFormat);
      fetchBody = fd;
    } else {
      fetchBody = JSON.stringify({
        text1:              text1Area.value,
        text2:              text2Area.value,
        compare_mode:       activeMode,
        ignore_case:        ignoreCase,
        ignore_whitespace:  ignoreWhitespace,
        ignore_blank_lines: ignoreBlankLines,
        context_lines:      contextLines,
        output_format:      apiOutputFormat,
      });
      fetchHeaders = { 'Content-Type': 'application/json' };
    }

    // Animate progress
    setProcessStep('proc-1','active');
    animateProgress(0, 25, 400, 'Uploading inputs…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1','done'); setProcessStep('proc-2','active');
      animateProgress(25, 55, 500, 'Tokenising content…');
    }, 500);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2','done'); setProcessStep('proc-3','active');
      animateProgress(55, 80, 500, 'Computing diff…');
    }, 1100);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3','done'); setProcessStep('proc-4','active');
      animateProgress(80, 92, 400, 'Rendering result…');
    }, 1700);

    try {
      const res = await fetch(endpoint, { method: 'POST', headers: fetchHeaders, body: fetchBody });
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Comparison failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const data = await res.json();
      renderResult(data);

      setProcessStep('proc-3','done'); setProcessStep('proc-4','done');
      animateProgress(92, 100, 250, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);

    } catch(err) {
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      console.error(err);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function renderResult(data) {
    const isIdentical = data.is_identical;
    const similarity  = data.similarity ?? 0;
    const stats       = data.stats ?? {};
    const differences = data.differences ?? [];

    // Verdict
    const badge = document.getElementById('verdict-badge');
    badge.className = 'inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-sm font-bold ' +
      (isIdentical ? 'verdict-match' : 'verdict-diff');
    document.getElementById('verdict-icon').textContent = isIdentical ? '✅' : '🔀';
    document.getElementById('verdict-text').textContent = isIdentical ? 'Identical' : 'Differences found';

    document.getElementById('similarity-val').textContent =
      (typeof similarity === 'number' ? similarity.toFixed(1) : similarity) + '%';

    document.getElementById('stat-added').textContent     = stats.added ?? 0;
    document.getElementById('stat-removed').textContent   = stats.removed ?? 0;
    document.getElementById('stat-changed').textContent   = stats.changed ?? 0;
    document.getElementById('stat-unchanged').textContent = stats.unchanged ?? 0;

    // Render diff based on active format
    const out = document.getElementById('diff-output');
    out.innerHTML = '';
    out.className = 'font-mono text-xs leading-relaxed';

    if (activeFormat === 'json') {
      const pre = document.createElement('pre');
      pre.style.padding = '16px';
      pre.style.whiteSpace = 'pre-wrap';
      pre.style.color = 'var(--fn-text2)';
      pre.textContent = JSON.stringify(data, null, 2);
      out.appendChild(pre);
      rawDiffText = JSON.stringify(data, null, 2);
    } else if (activeFormat === 'side_by_side') {
      renderSideBySide(out, differences);
      rawDiffText = buildUnifiedText(differences);
    } else if (activeFormat === 'unified') {
      renderUnified(out, differences);
      rawDiffText = buildUnifiedText(differences);
    } else {
      // html / inline
      renderInline(out, differences);
      rawDiffText = buildUnifiedText(differences);
    }

    // Wire up download + copy
    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = URL.createObjectURL(new Blob([rawDiffText], { type: 'text/plain;charset=utf-8;' }));
    const dl = document.getElementById('download-link');
    dl.href = blobUrl;
    dl.download = activeFormat === 'json' ? 'diff.json' : 'diff.txt';

    document.getElementById('btn-copy-result').onclick = async () => {
      try {
        await navigator.clipboard.writeText(rawDiffText);
        document.getElementById('copy-result-label').textContent = 'Copied!';
        setTimeout(() => { document.getElementById('copy-result-label').textContent = 'Copy diff'; }, 2000);
      } catch(_) {}
    };
  }

  function renderUnified(container, diffs) {
    diffs.forEach(d => {
      if (d.type === 'equal') {
        splitLines(d.old_content).forEach((line, idx) => {
          container.appendChild(diffRow('equal', d.old_start + idx, ' ', line));
        });
      } else if (d.type === 'delete' || d.type === 'replace') {
        splitLines(d.old_content).forEach((line, idx) => {
          container.appendChild(diffRow('remove', d.old_start + idx, '-', line));
        });
        if (d.type === 'replace') {
          splitLines(d.new_content).forEach((line, idx) => {
            container.appendChild(diffRow('add', d.new_start + idx, '+', line));
          });
        }
      } else if (d.type === 'insert') {
        splitLines(d.new_content).forEach((line, idx) => {
          container.appendChild(diffRow('add', d.new_start + idx, '+', line));
        });
      }
    });
  }

  function renderInline(container, diffs) {
    // Similar to unified but without gutter
    diffs.forEach(d => {
      if (d.type === 'equal') {
        splitLines(d.old_content).forEach(line => {
          container.appendChild(diffRow('equal', '', '', line));
        });
      } else if (d.type === 'delete' || d.type === 'replace') {
        splitLines(d.old_content).forEach(line => {
          container.appendChild(diffRow('remove', '', '−', line));
        });
        if (d.type === 'replace') {
          splitLines(d.new_content).forEach(line => {
            container.appendChild(diffRow('add', '', '+', line));
          });
        }
      } else if (d.type === 'insert') {
        splitLines(d.new_content).forEach(line => {
          container.appendChild(diffRow('add', '', '+', line));
        });
      }
    });
  }

  function renderSideBySide(container, diffs) {
    const grid = document.createElement('div');
    grid.className = 'sbs-grid';
    diffs.forEach(d => {
      const oldLines = splitLines(d.old_content);
      const newLines = splitLines(d.new_content);
      const maxLen = Math.max(oldLines.length, newLines.length);

      for (let i = 0; i < maxLen; i++) {
        const leftLine  = oldLines[i] ?? '';
        const rightLine = newLines[i] ?? '';
        const leftLn    = oldLines[i] !== undefined ? (d.old_start + i) : '';
        const rightLn   = newLines[i] !== undefined ? (d.new_start + i) : '';

        let leftClass = '', rightClass = '';
        if (d.type === 'delete')  { leftClass = 'remove'; }
        if (d.type === 'insert')  { rightClass = 'add'; }
        if (d.type === 'replace') { leftClass = 'remove'; rightClass = 'add'; }

        appendCell(grid, 'sbs-ln left',    leftLn);
        appendCell(grid, 'sbs-cell left ' + leftClass,  leftLine);
        appendCell(grid, 'sbs-ln',         rightLn);
        appendCell(grid, 'sbs-cell ' + rightClass, rightLine);
      }
    });
    container.appendChild(grid);
  }

  function appendCell(parent, cls, text) {
    const div = document.createElement('div');
    div.className = cls;
    div.textContent = text;
    parent.appendChild(div);
  }

  function diffRow(type, lineNum, sign, content) {
    const row = document.createElement('div');
    row.className = 'diff-row ' + type;
    row.innerHTML = `
      <span class="ln">${lineNum}</span>
      <span class="sign">${sign}</span>
      <span class="content"></span>`;
    row.querySelector('.content').textContent = content;
    return row;
  }

  function splitLines(text) {
    if (!text) return [];
    return text.replace(/\n$/, '').split('\n');
  }

  function buildUnifiedText(diffs) {
    let out = '';
    diffs.forEach(d => {
      if (d.type === 'equal') {
        splitLines(d.old_content).forEach(l => out += '  ' + l + '\n');
      } else if (d.type === 'delete' || d.type === 'replace') {
        splitLines(d.old_content).forEach(l => out += '- ' + l + '\n');
        if (d.type === 'replace') {
          splitLines(d.new_content).forEach(l => out += '+ ' + l + '\n');
        }
      } else if (d.type === 'insert') {
        splitLines(d.new_content).forEach(l => out += '+ ' + l + '\n');
      }
    });
    return out;
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
    text1Area.value = '';
    text2Area.value = '';
    text1Area.dispatchEvent(new Event('input'));
    text2Area.dispatchEvent(new Event('input'));
    resetFile(1);
    resetFile(2);
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
