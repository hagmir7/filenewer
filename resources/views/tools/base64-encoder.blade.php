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
            <div class="flex items-center gap-1 p-2 border-b border-fn-text/7 bg-fn-surface2 flex-wrap">
                @php
                $b64Tabs = [
                ['encode-text', '✏️', 'Encode Text'],
                ['encode-file', '📁', 'Encode File'],
                ['decode', '🔓', 'Decode'],
                ['validate', '✅', 'Validate'],
                ];
                @endphp
                @foreach($b64Tabs as [$tval,$ticon,$tlabel])
                <button type="button"
                    class="tab-btn {{ $tval === 'encode-text' ? 'active' : '' }} flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    data-tab="{{ $tval }}">
                    <span>{{ $ticon }}</span>
                    <span>{{ $tlabel }}</span>
                </button>
                @endforeach
            </div>

            <div class="p-6 lg:p-8">

                {{-- ══ SHARED OPTIONS BAR ══ --}}
                <div
                    class="flex flex-wrap items-center gap-3 mb-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-fn-text2 shrink-0">Encoding</span>
                        @php $encodingTypes = [['standard','Standard'],['url_safe','URL-safe'],['mime','MIME']]; @endphp
                        @foreach($encodingTypes as [$eval,$elabel])
                        <button type="button"
                            class="enc-type-btn {{ $eval === 'standard' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-sm font-semibold transition-all"
                            data-enc="{{ $eval }}">{{ $elabel }}</button>
                        @endforeach
                    </div>
                    <div class="w-px h-5 bg-fn-text/10 hidden sm:block"></div>
                    {{-- Decode-specific options --}}
                    <div class="decode-only hidden flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <div class="toggle-wrap relative w-8 h-4">
                                <input type="checkbox" id="opt-as-text" checked class="sr-only peer" />
                                <div
                                    class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                </div>
                                <div
                                    class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-fn-text2">As Text</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-fn-text2 shrink-0">Output</span>
                            @php $decOutputs = [['json','Preview'],['file','Download']]; @endphp
                            @foreach($decOutputs as [$doval,$dolabel])
                            <button type="button"
                                class="dec-output-btn {{ $doval === 'json' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-sm font-semibold transition-all"
                                data-decout="{{ $doval }}">{{ $dolabel }}</button>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-2" id="decode-filename-wrap">
                            <span class="text-sm text-fn-text3">Filename:</span>
                            <input type="text" id="opt-decode-filename" placeholder="decoded.txt" value="decoded.txt"
                                class="bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1 font-mono focus:outline-none w-28 focus:border-fn-blue/40" />
                        </div>
                    </div>
                    {{-- Encode-specific: chunk size --}}
                    <div class="encode-only flex items-center gap-2">
                        <span class="text-sm font-semibold text-fn-text2 shrink-0">Line wrap</span>
                        <select id="opt-chunk"
                            class="bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1 font-sans focus:outline-none cursor-pointer">
                            <option value="0">None</option>
                            <option value="76">76 (MIME)</option>
                            <option value="64">64</option>
                        </select>
                    </div>
                </div>

                {{-- ══ ENCODE TEXT TAB ══ --}}
                <div id="panel-encode-text" class="tab-panel">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Input Text</p>
                                <div class="flex gap-2">
                                    <button type="button" id="et-paste"
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
                                    <button type="button" id="et-clear"
                                        class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">Clear</button>
                                </div>
                            </div>
                            <textarea id="et-input" rows="12" spellcheck="false"
                                placeholder="Enter or paste text to encode…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                            <button type="button" id="et-encode-btn"
                                class="w-full flex items-center justify-center gap-2 py-2.5 bg-fn-blue text-white text-sm font-bold rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed"
                                disabled>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                </svg>
                                Encode
                            </button>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Base64 Output</p>
                                <div class="flex gap-2" id="et-output-actions">
                                    <span id="et-stats" class="hidden text-sm text-fn-text3 self-center"></span>
                                    <button type="button" id="et-copy"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="et-copy-label">Copy</span>
                                    </button>
                                </div>
                            </div>
                            <textarea id="et-output" rows="12" readonly spellcheck="false"
                                placeholder="Base64 encoded output will appear here…"
                                class="w-full bg-fn-surface border border-fn-text/8 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none resize-none leading-relaxed placeholder:text-fn-text3/30 cursor-default"></textarea>
                            <div id="et-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                </svg>
                                <span id="et-error-text"></span>
                            </div>
                        </div>
                    </div>
                </div>{{-- /encode-text --}}

                {{-- ══ ENCODE FILE TAB ══ --}}
                <div id="panel-encode-file" class="tab-panel hidden">

                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div id="ef-drop-zone"
                                class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                <div class="text-4xl mb-3">📁</div>
                                <h2 class="text-base font-bold mb-1">Drop any file here</h2>
                                <p class="text-fn-text3 text-sm mb-4">Images, documents, audio — any file type</p>
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-fn-blue text-white text-sm font-semibold rounded-lg pointer-events-none">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" y1="3" x2="12" y2="15" />
                                    </svg>
                                    Choose File
                                </div>
                                <p class="text-fn-text3 text-sm mt-3">Max 10MB</p>
                                <input type="file" id="ef-input"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </div>
                            <div id="ef-file-preview"
                                class="hidden p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-xl shrink-0"
                                    id="ef-icon">📄</div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate" id="ef-file-name">file.png</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="ef-file-meta">—</p>
                                </div>
                                <button type="button" id="ef-remove"
                                    class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                </button>
                            </div>
                            <button type="button" id="ef-encode-btn"
                                class="w-full flex items-center justify-center gap-2 py-2.5 bg-fn-blue text-white text-sm font-bold rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed"
                                disabled>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                </svg>
                                Encode File
                            </button>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Base64 Output</p>
                                <div class="flex gap-2">
                                    <span id="ef-stats" class="hidden text-sm text-fn-text3 self-center"></span>
                                    <button type="button" id="ef-copy"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="ef-copy-label">Copy</span>
                                    </button>
                                </div>
                            </div>
                            <textarea id="ef-output" rows="8" readonly spellcheck="false"
                                placeholder="Base64 encoded output will appear here…"
                                class="w-full bg-fn-surface border border-fn-text/8 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none resize-none leading-relaxed placeholder:text-fn-text3/30 cursor-default"></textarea>

                            {{-- Data URI card (shown for images) --}}
                            <div id="ef-data-uri-wrap" class="hidden space-y-2">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-fn-text2">Data URI</p>
                                    <button type="button" id="ef-copy-uri"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="ef-copy-uri-label">Copy</span>
                                    </button>
                                </div>
                                <textarea id="ef-data-uri" rows="3" readonly spellcheck="false"
                                    class="w-full bg-fn-surface border border-fn-text/8 text-fn-text3 text-sm font-mono rounded-xl px-4 py-3 focus:outline-none resize-none leading-relaxed cursor-default"></textarea>
                                {{-- Image preview --}}
                                <div id="ef-img-preview-wrap" class="hidden">
                                    <p class="text-sm font-semibold text-fn-text2 mb-2">Image Preview</p>
                                    <img id="ef-img-preview" src="" alt="Preview"
                                        class="max-h-40 rounded-xl border border-fn-text/8 object-contain bg-fn-surface2 w-full" />
                                </div>
                            </div>
                            <div id="ef-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                <span id="ef-error-text"></span>
                            </div>
                        </div>
                    </div>
                </div>{{-- /encode-file --}}

                {{-- ══ DECODE TAB ══ --}}
                <div id="panel-decode" class="tab-panel hidden">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Base64 Input</p>
                                <div class="flex gap-2">
                                    <button type="button" id="dec-paste"
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
                                    <button type="button" id="dec-clear"
                                        class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">Clear</button>
                                </div>
                            </div>
                            <textarea id="dec-input" rows="12" spellcheck="false"
                                placeholder="Paste Base64 string here…&#10;e.g. SGVsbG8sIFdvcmxkIQ=="
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                            <button type="button" id="dec-decode-btn"
                                class="w-full flex items-center justify-center gap-2 py-2.5 bg-fn-blue text-white text-sm font-bold rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed"
                                disabled>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Decode
                            </button>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Decoded Output</p>
                                <div class="flex gap-2">
                                    <span id="dec-stats" class="hidden text-sm text-fn-text3 self-center"></span>
                                    <button type="button" id="dec-copy"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="dec-copy-label">Copy</span>
                                    </button>
                                    <a id="dec-download" href="#" download="decoded.txt"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-green/10 border border-fn-green/25 text-fn-green text-sm font-semibold rounded-lg hover:bg-fn-green/20 transition-all">
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
                            <textarea id="dec-output" rows="12" readonly spellcheck="false"
                                placeholder="Decoded text will appear here…"
                                class="w-full bg-fn-surface border border-fn-text/8 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none resize-none leading-relaxed placeholder:text-fn-text3/30 cursor-default"></textarea>
                            <div id="dec-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                </svg>
                                <span id="dec-error-text"></span>
                            </div>
                        </div>
                    </div>
                </div>{{-- /decode --}}

                {{-- ══ VALIDATE TAB ══ --}}
                <div id="panel-validate" class="tab-panel hidden">
                    <div class="max-w-2xl">
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Base64 String to Validate</p>
                                <div class="flex gap-2">
                                    <button type="button" id="val-paste"
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
                                    <button type="button" id="val-clear"
                                        class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">Clear</button>
                                </div>
                            </div>
                            <textarea id="val-input" rows="8" spellcheck="false"
                                placeholder="Paste Base64 string to validate…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                            <button type="button" id="val-btn"
                                class="w-full flex items-center justify-center gap-2 py-2.5 bg-fn-blue text-white text-sm font-bold rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed"
                                disabled>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Validate
                            </button>
                        </div>

                        {{-- Validation result --}}
                        <div id="val-result" class="hidden p-5 rounded-2xl border">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-3xl" id="val-icon">✅</span>
                                <div>
                                    <p class="font-bold text-base" id="val-title">Valid Base64</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="val-message"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="val-stats"></div>
                        </div>

                        <div id="val-error"
                            class="hidden mt-3 flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <span id="val-error-text"></span>
                        </div>
                    </div>
                </div>{{-- /validate --}}

            </div>{{-- /card body --}}
        </div>{{-- /card --}}
    </div>
</section>


{{-- ══ ENCODING REFERENCE ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Encoding Types</h2>
        <div class="grid sm:grid-cols-3 gap-4">
            @php
            $encTypes = [
            ['Standard', 'A–Z a–z 0–9 + / =', 'General purpose encoding. Used everywhere — APIs, data storage, email
            bodies.'],
            ['URL-safe', 'A–Z a–z 0–9 - _ =', 'Replaces + with - and / with _. Safe to use in URLs, filenames, and JWT
            tokens without percent-encoding.'],
            ['MIME', 'Standard + line breaks every 76 chars', 'Used in email (MIME) attachments. Adds CRLF line breaks
            every 76 characters as specified in RFC 2045.'],
            ];
            @endphp
            @foreach($encTypes as [$name,$chars,$desc])
            <div class="p-4 bg-fn-surface border border-fn-text/8 rounded-xl">
                <p class="font-bold text-sm mb-1">{{ $name }}</p>
                <p class="text-sm font-mono text-fn-blue-l mb-2">{{ $chars }}</p>
                <p class="text-sm text-fn-text3 leading-relaxed">{{ $desc }}</p>
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

    .enc-type-btn,
    .dec-output-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .enc-type-btn.active,
    .dec-output-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264/40%);
        background: oklch(49% 0.24 264/8%);
    }

    .enc-type-btn:not(.active):hover,
    .dec-output-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264/25%);
        color: var(--fn-text);
    }

    .val-stat-chip {
        padding: 8px 12px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
        border-radius: 10px;
        text-align: center;
    }

    .val-stat-chip .stat-label {
        font-size: 10px;
        color: var(--fn-text3);
    }

    .val-stat-chip .stat-value {
        font-size: 13px;
        font-weight: 700;
        color: var(--fn-text2);
        margin-top: 2px;
    }
</style>

{{-- ══ JAVASCRIPT ══ --}}
@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      const API = 'https://api.filenewer.com/api/tools';
      let activeTab    = 'encode-text';
      let activeEnc    = 'standard';
      let activeDecOut = 'json';
      let efFile       = null;
      let decBlobUrl   = null;

      // ── Tab switching ──
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          activeTab = btn.dataset.tab;
          document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
          document.getElementById('panel-' + activeTab).classList.remove('hidden');
          // Show/hide options bar sections
          document.querySelectorAll('.decode-only').forEach(el =>
            el.classList.toggle('hidden', activeTab !== 'decode'));
          document.querySelectorAll('.encode-only').forEach(el =>
            el.classList.toggle('hidden', activeTab === 'decode' || activeTab === 'validate'));
        });
      });

      // ── Encoding type buttons ──
      document.querySelectorAll('.enc-type-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.enc-type-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeEnc = btn.dataset.enc;
        });
      });

      // ── Decode output buttons ──
      document.querySelectorAll('.dec-output-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.dec-output-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeDecOut = btn.dataset.decout;
          document.getElementById('decode-filename-wrap').classList.toggle('hidden', activeDecOut !== 'file');
        });
      });

      // ── Paste & clear helpers ──
      function setupPasteClear(pasteId, clearId, targetId, btnId) {
        document.getElementById(pasteId)?.addEventListener('click', async () => {
          try {
            document.getElementById(targetId).value = await navigator.clipboard.readText();
            if (btnId) document.getElementById(btnId).disabled = false;
          } catch(_) {}
        });
        document.getElementById(clearId)?.addEventListener('click', () => {
          document.getElementById(targetId).value = '';
          if (btnId) document.getElementById(btnId).disabled = true;
        });
      }

      setupPasteClear('et-paste', 'et-clear', 'et-input', 'et-encode-btn');
      setupPasteClear('dec-paste', 'dec-clear', 'dec-input', 'dec-decode-btn');
      setupPasteClear('val-paste', 'val-clear', 'val-input', 'val-btn');

      // Enable buttons on input
      ['et-input','dec-input','val-input'].forEach(id => {
        const el  = document.getElementById(id);
        const btn = { 'et-input':'et-encode-btn', 'dec-input':'dec-decode-btn', 'val-input':'val-btn' }[id];
        el.addEventListener('input', () => {
          document.getElementById(btn).disabled = !el.value.trim();
        });
      });

      // ── Copy helpers ──
      function setupCopy(btnId, labelId, getVal) {
        document.getElementById(btnId)?.addEventListener('click', async () => {
          try {
            await navigator.clipboard.writeText(getVal());
            const lbl = document.getElementById(labelId);
            lbl.textContent = 'Copied!';
            setTimeout(() => { lbl.textContent = 'Copy'; }, 2000);
          } catch(_) {}
        });
      }

      setupCopy('et-copy', 'et-copy-label', () => document.getElementById('et-output').value);
      setupCopy('ef-copy', 'ef-copy-label', () => document.getElementById('ef-output').value);
      setupCopy('ef-copy-uri', 'ef-copy-uri-label', () => document.getElementById('ef-data-uri').value);
      setupCopy('dec-copy', 'dec-copy-label', () => document.getElementById('dec-output').value);

      // ══ ENCODE TEXT ══
      document.getElementById('et-encode-btn').addEventListener('click', async () => {
        const text = document.getElementById('et-input').value;
        if (!text) return;
        setLoading('et-encode-btn');
        hideEl('et-error');
        try {
          const res  = await fetch(`${API}/base64-encode-text`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({
              text,
              encoding:   activeEnc,
              chunk_size: parseInt(document.getElementById('opt-chunk').value) || 0,
            }),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Encoding failed.');
          document.getElementById('et-output').value = data.encoded ?? '';
          document.getElementById('et-stats').textContent =
            `${data.original_size_kb ?? 0} KB → ${data.encoded_size_kb ?? 0} KB (+${Math.round(data.overhead_percent ?? 0)}% overhead)`;
          showEl('et-stats');
          showEl('et-copy');
        } catch(err) {
          document.getElementById('et-error-text').textContent = err.message;
          showEl('et-error', 'flex');
        } finally {
          resetBtn('et-encode-btn', 'Encode');
        }
      });

      // ══ ENCODE FILE ══
      const efDropZone = document.getElementById('ef-drop-zone');
      const efInput    = document.getElementById('ef-input');

      ['dragenter','dragover'].forEach(evt => {
        efDropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); efDropZone.classList.add('drag-over'); });
      });
      ['dragleave','dragend','drop'].forEach(evt => {
        efDropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); efDropZone.classList.remove('drag-over'); });
      });
      efDropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleEfFile(e.dataTransfer.files[0]); });
      efInput.addEventListener('change', e => { if (e.target.files[0]) handleEfFile(e.target.files[0]); });
      document.getElementById('ef-remove').addEventListener('click', () => {
        efFile = null; efInput.value = '';
        hideEl('ef-file-preview');
        document.getElementById('ef-encode-btn').disabled = true;
      });

      function handleEfFile(file) {
        if (file.size > 10 * 1024 * 1024) {
          document.getElementById('ef-error-text').textContent = 'File exceeds the 10MB limit.';
          showEl('ef-error', 'flex');
          return;
        }
        efFile = file;
        const ext  = file.name.split('.').pop().toLowerCase();
        const imgExts = ['png','jpg','jpeg','gif','webp','svg','bmp'];
        document.getElementById('ef-icon').textContent       = imgExts.includes(ext) ? '🖼️' : '📄';
        document.getElementById('ef-file-name').textContent  = file.name;
        document.getElementById('ef-file-meta').textContent  = formatBytes(file.size) + ' · ' + (file.type || ext.toUpperCase());
        showEl('ef-file-preview', 'flex');
        document.getElementById('ef-encode-btn').disabled = false;
        hideEl('ef-error');
      }

      document.getElementById('ef-encode-btn').addEventListener('click', async () => {
        if (!efFile) return;
        setLoading('ef-encode-btn');
        hideEl('ef-error');
        const fd = new FormData();
        fd.append('file',       efFile);
        fd.append('encoding',   activeEnc);
        fd.append('chunk_size', document.getElementById('opt-chunk').value || 0);
        try {
          const res  = await fetch(`${API}/base64-encode-file`, { method: 'POST', body: fd });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Encoding failed.');
          document.getElementById('ef-output').value = data.encoded ?? '';
          document.getElementById('ef-stats').textContent =
            `${data.original_size_kb ?? 0} KB → ${data.encoded_size_kb ?? 0} KB (+${Math.round(data.overhead_percent ?? 0)}% overhead)`;
          showEl('ef-stats'); showEl('ef-copy');
          if (data.data_uri) {
            document.getElementById('ef-data-uri').value = data.data_uri;
            showEl('ef-data-uri-wrap');
            // Image preview
            if (data.mime_type && data.mime_type.startsWith('image/')) {
              document.getElementById('ef-img-preview').src = data.data_uri;
              showEl('ef-img-preview-wrap');
            } else {
              hideEl('ef-img-preview-wrap');
            }
          } else {
            hideEl('ef-data-uri-wrap');
          }
        } catch(err) {
          document.getElementById('ef-error-text').textContent = err.message;
          showEl('ef-error', 'flex');
        } finally {
          resetBtn('ef-encode-btn', 'Encode File');
        }
      });

      // ══ DECODE ══
      document.getElementById('dec-decode-btn').addEventListener('click', async () => {
        const text = document.getElementById('dec-input').value.trim();
        if (!text) return;
        setLoading('dec-decode-btn');
        hideEl('dec-error');
        const filename = document.getElementById('opt-decode-filename').value.trim() || 'decoded.txt';
        try {
          const payload = {
            text,
            encoding:      activeEnc,
            as_text:       document.getElementById('opt-as-text').checked,
            text_encoding: 'utf-8',
            output:        activeDecOut,
          };
          if (activeDecOut === 'file') payload.filename = filename;

          const res = await fetch(`${API}/base64-decode`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
          });

          if (activeDecOut === 'file') {
            if (!res.ok) { const d = await res.json(); throw new Error(d.error || 'Decode failed.'); }
            const blob = await res.blob();
            if (decBlobUrl) URL.revokeObjectURL(decBlobUrl);
            decBlobUrl = URL.createObjectURL(blob);
            const dl = document.getElementById('dec-download');
            dl.href     = decBlobUrl;
            dl.download = filename;
            document.getElementById('dec-output').value = `File ready to download: ${filename}\n(${formatBytes(blob.size)})`;
            showEl('dec-download');
            showEl('dec-stats');
            document.getElementById('dec-stats').textContent = formatBytes(blob.size);
            hideEl('dec-copy');
          } else {
            const data = await res.json();
            if (!res.ok) throw new Error(data.error || 'Decode failed.');
            document.getElementById('dec-output').value = data.decoded_text ?? '';
            document.getElementById('dec-stats').textContent =
              `${data.original_size_kb ?? 0} KB → ${data.decoded_size_kb ?? 0} KB · ${data.text_encoding ?? 'utf-8'}`;
            showEl('dec-stats'); showEl('dec-copy');
            hideEl('dec-download');
          }
        } catch(err) {
          document.getElementById('dec-error-text').textContent = err.message;
          showEl('dec-error', 'flex');
        } finally {
          resetBtn('dec-decode-btn', 'Decode');
        }
      });

      // ══ VALIDATE ══
      document.getElementById('val-btn').addEventListener('click', async () => {
        const text = document.getElementById('val-input').value.trim();
        if (!text) return;
        setLoading('val-btn');
        hideEl('val-error'); hideEl('val-result');
        try {
          const res  = await fetch(`${API}/base64-validate`, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ text }),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Validation failed.');

          const valid = data.is_valid;
          const result = document.getElementById('val-result');
          result.className = `p-5 rounded-2xl border ${valid
            ? 'bg-fn-green/6 border-fn-green/20'
            : 'bg-fn-red/6 border-fn-red/20'}`;
          document.getElementById('val-icon').textContent    = valid ? '✅' : '❌';
          document.getElementById('val-title').textContent   = valid ? 'Valid Base64' : 'Invalid Base64';
          document.getElementById('val-message').textContent = data.message ?? '';

          const statsEl = document.getElementById('val-stats');
          statsEl.innerHTML = '';
          const chips = [
            ['Encoding',    data.encoding ?? '—'],
            ['Input size',  (data.input_size ?? 0) + ' chars'],
            ['Decoded size', (data.decoded_size_kb ?? 0) + ' KB'],
            ['Decoded bytes', data.decoded_size ?? '—'],
          ];
          chips.forEach(([label, value]) => {
            const div = document.createElement('div');
            div.className = 'val-stat-chip';
            div.innerHTML = `<div class="stat-label">${label}</div><div class="stat-value">${value}</div>`;
            statsEl.appendChild(div);
          });
          showEl('val-result');
        } catch(err) {
          document.getElementById('val-error-text').textContent = err.message;
          showEl('val-error', 'flex');
        } finally {
          resetBtn('val-btn', 'Validate');
        }
      });

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
      function setLoading(btnId) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.disabled = true;
        btn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Working…`;
      }
      function resetBtn(btnId, label) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.disabled = false;
        btn.innerHTML = label;
      }
      function formatBytes(bytes) {
        if (!bytes) return '—';
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
      }

    }); // end DOMContentLoaded
    </script>
@endpush

@endsection
