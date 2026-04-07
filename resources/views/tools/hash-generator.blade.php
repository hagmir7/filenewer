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
                @php
                $hashTabs = [
                ['generate', '#', 'Generate Hash'],
                ['compare', '⚖', 'Compare Hashes'],
                ['checksum', '📄', 'File Checksum'],
                ];
                @endphp
                @foreach($hashTabs as [$tval,$ticon,$tlabel])
                <button type="button"
                    class="tab-btn {{ $tval === 'generate' ? 'active' : '' }} flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    data-tab="{{ $tval }}">
                    <span class="{{ $tval === 'generate' ? 'font-black text-base' : '' }}">{{ $ticon }}</span>
                    <span>{{ $tlabel }}</span>
                </button>
                @endforeach
            </div>

            <div class="p-6 lg:p-8">

                {{-- ══ GENERATE TAB ══ --}}
                <div id="panel-generate" class="tab-panel">
                    <div class="grid lg:grid-cols-3 gap-6">

                        {{-- ── LEFT: Options ── --}}
                        <div class="space-y-4">

                            {{-- Input mode --}}
                            <div class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <button type="button" id="gen-mode-text"
                                    class="gen-mode-btn active flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-semibold transition-all">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="4 7 4 4 20 4 20 7" />
                                        <line x1="9" y1="20" x2="15" y2="20" />
                                        <line x1="12" y1="4" x2="12" y2="20" />
                                    </svg>
                                    Text
                                </button>
                                <button type="button" id="gen-mode-file"
                                    class="gen-mode-btn flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-semibold transition-all">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    File
                                </button>
                            </div>

                            {{-- Text input --}}
                            <div id="gen-text-panel" class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-semibold text-fn-text2">Input Text</label>
                                    <div class="flex gap-2">
                                        <button type="button" id="gen-paste"
                                            class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">Paste</button>
                                        <button type="button" id="gen-clear"
                                            class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">Clear</button>
                                    </div>
                                </div>
                                <textarea id="gen-text-input" rows="5" spellcheck="false"
                                    placeholder="Enter or paste text to hash…"
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                                <div class="flex items-center justify-between text-fn-text3 text-sm">
                                    <span id="gen-char-count">0 characters</span>
                                    <span id="gen-byte-count">0 bytes</span>
                                </div>
                            </div>

                            {{-- File input --}}
                            <div id="gen-file-panel" class="hidden space-y-2">
                                <div id="gen-drop-zone"
                                    class="drop-zone border-2 border-dashed border-fn-text/15 rounded-xl p-6 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                    <div class="text-3xl mb-2 font-black text-fn-text3/30">#</div>
                                    <p class="text-sm font-bold mb-1">Drop any file</p>
                                    <p class="text-fn-text3 text-sm mb-3">Compute hashes for any file type · Max 200MB
                                    </p>
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-fn-blue text-white text-sm font-semibold rounded-lg pointer-events-none">
                                        Choose File</div>
                                    <input type="file" id="gen-file-input"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                                <div id="gen-file-preview"
                                    class="hidden p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-base shrink-0">
                                        #</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-sm truncate" id="gen-file-name">file.pdf</p>
                                        <p class="text-fn-text3 text-sm mt-0.5" id="gen-file-meta">—</p>
                                    </div>
                                    <button type="button" id="gen-remove-file"
                                        class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Algorithms --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-fn-text2">Algorithms</label>
                                    <div class="flex gap-2">
                                        <button type="button" id="algo-select-all"
                                            class="text-sm text-fn-blue-l hover:underline font-semibold">All</button>
                                        <button type="button" id="algo-select-none"
                                            class="text-sm text-fn-text3 hover:underline font-semibold">None</button>
                                        <button type="button" id="algo-select-secure"
                                            class="text-sm text-fn-green hover:underline font-semibold">Secure
                                            only</button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-y-0.5">
                                    @php
                                    $hashAlgos = [
                                    ['md5', 'MD5', 128, false, false],
                                    ['sha1', 'SHA-1', 160, false, false],
                                    ['sha224', 'SHA-224', 224, true, false],
                                    ['sha256', 'SHA-256', 256, true, true],
                                    ['sha384', 'SHA-384', 384, true, false],
                                    ['sha512', 'SHA-512', 512, true, true],
                                    ['sha3_224', 'SHA3-224', 224, true, false],
                                    ['sha3_256', 'SHA3-256', 256, true, true],
                                    ['sha3_384', 'SHA3-384', 384, true, false],
                                    ['sha3_512', 'SHA3-512', 512, true, false],
                                    ['blake2b', 'BLAKE2b', 512, true, true],
                                    ['blake2s', 'BLAKE2s', 256, true, false],
                                    ['shake_128', 'SHAKE-128', 128, true, false],
                                    ['shake_256', 'SHAKE-256', 256, true, false],
                                    ];
                                    @endphp
                                    @foreach($hashAlgos as [$hval,$hlabel,$hbits,$hsecure,$hdefault])
                                    <label
                                        class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-fn-surface transition-colors cursor-pointer">
                                        <input type="checkbox" name="gen-algo" value="{{ $hval }}"
                                            data-secure="{{ $hsecure ? 'true' : 'false' }}" {{ $hdefault ? 'checked'
                                            : '' }} class="w-3.5 h-3.5 accent-fn-blue rounded" />
                                        <span class="text-sm font-semibold text-fn-text2 flex-1">{{ $hlabel }}</span>
                                        <span class="text-fn-text3 text-sm font-mono">{{ $hbits }}b</span>
                                        @if(!$hsecure)
                                        <span class="text-fn-red text-sm font-bold">!</span>
                                        @endif
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- HMAC + Output format --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                                <div>
                                    <label for="gen-hmac" class="text-sm font-semibold text-fn-text2 block mb-1.5">
                                        HMAC Key <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="gen-hmac" placeholder="Secret key for HMAC"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-fn-text2 block mb-1.5">Output
                                        Format</label>
                                    <div class="flex gap-1.5">
                                        @php $outFmts =
                                        [['hex','hex'],['base64','base64'],['base64url','base64url'],['int','int']];
                                        @endphp
                                        @foreach($outFmts as [$fval,$flabel])
                                        <button type="button"
                                            class="out-fmt-btn {{ $fval === 'hex' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-sm font-mono font-semibold transition-all"
                                            data-fmt="{{ $fval }}">{{ $flabel }}</button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="gen-btn"
                                class="w-full py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all hover:bg-fn-blue-l hover:-translate-y-0.5 flex items-center justify-center gap-2 disabled:opacity-40 disabled:cursor-not-allowed"
                                disabled>
                                <span class="font-black text-base">#</span>
                                Compute Hashes
                            </button>

                        </div>{{-- /left --}}

                        {{-- ── RIGHT: Results ── --}}
                        <div class="lg:col-span-2 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2" id="gen-result-label">Hash Results</p>
                                <div class="flex gap-2">
                                    <span id="gen-meta" class="hidden text-sm text-fn-text3 self-center"></span>
                                    <button type="button" id="gen-copy-all"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="gen-copy-label">Copy all</span>
                                    </button>
                                </div>
                            </div>

                            <div id="gen-results" class="space-y-2">
                                <div id="gen-empty"
                                    class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-fn-text/8 rounded-xl text-fn-text3 gap-2">
                                    <span class="text-4xl font-black opacity-20">#</span>
                                    <span class="text-sm">Hash results will appear here</span>
                                    <span class="text-sm">Enter text or upload a file, then click Compute</span>
                                </div>
                            </div>

                            <div id="gen-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
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

                {{-- ══ COMPARE TAB ══ --}}
                <div id="panel-compare" class="tab-panel hidden">
                    <div class="max-w-2xl space-y-4">

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-fn-text2 block">Hash 1</label>
                                <textarea id="cmp-hash1" rows="4" spellcheck="false" placeholder="Paste first hash…"
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-fn-text2 block">Hash 2</label>
                                <textarea id="cmp-hash2" rows="4" spellcheck="false" placeholder="Paste second hash…"
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                            </div>
                        </div>

                        <button type="button" id="cmp-btn" disabled
                            class="w-full py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Compare Hashes
                        </button>

                        {{-- Result --}}
                        <div id="cmp-result" class="hidden p-5 rounded-2xl border">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-3xl" id="cmp-icon">✅</span>
                                <div>
                                    <p class="font-bold text-base" id="cmp-title">Hashes Match</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="cmp-message"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2" id="cmp-stats"></div>
                        </div>

                        {{-- Live diff (character-by-character) --}}
                        <div id="cmp-diff" class="hidden">
                            <p class="text-sm font-semibold text-fn-text2 mb-2">Diff View</p>
                            <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl font-mono text-sm leading-relaxed break-all"
                                id="cmp-diff-view"></div>
                        </div>

                        <div id="cmp-error"
                            class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <span id="cmp-error-text"></span>
                        </div>
                    </div>
                </div>{{-- /panel-compare --}}

                {{-- ══ CHECKSUM TAB ══ --}}
                <div id="panel-checksum" class="tab-panel hidden">
                    <div class="max-w-2xl space-y-4">

                        {{-- Drop zone --}}
                        <div id="chk-drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="text-4xl mb-3">📄</div>
                            <h2 class="text-base font-bold mb-1">Drop a file to verify its checksum</h2>
                            <p class="text-fn-text3 text-sm mb-4">Any file type · Max 200MB</p>
                            <div
                                class="inline-flex items-center gap-2 px-4 py-2 bg-fn-blue text-white text-sm font-semibold rounded-lg pointer-events-none">
                                Choose File</div>
                            <input type="file" id="chk-file-input"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="chk-file-preview"
                            class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                                📄</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="chk-file-name">file.pdf</p>
                                <p class="text-fn-text3 text-sm mt-0.5" id="chk-file-meta">—</p>
                            </div>
                            <button type="button" id="chk-remove"
                                class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        {{-- Algorithm selector --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-sm font-semibold text-fn-text2 block mb-2">Algorithm</label>
                            <div class="flex flex-wrap gap-2">
                                @php $chkAlgos = ['sha256','sha512','md5','sha1','sha3_256','blake2b']; @endphp
                                @foreach($chkAlgos as $ca)
                                <button type="button"
                                    class="chk-algo-btn {{ $ca === 'sha256' ? 'active' : '' }} px-3 py-1.5 rounded-lg border text-sm font-mono font-semibold transition-all"
                                    data-algo="{{ $ca }}">{{ strtoupper(str_replace('_','-',$ca)) }}</button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Expected checksum (optional verify) --}}
                        <div>
                            <label for="chk-expected" class="text-sm font-semibold text-fn-text2 block mb-1.5">
                                Expected Checksum <span class="font-normal text-fn-text3 ml-1">(optional — paste to
                                    verify)</span>
                            </label>
                            <input type="text" id="chk-expected" placeholder="Paste expected hash to verify against…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40" />
                        </div>

                        <button type="button" id="chk-btn" disabled
                            class="w-full py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Compute Checksum
                        </button>

                        {{-- Result --}}
                        <div id="chk-result" class="hidden space-y-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-semibold text-fn-text2" id="chk-algo-label">SHA-256</p>
                                    <button type="button" id="chk-copy-btn"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="chk-copy-label">Copy</span>
                                    </button>
                                </div>
                                <p class="font-mono text-sm text-fn-text2 break-all" id="chk-hash-display">—</p>
                                <div class="flex gap-4 mt-2 text-sm text-fn-text3">
                                    <span id="chk-size-label">—</span>
                                </div>
                            </div>
                            {{-- Verify result --}}
                            <div id="chk-verify-result" class="hidden p-4 rounded-2xl border flex items-center gap-3">
                                <span class="text-2xl" id="chk-verify-icon">✅</span>
                                <div>
                                    <p class="font-bold text-sm" id="chk-verify-title">Checksum Verified</p>
                                    <p class="text-sm text-fn-text3 mt-0.5" id="chk-verify-sub"></p>
                                </div>
                            </div>
                        </div>

                        <div id="chk-error"
                            class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <span id="chk-error-text"></span>
                        </div>

                    </div>
                </div>{{-- /panel-checksum --}}

            </div>{{-- /card body --}}
        </div>{{-- /card --}}
    </div>
</section>


{{-- ══ ALGORITHM REFERENCE ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Algorithm Reference</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-fn-text/8">
                        <th class="text-left px-4 py-3 text-sm font-semibold text-fn-text3">Algorithm</th>
                        <th class="text-left px-4 py-3 text-sm font-semibold text-fn-text3">Family</th>
                        <th class="text-left px-4 py-3 text-sm font-semibold text-fn-text3">Bits</th>
                        <th class="text-left px-4 py-3 text-sm font-semibold text-fn-text3">Secure</th>
                        <th class="text-left px-4 py-3 text-sm font-semibold text-fn-text3">Use case</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-fn-text/5">
                    @php
                    $algoTable = [
                    ['MD5', 'MD', 128, false, 'Checksums only — not cryptographically secure'],
                    ['SHA-1', 'SHA-1', 160, false, 'Legacy — still used in Git, not for security'],
                    ['SHA-224', 'SHA-2', 224, true, 'Short hash when SHA-256 is too long'],
                    ['SHA-256', 'SHA-2', 256, true, 'Standard — most common, TLS, certificates'],
                    ['SHA-384', 'SHA-2', 384, true, 'High security SHA-2 variant'],
                    ['SHA-512', 'SHA-2', 512, true, 'Maximum SHA-2 security'],
                    ['SHA3-224', 'SHA-3', 224, true, 'Modern short hash (Keccak-based)'],
                    ['SHA3-256', 'SHA-3', 256, true, 'Modern standard, immune to length extension'],
                    ['SHA3-384', 'SHA-3', 384, true, 'Modern high security'],
                    ['SHA3-512', 'SHA-3', 512, true, 'Modern maximum security'],
                    ['BLAKE2b', 'BLAKE2', 512, true, 'Fastest secure hash — faster than MD5'],
                    ['BLAKE2s', 'BLAKE2', 256, true, 'Fast + compact, ideal for embedded/32-bit'],
                    ['SHAKE-128', 'SHA-3', 128, true, 'Variable-length output (XOF)'],
                    ['SHAKE-256', 'SHA-3', 256, true, 'Variable-length, stronger XOF'],
                    ];
                    @endphp
                    @foreach($algoTable as [$name,$family,$bits,$secure,$use])
                    <tr class="hover:bg-fn-surface2 transition-colors">
                        <td class="px-4 py-2.5 font-mono font-bold text-sm text-fn-text2">{{ $name }}</td>
                        <td class="px-4 py-2.5 text-sm text-fn-text3">{{ $family }}</td>
                        <td class="px-4 py-2.5 text-sm font-mono text-fn-text3">{{ $bits }}</td>
                        <td class="px-4 py-2.5">
                            @if($secure)
                            <span class="text-sm font-bold text-fn-green">✓</span>
                            @else
                            <span class="text-sm font-bold text-fn-red">✗ Legacy</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-sm text-fn-text3">{{ $use }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

    .gen-mode-btn {
        color: var(--fn-text3);
    }

    .gen-mode-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0/12%);
    }

    .out-fmt-btn,
    .chk-algo-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .out-fmt-btn.active,
    .chk-algo-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264/40%);
        background: oklch(49% 0.24 264/8%);
    }

    .out-fmt-btn:not(.active):hover,
    .chk-algo-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264/25%);
        color: var(--fn-text);
    }

    .hash-result-row {
        padding: 12px 16px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
        border-radius: 12px;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }

    .hash-result-row:hover {
        border-color: oklch(49% 0.24 264/30%);
    }

    .hash-result-row.copied {
        border-color: oklch(67% 0.18 162/40%);
        background: oklch(67% 0.18 162/6%);
    }

    .hash-result-row .hr-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }

    .hash-result-row .hr-algo {
        font-size: 11px;
        font-weight: 700;
        color: var(--fn-text3);
    }

    .hash-result-row .hr-bits {
        font-size: 10px;
        color: var(--fn-text3);
        font-family: monospace;
    }

    .hash-result-row .hr-secure {
        font-size: 10px;
        font-weight: 700;
    }

    .hash-result-row .hr-copy {
        font-size: 10px;
        font-weight: 700;
        color: var(--fn-blue-l);
        margin-left: auto;
        opacity: 0;
        transition: opacity .15s;
    }

    .hash-result-row:hover .hr-copy {
        opacity: 1;
    }

    .hash-result-row .hr-value {
        font-family: monospace;
        font-size: 12px;
        color: var(--fn-text);
        word-break: break-all;
    }

    .diff-char {
        font-family: monospace;
        font-size: 11px;
    }

    .diff-match {
        color: var(--fn-text2);
    }

    .diff-mismatch {
        background: oklch(62% 0.22 25/20%);
        color: oklch(62% 0.22 25);
        border-radius: 2px;
    }
</style>

@push('footer')
{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const API = 'https://api.filenewer.com/api/tools';
  let genMode    = 'text';
  let genFile    = null;
  let chkFile    = null;
  let activeAlgo = 'sha256'; // checksum tab
  let activeFmt  = 'hex';
  let chkHash    = '';

  // ── Tab switching ──
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
      document.getElementById('panel-' + btn.dataset.tab).classList.remove('hidden');
    });
  });

  // ── Generate: mode toggle ──
  document.getElementById('gen-mode-text').addEventListener('click', () => switchGenMode('text'));
  document.getElementById('gen-mode-file').addEventListener('click', () => switchGenMode('file'));

  function switchGenMode(mode) {
    genMode = mode;
    document.getElementById('gen-mode-text').classList.toggle('active', mode === 'text');
    document.getElementById('gen-mode-file').classList.toggle('active', mode === 'file');
    document.getElementById('gen-text-panel').classList.toggle('hidden', mode !== 'text');
    document.getElementById('gen-file-panel').classList.toggle('hidden', mode !== 'file');
    refreshGenBtn();
  }

  // ── Generate: text input ──
  const genTA = document.getElementById('gen-text-input');
  genTA.addEventListener('input', () => {
    const val = genTA.value;
    document.getElementById('gen-char-count').textContent = val.length.toLocaleString() + ' characters';
    document.getElementById('gen-byte-count').textContent = new Blob([val]).size.toLocaleString() + ' bytes';
    refreshGenBtn();
  });

  document.getElementById('gen-paste').addEventListener('click', async () => {
    try { genTA.value = await navigator.clipboard.readText(); genTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('gen-clear').addEventListener('click', () => {
    genTA.value = '';
    genTA.dispatchEvent(new Event('input'));
    document.getElementById('gen-results').innerHTML = genEmptyHTML();
    hideEl('gen-error'); hideEl('gen-meta'); hideEl('gen-copy-all');
  });

  // ── Generate: file drop ──
  setupDrop('gen-drop-zone', 'gen-file-input', 'gen-file-preview', 'gen-file-name', 'gen-file-meta', 'gen-remove-file',
    f => { genFile = f; refreshGenBtn(); },
    () => { genFile = null; refreshGenBtn(); }
  );

  // ── Algorithm selectors ──
  document.getElementById('algo-select-all').addEventListener('click', () => {
    document.querySelectorAll('input[name="gen-algo"]').forEach(cb => cb.checked = true);
  });
  document.getElementById('algo-select-none').addEventListener('click', () => {
    document.querySelectorAll('input[name="gen-algo"]').forEach(cb => cb.checked = false);
    refreshGenBtn();
  });
  document.getElementById('algo-select-secure').addEventListener('click', () => {
    document.querySelectorAll('input[name="gen-algo"]').forEach(cb => {
      cb.checked = cb.dataset.secure === 'true';
    });
  });
  document.querySelectorAll('input[name="gen-algo"]').forEach(cb => cb.addEventListener('change', refreshGenBtn));

  function refreshGenBtn() {
    const hasInput = genMode === 'text' ? !!genTA.value.trim() : !!genFile;
    const hasAlgo  = [...document.querySelectorAll('input[name="gen-algo"]:checked')].length > 0;
    document.getElementById('gen-btn').disabled = !(hasInput && hasAlgo);
  }

  // ── Output format ──
  document.querySelectorAll('.out-fmt-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.out-fmt-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeFmt = btn.dataset.fmt;
    });
  });

  // ── Generate: compute ──
  document.getElementById('gen-btn').addEventListener('click', doGenerate);

  async function doGenerate() {
    hideEl('gen-error');
    const btn = document.getElementById('gen-btn');
    btn.disabled = true;
    btn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Computing…`;

    const selectedAlgos = [...document.querySelectorAll('input[name="gen-algo"]:checked')].map(cb => cb.value);
    const hmacKey       = document.getElementById('gen-hmac').value.trim();

    try {
      let res;
      if (genMode === 'text') {
        res = await fetch(`${API}/hash-generate`, {
          method: 'POST', headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            text:          genTA.value,
            algorithms:    selectedAlgos,
            output_format: activeFmt,
            hmac_key:      hmacKey || null,
          }),
        });
      } else {
        const fd = new FormData();
        fd.append('file',          genFile);
        fd.append('algorithms',    selectedAlgos.join(','));
        fd.append('output_format', activeFmt);
        if (hmacKey) fd.append('hmac_key', hmacKey);
        res = await fetch(`${API}/hash-generate`, { method: 'POST', body: fd });
      }
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Hashing failed.');
      renderHashResults(data);
    } catch(err) {
      document.getElementById('gen-error-text').textContent = err.message;
      showEl('gen-error', 'flex');
    } finally {
      btn.disabled = false;
      btn.innerHTML = `<span class="font-black text-base">#</span> Compute Hashes`;
      refreshGenBtn();
    }
  }

  function genEmptyHTML() {
    return `<div id="gen-empty" class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-fn-text/8 rounded-xl text-fn-text3 gap-2">
      <span class="text-4xl font-black opacity-20">#</span>
      <span class="text-sm">Hash results will appear here</span>
      <span class="text-sm">Enter text or upload a file, then click Compute</span>
    </div>`;
  }

  function renderHashResults(data) {
    const hashes  = data.hashes ?? {};
    const container = document.getElementById('gen-results');
    container.innerHTML = '';

    const allLines = [];

    Object.entries(hashes).forEach(([algo, info]) => {
      if (info.error) return;
      const hash     = info.hash ?? '';
      const secure   = info.secure ?? true;
      const bits     = info.bits ?? 0;
      allLines.push(`${algo.toUpperCase()}: ${hash}`);

      const div = document.createElement('div');
      div.className = 'hash-result-row';
      div.innerHTML = `
        <div class="hr-header">
          <span class="hr-algo">${escHtml(algo.toUpperCase())}</span>
          <span class="hr-bits">${bits} bits</span>
          <span class="hr-secure ${secure ? 'text-fn-green' : 'text-fn-red'}">${secure ? '✓ Secure' : '✗ Legacy'}</span>
          <span class="hr-copy">Copy</span>
        </div>
        <div class="hr-value">${escHtml(hash)}</div>`;
      div.addEventListener('click', () => {
        navigator.clipboard.writeText(hash).catch(() => {});
        div.classList.add('copied');
        div.querySelector('.hr-copy').textContent = 'Copied!';
        setTimeout(() => { div.classList.remove('copied'); div.querySelector('.hr-copy').textContent = 'Copy'; }, 1500);
      });
      container.appendChild(div);
    });

    // Meta
    const meta = [
      data.input_type && `${data.input_type}`,
      data.filename && data.filename,
      data.input_size_kb && `${data.input_size_kb} KB`,
      data.is_hmac && 'HMAC',
      data.output_format && `${data.output_format}`,
    ].filter(Boolean).join(' · ');
    document.getElementById('gen-meta').textContent = meta;
    showEl('gen-meta');

    showEl('gen-copy-all');
    document.getElementById('gen-copy-all').onclick = async () => {
      await navigator.clipboard.writeText(allLines.join('\n')).catch(() => {});
      document.getElementById('gen-copy-label').textContent = 'Copied!';
      setTimeout(() => { document.getElementById('gen-copy-label').textContent = 'Copy all'; }, 2000);
    };
  }

  // ══ COMPARE ══
  const cmpHash1 = document.getElementById('cmp-hash1');
  const cmpHash2 = document.getElementById('cmp-hash2');
  const cmpBtn   = document.getElementById('cmp-btn');

  [cmpHash1, cmpHash2].forEach(el => el.addEventListener('input', () => {
    cmpBtn.disabled = !(cmpHash1.value.trim() && cmpHash2.value.trim());
  }));

  cmpBtn.addEventListener('click', async () => {
    hideEl('cmp-error'); hideEl('cmp-result'); hideEl('cmp-diff');
    const h1 = cmpHash1.value.trim();
    const h2 = cmpHash2.value.trim();
    cmpBtn.disabled = true;
    cmpBtn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Comparing…`;

    try {
      const res  = await fetch(`${API}/hash-compare`, {
        method: 'POST', headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ hash1: h1, hash2: h2 }),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Comparison failed.');

      const match  = data.match ?? false;
      const result = document.getElementById('cmp-result');
      result.className = `p-5 rounded-2xl border ${match
        ? 'bg-fn-green/6 border-fn-green/20'
        : 'bg-fn-red/6 border-fn-red/20'}`;
      document.getElementById('cmp-icon').textContent    = match ? '✅' : '❌';
      document.getElementById('cmp-title').textContent   = match ? 'Hashes Match' : 'Hashes Do Not Match';
      document.getElementById('cmp-message').textContent = data.message ?? '';

      // Stats chips
      const stats = document.getElementById('cmp-stats');
      stats.innerHTML = '';
      [
        ['Hash 1 length', (data.hash1_length ?? h1.length) + ' chars'],
        ['Hash 2 length', (data.hash2_length ?? h2.length) + ' chars'],
      ].forEach(([label, val]) => {
        const div = document.createElement('div');
        div.className = 'px-3 py-2 bg-fn-surface2 border border-fn-text/8 rounded-lg text-center';
        div.innerHTML = `<p class="text-sm text-fn-text3">${label}</p><p class="text-sm font-bold text-fn-text2 mt-0.5">${val}</p>`;
        stats.appendChild(div);
      });

      showEl('cmp-result');

      // Diff view (if lengths match)
      if (h1.length === h2.length && h1.length > 0) {
        let diffHtml = '';
        for (let i = 0; i < h1.length; i++) {
          const match = h1[i] === h2[i];
          diffHtml += `<span class="diff-char ${match ? 'diff-match' : 'diff-mismatch'}">${escHtml(h2[i])}</span>`;
        }
        document.getElementById('cmp-diff-view').innerHTML = diffHtml;
        showEl('cmp-diff');
      }

    } catch(err) {
      document.getElementById('cmp-error-text').textContent = err.message;
      showEl('cmp-error', 'flex');
    } finally {
      cmpBtn.disabled = false;
      cmpBtn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Compare Hashes`;
    }
  });

  // ══ CHECKSUM ══
  setupDrop('chk-drop-zone','chk-file-input','chk-file-preview','chk-file-name','chk-file-meta','chk-remove',
    f => { chkFile = f; document.getElementById('chk-btn').disabled = false; },
    () => { chkFile = null; document.getElementById('chk-btn').disabled = true; hideEl('chk-result'); }
  );

  document.querySelectorAll('.chk-algo-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.chk-algo-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeAlgo = btn.dataset.algo;
    });
  });

  document.getElementById('chk-btn').addEventListener('click', async () => {
    hideEl('chk-error'); hideEl('chk-result');
    const btn = document.getElementById('chk-btn');
    btn.disabled = true;
    btn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Computing…`;

    const fd = new FormData();
    fd.append('file',      chkFile);
    fd.append('algorithm', activeAlgo);

    try {
      const res  = await fetch(`${API}/file-checksum`, { method: 'POST', body: fd });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Checksum failed.');

      chkHash = data.checksum ?? '';
      document.getElementById('chk-algo-label').textContent   = (data.algorithm ?? activeAlgo).toUpperCase();
      document.getElementById('chk-hash-display').textContent = chkHash;
      document.getElementById('chk-size-label').textContent   =
        (data.filename ?? chkFile.name) + ' · ' + (data.size_kb ?? 0) + ' KB';

      // Copy button
      document.getElementById('chk-copy-btn').onclick = async () => {
        await navigator.clipboard.writeText(chkHash).catch(() => {});
        document.getElementById('chk-copy-label').textContent = 'Copied!';
        setTimeout(() => { document.getElementById('chk-copy-label').textContent = 'Copy'; }, 2000);
      };

      // Verify against expected
      const expected = document.getElementById('chk-expected').value.trim();
      const verifyEl = document.getElementById('chk-verify-result');
      if (expected) {
        const matches = expected.toLowerCase() === chkHash.toLowerCase();
        verifyEl.className = `p-4 rounded-2xl border flex items-center gap-3 ${matches
          ? 'bg-fn-green/6 border-fn-green/20'
          : 'bg-fn-red/6 border-fn-red/20'}`;
        document.getElementById('chk-verify-icon').textContent  = matches ? '✅' : '❌';
        document.getElementById('chk-verify-title').textContent = matches ? 'Checksum Verified ✓' : 'Checksum Mismatch!';
        document.getElementById('chk-verify-sub').textContent   = matches
          ? 'The file matches the expected checksum.'
          : 'The computed checksum does not match. File may be corrupted or tampered.';
        showEl('chk-verify-result', 'flex');
      } else {
        hideEl('chk-verify-result');
      }

      showEl('chk-result');
    } catch(err) {
      document.getElementById('chk-error-text').textContent = err.message;
      showEl('chk-error', 'flex');
    } finally {
      btn.disabled = false;
      btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> Compute Checksum`;
      if (chkFile) btn.disabled = false;
    }
  });

  // ── Generic drop zone ──
  function setupDrop(dzId, inputId, previewId, nameId, metaId, removeId, onFile, onRemove) {
    const dz      = document.getElementById(dzId);
    const input   = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    ['dragenter','dragover'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); dz.classList.add('drag-over'); }));
    ['dragleave','dragend','drop'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); dz.classList.remove('drag-over'); }));
    dz.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handle(e.dataTransfer.files[0]); });
    input.addEventListener('change', e => { if (e.target.files[0]) handle(e.target.files[0]); });
    document.getElementById(removeId).addEventListener('click', () => {
      input.value = '';
      preview.classList.add('hidden'); preview.classList.remove('flex');
      dz.classList.remove('has-file');
      onRemove();
    });
    function handle(file) {
      if (file.size > 50*1024*1024) { alert('File exceeds 50MB limit.'); return; }
      onFile(file);
      document.getElementById(nameId).textContent = file.name;
      document.getElementById(metaId).textContent = formatBytes(file.size) + ' · ' + (file.type || file.name.split('.').pop().toUpperCase());
      preview.classList.remove('hidden'); preview.classList.add('flex');
      dz.classList.add('has-file');
    }
  }

  // ── Helpers ──
  function showEl(id, display='block') {
    const el = document.getElementById(id); if(!el) return;
    el.classList.remove('hidden');
    if (display==='flex') el.classList.add('flex');
  }
  function hideEl(id) {
    const el = document.getElementById(id); if(!el) return;
    el.classList.add('hidden'); el.classList.remove('flex');
  }
  function formatBytes(b) {
    if (b<1024) return b+' B'; if (b<1048576) return (b/1024).toFixed(1)+' KB'; return (b/1048576).toFixed(1)+' MB';
  }
  function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

}); // end DOMContentLoaded
</script>

@endpush

@endsection
