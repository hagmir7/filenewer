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
                @foreach([['1','Input JSON'],['2','Converting'],['3','Result']] as [$n, $label])
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
                            Paste JSON
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .json
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">JSON source</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample-obj"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Object</button>
                                <button type="button" id="btn-sample-arr"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Array</button>
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
                                <button type="button" id="btn-format"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue text-xs font-semibold rounded-lg transition-all">Format</button>
                                <button type="button" id="btn-clear"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                            </div>
                        </div>

                        <textarea id="json-textarea" rows="12" spellcheck="false"
                            placeholder='Paste JSON object or array, e.g.&#10;&#10;{&#10;  "username": "booker12",&#10;  "department": "Sales",&#10;  "active": true,&#10;  "score": 98.5&#10;}'
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>

                        <div class="flex items-center justify-between text-xs mt-1.5">
                            <span id="json-status" class="text-fn-text3">Paste a JSON object or array</span>
                            <span id="json-meta" class="text-fn-text3/70">0 chars · 0 lines</span>
                        </div>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-yellow/40 hover:bg-fn-yellow/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div class="w-20 h-20 rounded-2xl flex items-center justify-center"
                                    style="background: oklch(85% 0.18 95 / 12%); border: 1px solid oklch(85% 0.18 95 / 25%)">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                        style="color: oklch(75% 0.18 88)">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="8" y1="13" x2="16" y2="13" />
                                        <line x1="8" y1="17" x2="16" y2="17" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your JSON file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .json files — or click to browse</p>
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
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input" accept=".json,application/json,text/plain"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                                style="background: oklch(85% 0.18 95 / 12%); border: 1px solid oklch(85% 0.18 95 / 25%)">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" style="color: oklch(75% 0.18 88)">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
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
                    </div>

                    {{-- Detected structure preview --}}
                    <div id="detected-content"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-blue/15 rounded-xl">
                        <div class="flex items-center gap-2 mb-3">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-blue-l">
                                <polyline points="16 18 22 12 16 6" />
                                <polyline points="8 6 2 12 8 18" />
                            </svg>
                            <p class="text-sm font-semibold text-fn-text2">Detected in your JSON</p>
                        </div>
                        <div class="flex flex-wrap gap-2" id="detected-chips"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">XML Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Left --}}
                            <div class="flex flex-col gap-3">

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label for="opt-root"
                                            class="text-xs font-semibold text-fn-text2 block mb-1.5">Root
                                            element</label>
                                        <input type="text" id="opt-root" value="root" placeholder="root"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                    </div>
                                    <div>
                                        <label for="opt-item"
                                            class="text-xs font-semibold text-fn-text2 block mb-1.5">Item
                                            element</label>
                                        <input type="text" id="opt-item" value="item" placeholder="item"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                    </div>
                                </div>

                                <div>
                                    <label for="opt-indent" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Indent size — <span id="indent-val" class="text-fn-blue-l font-mono">2</span>
                                        spaces
                                    </label>
                                    <input type="range" id="opt-indent" min="1" max="8" value="2"
                                        class="w-full accent-fn-blue cursor-pointer" />
                                </div>

                                <div>
                                    <label for="opt-output"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Output mode</label>
                                    <select id="opt-output"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="text" selected>Preview in browser</option>
                                        <option value="file">Download .xml file</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Right --}}
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Options</label>
                                <div class="flex flex-col gap-1.5">
                                    @foreach([
                                    ['opt-declaration', 'XML declaration', 'Add &lt;?xml version="1.0"?&gt; header',
                                    true],
                                    ['opt-prettify', 'Pretty-print', 'Indent with spaces for readability', true],
                                    ['opt-attributes', 'Attributes mode', 'Scalars as XML attributes instead', false],
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
                                            <p class="text-xs text-fn-text3 leading-tight">{!! $tdesc !!}</p>
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
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                        Convert to XML
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center"
                            style="background: oklch(85% 0.18 95 / 10%); border: 1px solid oklch(85% 0.18 95 / 20%)">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" style="color: oklch(75% 0.18 88)">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
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
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-blue-l">
                                <polyline points="16 18 22 12 16 6" />
                                <polyline points="8 6 2 12 8 18" />
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting JSON to XML…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Mapping types, building element tree &amp; serializing output
                    </p>

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
                        ['proc-1','Parsing JSON input'],
                        ['proc-2','Mapping types &amp; structure'],
                        ['proc-3','Building XML element tree'],
                        ['proc-4','Serializing output'],
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

                {{-- ── STATE: Result ── --}}
                <div id="state-download" class="hidden py-4">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-base">
                                ✅</div>
                            <div>
                                <p class="font-bold text-sm" id="result-title">Conversion complete</p>
                                <p class="text-fn-text3 text-xs" id="result-meta">—</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <button type="button" id="btn-copy-xml"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg hover:text-fn-text hover:bg-fn-surface2 transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                <span id="copy-label">Copy XML</span>
                            </button>
                            <a id="download-link" href="#" download="output.xml"
                                class="hidden flex items-center gap-1.5 px-3 py-1.5 text-white text-xs font-semibold rounded-lg transition-all hover:-translate-y-px"
                                style="background: oklch(67% 0.18 162);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download .xml
                            </a>
                            <button type="button" onclick="resetConverter()"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg hover:text-fn-text hover:bg-fn-surface2 transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10" />
                                    <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                                </svg>
                                Convert another
                            </button>
                        </div>
                    </div>

                    {{-- Result chips --}}
                    <div id="result-chips-wrap" class="hidden mb-4 flex flex-wrap gap-2" id="result-chips-wrap"></div>

                    {{-- Split pane: JSON → XML --}}
                    <div class="grid lg:grid-cols-2 gap-4">

                        {{-- JSON pane --}}
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-xs font-semibold text-fn-text2 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-sm inline-block"
                                        style="background: oklch(75% 0.18 88)"></span>
                                    Input JSON
                                </p>
                                <button type="button" id="btn-copy-json"
                                    class="text-xs text-fn-text3 hover:text-fn-text transition-colors font-semibold">Copy</button>
                            </div>
                            <pre id="json-preview"
                                class="flex-1 bg-fn-surface2 border border-fn-text/10 rounded-xl px-4 py-3 text-xs font-mono text-fn-text2 overflow-auto max-h-96 leading-relaxed whitespace-pre-wrap break-all"></pre>
                        </div>

                        {{-- XML pane --}}
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-xs font-semibold text-fn-text2 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-sm inline-block bg-fn-blue-l"></span>
                                    Output XML
                                </p>
                                <span class="text-xs text-fn-text3" id="xml-size-label">—</span>
                            </div>
                            <pre id="xml-preview"
                                class="flex-1 bg-fn-surface2 border border-fn-blue/15 rounded-xl px-4 py-3 text-xs font-mono text-fn-text2 overflow-auto max-h-96 leading-relaxed whitespace-pre-wrap break-all"></pre>
                        </div>

                    </div>

                    <p class="mt-5 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your data is encrypted in transit and never stored or shared.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ══ TYPE MAPPING ══ --}}
<section class="py-12 border-t border-fn-text/7 bg-fn-surface2">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-lg font-bold mb-1 text-center">JSON → XML Type Mapping</h2>
        <p class="text-fn-text3 text-sm text-center mb-6">Each JSON type is preserved with optional type annotations in
            the XML</p>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="border-b border-fn-text/10">
                        <th class="text-left py-2.5 px-3 text-xs font-bold text-fn-text2">JSON Type</th>
                        <th class="text-left py-2.5 px-3 text-xs font-bold text-fn-text2">XML Output</th>
                        <th class="text-left py-2.5 px-3 text-xs font-bold text-fn-text2">Attributes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                    ['string', '<tag>value</tag>', 'none'],
                    ['integer', '<tag type="integer">42</tag>', 'type="integer"'],
                    ['float', '<tag type="float">3.14</tag>', 'type="float"'],
                    ['boolean', '<tag type="boolean">true</tag>', 'type="boolean"'],
                    ['null', '
                    <tag nil="true" />', 'nil="true"'],
                    ['object', '<tag>…nested elements…</tag>', 'nested structure'],
                    ['array', '<tag type="array" count="N">…</tag>', 'type &amp; count attrs'],
                    ] as [$type, $xml, $attrs])
                    <tr class="border-b border-fn-text/7 hover:bg-fn-surface transition-colors">
                        <td class="py-2.5 px-3"><code
                                class="text-xs font-mono text-fn-blue-l bg-fn-blue/6 px-1.5 py-0.5 rounded">{{ $type }}</code>
                        </td>
                        <td class="py-2.5 px-3"><code class="text-xs font-mono text-fn-text2">{{ $xml }}</code></td>
                        <td class="py-2.5 px-3 text-xs text-fn-text3">{{ $attrs }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @foreach([
            ['What are root_element and item_element?', 'root_element is the outer tag that wraps the entire XML
            document (default: <root>). item_element is the tag name used for each item in a JSON array (default: <item>
                    ). For example, converting a users array with root_element="users" and item_element="user" produces
                    <users>
                        <user>…</user>
                    </users>.'],
                    ['What is attributes mode?', 'In the default mode, scalar values (strings, numbers, booleans) become
                    XML child elements. In attributes mode, those scalars are written as XML attributes on the root or
                    parent element instead — e.g. <root username="booker12" score="98.5">. Arrays and nested objects
                        still use child elements.'],
                        ['How are JSON types preserved in XML?', 'XML has no native type system, so types are recorded
                        as attributes: integers get type="integer", floats get type="float", booleans get
                        type="boolean", null becomes nil="true", and arrays get type="array" plus a count attribute.
                        Strings carry no type attribute.'],
                        ['Can I preview the XML without downloading?', 'Yes — select "Preview in browser" as the output
                        mode. The result appears in a side-by-side view with your original JSON on the left and the
                        converted XML on the right. You can copy either with one click, then download the .xml file if
                        needed.'],
                        ['Is my JSON data safe?', 'All data sent to the API uses TLS encryption in transit and is never
                        stored or logged. For the paste/text mode, nothing leaves your browser until you click
                        Convert.'],
                        ] as [$q, $a])
                        <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                            <button type="button"
                                class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left hover:bg-fn-surface2 transition-colors">
                                <span class="font-semibold text-sm">{{ $q }}</span>
                                <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
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

    .chip-type .chip-dot {
        background: oklch(75% 0.18 88);
    }

    .chip-type {
        color: oklch(65% 0.18 88);
        border-color: oklch(75% 0.18 88 / 30%);
        background: oklch(75% 0.18 88 / 6%);
    }

    .chip-keys .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-keys {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .chip-depth .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-depth {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .chip-size .chip-dot {
        background: oklch(67% 0.18 162);
    }

    .chip-size {
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
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_OBJ = JSON.stringify({
    username:   'booker12',
    identifier: 9012,
    first_name: 'Rachel',
    last_name:  'Booker',
    department: 'Sales',
    active:     true,
    score:      98.5,
    tags:       ['vip', 'new'],
    address: {
      city:    'Manchester',
      country: 'UK'
    }
  }, null, 2);

  const SAMPLE_ARR = JSON.stringify([
    { username: 'booker12',  department: 'Sales',       active: true  },
    { username: 'grey07',    department: 'Depot',       active: true  },
    { username: 'johnson81', department: 'Engineering', active: false },
  ], null, 2);

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
  const jsonTA      = document.getElementById('json-textarea');

  let selectedFile = null;
  let blobUrl      = null;
  let activeTab    = 'text';
  let detectTimer  = null;
  let lastXml      = '';
  let lastJson     = '';

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

  // ── Samples / Paste / Format / Clear ──
  document.getElementById('btn-sample-obj').addEventListener('click', () => {
    jsonTA.value = SAMPLE_OBJ;
    jsonTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-sample-arr').addEventListener('click', () => {
    jsonTA.value = SAMPLE_ARR;
    jsonTA.dispatchEvent(new Event('input'));
    // Suggest sensible element names for array
    document.getElementById('opt-root').value = 'users';
    document.getElementById('opt-item').value = 'user';
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { jsonTA.value = await navigator.clipboard.readText(); jsonTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-format').addEventListener('click', () => {
    try {
      jsonTA.value = JSON.stringify(JSON.parse(jsonTA.value), null, 2);
      jsonTA.dispatchEvent(new Event('input'));
    } catch(_) { showError('Invalid JSON — cannot format.'); }
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    jsonTA.value = '';
    jsonTA.dispatchEvent(new Event('input'));
  });

  // ── Indent slider ──
  document.getElementById('opt-indent').addEventListener('input', function () {
    document.getElementById('indent-val').textContent = this.value;
  });

  // ── Textarea input ──
  jsonTA.addEventListener('input', () => {
    const v     = jsonTA.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('json-meta').textContent = v.length.toLocaleString() + ' chars · ' + lines + ' lines';

    const status = document.getElementById('json-status');
    if (!v.trim()) {
      status.innerHTML = '<span class="text-fn-text3">Paste a JSON object or array</span>';
    } else {
      try {
        const parsed = JSON.parse(v);
        const stats  = analyzeJson(parsed);
        const parts  = [`${stats.type}`];
        if (stats.keyCount !== null)  parts.push(`${stats.keyCount} keys`);
        if (stats.itemCount !== null) parts.push(`${stats.itemCount} items`);
        if (stats.depth > 1) parts.push(`depth ${stats.depth}`);
        status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Valid JSON · ${parts.join(' · ')}
        </span>`;
        hideError();
      } catch(e) {
        status.innerHTML = '<span class="text-fn-red">Invalid JSON — ' + escHtml(e.message.substring(0, 60)) + '</span>';
      }
    }

    refreshConvertBtn();
    clearTimeout(detectTimer);
    detectTimer = setTimeout(refreshDetection, 300);
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
    if (!name.match(/\.(json|txt)$/)) {
      showError('Please select a valid JSON file (.json).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · JSON';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');

    if (file.size < 2 * 1024 * 1024) {
      try {
        const text   = await file.text();
        const parsed = JSON.parse(text);
        detectFromParsed(parsed);
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
    if (activeTab === 'text') {
      try { JSON.parse(jsonTA.value); convertBtn.disabled = false; }
      catch(_) { convertBtn.disabled = true; }
    } else {
      convertBtn.disabled = !selectedFile;
    }
  }

  // ── Detection ──
  function refreshDetection() {
    if (activeTab !== 'text') return;
    const v = jsonTA.value.trim();
    if (!v) { document.getElementById('detected-content').classList.add('hidden'); return; }
    try {
      detectFromParsed(JSON.parse(v));
    } catch(_) {
      document.getElementById('detected-content').classList.add('hidden');
    }
  }

  function detectFromParsed(parsed) {
    const stats = analyzeJson(parsed);
    const wrap  = document.getElementById('detected-content');
    const list  = document.getElementById('detected-chips');
    list.innerHTML = '';

    const chips = [['chip-type', 'Type', stats.type]];
    if (stats.keyCount !== null)  chips.push(['chip-keys',  'Keys',  stats.keyCount + '']);
    if (stats.itemCount !== null) chips.push(['chip-keys',  'Items', stats.itemCount + '']);
    if (stats.depth > 0)          chips.push(['chip-depth', 'Depth', stats.depth + '']);
    if (stats.hasArrays)          chips.push(['chip-mode',  'Arrays', 'detected']);
    if (stats.hasNulls)           chips.push(['chip-mode',  'Nulls', 'detected']);

    chips.forEach(([cls, label, val]) => {
      const chip = document.createElement('div');
      chip.className = 'chip-item ' + cls;
      chip.innerHTML = `<span class="chip-dot"></span><span class="chip-label"></span><span style="opacity:.6;margin-left:2px;font-family:monospace;font-size:10px;">${val}</span>`;
      chip.querySelector('.chip-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  function analyzeJson(v, depth) {
    depth = depth || 1;
    if (Array.isArray(v)) {
      return { type: 'array', keyCount: null, itemCount: v.length, depth, hasArrays: true, hasNulls: v.some(i => i === null) };
    }
    if (v !== null && typeof v === 'object') {
      const keys = Object.keys(v);
      let maxDepth = depth;
      let hasArrays = false, hasNulls = false;
      keys.forEach(k => {
        if (Array.isArray(v[k])) hasArrays = true;
        if (v[k] === null) hasNulls = true;
        if (typeof v[k] === 'object' && v[k] !== null) {
          const child = analyzeJson(v[k], depth + 1);
          if (child.depth > maxDepth) maxDepth = child.depth;
          if (child.hasArrays) hasArrays = true;
          if (child.hasNulls) hasNulls = true;
        }
      });
      return { type: 'object', keyCount: keys.length, itemCount: null, depth: maxDepth, hasArrays, hasNulls };
    }
    return { type: typeof v, keyCount: null, itemCount: null, depth, hasArrays: false, hasNulls: false };
  }

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const rootEl    = document.getElementById('opt-root').value.trim()  || 'root';
    const itemEl    = document.getElementById('opt-item').value.trim()   || 'item';
    const indent    = parseInt(document.getElementById('opt-indent').value);
    const outputMode = document.getElementById('opt-output').value;
    const inclDecl  = document.getElementById('opt-declaration').checked;
    const prettify  = document.getElementById('opt-prettify').checked;
    const attrMode  = document.getElementById('opt-attributes').checked;

    setProcessStep('proc-1', 'active');
    animateProgress(0, 22, 400, 'Parsing JSON input…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(22, 52, 600, 'Mapping types & structure…');
    }, 500);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(52, 78, 600, 'Building XML element tree…');
    }, 1200);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 92, 400, 'Serializing output…');
    }, 1900);

    try {
      let res, endpoint, fetchOpts;

      if (activeTab === 'text') {
        endpoint  = 'https://api.filenewer.com/api/tools/json-text-to-xml';
        const payload = {
          json:                JSON.parse(jsonTA.value),
          root_element:        rootEl,
          item_element:        itemEl,
          indent,
          include_declaration: inclDecl,
          prettify,
          attributes_mode:     attrMode,
          output:              outputMode,
        };
        fetchOpts = {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body:    JSON.stringify(payload),
        };
        lastJson = jsonTA.value;
      } else {
        endpoint = 'https://api.filenewer.com/api/tools/json-file-to-xml';
        const fd = new FormData();
        fd.append('file',                selectedFile);
        fd.append('root_element',        rootEl);
        fd.append('item_element',        itemEl);
        fd.append('indent',              indent);
        fd.append('include_declaration', inclDecl);
        fd.append('prettify',            prettify);
        fd.append('attributes_mode',     attrMode);
        fd.append('output',              outputMode);
        fetchOpts = { method: 'POST', body: fd };
        lastJson = '';
      }

      const res2 = await fetch(endpoint, fetchOpts);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res2.ok) {
        let msg = 'Conversion failed. Please check your JSON and try again.';
        try { const d = await res2.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(92, 100, 300, 'Done!');

      if (outputMode === 'file') {
        // File download
        const blob = await res2.blob();
        if (blobUrl) URL.revokeObjectURL(blobUrl);
        blobUrl = URL.createObjectURL(blob);

        const outName = activeTab === 'file'
          ? selectedFile.name.replace(/\.json$/i, '') + '.xml'
          : 'output.xml';

        const dlLink = document.getElementById('download-link');
        dlLink.href     = blobUrl;
        dlLink.download = outName;
        dlLink.classList.remove('hidden');
        dlLink.classList.add('flex');

        // Try to read blob for preview
        const reader = new FileReader();
        reader.onload = e => {
          lastXml = e.target.result;
          showResultState(lastJson, lastXml, { outputMode, rootEl, itemEl, attrMode, inclDecl, sizKb: (blob.size / 1024).toFixed(1) });
        };
        reader.readAsText(blob);
      } else {
        // JSON response with xml field
        const data = await res2.json();
        lastXml = data.xml || '';

        const dlLink = document.getElementById('download-link');
        dlLink.classList.add('hidden');
        dlLink.classList.remove('flex');

        showResultState(lastJson, lastXml, {
          outputMode,
          rootEl,
          itemEl,
          attrMode,
          inclDecl,
          type:      data.type,
          keyCount:  data.key_count,
          itemCount: data.item_count,
          depth:     data.depth,
          sizeOrigKb: data.size_original_kb,
          sizeXmlKb:  data.size_xml_kb,
        });
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

  function showResultState(jsonStr, xmlStr, meta) {
    // JSON pane
    const jsonPre = document.getElementById('json-preview');
    try {
      jsonPre.textContent = jsonStr
        ? JSON.stringify(JSON.parse(jsonStr), null, 2)
        : '(file upload — content not echoed)';
    } catch(_) {
      jsonPre.textContent = jsonStr || '(file upload)';
    }

    // XML pane
    document.getElementById('xml-preview').textContent = xmlStr;

    // Size label
    const xmlBytes = new TextEncoder().encode(xmlStr).length;
    document.getElementById('xml-size-label').textContent = formatBytes(xmlBytes);

    // Meta line
    const parts = [];
    if (meta.type)      parts.push(meta.type);
    if (meta.keyCount)  parts.push(meta.keyCount + ' keys');
    if (meta.itemCount) parts.push(meta.itemCount + ' items');
    if (meta.depth)     parts.push('depth ' + meta.depth);
    document.getElementById('result-meta').textContent = parts.join(' · ') || '—';

    // Title
    document.getElementById('result-title').textContent = meta.attrMode
      ? 'Converted with attributes mode'
      : 'Conversion complete';

    // Result chips
    renderResultChips(meta);
  }

  function renderResultChips(meta) {
    const wrap = document.getElementById('result-chips-wrap');
    wrap.innerHTML = '';
    const chips = [
      ['chip-type', 'Root', '<' + (meta.rootEl || 'root') + '>'],
      ['chip-keys', 'Item', '<' + (meta.itemEl || 'item') + '>'],
    ];
    if (meta.attrMode)  chips.push(['chip-mode', 'Mode', 'attributes']);
    if (meta.inclDecl)  chips.push(['chip-size', 'Declaration', '<?xml?>']);
    if (meta.sizeXmlKb) chips.push(['chip-size', 'XML size', meta.sizeXmlKb + ' KB']);

    chips.forEach(([cls, label, val]) => {
      const chip = document.createElement('div');
      chip.className = 'chip-item ' + cls;
      chip.innerHTML = `<span class="chip-dot"></span><span class="chip-label"></span><span style="opacity:.6;margin-left:2px;font-family:monospace;font-size:10px;">${escHtml(val)}</span>`;
      chip.querySelector('.chip-label').textContent = label;
      wrap.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  // ── Copy buttons ──
  document.getElementById('btn-copy-xml').addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(lastXml);
      const label = document.getElementById('copy-label');
      label.textContent = 'Copied!';
      setTimeout(() => { label.textContent = 'Copy XML'; }, 2000);
    } catch(_) {}
  });

  document.getElementById('btn-copy-json').addEventListener('click', async () => {
    try {
      const text = document.getElementById('json-preview').textContent;
      await navigator.clipboard.writeText(text);
      const btn = document.getElementById('btn-copy-json');
      btn.textContent = 'Copied!';
      setTimeout(() => { btn.textContent = 'Copy'; }, 2000);
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
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  window.resetConverter = function () {
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    resetFile();
    jsonTA.value = '';
    jsonTA.dispatchEvent(new Event('input'));
    document.getElementById('opt-root').value        = 'root';
    document.getElementById('opt-item').value        = 'item';
    document.getElementById('opt-indent').value      = '2';
    document.getElementById('indent-val').textContent = '2';
    document.getElementById('opt-output').value      = 'text';
    document.getElementById('opt-declaration').checked = true;
    document.getElementById('opt-prettify').checked    = true;
    document.getElementById('opt-attributes').checked  = false;
    document.getElementById('detected-content').classList.add('hidden');
    document.getElementById('result-chips-wrap').classList.add('hidden');
    document.getElementById('download-link').classList.add('hidden');
    document.getElementById('download-link').classList.remove('flex');
    lastXml = ''; lastJson = '';
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
