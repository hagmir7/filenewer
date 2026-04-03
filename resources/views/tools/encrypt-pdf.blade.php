@extends('layouts.base')

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- ── Mode tabs ── --}}
            <div class="flex items-center gap-1 p-2 border-b border-fn-text/7 bg-fn-surface2">
                @php
                $modes = [
                ['encrypt', '🔒', 'Encrypt PDF'],
                ['decrypt', '🔓', 'Decrypt PDF'],
                ['info', '📋', 'PDF Info'],
                ];
                @endphp
                @foreach($modes as [$mval, $micon, $mlabel])
                <button type="button"
                    class="mode-tab {{ $mval === 'encrypt' ? 'active' : '' }} flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    data-mode="{{ $mval }}">
                    <span>{{ $micon }}</span>
                    <span>{{ $mlabel }}</span>
                </button>
                @endforeach
            </div>

            <div class="p-8 lg:p-10">

                {{-- ── STATE: Input ── --}}
                <div id="state-upload">

                    {{-- ══ ENCRYPT PANEL ══ --}}
                    <div id="panel-encrypt">

                        {{-- Step indicator --}}
                        <div class="flex items-center justify-center gap-0 mb-8">
                            @php $encSteps = [['1','Upload PDF'],['2','Encrypting'],['3','Download']]; @endphp
                            @foreach($encSteps as [$n, $label])
                            <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-2"
                                id="enc-step-{{ $n }}">
                                <div
                                    class="step-dot w-6 h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                                    <span class="text-xs font-bold">{{ $n }}</span>
                                </div>
                                <span class="step-label text-xs font-semibold text-fn-text3 transition-colors">{{ $label
                                    }}</span>
                            </div>
                            @if($n !== '3')
                            <div class="w-10 h-px bg-fn-text/10 mx-2"></div>
                            @endif
                            @endforeach
                        </div>

                        {{-- Drop zone --}}
                        <div id="enc-drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-4">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-4xl">
                                    📕</div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                            <p class="text-fn-text3 text-sm mb-5">or click to browse from your computer</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue text-white text-sm font-semibold rounded-xl pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose PDF File
                            </div>
                            <p class="text-fn-text3 text-xs mt-4">Max 50MB free · <a href="/pricing"
                                    class="text-fn-blue-l hover:underline">200MB on Pro</a></p>
                            <input type="file" id="enc-file-input" accept=".pdf,application/pdf"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        {{-- File preview --}}
                        <div id="enc-file-preview"
                            class="hidden mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                                📕</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="enc-file-name">document.pdf</p>
                                <p class="text-fn-text3 text-xs mt-0.5" id="enc-file-meta">— · PDF Document</p>
                            </div>
                            <button type="button" id="enc-remove-file"
                                class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        {{-- Password fields --}}
                        <div class="mt-5 grid sm:grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    User Password
                                    <span class="text-fn-red ml-0.5">*</span>
                                </label>
                                <p class="text-fn-text3 text-xs mb-2">Required to open the PDF</p>
                                <div class="relative">
                                    <input type="password" id="enc-user-password" placeholder="e.g. mypassword123"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                    <button type="button"
                                        class="toggle-pw absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors"
                                        data-target="enc-user-password">
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
                                <div id="enc-pw-strength" class="mt-2 hidden">
                                    <div class="flex gap-1 mb-1">
                                        @for($i = 0; $i < 4; $i++) <div
                                            class="strength-bar h-1 flex-1 rounded-full bg-fn-text/10 transition-all duration-300">
                                    </div>
                                    @endfor
                                </div>
                                <p class="text-xs" id="enc-pw-strength-label"></p>
                            </div>
                        </div>
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                Owner Password
                                <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                            </label>
                            <p class="text-fn-text3 text-xs mb-2">Required to bypass restrictions</p>
                            <div class="relative">
                                <input type="password" id="enc-owner-password" placeholder="e.g. admin456"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <button type="button"
                                    class="toggle-pw absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors"
                                    data-target="enc-owner-password">
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
                    </div>

                    {{-- Permissions --}}
                    <div class="mt-3 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-fn-text2">Permissions</p>
                            <div class="flex gap-2">
                                <button type="button" id="enc-allow-all"
                                    class="text-xs text-fn-blue-l hover:underline font-semibold">Allow all</button>
                                <span class="text-fn-text3 text-xs">·</span>
                                <button type="button" id="enc-restrict-all"
                                    class="text-xs text-fn-red hover:underline font-semibold">Restrict all</button>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-2">
                            @php
                            $permissions = [
                            ['allow_printing', 'Allow Printing', 'Users can print the document'],
                            ['allow_copying', 'Allow Copying', 'Users can copy text & images'],
                            ['allow_editing', 'Allow Editing', 'Users can modify content'],
                            ['allow_annotations', 'Allow Annotations', 'Users can add comments'],
                            ];
                            @endphp
                            @foreach($permissions as [$pid, $plabel, $pdesc])
                            <label
                                class="perm-label flex items-start gap-3 p-3 bg-fn-surface border border-fn-text/8 rounded-xl cursor-pointer hover:border-fn-blue/25 transition-all">
                                <input type="checkbox" id="perm-{{ $pid }}" name="{{ $pid }}" checked
                                    class="perm-checkbox mt-0.5 w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue shrink-0" />
                                <div>
                                    <p class="text-xs font-semibold text-fn-text2">{{ $plabel }}</p>
                                    <p class="text-fn-text3 text-xs mt-0.5">{{ $pdesc }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                </div>{{-- /panel-encrypt --}}

                {{-- ══ DECRYPT PANEL ══ --}}
                <div id="panel-decrypt" class="hidden">

                    <div class="flex items-center justify-center gap-0 mb-8">
                        @php $decSteps = [['1','Upload PDF'],['2','Decrypting'],['3','Download']]; @endphp
                        @foreach($decSteps as [$n, $label])
                        <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-2"
                            id="dec-step-{{ $n }}">
                            <div
                                class="step-dot w-6 h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                                <span class="text-xs font-bold">{{ $n }}</span>
                            </div>
                            <span class="step-label text-xs font-semibold text-fn-text3 transition-colors">{{ $label
                                }}</span>
                        </div>
                        @if($n !== '3')
                        <div class="w-10 h-px bg-fn-text/10 mx-2"></div>
                        @endif
                        @endforeach
                    </div>

                    <div id="dec-drop-zone"
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                        <div class="flex items-center justify-center mb-4">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-4xl">
                                🔒</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your encrypted PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-5">or click to browse from your computer</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue text-white text-sm font-semibold rounded-xl pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF File
                        </div>
                        <p class="text-fn-text3 text-xs mt-4">Max 50MB free · <a href="/pricing"
                                class="text-fn-blue-l hover:underline">200MB on Pro</a></p>
                        <input type="file" id="dec-file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    <div id="dec-file-preview"
                        class="hidden mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            🔒</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="dec-file-name">document.pdf</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="dec-file-meta">— · Encrypted PDF</p>
                        </div>
                        <button type="button" id="dec-remove-file"
                            class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl max-w-sm">
                        <label class="text-xs font-semibold text-fn-text2 block mb-1.5">
                            PDF Password <span class="text-fn-red ml-0.5">*</span>
                        </label>
                        <p class="text-fn-text3 text-xs mb-2">Enter the password used to encrypt the PDF</p>
                        <div class="relative">
                            <input type="password" id="dec-password" placeholder="Enter PDF password"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <button type="button"
                                class="toggle-pw absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors"
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

                </div>{{-- /panel-decrypt --}}

                {{-- ══ INFO PANEL ══ --}}
                <div id="panel-info" class="hidden">

                    <div id="info-drop-zone"
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                        <div class="flex items-center justify-center mb-4">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-4xl">
                                📋</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-5">Inspect metadata, page count, encryption status and more
                        </p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue text-white text-sm font-semibold rounded-xl pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF File
                        </div>
                        <p class="text-fn-text3 text-xs mt-4">Max 50MB free</p>
                        <input type="file" id="info-file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    <div id="info-file-preview"
                        class="hidden mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            📋</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="info-file-name">document.pdf</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="info-file-meta">— · PDF Document</p>
                        </div>
                        <button type="button" id="info-remove-file"
                            class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl max-w-sm">
                        <label class="text-xs font-semibold text-fn-text2 block mb-1.5">
                            Password <span class="font-normal text-fn-text3 ml-1">(if encrypted)</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="info-password" placeholder="Leave blank if not protected"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <button type="button"
                                class="toggle-pw absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors"
                                data-target="info-password">
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

                </div>{{-- /panel-info --}}

                {{-- Error banner --}}
                <div id="upload-error"
                    class="hidden mt-5 items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        class="text-fn-red shrink-0" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span id="error-text">Something went wrong.</span>
                </div>

                {{-- Action button --}}
                <button id="action-btn" type="button" disabled
                    class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <span id="action-btn-label">Encrypt PDF</span>
                </button>

            </div>{{-- /state-upload --}}

            {{-- ── STATE: Processing ── --}}
            <div id="state-converting" class="hidden text-center py-6">
                <div class="flex items-center justify-center gap-5 mb-8">
                    <div
                        class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-3xl">
                        📕</div>
                    <div class="flex gap-1">
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                            style="animation-delay:0s"></span>
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                            style="animation-delay:.15s"></span>
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                            style="animation-delay:.3s"></span>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl"
                        id="conv-output-icon">🔒</div>
                </div>
                <h2 class="text-xl font-bold mb-2" id="conv-title">Processing your PDF…</h2>
                <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes just a few seconds</p>
                <div class="max-w-md mx-auto mb-3">
                    <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                        <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between max-w-md mx-auto text-xs text-fn-text3 mb-8">
                    <span id="progress-label">Starting…</span>
                    <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                </div>
                <div class="max-w-xs mx-auto flex flex-col gap-3 text-left" id="proc-steps">
                    @php
                    $procSteps = [
                    ['proc-1','Uploading & validating PDF'],
                    ['proc-2','Applying encryption & permissions'],
                    ['proc-3','Generating protected PDF'],
                    ];
                    @endphp
                    @foreach($procSteps as [$pid, $plabel])
                    <div class="flex items-center gap-3" id="{{ $pid }}">
                        <div
                            class="step-dot w-5 h-5 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center shrink-0 transition-all duration-300">
                            <svg class="check-icon hidden w-3 h-3 text-fn-green" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <svg class="spin-icon hidden w-3 h-3 text-fn-blue-l spin" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"
                                    stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="text-xs text-fn-text3">{{ $plabel }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── STATE: Result ── --}}
            <div id="state-download" class="hidden text-center py-6">
                <div class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5"
                    id="result-icon">✅</div>
                <h2 class="text-2xl font-bold mb-2" id="result-title">Done!</h2>
                <p class="text-fn-text2 text-sm mb-6" id="result-subtitle">Your file is ready.</p>

                {{-- Info result card (shown for info mode) --}}
                <div id="info-result-card" class="hidden max-w-lg mx-auto text-left mb-6">
                    <div class="bg-fn-surface2 border border-fn-text/8 rounded-2xl overflow-hidden">
                        {{-- Encryption status banner --}}
                        <div id="info-enc-banner" class="px-5 py-3 flex items-center gap-3 border-b border-fn-text/7">
                            <span id="info-enc-icon" class="text-xl">📄</span>
                            <div>
                                <p class="text-sm font-bold" id="info-enc-label">Not Encrypted</p>
                                <p class="text-xs text-fn-text3" id="info-enc-sub">This PDF has no password protection
                                </p>
                            </div>
                        </div>
                        {{-- Info rows --}}
                        <div class="divide-y divide-fn-text/6" id="info-rows"></div>
                    </div>
                </div>

                {{-- File download card (encrypt / decrypt modes) --}}
                <div id="file-download-card"
                    class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                    <div class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0"
                        id="dl-icon">🔒</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate" id="output-name">document_encrypted.pdf</p>
                        <p class="text-fn-text3 text-xs mt-0.5" id="output-size">PDF Document</p>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                </div>

                <a id="download-link" href="#" download="document.pdf"
                    class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                    style="background: oklch(67% 0.18 162);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    <span id="dl-btn-label">Download PDF</span>
                </a>

                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <button type="button" onclick="resetConverter()"
                        class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="1 4 1 10 7 10" />
                            <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                        </svg>
                        Try another
                    </button>
                    <a href="/tools"
                        class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                        All tools
                    </a>
                </div>

                <p class="mt-6 text-fn-text3 text-xs flex items-center justify-center gap-1.5">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
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
            @php
            $faqs = [
            ['What is the difference between User and Owner password?', 'The User password is required to open and view
            the PDF. The Owner password grants full access including bypassing any printing, copying, or editing
            restrictions you have set. If you only set a User password, anyone who knows it gets full access.'],
            ['What permissions can I restrict?', 'You can independently restrict printing, copying text and images,
            editing content, and adding annotations or comments. Uncheck any permission to block that action for users
            who open the PDF with the User password.'],
            ['Can I decrypt a PDF I no longer have the password for?', 'No — this tool requires the correct password to
            decrypt a PDF. It cannot bypass or crack passwords.'],
            ['What does the PDF Info tool show?', 'It returns the page count, file size, PDF version, encryption status,
            and all embedded metadata including title, author, subject, creator, and creation/modification dates.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ];
            @endphp
            @foreach($faqs as [$q,$a])
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

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ STYLES ══ --}}
<style>
    .mode-tab {
        color: var(--fn-text3);
    }

    .mode-tab.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 6px oklch(0% 0 0/14%);
    }

    .perm-label:has(.perm-checkbox:checked) {
        border-color: oklch(49% 0.24 264/30%);
        background: oklch(49% 0.24 264/5%);
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 20px;
    }

    .info-row-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--fn-text3);
        width: 110px;
        flex-shrink: 0;
        padding-top: 1px;
    }

    .info-row-value {
        font-size: 12px;
        color: var(--fn-text2);
        word-break: break-all;
    }
</style>

{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

  // ── State ──
  let activeMode   = 'encrypt'; // 'encrypt' | 'decrypt' | 'info'
  let encFile      = null;
  let decFile      = null;
  let infoFile     = null;
  let blobUrl      = null;

  // ── Mode tabs ──
  document.querySelectorAll('.mode-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      activeMode = tab.dataset.mode;
      document.querySelectorAll('.mode-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      ['encrypt','decrypt','info'].forEach(m => {
        document.getElementById('panel-' + m).classList.toggle('hidden', m !== activeMode);
      });
      updateActionBtn();
      hideError();
    });
  });

  // ── Password show/hide toggles ──
  document.querySelectorAll('.toggle-pw').forEach(btn => {
    btn.addEventListener('click', () => {
      const input   = document.getElementById(btn.dataset.target);
      const isPass  = input.type === 'password';
      input.type    = isPass ? 'text' : 'password';
      btn.querySelector('.eye-show').classList.toggle('hidden', isPass);
      btn.querySelector('.eye-hide').classList.toggle('hidden', !isPass);
    });
  });

  // ── Password strength meter ──
  const userPwInput  = document.getElementById('enc-user-password');
  const pwStrengthEl = document.getElementById('enc-pw-strength');
  const pwLabel      = document.getElementById('enc-pw-strength-label');
  const strengthBars = document.querySelectorAll('.strength-bar');

  userPwInput.addEventListener('input', () => {
    const pw  = userPwInput.value;
    updateActionBtn();
    if (!pw) { pwStrengthEl.classList.add('hidden'); return; }
    pwStrengthEl.classList.remove('hidden');
    const score = getStrength(pw);
    const colors = ['bg-fn-red','bg-fn-amber','bg-fn-amber','bg-fn-green'];
    const labels = ['Weak','Fair','Good','Strong'];
    strengthBars.forEach((bar, i) => {
      bar.className = 'strength-bar h-1 flex-1 rounded-full transition-all duration-300 ' +
        (i < score ? colors[score - 1] : 'bg-fn-text/10');
    });
    pwLabel.textContent  = labels[score - 1];
    pwLabel.className    = 'text-xs ' + ['text-fn-red','text-fn-amber','text-fn-amber','text-fn-green'][score - 1];
  });

  function getStrength(pw) {
    let s = 0;
    if (pw.length >= 8)  s++;
    if (pw.length >= 12) s++;
    if (/[A-Z]/.test(pw) && /[0-9]/.test(pw)) s++;
    if (/[^A-Za-z0-9]/.test(pw)) s++;
    return Math.max(1, Math.min(4, s));
  }

  // ── Allow all / Restrict all ──
  document.getElementById('enc-allow-all').addEventListener('click', () => {
    document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
  });
  document.getElementById('enc-restrict-all').addEventListener('click', () => {
    document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
  });

  // ── File inputs: generic setup ──
  function setupDropZone(dzId, inputId, previewId, nameId, metaId, removeBtnId, setter) {
    const dz      = document.getElementById(dzId);
    const input   = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const removeB = document.getElementById(removeBtnId);

    ['dragenter','dragover'].forEach(evt => {
      dz.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dz.classList.add('drag-over'); });
    });
    ['dragleave','dragend','drop'].forEach(evt => {
      dz.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dz.classList.remove('drag-over'); });
    });
    dz.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
    input.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
    removeB.addEventListener('click', e => {
      e.stopPropagation();
      setter(null);
      input.value = '';
      preview.classList.add('hidden');
      preview.classList.remove('flex');
      dz.classList.remove('has-file');
      updateActionBtn();
      hideError();
    });

    function handleFile(file) {
      hideError();
      if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
        showError('Please select a valid PDF file.');
        return;
      }
      if (file.size > 50 * 1024 * 1024) {
        showError('File exceeds the 50MB free limit.');
        return;
      }
      setter(file);
      document.getElementById(nameId).textContent = file.name;
      document.getElementById(metaId).textContent = formatBytes(file.size) + ' · PDF Document';
      preview.classList.remove('hidden');
      preview.classList.add('flex');
      dz.classList.add('has-file');
      updateActionBtn();
    }
  }

  setupDropZone('enc-drop-zone',  'enc-file-input',  'enc-file-preview',  'enc-file-name',  'enc-file-meta',  'enc-remove-file',  f => encFile  = f);
  setupDropZone('dec-drop-zone',  'dec-file-input',  'dec-file-preview',  'dec-file-name',  'dec-file-meta',  'dec-remove-file',  f => decFile  = f);
  setupDropZone('info-drop-zone', 'info-file-input', 'info-file-preview', 'info-file-name', 'info-file-meta', 'info-remove-file', f => infoFile = f);

  // Also watch dec-password for button enable
  document.getElementById('dec-password').addEventListener('input', updateActionBtn);

  function updateActionBtn() {
    const btn   = document.getElementById('action-btn');
    const label = document.getElementById('action-btn-label');
    if (activeMode === 'encrypt') {
      btn.disabled = !encFile || !userPwInput.value.trim();
      label.textContent = 'Encrypt PDF';
    } else if (activeMode === 'decrypt') {
      btn.disabled = !decFile || !document.getElementById('dec-password').value.trim();
      label.textContent = 'Decrypt PDF';
    } else {
      btn.disabled = !infoFile;
      label.textContent = 'Get PDF Info';
    }
  }

  // ── Action button ──
  document.getElementById('action-btn').addEventListener('click', startAction);

  async function startAction() {
    hideError();

    if (activeMode === 'info') {
      await doInfo();
    } else {
      showState('converting');
      updateStepIndicator(activeMode, 2);
      activeMode === 'encrypt' ? await doEncrypt() : await doDecrypt();
    }
  }

  // ── Encrypt ──
  async function doEncrypt() {
    document.getElementById('conv-title').textContent     = 'Encrypting your PDF…';
    document.getElementById('conv-output-icon').textContent = '🔒';
    updateProcLabels(['Uploading & validating PDF','Applying passwords & permissions','Generating protected PDF']);

    setProcessStep('proc-1', 'active');
    animateProgress(0, 30, 700, 'Uploading PDF…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1','done'); setProcessStep('proc-2','active');
      animateProgress(30, 70, 900, 'Applying passwords & permissions…');
    }, 800);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2','done'); setProcessStep('proc-3','active');
      animateProgress(70, 90, 700, 'Generating protected PDF…');
    }, 1900);

    const fd = new FormData();
    fd.append('file',           encFile);
    fd.append('user_password',  userPwInput.value.trim());
    const ownerPw = document.getElementById('enc-owner-password').value.trim();
    if (ownerPw) fd.append('owner_password', ownerPw);
    fd.append('allow_printing',    document.getElementById('perm-allow_printing').checked    ? 'true' : 'false');
    fd.append('allow_copying',     document.getElementById('perm-allow_copying').checked     ? 'true' : 'false');
    fd.append('allow_editing',     document.getElementById('perm-allow_editing').checked     ? 'true' : 'false');
    fd.append('allow_annotations', document.getElementById('perm-allow_annotations').checked ? 'true' : 'false');

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/pdf-encrypt', { method: 'POST', body: fd });
      clearTimeout(t2); clearTimeout(t3);
      if (!res.ok) { const d = await res.json().catch(() => ({})); throw new Error(d.error || 'Encryption failed.'); }
      const blob      = await res.blob();
      const fileName  = encFile.name.replace(/\.pdf$/i, '_encrypted.pdf');
      finishDownload(blob, fileName, '🔒', 'PDF Encrypted!', 'Your password-protected PDF is ready.', 'Download Encrypted PDF');
      setProcessStep('proc-2','done'); setProcessStep('proc-3','done');
      animateProgress(90, 100, 300, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator('encrypt', 3); }, 500);
    } catch(err) {
      clearTimeout(t2); clearTimeout(t3);
      showError(err.message);
      showState('upload');
      updateStepIndicator('encrypt', 1);
    }
  }

  // ── Decrypt ──
  async function doDecrypt() {
    document.getElementById('conv-title').textContent      = 'Decrypting your PDF…';
    document.getElementById('conv-output-icon').textContent = '🔓';
    updateProcLabels(['Uploading & validating PDF','Verifying password','Removing encryption']);

    setProcessStep('proc-1','active');
    animateProgress(0, 30, 700, 'Uploading PDF…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1','done'); setProcessStep('proc-2','active');
      animateProgress(30, 70, 800, 'Verifying password…');
    }, 800);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2','done'); setProcessStep('proc-3','active');
      animateProgress(70, 90, 600, 'Removing encryption…');
    }, 1700);

    const fd = new FormData();
    fd.append('file',     decFile);
    fd.append('password', document.getElementById('dec-password').value.trim());

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/pdf-decrypt', { method: 'POST', body: fd });
      clearTimeout(t2); clearTimeout(t3);
      if (!res.ok) { const d = await res.json().catch(() => ({})); throw new Error(d.error || 'Decryption failed. Check your password.'); }
      const blob     = await res.blob();
      const fileName = decFile.name.replace(/\.pdf$/i, '_decrypted.pdf');
      finishDownload(blob, fileName, '🔓', 'PDF Decrypted!', 'Encryption removed — your PDF is now unlocked.', 'Download Decrypted PDF');
      setProcessStep('proc-2','done'); setProcessStep('proc-3','done');
      animateProgress(90, 100, 300, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator('decrypt', 3); }, 500);
    } catch(err) {
      clearTimeout(t2); clearTimeout(t3);
      showError(err.message);
      showState('upload');
      updateStepIndicator('decrypt', 1);
    }
  }

  // ── Info ──
  async function doInfo() {
    const btn = document.getElementById('action-btn');
    btn.disabled = true;
    btn.innerHTML = `<svg class="spin w-5 h-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Fetching info…`;

    const fd = new FormData();
    fd.append('file', infoFile);
    const pw = document.getElementById('info-password').value.trim();
    if (pw) fd.append('password', pw);

    try {
      const res  = await fetch('https://api.filenewer.com/api/tools/pdf-info', { method: 'POST', body: fd });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Could not read PDF info.');
      renderInfoResult(data);
    } catch(err) {
      showError(err.message);
    } finally {
      btn.disabled = false;
      btn.innerHTML = `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Get PDF Info`;
    }
  }

  function renderInfoResult(data) {
    const isEncrypted = !!data.encrypted;
    const banner      = document.getElementById('info-enc-banner');
    banner.className  = 'px-5 py-3 flex items-center gap-3 border-b border-fn-text/7 ' +
      (isEncrypted ? 'bg-fn-amber/8' : 'bg-fn-green/8');
    document.getElementById('info-enc-icon').textContent  = isEncrypted ? '🔒' : '✅';
    document.getElementById('info-enc-label').textContent = isEncrypted ? 'Encrypted PDF' : 'Not Encrypted';
    document.getElementById('info-enc-sub').textContent   = isEncrypted
      ? 'This PDF is password protected'
      : 'This PDF has no password protection';

    const rows = [
      ['Pages',       data.pages ?? '—'],
      ['File Size',   data.file_size ? formatBytes(data.file_size) : '—'],
      ['PDF Version', data.pdf_version ?? '—'],
      ['Title',       data.metadata?.title   || '—'],
      ['Author',      data.metadata?.author  || '—'],
      ['Subject',     data.metadata?.subject || '—'],
      ['Creator',     data.metadata?.creator || '—'],
      ['Producer',    data.metadata?.producer|| '—'],
      ['Created',     formatPdfDate(data.metadata?.created)  || '—'],
      ['Modified',    formatPdfDate(data.metadata?.modified) || '—'],
    ];

    const container = document.getElementById('info-rows');
    container.innerHTML = '';
    rows.forEach(([label, value]) => {
      const div = document.createElement('div');
      div.className = 'info-row';
      div.innerHTML = `<span class="info-row-label">${label}</span><span class="info-row-value">${value}</span>`;
      container.appendChild(div);
    });

    document.getElementById('info-result-card').classList.remove('hidden');
    document.getElementById('file-download-card').classList.add('hidden');
    document.getElementById('download-link').classList.add('hidden');
    document.getElementById('result-title').textContent    = 'PDF Info';
    document.getElementById('result-subtitle').textContent = infoFile.name;
    document.getElementById('result-icon').textContent     = '📋';
    showState('download');
  }

  function formatPdfDate(d) {
    if (!d) return '';
    // PDF dates: D:YYYYMMDDHHmmSS
    const m = (d || '').replace('D:','').match(/^(\d{4})(\d{2})(\d{2})/);
    if (!m) return d;
    return `${m[1]}-${m[2]}-${m[3]}`;
  }

  // ── Finish download (encrypt/decrypt) ──
  function finishDownload(blob, fileName, icon, title, subtitle, btnLabel) {
    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = URL.createObjectURL(blob);
    const link    = document.getElementById('download-link');
    link.href     = blobUrl;
    link.download = fileName;
    link.classList.remove('hidden');
    document.getElementById('output-name').textContent  = fileName;
    document.getElementById('output-size').textContent  = formatBytes(blob.size) + ' · PDF Document';
    document.getElementById('dl-icon').textContent      = icon;
    document.getElementById('result-icon').textContent  = '✅';
    document.getElementById('result-title').textContent   = title;
    document.getElementById('result-subtitle').textContent = subtitle;
    document.getElementById('dl-btn-label').textContent  = btnLabel;
    document.getElementById('info-result-card').classList.add('hidden');
    document.getElementById('file-download-card').classList.remove('hidden');
  }

  // ── Step indicators ──
  function updateStepIndicator(mode, active) {
    const prefix = mode === 'encrypt' ? 'enc' : 'dec';
    if (mode === 'info') return;
    [1,2,3].forEach(n => {
      const el = document.getElementById(`${prefix}-step-${n}`);
      if (!el) return;
      el.classList.remove('active','done');
      if (n < active)   el.classList.add('done');
      if (n === active) el.classList.add('active');
    });
  }

  function updateProcLabels(labels) {
    ['proc-1','proc-2','proc-3'].forEach((id, i) => {
      const el = document.getElementById(id);
      if (el) el.querySelector('span').textContent = labels[i] || '';
    });
  }

  // ── Helpers ──
  function showState(state) {
    ['upload','converting','download'].forEach(s => {
      document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
    });
    if (state === 'download') document.getElementById('state-download').classList.add('bounce-in');
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
      dot.style.background  = 'oklch(49% 0.24 264/15%)';
    }
    if (state === 'done') {
      check.classList.remove('hidden');
      dot.style.borderColor = 'oklch(67% 0.18 162)';
      dot.style.background  = 'oklch(67% 0.18 162/15%)';
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
    encFile = decFile = infoFile = null;
    // Reset all file zones
    ['enc','dec','info'].forEach(p => {
      const input   = document.getElementById(p + '-file-input');
      const preview = document.getElementById(p + '-file-preview');
      const dz      = document.getElementById(p + '-drop-zone');
      if (input)   input.value = '';
      if (preview) { preview.classList.add('hidden'); preview.classList.remove('flex'); }
      if (dz)      dz.classList.remove('has-file');
    });
    // Reset passwords
    ['enc-user-password','enc-owner-password','dec-password','info-password'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    // Reset permissions
    document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
    // Reset strength meter
    pwStrengthEl.classList.add('hidden');
    // Reset info result
    document.getElementById('info-result-card').classList.add('hidden');
    document.getElementById('file-download-card').classList.remove('hidden');
    document.getElementById('download-link').classList.remove('hidden');
    showState('upload');
    updateActionBtn();
    hideError();
    animateProgress(0, 0, 0, 'Starting…');
    ['proc-1','proc-2','proc-3'].forEach(id => setProcessStep(id, ''));
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
    if (!bytes) return '—';
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

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

@endsection
