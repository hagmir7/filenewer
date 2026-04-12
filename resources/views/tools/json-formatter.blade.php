@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ MAIN CARD ══ --}}
<section class="pb-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- ── Mode tabs ── --}}
            <div class="flex items-center gap-1 p-2 border-b border-fn-text/7 bg-fn-surface2">
                <button type="button" id="tab-text"
                    class="tab-btn active flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="4 7 4 4 20 4 20 7" />
                        <line x1="9" y1="20" x2="15" y2="20" />
                        <line x1="12" y1="4" x2="12" y2="20" />
                    </svg>
                    Paste JSON
                </button>
                <button type="button" id="tab-file"
                    class="tab-btn flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Upload File
                </button>
            </div>

            <div class="p-6 lg:p-8">

                {{-- ── OPTIONS BAR (shared) ── --}}
                <div
                    class="flex flex-wrap items-center gap-3 mb-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">

                    {{-- Indent --}}
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-fn-text2 shrink-0">Indent</span>
                        <div class="flex gap-1">
                            @php $indentOpts = [2, 4, 8]; @endphp
                            @foreach($indentOpts as $ind)
                            <button type="button"
                                class="indent-btn {{ $ind === 4 ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-sm font-mono font-bold transition-all"
                                data-indent="{{ $ind }}">{{ $ind }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="w-px h-5 bg-fn-text/10 hidden sm:block"></div>

                    {{-- Toggles --}}
                    <label class="toggle-label flex items-center gap-2 cursor-pointer select-none">
                        <div class="toggle-wrap relative w-8 h-4">
                            <input type="checkbox" id="opt-sort" class="sr-only peer" />
                            <div
                                class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                            </div>
                            <div
                                class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-fn-text2">Sort Keys</span>
                    </label>

                    <label class="toggle-label flex items-center gap-2 cursor-pointer select-none">
                        <div class="toggle-wrap relative w-8 h-4">
                            <input type="checkbox" id="opt-minify" class="sr-only peer" />
                            <div
                                class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                            </div>
                            <div
                                class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-fn-text2">Minify</span>
                    </label>

                    <label class="toggle-label flex items-center gap-2 cursor-pointer select-none">
                        <div class="toggle-wrap relative w-8 h-4">
                            <input type="checkbox" id="opt-ascii" class="sr-only peer" />
                            <div
                                class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                            </div>
                            <div
                                class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-fn-text2">Escape ASCII</span>
                    </label>

                    <div class="w-px h-5 bg-fn-text/10 hidden sm:block"></div>

                    {{-- Output mode --}}
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-fn-text2 shrink-0">Output</span>
                        <div class="flex gap-1">
                            @php $outputOpts = [['text','Preview'],['file','Download']]; @endphp
                            @foreach($outputOpts as [$oval,$olabel])
                            <button type="button"
                                class="output-btn {{ $oval === 'text' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-sm font-semibold transition-all"
                                data-output="{{ $oval }}">{{ $olabel }}</button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Format button (compact, right-aligned) --}}
                    <button type="button" id="format-btn" disabled
                        class="ml-auto flex items-center gap-2 px-4 py-2 bg-fn-blue text-white text-sm font-bold rounded-lg transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Format
                    </button>
                </div>

                {{-- ══ TEXT TAB ══ --}}
                <div id="panel-text">
                    <div class="grid lg:grid-cols-2 gap-4">

                        {{-- Input --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Input JSON</p>
                                <div class="flex gap-2">
                                    <span id="text-input-status" class="hidden text-sm font-semibold"></span>
                                    <button type="button" id="btn-paste"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                            <rect x="8" y="2" width="8" height="4" rx="1" />
                                        </svg>
                                        Paste
                                    </button>
                                    <button type="button" id="btn-clear-text"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        </svg>
                                        Clear
                                    </button>
                                </div>
                            </div>
                            <div class="relative">
                                <textarea id="json-input" rows="20" spellcheck="false"
                                    placeholder='{"name": "Alice", "age": 30, "city": "London"}'
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                                <div id="error-gutter"
                                    class="hidden absolute left-0 top-0 bottom-0 w-1 bg-fn-red rounded-l-xl"></div>
                            </div>
                            {{-- Error detail --}}
                            <div id="text-error-banner"
                                class="hidden flex items-start gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="shrink-0 mt-0.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                <span id="text-error-msg"></span>
                            </div>
                        </div>

                        {{-- Output --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Formatted Output</p>
                                <div class="flex gap-2" id="output-actions">
                                    <button type="button" id="btn-copy"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="copy-label">Copy</span>
                                    </button>
                                    <a id="btn-download" href="#" download="formatted.json"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-green/10 border border-fn-green/25 text-fn-green text-sm font-semibold rounded-lg transition-all hover:bg-fn-green/20">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" y1="15" x2="12" y2="3" />
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                            <textarea id="json-output" rows="20" readonly spellcheck="false"
                                placeholder="Formatted JSON will appear here…"
                                class="w-full bg-fn-surface2 border border-fn-text/8 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none resize-none leading-relaxed placeholder:text-fn-text3/40 cursor-default"></textarea>
                            {{-- Stats bar --}}
                            <div id="stats-bar" class="hidden flex flex-wrap gap-x-4 gap-y-1">
                                @php
                                $statFields = [
                                ['stat-type', 'Type'],
                                ['stat-depth', 'Depth'],
                                ['stat-keys', 'Keys'],
                                ['stat-items', 'Items'],
                                ['stat-size-orig', 'Original'],
                                ['stat-size-fmt', 'Formatted'],
                                ];
                                @endphp
                                @foreach($statFields as [$sid, $slabel])
                                <div class="flex items-center gap-1">
                                    <span class="text-fn-text3 text-sm">{{ $slabel }}:</span>
                                    <span class="text-sm font-semibold text-fn-text2" id="{{ $sid }}">—</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>{{-- /panel-text --}}

                {{-- ══ FILE TAB ══ --}}
                <div id="panel-file" class="hidden">

                    {{-- Drop zone --}}
                    <div id="drop-zone"
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative mb-4">
                        <div class="flex items-center justify-center mb-4">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-4xl">
                                📋</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your JSON file here</h2>
                        <p class="text-fn-text3 text-sm mb-5">or click to browse from your computer</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue text-white text-sm font-semibold rounded-xl pointer-events-none">
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
                        class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4 mb-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            📋</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">data.json</p>
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

                    {{-- File result (shown after formatting) --}}
                    <div id="file-result" class="hidden">
                        <div class="grid lg:grid-cols-2 gap-4">
                            {{-- Stats card --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-lg" id="file-result-icon">✅</span>
                                    <p class="font-bold text-sm" id="file-result-title">Format Complete</p>
                                </div>
                                <div class="space-y-2" id="file-stats-rows"></div>
                            </div>
                            {{-- Download card --}}
                            <div
                                class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex flex-col justify-center gap-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                                        📋</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-sm truncate" id="file-output-name">formatted.json
                                        </p>
                                        <p class="text-fn-text3 text-sm mt-0.5" id="file-output-size">—</p>
                                    </div>
                                    <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                                </div>
                                <a id="file-download-link" href="#" download="formatted.json"
                                    class="flex items-center justify-center gap-2 px-4 py-2.5 text-white text-sm font-bold rounded-xl transition-all hover:-translate-y-0.5"
                                    style="background: oklch(67% 0.18 162);">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    Download Formatted JSON
                                </a>
                                <button type="button" onclick="resetFile()"
                                    class="flex items-center justify-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:bg-fn-surface2 transition-all">
                                    Format another file
                                </button>
                            </div>
                        </div>

                        {{-- Invalid JSON error for file mode --}}
                        <div id="file-error-banner"
                            class="hidden mt-4 flex items-start gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-red">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <div>
                                <p class="font-bold mb-0.5">Invalid JSON</p>
                                <p class="text-sm" id="file-error-msg"></p>
                            </div>
                        </div>
                    </div>

                </div>{{-- /panel-file --}}

                {{-- General error --}}
                <div id="general-error"
                    class="hidden mt-4 flex items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-red shrink-0" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span id="general-error-text"></span>
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
            @php
            $jfFaqs = [
            ['What does the JSON Formatter do?', 'It parses your raw or minified JSON and reformats it with proper
            indentation, making it human-readable. It also validates the JSON and reports the exact line and column of
            any syntax error.'],
            ['What is the difference between Format and Minify?', 'Format adds indentation and line breaks to make JSON
            easy to read. Minify does the opposite — it removes all whitespace to produce the smallest possible output,
            ideal for APIs and data transfer.'],
            ['What does Sort Keys do?', 'Sort Keys reorders all object keys alphabetically at every level of nesting.
            This is useful for consistent diffing, version control, or simply making large JSON objects easier to
            scan.'],
            ['Can I format a large JSON file?', 'Yes — switch to the Upload File tab and upload your .json file
            directly. Files up to 50MB are supported for free. For files over 50MB, upgrade to Pro.'],
            ['What stats does the formatter show?', 'After formatting you can see the JSON type (object, array, other),
            maximum nesting depth, total key count, top-level item count, and the original vs formatted file size in
            KB.'],
            ];
            @endphp
            @foreach($jfFaqs as [$q,$a])
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
        box-shadow: 0 1px 6px oklch(0% 0 0/14%);
    }

    .indent-btn,
    .output-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
    }

    .indent-btn.active,
    .output-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264/40%);
        background: oklch(49% 0.24 264/8%);
    }

    .indent-btn:not(.active):hover,
    .output-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264/25%);
        color: var(--fn-text);
    }

    /* Minify active → disable indent buttons visually */
    .indent-btn.muted {
        opacity: 0.4;
        pointer-events: none;
    }

    #json-input.invalid {
        border-color: oklch(62% 0.22 25/50%);
    }

    #json-input.valid {
        border-color: oklch(67% 0.18 162/40%);
    }

    #json-output {
        background: var(--fn-surface);
    }

    .stat-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 0;
    }

    .stat-row-label {
        font-size: 11px;
        color: var(--fn-text3);
        width: 100px;
        flex-shrink: 0;
    }

    .stat-row-value {
        font-size: 12px;
        font-weight: 600;
        color: var(--fn-text2);
    }
</style>

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      // ── State ──
      let activeTab    = 'text';
      let activeIndent = 4;
      let activeOutput = 'text';
      let selectedFile = null;
      let fileBlobUrl  = null;
      let textBlobUrl  = null;

      // ── Tab switching ──
      document.getElementById('tab-text').addEventListener('click', () => switchTab('text'));
      document.getElementById('tab-file').addEventListener('click', () => switchTab('file'));

      function switchTab(tab) {
        activeTab = tab;
        document.getElementById('tab-text').classList.toggle('active', tab === 'text');
        document.getElementById('tab-file').classList.toggle('active', tab === 'file');
        document.getElementById('panel-text').classList.toggle('hidden', tab !== 'text');
        document.getElementById('panel-file').classList.toggle('hidden', tab !== 'file');
        hideGeneralError();
        refreshFormatBtn();
      }

      // ── Indent buttons ──
      document.querySelectorAll('.indent-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.indent-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeIndent = parseInt(btn.dataset.indent);
        });
      });

      // ── Output buttons ──
      document.querySelectorAll('.output-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.output-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeOutput = btn.dataset.output;
        });
      });

      // ── Minify toggle: disable indent when active ──
      document.getElementById('opt-minify').addEventListener('change', e => {
        document.querySelectorAll('.indent-btn').forEach(b => {
          b.classList.toggle('muted', e.target.checked);
        });
      });

      // ── Text tab: live validation ──
      const jsonInput  = document.getElementById('json-input');
      const jsonOutput = document.getElementById('json-output');

      let validateTimer = null;
      jsonInput.addEventListener('input', () => {
        clearTimeout(validateTimer);
        validateTimer = setTimeout(liveValidate, 400);
        refreshFormatBtn();
      });

      function liveValidate() {
        const raw = jsonInput.value.trim();
        const statusEl = document.getElementById('text-input-status');
        const errBanner = document.getElementById('text-error-banner');
        const errGutter = document.getElementById('error-gutter');

        if (!raw) {
          jsonInput.className = jsonInput.className.replace(/\b(valid|invalid)\b/g, '').trim();
          statusEl.classList.add('hidden');
          errBanner.classList.add('hidden');
          errGutter.classList.add('hidden');
          return;
        }
        try {
          JSON.parse(raw);
          jsonInput.classList.remove('invalid'); jsonInput.classList.add('valid');
          statusEl.innerHTML = `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green inline-block mr-1"><polyline points="20 6 9 17 4 12"/></svg><span class="text-fn-green">Valid JSON</span>`;
          statusEl.classList.remove('hidden');
          errBanner.classList.add('hidden');
          errGutter.classList.add('hidden');
        } catch(e) {
          jsonInput.classList.remove('valid'); jsonInput.classList.add('invalid');
          statusEl.innerHTML = `<span class="text-fn-red">⚠ Invalid</span>`;
          statusEl.classList.remove('hidden');
          document.getElementById('text-error-msg').textContent = e.message;
          errBanner.classList.remove('hidden');
          errGutter.classList.remove('hidden');
        }
      }

      function refreshFormatBtn() {
        const btn = document.getElementById('format-btn');
        if (activeTab === 'text') {
          btn.disabled = !jsonInput.value.trim();
        } else {
          btn.disabled = !selectedFile;
        }
      }

      // Paste & clear
      document.getElementById('btn-paste').addEventListener('click', async () => {
        try { jsonInput.value = await navigator.clipboard.readText(); liveValidate(); refreshFormatBtn(); } catch(_) {}
      });
      document.getElementById('btn-clear-text').addEventListener('click', () => {
        jsonInput.value = '';
        jsonOutput.value = '';
        jsonInput.className = jsonInput.className.replace(/\b(valid|invalid)\b/g,'').trim();
        document.getElementById('text-input-status').classList.add('hidden');
        document.getElementById('text-error-banner').classList.add('hidden');
        document.getElementById('error-gutter').classList.add('hidden');
        document.getElementById('stats-bar').classList.add('hidden');
        document.getElementById('btn-copy').classList.add('hidden');
        document.getElementById('btn-download').classList.add('hidden');
        if (textBlobUrl) { URL.revokeObjectURL(textBlobUrl); textBlobUrl = null; }
        refreshFormatBtn();
      });

      // ── File tab ──
      const dropZone   = document.getElementById('drop-zone');
      const fileInput  = document.getElementById('file-input');
      const filePreview = document.getElementById('file-preview');

      ['dragenter','dragover'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
      });
      ['dragleave','dragend','drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
      });
      dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
      fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
      document.getElementById('remove-file').addEventListener('click', () => resetFile());

      function handleFile(file) {
        hideGeneralError();
        if (!file.name.toLowerCase().endsWith('.json') && file.type !== 'application/json') {
          showGeneralError('Please select a valid JSON file.');
          return;
        }
        if (file.size > 50 * 1024 * 1024) { showGeneralError('File exceeds the 50MB free limit.'); return; }
        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · JSON File';
        filePreview.classList.remove('hidden');
        filePreview.classList.add('flex');
        dropZone.classList.add('has-file');
        document.getElementById('file-result').classList.add('hidden');
        refreshFormatBtn();
      }

      window.resetFile = function() {
        selectedFile    = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
        dropZone.classList.remove('has-file');
        document.getElementById('file-result').classList.add('hidden');
        if (fileBlobUrl) { URL.revokeObjectURL(fileBlobUrl); fileBlobUrl = null; }
        refreshFormatBtn();
      };

      // ── Format button ──
      document.getElementById('format-btn').addEventListener('click', doFormat);

      async function doFormat() {
        hideGeneralError();
        const btn = document.getElementById('format-btn');
        btn.disabled = true;
        btn.innerHTML = `<svg class="spin w-3 h-3" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Formatting…`;

        const sortKeys   = document.getElementById('opt-sort').checked;
        const minify     = document.getElementById('opt-minify').checked;
        const ensureAscii = document.getElementById('opt-ascii').checked;

        try {
          if (activeTab === 'text') {
            await formatText(sortKeys, minify, ensureAscii);
          } else {
            await formatFile(sortKeys, minify, ensureAscii);
          }
        } catch(err) {
          showGeneralError(err.message || 'Something went wrong. Please try again.');
        } finally {
          btn.disabled = false;
          btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Format`;
          refreshFormatBtn();
        }
      }

      // ── Format text → /api/tools/format-json-text ──
      async function formatText(sortKeys, minify, ensureAscii) {
        let jsonValue;
        try { jsonValue = JSON.parse(jsonInput.value.trim()); }
        catch(e) { throw new Error('Cannot format — invalid JSON: ' + e.message); }

        const payload = {
          json:         jsonValue,
          indent:       minify ? 0 : activeIndent,
          sort_keys:    sortKeys,
          minify:       minify,
          ensure_ascii: ensureAscii,
          output:       activeOutput,
        };

        const res  = await fetch('https://api.filenewer.com/api/tools/format-json-text', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body:    JSON.stringify(payload),
        });

        if (!res.ok) {
          const d = await res.json().catch(() => ({}));
          throw new Error(d.error || 'Formatting failed.');
        }

        const data = await res.json();

        if (!data.is_valid) {
          document.getElementById('text-error-msg').textContent =
            data.error + (data.error_line ? ` (line ${data.error_line}, col ${data.error_column})` : '');
          document.getElementById('text-error-banner').classList.remove('hidden');
          document.getElementById('error-gutter').classList.remove('hidden');
          jsonInput.classList.add('invalid');
          jsonOutput.value = '';
          document.getElementById('stats-bar').classList.add('hidden');
          return;
        }

        const formatted = data.formatted ?? '';
        jsonOutput.value = formatted;

        // Stats
        populateStats(data);
        document.getElementById('stats-bar').classList.remove('hidden');

        // Copy / Download buttons
        const copyBtn = document.getElementById('btn-copy');
        const dlBtn   = document.getElementById('btn-download');

        copyBtn.classList.remove('hidden');
        if (textBlobUrl) URL.revokeObjectURL(textBlobUrl);
        textBlobUrl       = URL.createObjectURL(new Blob([formatted], { type: 'application/json' }));
        dlBtn.href        = textBlobUrl;
        dlBtn.download    = 'formatted.json';
        dlBtn.classList.remove('hidden');

        // Hide error banners
        document.getElementById('text-error-banner').classList.add('hidden');
        document.getElementById('error-gutter').classList.add('hidden');
        jsonInput.classList.remove('invalid'); jsonInput.classList.add('valid');
      }

      // ── Format file → /api/tools/format-json-file ──
      async function formatFile(sortKeys, minify, ensureAscii) {
        const fd = new FormData();
        fd.append('file',         selectedFile);
        fd.append('indent',       minify ? 0 : activeIndent);
        fd.append('sort_keys',    sortKeys   ? 'true' : 'false');
        fd.append('minify',       minify     ? 'true' : 'false');
        fd.append('ensure_ascii', ensureAscii ? 'true' : 'false');
        fd.append('output',       'file'); // always get file back; we show stats from headers/blob

        const res = await fetch('https://api.filenewer.com/api/tools/format-json-file', {
          method: 'POST',
          body:   fd,
        });

        const fileResultEl  = document.getElementById('file-result');
        const fileErrBanner = document.getElementById('file-error-banner');
        const fileStatsRows = document.getElementById('file-stats-rows');

        fileResultEl.classList.remove('hidden');

        // Always read as text first — the API may return JSON even for output=file
        const rawText = await res.text();

        // Try to parse as JSON (API response with formatted field or error)
        let data = null;
        try { data = JSON.parse(rawText); } catch(_) { data = null; }

        if (data !== null) {
          // Got a JSON response — either { is_valid, formatted, ... } or { error }
          if (data.is_valid === false) {
            document.getElementById('file-result-icon').textContent  = '❌';
            document.getElementById('file-result-title').textContent = 'Invalid JSON';
            document.getElementById('file-error-msg').textContent    =
              data.error + (data.error_line ? ` (line ${data.error_line}, col ${data.error_column})` : '');
            fileErrBanner.classList.remove('hidden');
            fileStatsRows.innerHTML = '';
            return;
          }

          if (!res.ok) {
            throw new Error(data.error || 'Formatting failed.');
          }

          // Valid JSON response — use the `formatted` field as the file content
          const formatted = data.formatted ?? rawText;
          fileErrBanner.classList.add('hidden');
          document.getElementById('file-result-icon').textContent  = '✅';
          document.getElementById('file-result-title').textContent = 'Format Complete';

          const blob    = new Blob([formatted], { type: 'application/json' });
          const outName = selectedFile.name.replace(/\.json$/i, '_formatted.json');
          if (fileBlobUrl) URL.revokeObjectURL(fileBlobUrl);
          fileBlobUrl = URL.createObjectURL(blob);

          const dlLink = document.getElementById('file-download-link');
          dlLink.href     = fileBlobUrl;
          dlLink.download = outName;

          document.getElementById('file-output-name').textContent = outName;
          document.getElementById('file-output-size').textContent = formatBytes(blob.size) + ' · JSON File';

          // Populate stats from API response
          fileStatsRows.innerHTML = '';
          const apiStats = [
            ['Type',           data.type       ?? '—'],
            ['Depth',          data.depth      ?? '—'],
            ['Keys',           data.key_count  ?? '—'],
            ['Items',          data.item_count ?? '—'],
            ['Original size',  data.size_original_kb  != null ? data.size_original_kb  + ' KB' : formatBytes(selectedFile.size)],
            ['Formatted size', data.size_formatted_kb != null ? data.size_formatted_kb + ' KB' : formatBytes(blob.size)],
            ['Indent',         data.minified ? 'Minified' : (data.indent ?? activeIndent) + ' spaces'],
            ['Sort keys',      data.sorted_keys ? 'Yes' : 'No'],
          ];
          apiStats.forEach(([label, value]) => {
            const div = document.createElement('div');
            div.className = 'stat-row';
            div.innerHTML = `<span class="stat-row-label">${label}</span><span class="stat-row-value">${value}</span>`;
            fileStatsRows.appendChild(div);
          });

        } else {
          // Raw file response (binary/plain text) — treat as direct file download
          if (!res.ok) throw new Error('Formatting failed.');

          fileErrBanner.classList.add('hidden');
          document.getElementById('file-result-icon').textContent  = '✅';
          document.getElementById('file-result-title').textContent = 'Format Complete';

          const blob    = new Blob([rawText], { type: 'application/json' });
          const outName = selectedFile.name.replace(/\.json$/i, '_formatted.json');
          if (fileBlobUrl) URL.revokeObjectURL(fileBlobUrl);
          fileBlobUrl = URL.createObjectURL(blob);

          const dlLink = document.getElementById('file-download-link');
          dlLink.href     = fileBlobUrl;
          dlLink.download = outName;

          document.getElementById('file-output-name').textContent = outName;
          document.getElementById('file-output-size').textContent = formatBytes(blob.size) + ' · JSON File';

          fileStatsRows.innerHTML = '';
          const knownStats = [
            ['Original size', formatBytes(selectedFile.size)],
            ['Formatted size', formatBytes(blob.size)],
            ['Indent',  minify ? 'Minified' : `${activeIndent} spaces`],
            ['Sort keys', sortKeys ? 'Yes' : 'No'],
          ];
          knownStats.forEach(([label, value]) => {
            const div = document.createElement('div');
            div.className = 'stat-row';
            div.innerHTML = `<span class="stat-row-label">${label}</span><span class="stat-row-value">${value}</span>`;
            fileStatsRows.appendChild(div);
          });
        }
      }

      // ── Populate stats bar (text mode) ──
      function populateStats(data) {
        document.getElementById('stat-type').textContent      = data.type       ?? '—';
        document.getElementById('stat-depth').textContent     = data.depth      ?? '—';
        document.getElementById('stat-keys').textContent      = data.key_count  ?? '—';
        document.getElementById('stat-items').textContent     = data.item_count ?? '—';
        document.getElementById('stat-size-orig').textContent = data.size_original_kb  != null ? data.size_original_kb  + ' KB' : '—';
        document.getElementById('stat-size-fmt').textContent  = data.size_formatted_kb != null ? data.size_formatted_kb + ' KB' : '—';
      }

      // ── Copy button ──
      document.getElementById('btn-copy').addEventListener('click', async () => {
        try {
          await navigator.clipboard.writeText(jsonOutput.value);
          const label = document.getElementById('copy-label');
          label.textContent = 'Copied!';
          setTimeout(() => { label.textContent = 'Copy'; }, 2000);
        } catch(_) {}
      });

      // ── Helpers ──
      function showGeneralError(msg) {
        document.getElementById('general-error-text').textContent = msg;
        document.getElementById('general-error').classList.remove('hidden');
        document.getElementById('general-error').classList.add('flex');
      }
      function hideGeneralError() {
        document.getElementById('general-error').classList.add('hidden');
        document.getElementById('general-error').classList.remove('flex');
      }
      function formatBytes(bytes) {
        if (!bytes) return '—';
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
          if (!isOpen) { body.classList.remove('hidden'); icon.style.transform = 'rotate(180deg)'; }
        });
      });

    }); // end DOMContentLoaded
    </script>
@endpush

@endsection
