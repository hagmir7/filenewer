@extends('layouts.base')

@section('title', 'UUID Generator – Generate, Validate & Export UUIDs | Filenewer')

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ MAIN CARD ══ --}}
<section class="pb-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- ── Mode tabs ── --}}
            <div class="flex items-center gap-1 p-2 border-b border-fn-text/7 bg-fn-surface2">
                @php
                $uuidTabs = [
                ['generate', '⚡', 'Generate'],
                ['validate', '✅', 'Validate'],
                ['bulk', '📦', 'Bulk Export'],
                ];
                @endphp
                @foreach($uuidTabs as [$tval,$ticon,$tlabel])
                <button type="button"
                    class="tab-btn {{ $tval === 'generate' ? 'active' : '' }} flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    data-tab="{{ $tval }}">
                    <span>{{ $ticon }}</span><span>{{ $tlabel }}</span>
                </button>
                @endforeach
            </div>

            <div class="p-6 lg:p-8">

                {{-- ══ GENERATE TAB ══ --}}
                <div id="panel-generate" class="tab-panel">
                    <div class="grid lg:grid-cols-3 gap-6">

                        {{-- ── LEFT: Options ── --}}
                        <div class="lg:col-span-1 space-y-4">

                            {{-- Version --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">UUID Version</label>
                                <div class="grid grid-cols-3 gap-1.5">
                                    @php $uuidVersions = [1,3,4,5,6,7]; @endphp
                                    @foreach($uuidVersions as $v)
                                    <button type="button"
                                        class="ver-btn {{ $v === 4 ? 'active' : '' }} py-2 rounded-xl border text-sm font-bold transition-all"
                                        data-ver="{{ $v }}">v{{ $v }}</button>
                                    @endforeach
                                </div>
                                <p class="text-fn-text3 text-xs mt-2" id="ver-desc">Random (cryptographically secure)
                                </p>
                            </div>

                            {{-- Count --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">
                                    Count — <span id="count-val" class="text-fn-blue-l">1</span>
                                </label>
                                <input type="range" id="opt-count" min="1" max="50" value="1" step="1"
                                    class="w-full accent-fn-blue cursor-pointer mb-1" />
                                <div class="flex justify-between text-fn-text3 text-xs">
                                    <span>1</span><span>10</span><span>25</span><span>50</span>
                                </div>
                                <input type="number" id="opt-count-num" min="1" max="50" value="1"
                                    class="mt-2 w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40" />
                            </div>

                            {{-- Name-based options (v3/v5) --}}
                            <div id="name-opts"
                                class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Namespace</label>
                                    <select id="opt-namespace"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                        <option value="dns">DNS</option>
                                        <option value="url">URL</option>
                                        <option value="oid">OID</option>
                                        <option value="x500">X.500</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="opt-name" class="text-xs font-semibold text-fn-text2 block mb-1.5">Name
                                        <span class="text-fn-red">*</span></label>
                                    <input type="text" id="opt-name" placeholder="e.g. example.com"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>
                            </div>

                            {{-- Format options --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-2">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Format</label>
                                @php
                                $fmtToggles = [
                                ['opt-uppercase', 'Uppercase'],
                                ['opt-hyphens', 'Include hyphens'],
                                ['opt-braces', 'Wrap with braces { }'],
                                ];
                                @endphp
                                @foreach($fmtToggles as [$tid,$tlabel])
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <div class="toggle-wrap relative w-8 h-4">
                                        <input type="checkbox" id="{{ $tid }}" {{ $tid==='opt-hyphens' ? 'checked' : ''
                                            }} class="sr-only peer" />
                                        <div
                                            class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                        </div>
                                        <div
                                            class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                        </div>
                                    </div>
                                    <span class="text-xs text-fn-text2 font-semibold">{{ $tlabel }}</span>
                                </label>
                                @endforeach
                            </div>

                            {{-- Prefix / Suffix / Seed --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-2">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1">Extra Options</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="text-xs text-fn-text3 block mb-1">Prefix</label>
                                        <input type="text" id="opt-prefix" placeholder="ID-"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                    </div>
                                    <div>
                                        <label class="text-xs text-fn-text3 block mb-1">Suffix</label>
                                        <input type="text" id="opt-suffix" placeholder="-END"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                    </div>
                                </div>
                                <div>
                                    <label class="text-xs text-fn-text3 block mb-1">Seed <span
                                            class="font-normal">(optional — for reproducibility)</span></label>
                                    <input type="number" id="opt-seed" placeholder="e.g. 42"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                </div>
                            </div>

                            <button type="button" id="gen-btn"
                                class="w-full py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all hover:bg-fn-blue-l hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                </svg>
                                Generate
                            </button>

                        </div>{{-- /left --}}

                        {{-- ── RIGHT: Output ── --}}
                        <div class="lg:col-span-2 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold text-fn-text2" id="gen-output-label">Generated UUIDs</p>
                                <div class="flex gap-2">
                                    <span id="gen-desc-badge"
                                        class="hidden text-xs px-2 py-1 bg-fn-blue/10 border border-fn-blue/20 text-fn-blue-l rounded-lg font-semibold"></span>
                                    <button type="button" id="gen-copy-all"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="gen-copy-label">Copy all</span>
                                    </button>
                                    <button type="button" id="gen-regen"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue-l text-xs font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="1 4 1 10 7 10" />
                                            <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                                        </svg>
                                        Regenerate
                                    </button>
                                </div>
                            </div>

                            {{-- UUID list --}}
                            <div id="gen-uuid-list" class="space-y-1.5 min-h-32">
                                {{-- Empty state --}}
                                <div id="gen-empty"
                                    class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-fn-text/8 rounded-xl text-fn-text3 gap-2">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="7" width="20" height="14" rx="2" />
                                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                                        <line x1="12" y1="12" x2="12" y2="16" />
                                        <line x1="10" y1="14" x2="14" y2="14" />
                                    </svg>
                                    <span class="text-sm">Configure options and click Generate</span>
                                </div>
                            </div>

                            <div id="gen-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-xs text-fn-red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                </svg>
                                <span id="gen-error-text"></span>
                            </div>
                        </div>

                    </div>
                </div>{{-- /panel-generate --}}

                {{-- ══ VALIDATE TAB ══ --}}
                <div id="panel-validate" class="tab-panel hidden">
                    <div class="max-w-2xl space-y-4">

                        <div class="flex gap-2">
                            <input type="text" id="val-input" placeholder="550e8400-e29b-41d4-a716-446655440000"
                                class="flex-1 bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40" />
                            <button type="button" id="val-btn"
                                class="px-5 py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 shrink-0"
                                disabled>
                                Validate
                            </button>
                        </div>

                        {{-- Quick paste --}}
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="val-paste"
                                class="flex items-center gap-1 px-2.5 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <rect x="8" y="2" width="8" height="4" rx="1" />
                                </svg>
                                Paste
                            </button>
                            <span class="text-xs text-fn-text3 self-center">Try:</span>
                            @php
                            $valExamples = [
                            '550e8400-e29b-41d4-a716-446655440000',
                            '6ba7b810-9dad-11d1-80b4-00c04fd430c8',
                            'not-a-uuid',
                            ];
                            @endphp
                            @foreach($valExamples as $ve)
                            <button type="button"
                                class="val-example px-2 py-0.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-mono rounded-lg transition-all"
                                data-uuid="{{ $ve }}">{{ Str::limit($ve, 20) }}</button>
                            @endforeach
                        </div>

                        {{-- Result --}}
                        <div id="val-result" class="hidden p-5 rounded-2xl border space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl" id="val-icon">✅</span>
                                <div>
                                    <p class="font-bold text-base" id="val-title">Valid UUID</p>
                                    <p class="text-fn-text3 text-xs mt-0.5 font-mono" id="val-uuid-display"></p>
                                </div>
                            </div>
                            {{-- Info chips --}}
                            <div class="flex flex-wrap gap-2" id="val-chips"></div>
                            {{-- Formatted versions --}}
                            <div id="val-formats-wrap" class="hidden">
                                <p class="text-xs font-semibold text-fn-text2 mb-2">All Formats</p>
                                <div class="grid sm:grid-cols-2 gap-1.5" id="val-formats"></div>
                            </div>
                        </div>

                        <div id="val-error"
                            class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-xs text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <span id="val-error-text"></span>
                        </div>
                    </div>
                </div>{{-- /panel-validate --}}

                {{-- ══ BULK TAB ══ --}}
                <div id="panel-bulk" class="tab-panel hidden">
                    <div class="grid lg:grid-cols-3 gap-6">

                        {{-- Options --}}
                        <div class="space-y-4">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">Version</label>
                                <div class="grid grid-cols-3 gap-1.5">
                                    @foreach($uuidVersions as $v)
                                    <button type="button"
                                        class="bulk-ver-btn {{ $v === 4 ? 'active' : '' }} py-2 rounded-xl border text-sm font-bold transition-all"
                                        data-ver="{{ $v }}">v{{ $v }}</button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">
                                    Count — <span id="bulk-count-val" class="text-fn-blue-l">10</span>
                                </label>
                                <input type="range" id="bulk-count" min="1" max="1000" value="10" step="1"
                                    class="w-full accent-fn-blue cursor-pointer mb-1" />
                                <div class="flex justify-between text-fn-text3 text-xs mb-2">
                                    <span>1</span><span>250</span><span>500</span><span>1000</span>
                                </div>
                                <input type="number" id="bulk-count-num" min="1" max="1000" value="10"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40" />
                            </div>

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">Export Format</label>
                                <div class="space-y-1.5">
                                    @php $bulkFormats = [['standard','One per line'],['csv','CSV with
                                    header'],['json','JSON array'],['sql','SQL INSERT'],['array','JS array']]; @endphp
                                    @foreach($bulkFormats as [$fval,$flabel])
                                    <label
                                        class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-fn-surface transition-colors">
                                        <input type="radio" name="bulk-format" value="{{ $fval }}" {{ $fval==='json'
                                            ? 'checked' : '' }} class="accent-fn-blue" />
                                        <span class="text-xs text-fn-text2 font-semibold">{{ $flabel }}</span>
                                        <span class="text-fn-text3 text-xs font-mono ml-auto">{{ $fval }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" id="bulk-preview-btn"
                                    class="py-2.5 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-bold rounded-xl transition-all hover:bg-fn-surface2 flex items-center justify-center gap-1.5">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Preview
                                </button>
                                <button type="button" id="bulk-download-btn"
                                    class="py-2.5 bg-fn-blue text-white text-xs font-bold rounded-xl transition-all hover:bg-fn-blue-l flex items-center justify-center gap-1.5">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    Download
                                </button>
                            </div>
                        </div>

                        {{-- Preview output --}}
                        <div class="lg:col-span-2 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold text-fn-text2">Preview</p>
                                <div class="flex gap-2">
                                    <span id="bulk-meta" class="hidden text-xs text-fn-text3"></span>
                                    <button type="button" id="bulk-copy-btn"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="bulk-copy-label">Copy</span>
                                    </button>
                                    <a id="bulk-dl-link" href="#" download="uuids.txt"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-green/10 border border-fn-green/25 text-fn-green text-xs font-semibold rounded-lg hover:bg-fn-green/20 transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" y1="15" x2="12" y2="3" />
                                        </svg>
                                        <span id="bulk-dl-label">Download</span>
                                    </a>
                                </div>
                            </div>
                            <textarea id="bulk-output" rows="20" readonly spellcheck="false"
                                placeholder="Click Preview or Download to generate UUIDs…"
                                class="w-full bg-fn-surface2 border border-fn-text/8 text-fn-text text-xs font-mono rounded-xl px-4 py-3 focus:outline-none resize-none leading-relaxed placeholder:text-fn-text3/30 cursor-default"></textarea>
                            <div id="bulk-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-xs text-fn-red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                <span id="bulk-error-text"></span>
                            </div>
                        </div>

                    </div>
                </div>{{-- /panel-bulk --}}

            </div>{{-- /card body --}}
        </div>{{-- /card --}}
    </div>
</section>


{{-- ══ VERSION REFERENCE ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">UUID Versions Guide</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php
            $versionGuide = [
            ['v1', 'Time + MAC', false, 'Legacy systems. Embeds the host MAC address — may raise privacy concerns.'],
            ['v3', 'MD5 hash', false, 'Deterministic from a name + namespace. Same input → same UUID. Legacy choice.'],
            ['v4', 'Random', false, 'Most common. Cryptographically random — ideal for general-purpose IDs.'],
            ['v5', 'SHA-1 hash', false, 'Like v3 but uses SHA-1. Preferred over v3 for name-based deterministic
            UUIDs.'],
            ['v6', 'Reordered time', true, 'Sortable replacement for v1. Timestamp in the high bits for natural
            ordering.'],
            ['v7', 'Unix timestamp', true, 'Modern standard. Millisecond-precision timestamp. Best for database primary
            keys.'],
            ];
            @endphp
            @foreach($versionGuide as [$ver,$algo,$sortable,$desc])
            <div class="p-4 bg-fn-surface border border-fn-text/8 rounded-xl">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-base font-black text-fn-text">{{ $ver }}</span>
                    @if($sortable)
                    <span
                        class="text-xs px-2 py-0.5 bg-fn-green/10 border border-fn-green/25 text-fn-green rounded-md font-bold">✓
                        Sortable</span>
                    @else
                    <span
                        class="text-xs px-2 py-0.5 bg-fn-text/6 border border-fn-text/10 text-fn-text3 rounded-md font-semibold">Not
                        sortable</span>
                    @endif
                </div>
                <p class="text-xs font-mono text-fn-blue-l mb-1.5">{{ $algo }}</p>
                <p class="text-xs text-fn-text3 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

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
        box-shadow: 0 1px 6px oklch(0% 0 0/14%);
    }

    .ver-btn,
    .bulk-ver-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .ver-btn.active,
    .bulk-ver-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264/40%);
        background: oklch(49% 0.24 264/8%);
    }

    .ver-btn:not(.active):hover,
    .bulk-ver-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264/25%);
        color: var(--fn-text);
    }

    .uuid-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
        border-radius: 10px;
        transition: border-color .15s;
        cursor: pointer;
    }

    .uuid-row:hover {
        border-color: oklch(49% 0.24 264/30%);
    }

    .uuid-row .uuid-text {
        font-family: monospace;
        font-size: 13px;
        color: var(--fn-text2);
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .uuid-row .uuid-num {
        font-size: 10px;
        color: var(--fn-text3);
        width: 20px;
        text-align: right;
        flex-shrink: 0;
    }

    .uuid-row .uuid-copy {
        font-size: 10px;
        color: var(--fn-blue-l);
        font-weight: 700;
        opacity: 0;
        transition: opacity .15s;
        flex-shrink: 0;
    }

    .uuid-row:hover .uuid-copy {
        opacity: 1;
    }

    .uuid-row.copied {
        border-color: oklch(67% 0.18 162/40%);
        background: oklch(67% 0.18 162/6%);
    }

    .val-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/10%);
        color: var(--fn-text2);
    }

    .fmt-row {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
        border-radius: 8px;
        cursor: pointer;
        transition: border-color .15s;
    }

    .fmt-row:hover {
        border-color: oklch(49% 0.24 264/30%);
    }

    .fmt-row-label {
        font-size: 10px;
        color: var(--fn-text3);
        width: 80px;
        flex-shrink: 0;
    }

    .fmt-row-value {
        font-size: 11px;
        font-family: monospace;
        color: var(--fn-text2);
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .fmt-row-copy {
        font-size: 10px;
        color: var(--fn-blue-l);
        font-weight: 700;
        opacity: 0;
        flex-shrink: 0;
        transition: opacity .15s;
    }

    .fmt-row:hover .fmt-row-copy {
        opacity: 1;
    }
</style>

{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const API = 'https://api.filenewer.com/api/tools';

  // ── Version descriptions ──
  const verDescs = {
    1: 'Time-based (MAC address)',
    3: 'MD5 name-based (deterministic)',
    4: 'Random (cryptographically secure)',
    5: 'SHA-1 name-based (deterministic)',
    6: 'Reordered time-based (sortable)',
    7: 'Unix timestamp ms (sortable, modern)',
  };

  // ── Tab switching ──
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
      document.getElementById('panel-' + btn.dataset.tab).classList.remove('hidden');
    });
  });

  // ══ GENERATE TAB ══

  let genVersion = 4;
  let bulkVersion = 4;
  let bulkBlobUrl = null;

  // Version buttons
  document.querySelectorAll('.ver-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.ver-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      genVersion = parseInt(btn.dataset.ver);
      document.getElementById('ver-desc').textContent = verDescs[genVersion] ?? '';
      // Show/hide name options
      const needsName = genVersion === 3 || genVersion === 5;
      document.getElementById('name-opts').classList.toggle('hidden', !needsName);
    });
  });

  // Count slider ↔ number sync
  const countRange = document.getElementById('opt-count');
  const countNum   = document.getElementById('opt-count-num');
  countRange.addEventListener('input', () => {
    document.getElementById('count-val').textContent = countRange.value;
    countNum.value = countRange.value;
  });
  countNum.addEventListener('input', () => {
    const v = Math.max(1, Math.min(50, parseInt(countNum.value) || 1));
    countNum.value   = v;
    countRange.value = v;
    document.getElementById('count-val').textContent = v;
  });

  // Generate button
  document.getElementById('gen-btn').addEventListener('click', doGenerate);
  document.getElementById('gen-regen').addEventListener('click', doGenerate);

  async function doGenerate() {
    const btn = document.getElementById('gen-btn');
    btn.disabled = true;
    btn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Generating…`;

    const count = parseInt(countNum.value) || 1;
    hideEl('gen-error');

    const payload = {
      version:   genVersion,
      count,
      uppercase: document.getElementById('opt-uppercase').checked,
      hyphens:   document.getElementById('opt-hyphens').checked,
      braces:    document.getElementById('opt-braces').checked,
      prefix:    document.getElementById('opt-prefix').value || '',
      suffix:    document.getElementById('opt-suffix').value || '',
    };

    const needsName = genVersion === 3 || genVersion === 5;
    if (needsName) {
      payload.namespace = document.getElementById('opt-namespace').value;
      payload.name      = document.getElementById('opt-name').value;
    }

    const seed = document.getElementById('opt-seed').value;
    if (seed) payload.seed = parseInt(seed);

    try {
      const res  = await fetch(`${API}/uuid-generate`, {
        method: 'POST', headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Generation failed.');

      renderUUIDs(data.uuids ?? [], data.description ?? verDescs[genVersion]);
    } catch(err) {
      document.getElementById('gen-error-text').textContent = err.message;
      showEl('gen-error', 'flex');
    } finally {
      btn.disabled = false;
      btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Generate`;
    }
  }

  function renderUUIDs(uuids, desc) {
    const list = document.getElementById('gen-uuid-list');
    list.innerHTML = '';
    hideEl('gen-empty'); // remove empty state if still there

    const empty = document.createElement('div');
    empty.id = 'gen-empty';
    empty.className = 'hidden';
    list.appendChild(empty);

    uuids.forEach((uuid, idx) => {
      const row = document.createElement('div');
      row.className = 'uuid-row';
      row.innerHTML = `
        <span class="uuid-num">${idx + 1}</span>
        <span class="uuid-text">${escHtml(uuid)}</span>
        <span class="uuid-copy">Copy</span>`;
      row.addEventListener('click', () => {
        navigator.clipboard.writeText(uuid).catch(() => {});
        row.classList.add('copied');
        row.querySelector('.uuid-copy').textContent = 'Copied!';
        setTimeout(() => {
          row.classList.remove('copied');
          row.querySelector('.uuid-copy').textContent = 'Copy';
        }, 1500);
      });
      list.appendChild(row);
    });

    // Badge + actions
    document.getElementById('gen-desc-badge').textContent = desc;
    showEl('gen-desc-badge');
    showEl('gen-copy-all');
    showEl('gen-regen');
    document.getElementById('gen-output-label').textContent = `Generated UUIDs (${uuids.length})`;

    // Copy all
    document.getElementById('gen-copy-all').onclick = async () => {
      await navigator.clipboard.writeText(uuids.join('\n')).catch(() => {});
      document.getElementById('gen-copy-label').textContent = 'Copied!';
      setTimeout(() => { document.getElementById('gen-copy-label').textContent = 'Copy all'; }, 2000);
    };
  }

  // ══ VALIDATE TAB ══

  const valInput = document.getElementById('val-input');
  const valBtn   = document.getElementById('val-btn');

  valInput.addEventListener('input', () => { valBtn.disabled = !valInput.value.trim(); });
  valInput.addEventListener('keydown', e => { if (e.key === 'Enter') doValidate(); });
  valBtn.addEventListener('click', doValidate);

  document.getElementById('val-paste').addEventListener('click', async () => {
    try { valInput.value = await navigator.clipboard.readText(); valBtn.disabled = false; } catch(_) {}
  });

  document.querySelectorAll('.val-example').forEach(btn => {
    btn.addEventListener('click', () => {
      valInput.value = btn.dataset.uuid;
      valBtn.disabled = false;
      doValidate();
    });
  });

  async function doValidate() {
    const uuid = valInput.value.trim();
    if (!uuid) return;
    valBtn.disabled = true;
    valBtn.textContent = '…';
    hideEl('val-error'); hideEl('val-result');

    try {
      const res  = await fetch(`${API}/uuid-validate`, {
        method: 'POST', headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ uuid }),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Validation failed.');

      const valid = data.is_valid;
      const result = document.getElementById('val-result');
      result.className = `p-5 rounded-2xl border space-y-4 ${valid
        ? 'bg-fn-green/6 border-fn-green/20'
        : 'bg-fn-red/6 border-fn-red/20'}`;

      document.getElementById('val-icon').textContent         = valid ? '✅' : '❌';
      document.getElementById('val-title').textContent        = valid ? 'Valid UUID' : 'Invalid UUID';
      document.getElementById('val-uuid-display').textContent = data.uuid ?? uuid;

      // Chips
      const chips = document.getElementById('val-chips');
      chips.innerHTML = '';
      if (valid) {
        [
          ['Version', 'v' + data.version],
          ['Variant', data.variant ?? '—'],
          ['Type', data.description ?? '—'],
        ].forEach(([label, val]) => {
          const span = document.createElement('span');
          span.className = 'val-chip';
          span.innerHTML = `<span class="text-fn-text3">${label}:</span> ${escHtml(String(val))}`;
          chips.appendChild(span);
        });
      }

      // Format cards
      const fmts = data.formatted ?? {};
      const fmtDefs = [
        ['Standard',    fmts.standard],
        ['Uppercase',   fmts.uppercase],
        ['No hyphens',  fmts.no_hyphens],
        ['Braces',      fmts.braces],
        ['URN',         fmts.urn],
        ['Hex',         fmts.hex],
      ].filter(([,v]) => v != null);

      const fmtWrap = document.getElementById('val-formats-wrap');
      const fmtEl   = document.getElementById('val-formats');
      if (valid && fmtDefs.length > 0) {
        fmtEl.innerHTML = '';
        fmtDefs.forEach(([label, value]) => {
          const div = document.createElement('div');
          div.className = 'fmt-row';
          div.innerHTML = `
            <span class="fmt-row-label">${label}</span>
            <span class="fmt-row-value">${escHtml(String(value))}</span>
            <span class="fmt-row-copy">Copy</span>`;
          div.addEventListener('click', () => {
            navigator.clipboard.writeText(String(value)).catch(() => {});
            div.querySelector('.fmt-row-copy').textContent = 'Copied!';
            setTimeout(() => { div.querySelector('.fmt-row-copy').textContent = 'Copy'; }, 1500);
          });
          fmtEl.appendChild(div);
        });
        fmtWrap.classList.remove('hidden');
      } else {
        fmtWrap.classList.add('hidden');
      }

      showEl('val-result');
    } catch(err) {
      document.getElementById('val-error-text').textContent = err.message;
      showEl('val-error', 'flex');
    } finally {
      valBtn.disabled = false;
      valBtn.textContent = 'Validate';
    }
  }

  // ══ BULK TAB ══

  // Version buttons (bulk)
  document.querySelectorAll('.bulk-ver-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.bulk-ver-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      bulkVersion = parseInt(btn.dataset.ver);
    });
  });

  // Count sync
  const bulkRange = document.getElementById('bulk-count');
  const bulkNum   = document.getElementById('bulk-count-num');
  bulkRange.addEventListener('input', () => {
    document.getElementById('bulk-count-val').textContent = bulkRange.value;
    bulkNum.value = bulkRange.value;
  });
  bulkNum.addEventListener('input', () => {
    const v = Math.max(1, Math.min(1000, parseInt(bulkNum.value) || 1));
    bulkNum.value   = v;
    bulkRange.value = v;
    document.getElementById('bulk-count-val').textContent = v;
  });

  document.getElementById('bulk-preview-btn').addEventListener('click', () => doBulk('preview'));
  document.getElementById('bulk-download-btn').addEventListener('click', () => doBulk('download'));

  async function doBulk(mode) {
    const count  = parseInt(bulkNum.value) || 10;
    const format = document.querySelector('input[name="bulk-format"]:checked').value;
    hideEl('bulk-error');

    const previewBtn  = document.getElementById('bulk-preview-btn');
    const downloadBtn = document.getElementById('bulk-download-btn');
    previewBtn.disabled  = true;
    downloadBtn.disabled = true;

    try {
      const res  = await fetch(`${API}/uuid-bulk`, {
        method: 'POST', headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ version: bulkVersion, count, format, output: 'json' }),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Bulk generation failed.');

      // Build output string
      let output = '';
      if (data.export) {
        output = data.export;
      } else if (Array.isArray(data.uuids)) {
        output = data.uuids.join('\n');
      }

      document.getElementById('bulk-output').value = output;
      document.getElementById('bulk-meta').textContent = `${count} UUIDs · v${bulkVersion} · ${format}`;
      showEl('bulk-meta');
      showEl('bulk-copy-btn');

      // Wire copy
      document.getElementById('bulk-copy-btn').onclick = async () => {
        await navigator.clipboard.writeText(output).catch(() => {});
        document.getElementById('bulk-copy-label').textContent = 'Copied!';
        setTimeout(() => { document.getElementById('bulk-copy-label').textContent = 'Copy'; }, 2000);
      };

      // Download link
      const extMap = { standard:'txt', csv:'csv', json:'json', sql:'sql', array:'js' };
      const ext    = extMap[format] ?? 'txt';
      if (bulkBlobUrl) URL.revokeObjectURL(bulkBlobUrl);
      bulkBlobUrl = URL.createObjectURL(new Blob([output], { type: 'text/plain;charset=utf-8;' }));
      const dlLink = document.getElementById('bulk-dl-link');
      dlLink.href     = bulkBlobUrl;
      dlLink.download = `uuids_v${bulkVersion}.${ext}`;
      document.getElementById('bulk-dl-label').textContent = `Download .${ext}`;
      showEl('bulk-dl-link');

      if (mode === 'download') dlLink.click();

    } catch(err) {
      document.getElementById('bulk-error-text').textContent = err.message;
      showEl('bulk-error', 'flex');
    } finally {
      previewBtn.disabled  = false;
      downloadBtn.disabled = false;
    }
  }

  // ── Utility ──
  function showEl(id, display = 'block') {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('hidden');
    if (display === 'flex') el.classList.add('flex');
  }
  function hideEl(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.add('hidden');
    el.classList.remove('flex');
  }
  function escHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

}); // end DOMContentLoaded
</script>

@endsection
