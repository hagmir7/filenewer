@extends('layouts.base')


@push('scripts')
<x-ld-json :tool="$tool" />
@endpush

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ MAIN CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- ── Mode tabs ── --}}
            <div class="flex items-center gap-1 p-2 border-b border-fn-text/7 bg-fn-surface2">
                @php
                $fsTabs = [
                ['encrypt', '🔒', 'Encrypt File'],
                ['decrypt', '🔓', 'Decrypt File'],
                ['hash', '#', 'Hash File / Text'],
                ];
                @endphp
                @foreach($fsTabs as [$tval,$ticon,$tlabel])
                <button type="button"
                    class="tab-btn {{ $tval === 'encrypt' ? 'active' : '' }} flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    data-tab="{{ $tval }}">
                    <span class="{{ $tval === 'hash' ? 'font-black text-base' : '' }}">{{ $ticon }}</span>
                    <span>{{ $tlabel }}</span>
                </button>
                @endforeach
            </div>

            <div class="p-8 lg:p-10">

                {{-- ══ ENCRYPT TAB ══ --}}
                <div id="panel-encrypt" class="tab-panel">
                    <div class="grid lg:grid-cols-2 gap-8">

                        {{-- Left: Upload + Options --}}
                        <div class="space-y-4">

                            <div id="enc-drop-zone"
                                class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                <div class="text-4xl mb-3">📄</div>
                                <h2 class="text-base font-bold mb-1">Drop any file here</h2>
                                <p class="text-fn-text3 text-sm mb-4">PDF, images, documents — any format supported</p>
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
                                <p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>
                                <input type="file" id="enc-file-input"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </div>

                            <div id="enc-file-preview"
                                class="hidden p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-xl shrink-0"
                                    id="enc-file-icon">📄</div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate" id="enc-file-name">file.pdf</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="enc-file-meta">—</p>
                                </div>
                                <button type="button" id="enc-remove"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Algorithm --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Algorithm</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @php
                                    $algorithms = [
                                    ['AES-256-GCM', 'Recommended', 'Authenticated encryption'],
                                    ['AES-256-CBC', 'Compatible', 'Wide compatibility'],
                                    ['ChaCha20', 'Fast', 'Best for large files'],
                                    ];
                                    @endphp
                                    @foreach($algorithms as [$aval,$abadge,$adesc])
                                    <button type="button"
                                        class="algo-btn {{ $aval === 'AES-256-GCM' ? 'active' : '' }} flex flex-col items-start gap-0.5 p-3 rounded-xl border text-left transition-all"
                                        data-algo="{{ $aval }}">
                                        <span class="text-sm font-bold font-mono">{{ $aval }}</span>
                                        <span class="algo-badge text-sm font-semibold px-1.5 py-0.5 rounded-md">{{
                                            $abadge }}</span>
                                        <span class="text-fn-text3 text-sm leading-tight mt-0.5">{{ $adesc }}</span>
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-1.5">
                                    Encryption Password <span class="text-fn-red">*</span>
                                </label>
                                <div class="relative mb-2">
                                    <input type="password" id="enc-password" placeholder="Enter a strong password"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                    <button type="button"
                                        class="toggle-pw absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text"
                                        data-target="enc-password">
                                        <svg class="eye-show w-4 h-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg class="eye-hide hidden w-4 h-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </button>
                                </div>
                                {{-- Strength meter --}}
                                <div id="enc-strength" class="hidden">
                                    <div class="flex gap-1 mb-1">
                                        @for($i=0;$i<4;$i++) <div
                                            class="strength-bar h-1 flex-1 rounded-full bg-fn-text/10 transition-all duration-300">
                                    </div>
                                    @endfor
                                </div>
                                <p class="text-sm" id="enc-strength-label"></p>
                            </div>

                        </div>

                    </div>{{-- /left --}}

                    {{-- Right: Info + Action --}}
                    <div class="flex flex-col justify-between gap-4">

                        {{-- How it works --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                            <p class="text-sm font-semibold text-fn-text2">How it works</p>
                            @php
                            $encSteps = [
                            ['🔑','Password → PBKDF2 key derivation (100k rounds)'],
                            ['🎲','Random salt & IV generated per file'],
                            ['🔒','File encrypted with chosen algorithm'],
                            ['📦','Metadata header prepended to .enc file'],
                            ];
                            @endphp
                            @foreach($encSteps as [$icon,$text])
                            <div class="flex items-start gap-2.5">
                                <span class="text-base shrink-0">{{ $icon }}</span>
                                <span class="text-sm text-fn-text3 leading-relaxed">{{ $text }}</span>
                            </div>
                            @endforeach
                        </div>

                        {{-- Output info --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <p class="text-sm font-semibold text-fn-text2 mb-2">Output</p>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-xl shrink-0">
                                    🔒</div>
                                <div>
                                    <p class="text-sm font-semibold text-fn-text2" id="enc-output-preview">your_file.enc
                                    </p>
                                    <p class="text-fn-text3 text-sm">Encrypted binary file · add .enc extension</p>
                                </div>
                            </div>
                        </div>

                        <div id="enc-error"
                            class="hidden flex items-center gap-2 px-3 py-2.5 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-red">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <span id="enc-error-text"></span>
                        </div>

                        <button type="button" id="enc-btn" disabled
                            class="w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            Encrypt File
                        </button>

                        {{-- Download card --}}
                        <div id="enc-result" class="hidden p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-xl shrink-0">
                                    ✅</div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate" id="enc-out-name">file.enc</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="enc-out-meta">—</p>
                                </div>
                                <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                            </div>
                            <a id="enc-download" href="#" download="file.enc"
                                class="flex items-center justify-center gap-2 w-full py-2.5 text-white text-sm font-bold rounded-xl transition-all hover:-translate-y-0.5"
                                style="background: oklch(67% 0.18 162);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download Encrypted File
                            </a>
                        </div>
                    </div>

                </div>
            </div>{{-- /panel-encrypt --}}

            {{-- ══ DECRYPT TAB ══ --}}
            <div id="panel-decrypt" class="tab-panel hidden">
                <div class="grid lg:grid-cols-2 gap-8">

                    <div class="space-y-4">

                        <div id="dec-drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="text-4xl mb-3">🔒</div>
                            <h2 class="text-base font-bold mb-1">Drop your .enc file here</h2>
                            <p class="text-fn-text3 text-sm mb-4">Files encrypted with Filenewer's encrypt tool</p>
                            <div
                                class="inline-flex items-center gap-2 px-4 py-2 bg-fn-blue text-white text-sm font-semibold rounded-lg pointer-events-none">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose .enc File
                            </div>
                            <input type="file" id="dec-file-input" accept=".enc"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="dec-file-preview"
                            class="hidden p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-xl shrink-0">
                                🔒</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="dec-file-name">file.enc</p>
                                <p class="text-fn-text3 text-sm mt-0.5" id="dec-file-meta">—</p>
                            </div>
                            <button type="button" id="dec-remove"
                                class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-sm font-semibold text-fn-text2 block mb-1.5">
                                Decryption Password <span class="text-fn-red">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="dec-password"
                                    placeholder="Enter the password used to encrypt"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <button type="button"
                                    class="toggle-pw absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text"
                                    data-target="dec-password">
                                    <svg class="eye-show w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg class="eye-hide hidden w-4 h-4" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="dec-error"
                            class="hidden flex items-start gap-2 px-3 py-2.5 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-red">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <span id="dec-error-text"></span>
                        </div>

                        <button type="button" id="dec-btn" disabled
                            class="w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            Decrypt File
                        </button>

                        {{-- Result --}}
                        <div id="dec-result" class="hidden p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-xl shrink-0">
                                    🔓</div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate" id="dec-out-name">file.pdf</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="dec-out-meta">—</p>
                                </div>
                                <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                            </div>
                            <a id="dec-download" href="#" download="file.pdf"
                                class="flex items-center justify-center gap-2 w-full py-2.5 text-white text-sm font-bold rounded-xl transition-all hover:-translate-y-0.5"
                                style="background: oklch(67% 0.18 162);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download Decrypted File
                            </a>
                        </div>
                    </div>

                    {{-- Right: Info --}}
                    <div class="space-y-4">
                        <div class="p-5 bg-fn-amber/6 border border-fn-amber/20 rounded-xl">
                            <div class="flex items-start gap-3">
                                <span class="text-xl shrink-0">⚠️</span>
                                <div>
                                    <p class="text-sm font-bold text-fn-text mb-1">Important</p>
                                    <p class="text-sm text-fn-text3 leading-relaxed">You must use the exact same
                                        password that was used to encrypt the file. If the password is wrong or the file
                                        is corrupted, decryption will fail.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                            <p class="text-sm font-semibold text-fn-text2">Supported algorithms</p>
                            @foreach($algorithms as [$aval,$abadge,$adesc])
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-mono font-bold text-fn-blue-l w-28 shrink-0">{{ $aval
                                    }}</span>
                                <span class="text-sm text-fn-text3">{{ $adesc }}</span>
                            </div>
                            @endforeach
                            <p class="text-sm text-fn-text3 mt-2">Algorithm is auto-detected from the file header — no
                                need to specify.</p>
                        </div>
                    </div>

                </div>
            </div>{{-- /panel-decrypt --}}

            {{-- ══ HASH TAB ══ --}}
            <div id="panel-hash" class="tab-panel hidden">

                {{-- Input mode tabs --}}
                <div class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-5 w-fit">
                    <button type="button" id="hash-tab-file"
                        class="hash-tab-btn active flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold transition-all">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Hash File
                    </button>
                    <button type="button" id="hash-tab-text"
                        class="hash-tab-btn flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold transition-all">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="4 7 4 4 20 4 20 7" />
                            <line x1="9" y1="20" x2="15" y2="20" />
                            <line x1="12" y1="4" x2="12" y2="20" />
                        </svg>
                        Hash Text
                    </button>
                </div>

                <div class="grid lg:grid-cols-2 gap-6">

                    {{-- Left: Input --}}
                    <div class="space-y-4">

                        {{-- File input --}}
                        <div id="hash-file-panel">
                            <div id="hash-drop-zone"
                                class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-8 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                <div class="text-3xl mb-2">#</div>
                                <h2 class="text-base font-bold mb-1">Drop any file to hash</h2>
                                <p class="text-fn-text3 text-sm mb-3">Compute checksums for any file type</p>
                                <div
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-fn-blue text-white text-sm font-semibold rounded-lg pointer-events-none">
                                    Choose File</div>
                                <<p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>
                                    <input type="file" id="hash-file-input"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </div>
                            <div id="hash-file-preview"
                                class="hidden mt-3 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-xl shrink-0">
                                    #</div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate" id="hash-file-name">file.pdf</p>
                                    <p class="text-fn-text3 text-sm mt-0.5" id="hash-file-meta">—</p>
                                </div>
                                <button type="button" id="hash-remove"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all shrink-0">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Text input --}}
                        <div id="hash-text-panel" class="hidden space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Input Text</p>
                                <div class="flex gap-2">
                                    <button type="button" id="hash-text-paste"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">Paste</button>
                                    <button type="button" id="hash-text-clear"
                                        class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">Clear</button>
                                </div>
                            </div>
                            <textarea id="hash-text-input" rows="8" spellcheck="false"
                                placeholder="Enter or paste text to hash…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                        </div>

                        {{-- Algorithm selector --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-semibold text-fn-text2">Algorithms</label>
                                <div class="flex gap-2">
                                    <button type="button" id="hash-select-all"
                                        class="text-sm text-fn-blue-l hover:underline font-semibold">All</button>
                                    <button type="button" id="hash-select-none"
                                        class="text-sm text-fn-text3 hover:underline font-semibold">None</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1.5">
                                @php
                                $hashAlgos = [
                                ['md5', 'MD5', '32 chars', false],
                                ['sha1', 'SHA-1', '40 chars', false],
                                ['sha256', 'SHA-256', '64 chars', true],
                                ['sha512', 'SHA-512', '128 chars',true],
                                ['sha3_256', 'SHA3-256', '64 chars', true],
                                ['sha3_512', 'SHA3-512', '128 chars',false],
                                ['blake2b', 'BLAKE2b', '128 chars',true],
                                ];
                                @endphp
                                @foreach($hashAlgos as [$hval,$hlabel,$hlen,$hdefault])
                                <label
                                    class="flex items-center gap-2 p-2 rounded-lg hover:bg-fn-surface transition-colors cursor-pointer">
                                    <input type="checkbox" name="hash-algo" value="{{ $hval }}" {{ $hdefault ? 'checked'
                                        : '' }} class="w-3.5 h-3.5 accent-fn-blue rounded" />
                                    <span class="text-sm font-semibold text-fn-text2">{{ $hlabel }}</span>
                                    <span class="text-fn-text3 text-sm ml-auto font-mono">{{ $hlen }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="hash-error"
                            class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <span id="hash-error-text"></span>
                        </div>

                        <button type="button" id="hash-btn" disabled
                            class="w-full py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l flex items-center justify-center gap-2">
                            <span class="font-black text-base">#</span>
                            Compute Hashes
                        </button>
                    </div>

                    {{-- Right: Results --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-fn-text2">Hash Results</p>
                            <div class="flex gap-2">
                                <span id="hash-meta" class="hidden text-sm text-fn-text3"></span>
                                <button type="button" id="hash-copy-all"
                                    class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" />
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                    </svg>
                                    <span id="hash-copy-all-label">Copy all</span>
                                </button>
                            </div>
                        </div>

                        <div id="hash-results" class="space-y-2">
                            <div id="hash-empty"
                                class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-fn-text/8 rounded-xl text-fn-text3 gap-2">
                                <span class="text-3xl font-black opacity-30">#</span>
                                <span class="text-sm">Hash results will appear here</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>{{-- /panel-hash --}}

        </div>{{-- /card body --}}
    </div>{{-- /card --}}
    </div>
</section>


{{-- ══ ALGORITHM REFERENCE ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Hash Algorithms Reference</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php
            $algoRef = [
            ['MD5', '32 chars', false, 'md5', 'Checksums and legacy use only. Not cryptographically secure.'],
            ['SHA-1', '40 chars', false, 'sha1', 'Legacy — still used in Git and some older systems. Not secure for
            cryptography.'],
            ['SHA-256', '64 chars', true, 'sha256', 'The standard. Used in TLS, certificates, Bitcoin, and most modern
            systems.'],
            ['SHA-512', '128 chars', true, 'sha512', 'Stronger than SHA-256. Ideal when maximum collision resistance is
            required.'],
            ['SHA3-256','64 chars', true, 'sha3_256', 'Modern SHA-3 standard. Different internal design from SHA-2,
            immune to length extension.'],
            ['BLAKE2b', '128 chars', true, 'blake2b', 'Fastest secure hash. Faster than MD5 on modern hardware while
            being cryptographically secure.'],
            ];
            @endphp
            @foreach($algoRef as [$name,$len,$secure,$val,$desc])
            <div class="p-4 bg-fn-surface border border-fn-text/8 rounded-xl">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="font-bold text-sm">{{ $name }}</span>
                    @if($secure)
                    <span
                        class="text-sm px-2 py-0.5 bg-fn-green/10 border border-fn-green/25 text-fn-green rounded-md font-bold">✓
                        Secure</span>
                    @else
                    <span
                        class="text-sm px-2 py-0.5 bg-fn-red/10 border border-fn-red/20 text-fn-red rounded-md font-semibold">Legacy</span>
                    @endif
                </div>
                <p class="text-sm font-mono text-fn-blue-l mb-1.5">{{ $len }}</p>
                <p class="text-sm text-fn-text3 leading-relaxed">{{ $desc }}</p>
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

    .hash-tab-btn {
        color: var(--fn-text3);
    }

    .hash-tab-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0/12%);
    }

    .algo-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
        color: var(--fn-text2);
    }

    .algo-btn .algo-badge {
        background: oklch(var(--fn-text-l, 80%) 0 0/8%);
        color: var(--fn-text3);
    }

    .algo-btn.active {
        border-color: oklch(49% 0.24 264/45%);
        background: oklch(49% 0.24 264/7%);
    }

    .algo-btn.active .algo-badge {
        background: oklch(49% 0.24 264/12%);
        color: var(--fn-blue-l);
    }

    .algo-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264/25%);
    }

    .hash-row {
        padding: 10px 14px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
        border-radius: 10px;
        cursor: pointer;
        transition: border-color .15s;
    }

    .hash-row:hover {
        border-color: oklch(49% 0.24 264/30%);
    }

    .hash-row.copied {
        border-color: oklch(67% 0.18 162/40%);
        background: oklch(67% 0.18 162/6%);
    }

    .hash-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--fn-text3);
        margin-bottom: 3px;
    }

    .hash-value {
        font-family: monospace;
        font-size: 11px;
        color: var(--fn-text2);
        word-break: break-all;
    }

    .hash-copy {
        font-size: 10px;
        font-weight: 700;
        color: var(--fn-blue-l);
        float: right;
        opacity: 0;
        transition: opacity .15s;
    }

    .hash-row:hover .hash-copy {
        opacity: 1;
    }
</style>

@push('footer')
{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const API = 'https://api.filenewer.com/api/tools';

  // ── Tab switching ──
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
      document.getElementById('panel-' + btn.dataset.tab).classList.remove('hidden');
    });
  });

  // ── Password show/hide ──
  document.querySelectorAll('.toggle-pw').forEach(btn => {
    btn.addEventListener('click', () => {
      const input  = document.getElementById(btn.dataset.target);
      const isPass = input.type === 'password';
      input.type   = isPass ? 'text' : 'password';
      btn.querySelector('.eye-show').classList.toggle('hidden', isPass);
      btn.querySelector('.eye-hide').classList.toggle('hidden', !isPass);
    });
  });

  // ── Password strength (encrypt tab) ──
  const encPw       = document.getElementById('enc-password');
  const encStrength = document.getElementById('enc-strength');
  const encStrLabel = document.getElementById('enc-strength-label');
  const encBtn      = document.getElementById('enc-btn');

  function updateEncBtn() {
    encBtn.disabled = !(!!encFile && !!encPw.value.trim());
  }

  encPw.addEventListener('input', () => {
    updateEncBtn();
    const pw = encPw.value;
    if (!pw) { encStrength.classList.add('hidden'); return; }
    encStrength.classList.remove('hidden');
    let s = 0;
    if (pw.length >= 8)  s++;
    if (pw.length >= 12) s++;
    if (/[A-Z]/.test(pw) && /[0-9]/.test(pw)) s++;
    if (/[^A-Za-z0-9]/.test(pw)) s++;
    s = Math.max(1, Math.min(4, s));
    const colors = ['bg-fn-red','bg-fn-amber','bg-fn-amber','bg-fn-green'];
    const labels = ['Weak','Fair','Good','Strong'];
    document.querySelectorAll('.strength-bar').forEach((bar, i) => {
      bar.className = 'strength-bar h-1 flex-1 rounded-full transition-all duration-300 ' + (i < s ? colors[s-1] : 'bg-fn-text/10');
    });
    encStrLabel.textContent = labels[s-1];
    encStrLabel.className   = 'text-sm ' + ['text-fn-red','text-fn-amber','text-fn-amber','text-fn-green'][s-1];
  });


  // ══ ENCRYPT ══
  let encFile = null, encBlobUrl = null;

  setupDropZone('enc-drop-zone', 'enc-file-input', 'enc-file-preview', 'enc-file-name', 'enc-file-meta', 'enc-remove', f => {
    encFile = f;
    document.getElementById('enc-output-preview').textContent = f.name + '.enc';
    updateEncBtn();
  }, () => {
    encFile = null;
    document.getElementById('enc-output-preview').textContent = 'your_file.enc';
    updateEncBtn();
  });

  let activeAlgo = 'AES-256-GCM';
  document.querySelectorAll('.algo-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.algo-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeAlgo = btn.dataset.algo;
    });
  });

  encBtn.addEventListener('click', async () => {
    if (!encFile) return;
    hideEl('enc-error'); hideEl('enc-result');
    setLoading(encBtn, 'Encrypting…');
    const fd = new FormData();
    fd.append('file',      encFile);
    fd.append('password',  encPw.value);
    fd.append('algorithm', activeAlgo);
    try {
      const res = await fetch(`${API}/file-encrypt`, { method:'POST', body:fd });
      if (!res.ok) { const d=await res.json().catch(()=>({})); throw new Error(d.error||'Encryption failed.'); }
      const blob    = await res.blob();
      const outName = res.headers.get('Content-Disposition')?.match(/filename="?([^"]+)"?/)?.[1] || (encFile.name + '.enc');
      const origKb  = parseFloat(res.headers.get('X-Original-Size-KB')) || (encFile.size/1024);
      const encKb   = parseFloat(res.headers.get('X-Encrypted-Size-KB')) || (blob.size/1024);
      if (encBlobUrl) URL.revokeObjectURL(encBlobUrl);
      encBlobUrl = URL.createObjectURL(blob);
      const dl = document.getElementById('enc-download');
      dl.href = encBlobUrl; dl.download = outName;
      document.getElementById('enc-out-name').textContent = outName;
      document.getElementById('enc-out-meta').textContent =
        formatKb(origKb) + ' → ' + formatKb(encKb) + ' · ' + (res.headers.get('X-Algorithm') || activeAlgo);
      showEl('enc-result');
    } catch(err) {
      document.getElementById('enc-error-text').textContent = err.message;
      showEl('enc-error', 'flex');
    } finally { resetBtn(encBtn, '🔒 Encrypt File'); }
  });

  // ══ DECRYPT ══
  let decFile = null, decBlobUrl = null;

  document.getElementById('dec-password').addEventListener('input', updateDecBtn);
  function updateDecBtn() {
    document.getElementById('dec-btn').disabled = !(decFile && document.getElementById('dec-password').value.trim());
  }

  setupDropZone('dec-drop-zone','dec-file-input','dec-file-preview','dec-file-name','dec-file-meta','dec-remove', f => {
    decFile = f; updateDecBtn();
  }, () => { decFile = null; updateDecBtn(); });

  document.getElementById('dec-btn').addEventListener('click', async () => {
    if (!decFile) return;
    hideEl('dec-error'); hideEl('dec-result');
    setLoading(document.getElementById('dec-btn'), 'Decrypting…');
    const fd = new FormData();
    fd.append('file',     decFile);
    fd.append('password', document.getElementById('dec-password').value);
    try {
      const res = await fetch(`${API}/file-decrypt`, { method:'POST', body:fd });
      if (!res.ok) { const d=await res.json().catch(()=>({})); throw new Error(d.error||'Decryption failed. Check your password.'); }
      const blob    = await res.blob();
      const outName = res.headers.get('Content-Disposition')?.match(/filename="?([^"]+)"?/)?.[1]
        || decFile.name.replace(/\.enc$/i,'');
      const origKb  = parseFloat(res.headers.get('X-Original-Size-KB')) || (blob.size/1024);
      if (decBlobUrl) URL.revokeObjectURL(decBlobUrl);
      decBlobUrl = URL.createObjectURL(blob);
      const dl = document.getElementById('dec-download');
      dl.href = decBlobUrl; dl.download = outName;
      document.getElementById('dec-out-name').textContent = outName;
      document.getElementById('dec-out-meta').textContent =
        formatKb(origKb) + ' · ' + (res.headers.get('X-Algorithm') || 'Decrypted');
      showEl('dec-result');
    } catch(err) {
      document.getElementById('dec-error-text').textContent = err.message;
      showEl('dec-error', 'flex');
    } finally { resetBtn(document.getElementById('dec-btn'), '🔓 Decrypt File'); }
  });

  // ══ HASH ══
  let hashFile = null;
  let hashMode = 'file'; // 'file' | 'text'

  // Hash mode tabs
  document.getElementById('hash-tab-file').addEventListener('click', () => switchHashMode('file'));
  document.getElementById('hash-tab-text').addEventListener('click', () => switchHashMode('text'));

  function switchHashMode(mode) {
    hashMode = mode;
    document.getElementById('hash-tab-file').classList.toggle('active', mode === 'file');
    document.getElementById('hash-tab-text').classList.toggle('active', mode === 'text');
    document.getElementById('hash-file-panel').classList.toggle('hidden', mode !== 'file');
    document.getElementById('hash-text-panel').classList.toggle('hidden', mode !== 'text');
    refreshHashBtn();
  }

  function refreshHashBtn() {
    const btn = document.getElementById('hash-btn');
    if (hashMode === 'file') btn.disabled = !hashFile;
    else btn.disabled = !document.getElementById('hash-text-input').value.trim();
  }

  document.getElementById('hash-text-input').addEventListener('input', refreshHashBtn);
  document.getElementById('hash-text-paste').addEventListener('click', async () => {
    try { document.getElementById('hash-text-input').value = await navigator.clipboard.readText(); refreshHashBtn(); } catch(_) {}
  });
  document.getElementById('hash-text-clear').addEventListener('click', () => {
    document.getElementById('hash-text-input').value = ''; refreshHashBtn();
  });

  setupDropZone('hash-drop-zone','hash-file-input','hash-file-preview','hash-file-name','hash-file-meta','hash-remove', f => {
    hashFile = f; refreshHashBtn();
  }, () => { hashFile = null; refreshHashBtn(); });

  document.getElementById('hash-select-all').addEventListener('click', () => {
    document.querySelectorAll('input[name="hash-algo"]').forEach(cb => cb.checked = true);
  });
  document.getElementById('hash-select-none').addEventListener('click', () => {
    document.querySelectorAll('input[name="hash-algo"]').forEach(cb => cb.checked = false);
  });

  document.getElementById('hash-btn').addEventListener('click', async () => {
    const selectedAlgos = [...document.querySelectorAll('input[name="hash-algo"]:checked')].map(cb => cb.value);
    if (selectedAlgos.length === 0) {
      document.getElementById('hash-error-text').textContent = 'Select at least one algorithm.';
      showEl('hash-error', 'flex'); return;
    }
    hideEl('hash-error');
    setLoading(document.getElementById('hash-btn'), 'Computing…');
    try {
      let res;
      if (hashMode === 'file') {
        const fd = new FormData();
        fd.append('file',       hashFile);
        fd.append('algorithms', selectedAlgos.join(','));
        res = await fetch(`${API}/file-hash`, { method:'POST', body:fd });
      } else {
        res = await fetch(`${API}/file-hash`, {
          method:'POST', headers:{'Content-Type':'application/json'},
          body: JSON.stringify({ text: document.getElementById('hash-text-input').value, algorithms: selectedAlgos }),
        });
      }
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Hashing failed.');
      renderHashResults(data);
    } catch(err) {
      document.getElementById('hash-error-text').textContent = err.message;
      showEl('hash-error', 'flex');
    } finally { resetBtn(document.getElementById('hash-btn'), '# Compute Hashes'); }
  });

  function renderHashResults(data) {
    const results = document.getElementById('hash-results');
    results.innerHTML = '';
    const hashes = data.hashes ?? {};
    const allText = Object.entries(hashes).map(([k,v]) => `${k.toUpperCase()}: ${v}`).join('\n');

    const meta = [
      data.filename && `${data.filename}`,
      data.size_kb && `${data.size_kb} KB`,
    ].filter(Boolean).join(' · ');
    if (meta) {
      document.getElementById('hash-meta').textContent = meta;
      showEl('hash-meta');
    }

    Object.entries(hashes).forEach(([algo, hash]) => {
      const div = document.createElement('div');
      div.className = 'hash-row';
      div.innerHTML = `
        <div class="hash-label">${algo.toUpperCase()} <span class="hash-copy">Copy</span></div>
        <div class="hash-value">${escHtml(hash)}</div>`;
      div.addEventListener('click', () => {
        navigator.clipboard.writeText(hash).catch(() => {});
        div.classList.add('copied');
        div.querySelector('.hash-copy').textContent = 'Copied!';
        setTimeout(() => { div.classList.remove('copied'); div.querySelector('.hash-copy').textContent = 'Copy'; }, 1500);
      });
      results.appendChild(div);
    });

    showEl('hash-copy-all');
    document.getElementById('hash-copy-all').onclick = async () => {
      await navigator.clipboard.writeText(allText).catch(() => {});
      document.getElementById('hash-copy-all-label').textContent = 'Copied!';
      setTimeout(() => { document.getElementById('hash-copy-all-label').textContent = 'Copy all'; }, 2000);
    };
  }

  // ── Generic drop zone setup ──
  function setupDropZone(dzId, inputId, previewId, nameId, metaId, removeId, onFile, onRemove) {
    const dz     = document.getElementById(dzId);
    const input  = document.getElementById(inputId);
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
  function setLoading(btn, label) {
    btn.disabled = true;
    btn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> ${label}`;
  }
  function resetBtn(btn, label) { btn.disabled = false; btn.innerHTML = label; }
  function formatBytes(b) {
    if (b<1024) return b+' B'; if (b<1048576) return (b/1024).toFixed(1)+' KB'; return (b/1048576).toFixed(1)+' MB';
  }
  function formatKb(kb) {
    if (!kb) return '—'; if (kb>=1024) return (kb/1024).toFixed(2)+' MB'; return Math.round(kb)+' KB';
  }
  function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

}); // end DOMContentLoaded
</script>

@endpush

@endsection
