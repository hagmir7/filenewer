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
                $pwTabs = [
                ['generate', '⚡', 'Password'],
                ['passphrase', '💬', 'Passphrase'],
                ['strength', '🛡', 'Strength Check'],
                ];
                @endphp
                @foreach($pwTabs as [$tval,$ticon,$tlabel])
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
                        <div class="space-y-4">

                            {{-- Length --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Length — <span id="pw-len-val" class="text-fn-blue-l">16</span> characters
                                </label>
                                <input type="range" id="pw-length" min="4" max="128" value="16" step="1"
                                    class="w-full accent-fn-blue cursor-pointer mb-1" />
                                <div class="flex justify-between text-fn-text3 text-sm mb-2">
                                    <span>4</span><span>32</span><span>64</span><span>128</span>
                                </div>
                                <input type="number" id="pw-length-num" min="4" max="256" value="16"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40" />
                            </div>

                            {{-- Count --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Count — <span id="pw-count-val" class="text-fn-blue-l">1</span>
                                </label>
                                <input type="range" id="pw-count" min="1" max="20" value="1" step="1"
                                    class="w-full accent-fn-blue cursor-pointer" />
                                <div class="flex justify-between text-fn-text3 text-sm mt-1">
                                    <span>1</span><span>5</span><span>10</span><span>20</span>
                                </div>
                            </div>

                            {{-- Character sets --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Characters</label>
                                <div class="space-y-2">
                                    @php
                                    $charToggles = [
                                    ['pw-uppercase', 'Uppercase', 'A–Z', true],
                                    ['pw-lowercase', 'Lowercase', 'a–z', true],
                                    ['pw-digits', 'Digits', '0–9', true],
                                    ['pw-symbols', 'Symbols', '!@#$%^&*', true],
                                    ];
                                    @endphp
                                    @foreach($charToggles as [$tid,$tlabel,$tchars,$tdefault])
                                    <label class="flex items-center justify-between cursor-pointer select-none">
                                        <div class="flex items-center gap-2">
                                            <div class="toggle-wrap relative w-8 h-4">
                                                <input type="checkbox" id="{{ $tid }}" {{ $tdefault ? 'checked' : '' }}
                                                    class="sr-only peer" />
                                                <div
                                                    class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                                </div>
                                                <div
                                                    class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                                </div>
                                            </div>
                                            <span class="text-sm font-semibold text-fn-text2">{{ $tlabel }}</span>
                                        </div>
                                        <span class="text-sm font-mono text-fn-text3">{{ $tchars }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Exclusion options --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-2">
                                <label class="text-sm font-semibold text-fn-text2 block mb-1">Exclusions</label>
                                @php
                                $exclusions = [
                                ['pw-exclude-similar', 'Exclude similar', '0 O 1 l I'],
                                ['pw-exclude-ambiguous', 'Exclude ambiguous', '{ } / \\ ; :'],
                                ['pw-no-repeat', 'No repeating chars', ''],
                                ];
                                @endphp
                                @foreach($exclusions as [$eid,$elabel,$echars])
                                <label class="flex items-center justify-between cursor-pointer select-none">
                                    <div class="flex items-center gap-2">
                                        <div class="toggle-wrap relative w-8 h-4">
                                            <input type="checkbox" id="{{ $eid }}" class="sr-only peer" />
                                            <div
                                                class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                            </div>
                                            <div
                                                class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold text-fn-text2">{{ $elabel }}</span>
                                    </div>
                                    @if($echars)
                                    <span class="text-sm font-mono text-fn-text3">{{ $echars }}</span>
                                    @endif
                                </label>
                                @endforeach
                                <div class="pt-1">
                                    <label class="text-sm text-fn-text3 block mb-1">Exclude specific chars</label>
                                    <input type="text" id="pw-exclude-chars" placeholder='e.g. @#$'
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                </div>
                            </div>

                            {{-- Prefix / Suffix / Custom --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-2">
                                <label class="text-sm font-semibold text-fn-text2 block mb-1">Advanced</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="text-sm text-fn-text3 block mb-1">Prefix</label>
                                        <input type="text" id="pw-prefix" placeholder="APP-"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-fn-text3 block mb-1">Suffix</label>
                                        <input type="text" id="pw-suffix" placeholder="-2024"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm text-fn-text3 block mb-1">Custom characters only <span
                                            class="font-normal">(overrides above)</span></label>
                                    <input type="text" id="pw-custom-chars" placeholder="abcdefABCDEF0123456789"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1.5 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
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
                        <div class="lg:col-span-2 space-y-4">

                            {{-- Entropy / strength badge --}}
                            <div id="gen-meta-bar"
                                class="hidden flex flex-wrap items-center gap-2 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm text-fn-text3">Strength:</span>
                                    <span id="gen-strength-badge"
                                        class="text-sm font-bold px-2 py-0.5 rounded-md">—</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm text-fn-text3">Entropy:</span>
                                    <span class="text-sm font-bold text-fn-text2" id="gen-entropy">—</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm text-fn-text3">Pool:</span>
                                    <span class="text-sm font-bold text-fn-text2" id="gen-pool">—</span>
                                </div>
                                <div class="ml-auto flex items-center gap-2">
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
                                    <button type="button" id="gen-regen"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue-l text-sm font-semibold rounded-lg transition-all">
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

                            {{-- Password rows --}}
                            <div id="pw-list" class="space-y-2 min-h-24">
                                <div id="pw-empty"
                                    class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-fn-text/8 rounded-xl text-fn-text3 gap-2">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    <span class="text-sm">Configure options and click Generate</span>
                                </div>
                            </div>

                            {{-- Crack time (shown after generate) --}}
                            <div id="crack-time-card"
                                class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <p class="text-sm font-semibold text-fn-text2 mb-3">⏱ Estimated Crack Time</p>
                                <div class="grid sm:grid-cols-2 gap-2" id="crack-time-grid"></div>
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

                {{-- ══ PASSPHRASE TAB ══ --}}
                <div id="panel-passphrase" class="tab-panel hidden">
                    <div class="grid lg:grid-cols-3 gap-6">

                        {{-- Options --}}
                        <div class="space-y-4">

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Words — <span id="pp-words-val" class="text-fn-blue-l">4</span>
                                </label>
                                <input type="range" id="pp-words" min="2" max="10" value="4" step="1"
                                    class="w-full accent-fn-blue cursor-pointer" />
                                <div class="flex justify-between text-fn-text3 text-sm mt-1">
                                    <span>2</span><span>4</span><span>7</span><span>10</span>
                                </div>
                            </div>

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Count — <span id="pp-count-val" class="text-fn-blue-l">3</span>
                                </label>
                                <input type="range" id="pp-count" min="1" max="10" value="3" step="1"
                                    class="w-full accent-fn-blue cursor-pointer" />
                            </div>

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="pp-separator"
                                    class="text-sm font-semibold text-fn-text2 block mb-2">Separator</label>
                                <div class="flex gap-2 mb-2">
                                    @php $seps = ['-','_','.','/','@',' ']; @endphp
                                    @foreach($seps as $sep)
                                    <button type="button"
                                        class="sep-preset-btn {{ $sep === '-' ? 'active' : '' }} px-2.5 py-1 rounded-lg border text-sm font-mono font-bold transition-all"
                                        data-sep="{{ $sep }}">{{ $sep === ' ' ? '␣' : $sep }}</button>
                                    @endforeach
                                </div>
                                <input type="text" id="pp-separator" value="-" placeholder="Custom separator"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40" />
                            </div>

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-2">
                                <label class="text-sm font-semibold text-fn-text2 block mb-1">Options</label>
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <div class="toggle-wrap relative w-8 h-4">
                                        <input type="checkbox" id="pp-capitalize" checked class="sr-only peer" />
                                        <div
                                            class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                        </div>
                                        <div
                                            class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold text-fn-text2">Capitalize words</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <div class="toggle-wrap relative w-8 h-4">
                                        <input type="checkbox" id="pp-digit" checked class="sr-only peer" />
                                        <div
                                            class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                        </div>
                                        <div
                                            class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold text-fn-text2">Include a digit</span>
                                </label>
                            </div>

                            <button type="button" id="pp-gen-btn"
                                class="w-full py-3 bg-fn-blue text-white font-bold text-sm rounded-xl transition-all hover:bg-fn-blue-l hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                </svg>
                                Generate Passphrases
                            </button>
                        </div>

                        {{-- Output --}}
                        <div class="lg:col-span-2 space-y-4">

                            <div id="pp-meta-bar"
                                class="hidden flex flex-wrap items-center gap-2 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm text-fn-text3">Strength:</span>
                                    <span id="pp-strength-badge"
                                        class="text-sm font-bold px-2 py-0.5 rounded-md">—</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm text-fn-text3">Entropy:</span>
                                    <span class="text-sm font-bold text-fn-text2" id="pp-entropy">—</span>
                                </div>
                                <div class="ml-auto flex items-center gap-2">
                                    <button type="button" id="pp-copy-all"
                                        class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                        <span id="pp-copy-label">Copy all</span>
                                    </button>
                                    <button type="button" id="pp-regen"
                                        class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue-l text-sm font-semibold rounded-lg transition-all">
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

                            <div id="pp-list" class="space-y-2 min-h-24">
                                <div id="pp-empty"
                                    class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-fn-text/8 rounded-xl text-fn-text3 gap-2">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    </svg>
                                    <span class="text-sm">Configure options and generate passphrases</span>
                                </div>
                            </div>

                            <div id="pp-crack-card"
                                class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <p class="text-sm font-semibold text-fn-text2 mb-3">⏱ Estimated Crack Time</p>
                                <div class="grid sm:grid-cols-2 gap-2" id="pp-crack-grid"></div>
                            </div>

                            <div id="pp-error"
                                class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                <span id="pp-error-text"></span>
                            </div>
                        </div>

                    </div>
                </div>{{-- /panel-passphrase --}}

                {{-- ══ STRENGTH TAB ══ --}}
                <div id="panel-strength" class="tab-panel hidden">
                    <div class="max-w-2xl space-y-4">

                        {{-- Input --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-fn-text2">Enter Password to Analyse</p>
                                <button type="button" id="str-toggle-vis"
                                    class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg id="str-eye-show" width="11" height="11" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg id="str-eye-hide" class="hidden" width="11" height="11" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                    Show
                                </button>
                            </div>
                            <input type="password" id="str-input" placeholder="Type or paste a password to analyse…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-base font-mono rounded-xl px-5 py-4 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 placeholder:font-sans placeholder:text-sm" />

                            {{-- Live strength bar --}}
                            <div class="h-2 bg-fn-surface2 border border-fn-text/8 rounded-full overflow-hidden">
                                <div id="str-bar" class="h-full rounded-full transition-all duration-500"
                                    style="width:0%"></div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span id="str-live-label" class="font-semibold text-fn-text3">—</span>
                                <span id="str-live-entropy" class="font-mono text-fn-text3"></span>
                            </div>
                        </div>

                        {{-- Full result (after API call) --}}
                        <div id="str-result" class="hidden space-y-4">

                            {{-- Main score card --}}
                            <div class="p-5 rounded-2xl border" id="str-score-card">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="relative w-16 h-16 shrink-0">
                                        <svg class="w-16 h-16 -rotate-90" viewBox="0 0 36 36">
                                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="currentColor"
                                                stroke-width="3" class="text-fn-text/10" />
                                            <circle id="str-score-circle" cx="18" cy="18" r="15.9" fill="none"
                                                stroke-width="3.5" stroke-linecap="round" stroke-dasharray="100 100"
                                                stroke-dashoffset="100" class="transition-all duration-700" />
                                        </svg>
                                        <span
                                            class="absolute inset-0 flex items-center justify-center text-sm font-black"
                                            id="str-score-num">0</span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-black" id="str-strength-label">—</p>
                                        <p class="text-sm text-fn-text3 mt-0.5" id="str-entropy-label"></p>
                                    </div>
                                </div>

                                {{-- Character type pills --}}
                                <div class="flex flex-wrap gap-1.5" id="str-char-pills"></div>
                            </div>

                            {{-- Crack time --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <p class="text-sm font-semibold text-fn-text2 mb-3">⏱ Estimated Crack Time</p>
                                <div class="grid sm:grid-cols-2 gap-2" id="str-crack-grid"></div>
                            </div>

                            {{-- Issues & suggestions --}}
                            <div id="str-issues-wrap"
                                class="hidden p-4 bg-fn-amber/6 border border-fn-amber/20 rounded-xl space-y-2">
                                <p class="text-sm font-semibold text-fn-amber">⚠ Issues & Suggestions</p>
                                <ul id="str-issues-list" class="space-y-1"></ul>
                            </div>

                        </div>

                        <div id="str-error"
                            class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <span id="str-error-text"></span>
                        </div>

                    </div>
                </div>{{-- /panel-strength --}}

            </div>{{-- /card body --}}
        </div>{{-- /card --}}
    </div>
</section>


{{-- ══ STRENGTH GUIDE ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Strength Levels</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @php
            $strengthLevels = [
            ['Very Weak', '< 28 bits', 'bg-fn-red/10 border-fn-red/25 text-fn-red' , 'Cracked instantly. Never use.' ],
                ['Weak', '28–36 bits' , 'bg-fn-amber/10 border-fn-amber/25 text-fn-amber'
                , 'Cracked in seconds or minutes.' ], ['Moderate', '36–60 bits'
                , 'bg-fn-yellow/10 border-fn-yellow/25 text-fn-yellow' ,'Cracked in hours or days.'],
                ['Strong', '60–128 bits' , 'bg-fn-green/10 border-fn-green/25 text-fn-green'
                , 'Cracked in years or centuries.' ], ['Very Strong', '> 128 bits'
                , 'bg-fn-blue/10 border-fn-blue/25 text-fn-blue-l' , 'Practically uncrackable.' ], ]; @endphp
                @foreach($strengthLevels as [$name,$entropy,$classes,$desc]) <div
                class="p-4 border rounded-xl {{ $classes }}">
                <p class="font-bold text-sm mb-1">{{ $name }}</p>
                <p class="text-sm font-mono opacity-80 mb-2">{{ $entropy }}</p>
                <p class="text-sm opacity-70 leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
    </div>
</section>

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

@push('styles')
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

        .sep-preset-btn {
            border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
            background: var(--fn-surface);
            color: var(--fn-text3);
        }

        .sep-preset-btn.active {
            color: var(--fn-blue-l);
            border-color: oklch(49% 0.24 264/40%);
            background: oklch(49% 0.24 264/8%);
        }

        .pw-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: var(--fn-surface2);
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
            border-radius: 10px;
            cursor: pointer;
            transition: border-color .15s;
        }

        .pw-row:hover {
            border-color: oklch(49% 0.24 264/30%);
        }

        .pw-row.copied {
            border-color: oklch(67% 0.18 162/40%);
            background: oklch(67% 0.18 162/6%);
        }

        .pw-text {
            font-family: monospace;
            font-size: 14px;
            color: var(--fn-text);
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pw-copy {
            font-size: 10px;
            font-weight: 700;
            color: var(--fn-blue-l);
            opacity: 0;
            transition: opacity .15s;
            flex-shrink: 0;
        }

        .pw-row:hover .pw-copy {
            opacity: 1;
        }

        .crack-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 8px 12px;
            background: var(--fn-surface);
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
            border-radius: 8px;
        }

        .crack-scenario {
            font-size: 10px;
            color: var(--fn-text3);
            width: 120px;
            flex-shrink: 0;
        }

        .crack-value {
            font-size: 11px;
            font-weight: 700;
            color: var(--fn-text2);
        }
    </style>
@endpush

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      const API = 'https://api.filenewer.com/api/tools';

      const strengthConfig = {
        very_weak:   { label: 'Very Weak',   color: 'oklch(62% 0.22 25)',  bg: 'oklch(62% 0.22 25/12%)', border: 'oklch(62% 0.22 25/30%)', pct: 10 },
        weak:        { label: 'Weak',        color: 'oklch(75% 0.15 55)',  bg: 'oklch(75% 0.15 55/12%)', border: 'oklch(75% 0.15 55/30%)', pct: 30 },
        moderate:    { label: 'Moderate',    color: 'oklch(80% 0.16 80)',  bg: 'oklch(80% 0.16 80/12%)', border: 'oklch(80% 0.16 80/30%)', pct: 55 },
        strong:      { label: 'Strong',      color: 'oklch(67% 0.18 162)', bg: 'oklch(67% 0.18 162/12%)', border: 'oklch(67% 0.18 162/30%)', pct: 80 },
        very_strong: { label: 'Very Strong', color: 'oklch(49% 0.24 264)', bg: 'oklch(49% 0.24 264/12%)', border: 'oklch(49% 0.24 264/30%)', pct: 100 },
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

      // ══ GENERATE ══

      // Sync length slider ↔ number input
      const pwLenRange = document.getElementById('pw-length');
      const pwLenNum   = document.getElementById('pw-length-num');
      pwLenRange.addEventListener('input', () => { document.getElementById('pw-len-val').textContent = pwLenRange.value; pwLenNum.value = pwLenRange.value; });
      pwLenNum.addEventListener('input', () => {
        const v = Math.max(4, Math.min(256, parseInt(pwLenNum.value)||16));
        pwLenNum.value = v; pwLenRange.value = Math.min(v, 128);
        document.getElementById('pw-len-val').textContent = v;
      });

      // Sync count slider
      document.getElementById('pw-count').addEventListener('input', e => {
        document.getElementById('pw-count-val').textContent = e.target.value;
      });

      document.getElementById('gen-btn').addEventListener('click', doGenerate);
      document.getElementById('gen-regen').addEventListener('click', doGenerate);

      async function doGenerate() {
        hideEl('gen-error');
        setLoading('gen-btn', 'Generating…');

        const payload = {
          length:            parseInt(pwLenNum.value) || 16,
          count:             parseInt(document.getElementById('pw-count').value) || 1,
          uppercase:         document.getElementById('pw-uppercase').checked,
          lowercase:         document.getElementById('pw-lowercase').checked,
          digits:            document.getElementById('pw-digits').checked,
          symbols:           document.getElementById('pw-symbols').checked,
          exclude_similar:   document.getElementById('pw-exclude-similar').checked,
          exclude_ambiguous: document.getElementById('pw-exclude-ambiguous').checked,
          no_repeat:         document.getElementById('pw-no-repeat').checked,
          exclude_chars:     document.getElementById('pw-exclude-chars').value || '',
          prefix:            document.getElementById('pw-prefix').value || '',
          suffix:            document.getElementById('pw-suffix').value || '',
          custom_chars:      document.getElementById('pw-custom-chars').value || '',
        };

        try {
          const res  = await fetch(`${API}/password-generate`, {
            method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Generation failed.');
          renderPasswords(data);
        } catch(err) {
          document.getElementById('gen-error-text').textContent = err.message;
          showEl('gen-error', 'flex');
        } finally {
          resetLoading('gen-btn', `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Generate`);
        }
      }

      function renderPasswords(data) {
        const passwords = data.passwords ?? [];
        const strength  = data.strength  ?? 'moderate';
        const cfg       = strengthConfig[strength] ?? strengthConfig.moderate;

        // Meta bar
        document.getElementById('gen-strength-badge').textContent  = cfg.label;
        document.getElementById('gen-strength-badge').style.background = cfg.bg;
        document.getElementById('gen-strength-badge').style.color      = cfg.color;
        document.getElementById('gen-strength-badge').style.border     = `1px solid ${cfg.border}`;
        document.getElementById('gen-entropy').textContent = data.entropy ? data.entropy.toFixed(1) + ' bits' : '—';
        document.getElementById('gen-pool').textContent    = data.pool_size ? data.pool_size + ' chars' : '—';
        showEl('gen-meta-bar', 'flex');
        showEl('gen-copy-all');

        // Password rows
        const list = document.getElementById('pw-list');
        list.innerHTML = '';
        passwords.forEach(pw => {
          const row = document.createElement('div');
          row.className = 'pw-row';
          row.innerHTML = `<span class="pw-text">${escHtml(pw)}</span><span class="pw-copy">Copy</span>`;
          row.addEventListener('click', () => {
            navigator.clipboard.writeText(pw).catch(() => {});
            row.classList.add('copied');
            row.querySelector('.pw-copy').textContent = 'Copied!';
            setTimeout(() => { row.classList.remove('copied'); row.querySelector('.pw-copy').textContent = 'Copy'; }, 1500);
          });
          list.appendChild(row);
        });

        // Copy all
        document.getElementById('gen-copy-all').onclick = async () => {
          await navigator.clipboard.writeText(passwords.join('\n')).catch(() => {});
          document.getElementById('gen-copy-label').textContent = 'Copied!';
          setTimeout(() => { document.getElementById('gen-copy-label').textContent = 'Copy all'; }, 2000);
        };

        // Crack time
        if (data.crack_time) {
          renderCrackTime('crack-time-grid', data.crack_time);
          showEl('crack-time-card');
        }
      }

      // ══ PASSPHRASE ══
      document.getElementById('pp-words').addEventListener('input', e => {
        document.getElementById('pp-words-val').textContent = e.target.value;
      });
      document.getElementById('pp-count').addEventListener('input', e => {
        document.getElementById('pp-count-val').textContent = e.target.value;
      });

      // Separator presets
      document.querySelectorAll('.sep-preset-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.sep-preset-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          document.getElementById('pp-separator').value = btn.dataset.sep === '␣' ? ' ' : btn.dataset.sep;
        });
      });
      document.getElementById('pp-separator').addEventListener('input', () => {
        document.querySelectorAll('.sep-preset-btn').forEach(b => b.classList.remove('active'));
      });

      document.getElementById('pp-gen-btn').addEventListener('click', doPassphrase);
      document.getElementById('pp-regen').addEventListener('click', doPassphrase);

      async function doPassphrase() {
        hideEl('pp-error');
        setLoading('pp-gen-btn', 'Generating…');
        const payload = {
          words:         parseInt(document.getElementById('pp-words').value) || 4,
          count:         parseInt(document.getElementById('pp-count').value) || 3,
          separator:     document.getElementById('pp-separator').value,
          capitalize:    document.getElementById('pp-capitalize').checked,
          include_digit: document.getElementById('pp-digit').checked,
        };
        try {
          const res  = await fetch(`${API}/passphrase-generate`, {
            method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Generation failed.');
          renderPassphrases(data);
        } catch(err) {
          document.getElementById('pp-error-text').textContent = err.message;
          showEl('pp-error', 'flex');
        } finally {
          resetLoading('pp-gen-btn', `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Generate Passphrases`);
        }
      }

      function renderPassphrases(data) {
        const phrases = data.passphrases ?? [];
        const strength = data.strength ?? 'moderate';
        const cfg = strengthConfig[strength] ?? strengthConfig.moderate;

        document.getElementById('pp-strength-badge').textContent       = cfg.label;
        document.getElementById('pp-strength-badge').style.background  = cfg.bg;
        document.getElementById('pp-strength-badge').style.color       = cfg.color;
        document.getElementById('pp-strength-badge').style.border      = `1px solid ${cfg.border}`;
        document.getElementById('pp-entropy').textContent = data.entropy ? data.entropy.toFixed(1) + ' bits' : '—';
        showEl('pp-meta-bar', 'flex');
        showEl('pp-copy-all');

        const list = document.getElementById('pp-list');
        list.innerHTML = '';
        phrases.forEach(ph => {
          const row = document.createElement('div');
          row.className = 'pw-row';
          row.innerHTML = `<span class="pw-text">${escHtml(ph)}</span><span class="pw-copy">Copy</span>`;
          row.addEventListener('click', () => {
            navigator.clipboard.writeText(ph).catch(() => {});
            row.classList.add('copied');
            row.querySelector('.pw-copy').textContent = 'Copied!';
            setTimeout(() => { row.classList.remove('copied'); row.querySelector('.pw-copy').textContent = 'Copy'; }, 1500);
          });
          list.appendChild(row);
        });

        document.getElementById('pp-copy-all').onclick = async () => {
          await navigator.clipboard.writeText(phrases.join('\n')).catch(() => {});
          document.getElementById('pp-copy-label').textContent = 'Copied!';
          setTimeout(() => { document.getElementById('pp-copy-label').textContent = 'Copy all'; }, 2000);
        };

        if (data.crack_time) {
          renderCrackTime('pp-crack-grid', data.crack_time);
          showEl('pp-crack-card');
        }
      }

      // ══ STRENGTH ══
      const strInput = document.getElementById('str-input');

      // Show/hide toggle
      document.getElementById('str-toggle-vis').addEventListener('click', () => {
        const isPass = strInput.type === 'password';
        strInput.type = isPass ? 'text' : 'password';
        document.getElementById('str-eye-show').classList.toggle('hidden', isPass);
        document.getElementById('str-eye-hide').classList.toggle('hidden', !isPass);
        document.getElementById('str-toggle-vis').querySelector('span:last-child')?.remove();
      });

      // Live bar (client-side estimate)
      let strDebounce = null;
      strInput.addEventListener('input', () => {
        updateLiveBar(strInput.value);
        clearTimeout(strDebounce);
        if (strInput.value.length >= 4) {
          strDebounce = setTimeout(doStrengthCheck, 700);
        } else {
          hideEl('str-result');
        }
      });

      function updateLiveBar(pw) {
        let bits = 0;
        if (pw.length > 0) {
          let pool = 0;
          if (/[a-z]/.test(pw)) pool += 26;
          if (/[A-Z]/.test(pw)) pool += 26;
          if (/[0-9]/.test(pw)) pool += 10;
          if (/[^a-zA-Z0-9]/.test(pw)) pool += 32;
          bits = pool > 0 ? Math.log2(pool) * pw.length : 0;
        }
        const level = bits < 28 ? 'very_weak' : bits < 36 ? 'weak' : bits < 60 ? 'moderate' : bits < 128 ? 'strong' : 'very_strong';
        const cfg   = strengthConfig[level];
        document.getElementById('str-bar').style.width       = cfg.pct + '%';
        document.getElementById('str-bar').style.background  = cfg.color;
        document.getElementById('str-live-label').textContent = pw.length ? cfg.label : '—';
        document.getElementById('str-live-label').style.color = pw.length ? cfg.color : '';
        document.getElementById('str-live-entropy').textContent = pw.length ? bits.toFixed(1) + ' bits' : '';
      }

      async function doStrengthCheck() {
        const pw = strInput.value;
        if (!pw) return;
        hideEl('str-error');
        try {
          const res  = await fetch(`${API}/password-strength`, {
            method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ password: pw }),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Check failed.');
          renderStrength(data);
        } catch(err) {
          document.getElementById('str-error-text').textContent = err.message;
          showEl('str-error', 'flex');
        }
      }

      function renderStrength(data) {
        const strength = data.strength ?? 'moderate';
        const cfg      = strengthConfig[strength] ?? strengthConfig.moderate;
        const score    = data.score ?? cfg.pct;

        // Score card
        const card = document.getElementById('str-score-card');
        card.style.background = cfg.bg;
        card.style.border     = `1px solid ${cfg.border}`;

        document.getElementById('str-strength-label').textContent = cfg.label;
        document.getElementById('str-strength-label').style.color = cfg.color;
        document.getElementById('str-entropy-label').textContent  =
          `Entropy: ${(data.entropy ?? 0).toFixed(1)} bits  ·  Score: ${score}/100`;
        document.getElementById('str-score-num').textContent = score;

        // Animated circle
        const circle = document.getElementById('str-score-circle');
        circle.style.stroke = cfg.color;
        const circ = 2 * Math.PI * 15.9;
        circle.style.strokeDasharray  = circ;
        circle.style.strokeDashoffset = circ * (1 - score / 100);

        // Character pills
        const pills = document.getElementById('str-char-pills');
        pills.innerHTML = '';
        const checks = [
          ['has_uppercase', 'Uppercase A–Z'],
          ['has_lowercase', 'Lowercase a–z'],
          ['has_digits',    'Digits 0–9'],
          ['has_symbols',   'Symbols'],
        ];
        checks.forEach(([key, label]) => {
          const ok  = data[key] ?? false;
          const span = document.createElement('span');
          span.className = `text-sm font-semibold px-2.5 py-1 rounded-lg border ${ok
            ? 'bg-fn-green/10 border-fn-green/25 text-fn-green'
            : 'bg-fn-text/6 border-fn-text/10 text-fn-text3'}`;
          span.innerHTML = `${ok ? '✓' : '✗'} ${label}`;
          pills.appendChild(span);
        });

        // Crack time
        if (data.crack_time) {
          renderCrackTime('str-crack-grid', data.crack_time);
        }

        // Issues
        const allIssues = [...(data.issues ?? []), ...(data.suggestions ?? [])];
        if (allIssues.length > 0) {
          const list = document.getElementById('str-issues-list');
          list.innerHTML = '';
          allIssues.forEach(issue => {
            const li = document.createElement('li');
            li.className = 'text-sm text-fn-text2 flex items-start gap-1.5';
            li.innerHTML = `<span class="text-fn-amber mt-0.5">•</span>${escHtml(issue)}`;
            list.appendChild(li);
          });
          showEl('str-issues-wrap');
        } else {
          hideEl('str-issues-wrap');
        }

        showEl('str-result');
      }

      // ── Shared crack time renderer ──
      const crackScenarios = [
        ['online_throttled',   'Online (throttled)'],
        ['online_unthrottled', 'Online (fast)'],
        ['offline_slow',       'Offline (slow hash)'],
        ['offline_fast',       'Offline (GPU)'],
        ['massive_attack',     'Massive attack'],
      ];

      function renderCrackTime(gridId, crackTime) {
        const grid = document.getElementById(gridId);
        grid.innerHTML = '';
        crackScenarios.forEach(([key, label]) => {
          if (!crackTime[key]) return;
          const div = document.createElement('div');
          div.className = 'crack-row';
          div.innerHTML = `<span class="crack-scenario">${label}</span><span class="crack-value">${escHtml(crackTime[key])}</span>`;
          grid.appendChild(div);
        });
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
      function setLoading(btnId, label) {
        const btn = document.getElementById(btnId); if(!btn) return;
        btn.disabled = true;
        btn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> ${label}`;
      }
      function resetLoading(btnId, html) {
        const btn = document.getElementById(btnId); if(!btn) return;
        btn.disabled = false; btn.innerHTML = html;
      }
      function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

    }); // end DOMContentLoaded
    </script>
@endpush

@endsection
