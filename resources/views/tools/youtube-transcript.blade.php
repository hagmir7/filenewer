@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ TOOL CARD ══ --}}
<section class="pb-8 sm:pb-16 overflow-x-hidden">
    <div class="max-w-5xl mx-auto px-3 sm:px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div
                class="flex items-center justify-center gap-0 px-2 sm:px-8 py-3 sm:py-5 border-b border-fn-text/7 bg-fn-surface2 overflow-x-auto">
                @foreach([['1','Paste URL'],['2','Fetching'],['3','Result']] as [$n, $label])
                <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-1 sm:gap-2 shrink-0"
                    id="step-{{ $n }}">
                    <div
                        class="step-dot w-4 h-4 sm:w-6 sm:h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                        <span class="text-[10px] sm:text-sm font-bold">{{ $n }}</span>
                    </div>
                    <span
                        class="step-label text-[10px] sm:text-sm font-semibold text-fn-text3 transition-colors whitespace-nowrap">{{
                        $label }}</span>
                </div>
                @if($n !== '3')
                <div class="w-3 sm:w-10 h-px bg-fn-text/10 mx-1 sm:mx-2 shrink-0"></div>
                @endif
                @endforeach
            </div>

            <div class="p-3 sm:p-8 lg:p-10">

                {{-- ── STATE: Input ── --}}
                <div id="state-upload">

                    {{-- URL input --}}
                    <div class="mb-4 sm:mb-5">
                        <label for="yt-url" class="text-xs font-semibold text-fn-text2 block mb-2">YouTube URL</label>

                        {{-- On mobile: stacked input + button; on sm+: inline --}}
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="relative flex-1 min-w-0">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                        class="text-fn-red">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                </div>
                                <input type="url" id="yt-url" autocomplete="off" spellcheck="false"
                                    placeholder="https://youtube.com/watch?v=..."
                                    class="w-full min-w-0 bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm rounded-xl pl-9 pr-3 py-3 sm:py-3.5 focus:outline-none focus:border-fn-red/40 placeholder:text-fn-text3/50 transition-colors" />
                            </div>
                            <button type="button" id="btn-paste-url"
                                class="flex items-center justify-center gap-1.5 px-4 py-3 bg-fn-surface border border-fn-text/10 text-fn-text2 hover:text-fn-text text-sm font-semibold rounded-xl transition-all shrink-0">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <rect x="8" y="2" width="8" height="4" rx="1" />
                                </svg>
                                Paste URL
                            </button>
                        </div>

                        <div class="mt-1.5">
                            <span id="url-status" class="text-xs text-fn-text3 break-words">Supports youtube.com,
                                youtu.be, Shorts, and embed URLs</span>
                        </div>
                    </div>

                    {{-- Options --}}
                    <div class="p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-4 sm:mb-5">
                        <div class="flex items-center justify-between mb-3 gap-2">
                            <p class="text-sm font-semibold text-fn-text2">Transcript Settings</p>
                            <span class="text-xs text-fn-text3 shrink-0">Optional</span>
                        </div>

                        {{-- Language selects: side by side on all screens --}}
                        <div class="grid grid-cols-2 gap-2 sm:gap-3 mb-3">
                            <div class="min-w-0">
                                <label for="opt-language"
                                    class="text-xs font-semibold text-fn-text2 block mb-1.5">Language</label>
                                <select id="opt-language"
                                    class="w-full min-w-0 bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-2 sm:px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer truncate">
                                    <option value="en" selected>English</option>
                                    <option value="ar">Arabic (عربي)</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                    <option value="es">Spanish</option>
                                    <option value="it">Italian</option>
                                    <option value="pt">Portuguese</option>
                                    <option value="zh">Chinese</option>
                                    <option value="ja">Japanese</option>
                                    <option value="ru">Russian</option>
                                </select>
                            </div>
                            <div class="min-w-0">
                                <label for="opt-translate"
                                    class="text-xs font-semibold text-fn-text2 block mb-1.5">Translate to</label>
                                <select id="opt-translate"
                                    class="w-full min-w-0 bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-2 sm:px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer truncate">
                                    <option value="" selected>No translation</option>
                                    <option value="en">English</option>
                                    <option value="ar">Arabic (عربي)</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                    <option value="es">Spanish</option>
                                    <option value="it">Italian</option>
                                    <option value="pt">Portuguese</option>
                                    <option value="zh">Chinese</option>
                                    <option value="ja">Japanese</option>
                                    <option value="ru">Russian</option>
                                </select>
                            </div>
                        </div>

                        {{-- Output format: 2 cols on mobile, 4 on sm+ --}}
                        <div class="mb-3">
                            <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Output format</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5">
                                @foreach([
                                ['fmt-text', 'text', '📝', 'Plain text', 'Reading & copying', true],
                                ['fmt-srt', 'srt', '🎬', 'SRT', 'Video players', false],
                                ['fmt-vtt', 'vtt', '🌐', 'VTT', 'HTML5 video', false],
                                ['fmt-json', 'json', '⚙️', 'JSON', 'Processing', false],
                                ] as [$fid, $fval, $ficon, $flabel, $fdesc, $fdefault])
                                <label id="{{ $fid }}-wrap"
                                    class="fmt-card {{ $fdefault ? 'active' : '' }} flex items-center gap-1.5 sm:gap-2 px-2 sm:px-2.5 py-2 border rounded-lg cursor-pointer transition-all min-w-0">
                                    <input type="radio" name="output_format" value="{{ $fval }}" {{ $fdefault
                                        ? 'checked' : '' }} class="sr-only fmt-radio" />
                                    <span class="text-sm sm:text-base shrink-0">{{ $ficon }}</span>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-fn-text leading-none truncate">{{ $flabel }}
                                        </p>
                                        <p class="text-xs text-fn-text3 leading-tight mt-0.5 hidden sm:block truncate">
                                            {{ $fdesc }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Toggles: 2 cols on sm+ --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                            @foreach([
                            ['opt-timestamps', 'Include timestamps', 'Add [HH:MM:SS] before each line', false],
                            ['opt-auto', 'Auto-captions', 'Fall back to auto-generated captions', true],
                            ] as [$tid, $tlabel, $tdesc, $tdefault])
                            <label
                                class="flex items-center gap-2 cursor-pointer select-none px-3 py-2 bg-fn-surface border border-fn-text/10 rounded-lg hover:border-fn-blue/25 transition-colors">
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
                                    <p class="text-xs text-fn-text3 leading-tight hidden sm:block">{{ $tdesc }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Error banner --}}
                    <div id="upload-error"
                        class="hidden mb-4 items-start gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-fn-red shrink-0 mt-0.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="error-text" class="break-words">Something went wrong.</span>
                    </div>

                    <button id="convert-btn" type="button" disabled
                        class="w-full py-3.5 text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:opacity-90 hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2"
                        style="background: oklch(52% 0.22 25);">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                        Get Transcript
                    </button>
                </div>

                {{-- ── STATE: Fetching ── --}}
                <div id="state-converting" class="hidden text-center py-4 sm:py-6">
                    <div class="flex items-center justify-center gap-2 sm:gap-5 mb-5 sm:mb-8">
                        <div class="w-11 h-11 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center shrink-0"
                            style="background: oklch(52% 0.22 25 / 12%); border: 1px solid oklch(52% 0.22 25 / 25%)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                style="color: oklch(52% 0.22 25)">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
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
                            class="w-11 h-11 sm:w-16 sm:h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-xl sm:text-3xl shrink-0">
                            📝</div>
                    </div>

                    <h2 class="text-base sm:text-xl font-bold mb-2 px-2" id="fetching-title">Fetching Transcript…</h2>
                    <p class="text-fn-text3 text-xs sm:text-sm mb-5 sm:mb-8 px-4 break-words" id="converting-subtitle">
                        Connecting to YouTube &amp; extracting captions</p>

                    <div class="max-w-md mx-auto mb-3 px-2">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-between max-w-md mx-auto text-sm text-fn-text3 mb-5 sm:mb-8 px-2 gap-2">
                        <span id="progress-label" class="text-xs sm:text-sm truncate">Starting…</span>
                        <span id="progress-pct"
                            class="font-mono font-semibold text-fn-text2 text-xs sm:text-sm shrink-0">0%</span>
                    </div>

                    <div class="max-w-xs mx-auto flex flex-col gap-3 text-left px-2">
                        @foreach([
                        ['proc-1', 'Validating &amp; extracting video ID'],
                        ['proc-2', 'Fetching transcript via API'],
                        ['proc-3', 'Processing language &amp; format'],
                        ['proc-4', 'Building output'],
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
                            <span class="text-xs sm:text-sm text-fn-text3 break-words min-w-0">{!! $plabel !!}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Whisper fallback notice --}}
                    <div id="whisper-notice"
                        class="hidden max-w-sm mx-auto mt-6 p-3 bg-fn-amber/6 border border-fn-amber/20 rounded-xl flex items-start gap-2 text-left">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-fn-amber shrink-0 mt-0.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <p class="text-xs text-fn-text2 leading-relaxed break-words">Captions not found — falling back
                            to <span class="font-semibold">Whisper AI</span> transcription. This may take a minute…</p>
                    </div>
                </div>

                {{-- ── STATE: Result ── --}}
                <div id="state-download" class="hidden py-2">

                    {{-- Video info bar --}}
                    <div
                        class="flex items-start gap-2 sm:gap-3 mb-4 sm:mb-5 p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center shrink-0"
                            style="background: oklch(52% 0.22 25 / 12%); border: 1px solid oklch(52% 0.22 25 / 22%)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"
                                style="color: oklch(52% 0.22 25)">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm truncate" id="video-title">—</p>
                            <div class="flex flex-wrap items-center gap-x-2 sm:gap-x-3 gap-y-1 mt-1"
                                id="video-meta-chips"></div>
                        </div>
                        <a id="video-link" href="#" target="_blank" rel="noopener"
                            class="shrink-0 flex items-center gap-1 px-2 sm:px-2.5 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                <polyline points="15 3 21 3 21 9" />
                                <line x1="10" y1="14" x2="21" y2="3" />
                            </svg>
                            <span class="hidden sm:inline">Watch</span>
                        </a>
                    </div>

                    {{-- Toolbar: stacks on mobile --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-2">
                        <div class="flex items-center gap-2 flex-wrap min-w-0">
                            <span class="text-xs font-semibold text-fn-text2 truncate" id="result-format-label">Plain
                                text</span>
                            <span id="result-stats" class="text-xs text-fn-text3 shrink-0"></span>
                        </div>
                        <div class="grid grid-cols-3 sm:flex sm:items-center gap-1.5">
                            <button type="button" id="btn-copy"
                                class="flex items-center justify-center gap-1.5 px-2 sm:px-3 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg hover:text-fn-text transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                    <rect x="9" y="9" width="13" height="13" rx="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                <span id="copy-label" class="truncate">Copy</span>
                            </button>
                            <button type="button" id="btn-download-txt"
                                class="flex items-center justify-center gap-1.5 px-2 sm:px-3 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg hover:text-fn-text transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                <span id="download-ext-label" class="truncate">Download .txt</span>
                            </button>
                            <button type="button" onclick="resetConverter()"
                                class="flex items-center justify-center gap-1.5 px-2 sm:px-3 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg hover:text-fn-text transition-all">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                    <polyline points="1 4 1 10 7 10" />
                                    <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                                </svg>
                                New
                            </button>
                        </div>
                    </div>

                    {{-- Transcript output --}}
                    <pre id="transcript-output"
                        class="w-full bg-fn-surface2 border border-fn-text/10 rounded-xl px-3 sm:px-5 py-4 text-xs sm:text-sm text-fn-text2 leading-relaxed overflow-auto max-h-64 sm:max-h-[32rem] whitespace-pre-wrap break-words font-sans"></pre>

                    {{-- Method badge + privacy note --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-3 gap-2">
                        <div class="flex items-center gap-1.5" id="method-badge"></div>
                        <p class="text-fn-text3 text-xs flex items-start gap-1.5">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-green shrink-0 mt-0.5">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            <span>Transcript not stored — cleared after your session ends.</span>
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


{{-- ══ HOW IT WORKS ══ --}}
<section class="py-8 sm:py-12 border-t border-fn-text/7 bg-fn-surface2 overflow-x-hidden">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <h2 class="text-lg font-bold mb-1 text-center">How It Works</h2>
        <p class="text-fn-text3 text-sm text-center mb-5 sm:mb-8">Two-strategy approach for maximum coverage</p>
        <div class="grid sm:grid-cols-2 gap-3 sm:gap-4">
            <div class="p-4 sm:p-5 bg-fn-surface border border-fn-text/8 rounded-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-lg shrink-0">
                        ⚡</div>
                    <div class="min-w-0">
                        <p class="font-bold text-sm">Strategy 1 — Transcript API</p>
                        <p class="text-xs text-fn-green font-semibold">Fast · ⭐⭐⭐⭐</p>
                    </div>
                </div>
                <p class="text-xs text-fn-text2 leading-relaxed mb-3">Directly fetches the caption track embedded by the
                    video creator or auto-generated by YouTube. Instant — no audio processing needed.</p>
                <div class="flex flex-col gap-1 text-xs text-fn-text3">
                    <div class="flex items-start gap-1.5"><svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-green shrink-0 mt-0.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg> <span>No extra dependencies</span></div>
                    <div class="flex items-start gap-1.5"><svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-green shrink-0 mt-0.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg> <span>Language selection &amp; translation</span></div>
                    <div class="flex items-start gap-1.5"><svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-green shrink-0 mt-0.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg> <span>Supports auto-generated captions</span></div>
                </div>
            </div>
            <div class="p-4 sm:p-5 bg-fn-surface border border-fn-text/8 rounded-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-lg shrink-0">
                        🎙️</div>
                    <div class="min-w-0">
                        <p class="font-bold text-sm">Strategy 2 — Whisper AI</p>
                        <p class="text-xs text-fn-purple font-semibold">Slower · ⭐⭐⭐⭐⭐</p>
                    </div>
                </div>
                <p class="text-xs text-fn-text2 leading-relaxed mb-3">Falls back to downloading the audio and running
                    OpenAI Whisper for AI-powered speech-to-text when no captions are available.</p>
                <div class="flex flex-col gap-1 text-xs text-fn-text3">
                    <div class="flex items-start gap-1.5"><svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-green shrink-0 mt-0.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg> <span>Works on any video, even without captions</span></div>
                    <div class="flex items-start gap-1.5"><svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-green shrink-0 mt-0.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg> <span>Highest transcription accuracy</span></div>
                    <div class="flex items-start gap-1.5"><svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-amber shrink-0 mt-0.5">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg> <span>Takes longer — audio download + AI processing</span></div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ══ OUTPUT FORMATS ══ --}}
<section class="py-8 sm:py-12 border-t border-fn-text/7 bg-fn-surface overflow-x-hidden">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <h2 class="text-lg font-bold mb-1 text-center">Output Formats</h2>
        <p class="text-fn-text3 text-sm text-center mb-5 sm:mb-6">Choose the format that fits your workflow</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3">
            @foreach([
            ['📝', 'text', 'Plain text', 'Reading & copying', 'Simple readable transcript, optionally with timestamps'],
            ['🎬', 'srt', 'SRT', 'Video players', 'SubRip format — the standard for most video editing tools'],
            ['🌐', 'vtt', 'VTT', 'HTML5 video', 'WebVTT — used by browsers and HTML5 video elements'],
            ['⚙️', 'json', 'JSON', 'Processing', 'Raw segments array with start, duration, and text fields'],
            ] as [$icon, $val, $name, $use, $desc])
            <div class="p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl min-w-0">
                <div class="text-xl sm:text-2xl mb-1.5 sm:mb-2">{{ $icon }}</div>
                <p class="font-bold text-sm truncate">{{ $name }}</p>
                <p class="text-xs text-fn-blue-l font-semibold mt-0.5 break-words">{{ $use }}</p>
                <p class="text-xs text-fn-text3 mt-1.5 leading-relaxed hidden sm:block">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-8 sm:py-16 border-t border-fn-text/7 bg-fn-surface2 overflow-x-hidden">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <h2 class="text-xl sm:text-2xl font-bold tracking-tight mb-5 sm:mb-8 text-center">Frequently Asked Questions
        </h2>
        <div class="space-y-2 sm:space-y-3">
            @foreach([
            ['Which YouTube URL formats are supported?', 'Standard watch URLs (youtube.com/watch?v=...), short URLs
            (youtu.be/...), Shorts (youtube.com/shorts/...), embed URLs (youtube.com/embed/...), and even bare URLs
            without the protocol (youtube.com/watch?v=...) are all accepted.'],
            ['What if the video has no captions?', 'If no caption track is found, the tool automatically falls back to
            Whisper AI — it downloads the audio and runs OpenAI\'s speech-to-text model. This produces a high-quality
            transcript for almost any video, though it takes longer than caption extraction.'],
            ['Can I get transcripts in languages other than English?', 'Yes — select the transcript language to fetch an
            existing caption track in that language. You can also translate the transcript to another language after
            fetching it by selecting a target in the "Translate to" field.'],
            ['What is the difference between SRT and VTT?', 'SRT (SubRip) is the most widely supported subtitle format —
            compatible with VLC, Premiere Pro, DaVinci Resolve, and most video tools. VTT (WebVTT) is the standard for
            HTML5 video elements and browser-based players. Both contain timed captions; the syntax differs slightly.'],
            ['What does auto-captions do?', 'When enabled (default), the tool will also check for YouTube\'s
            automatically generated captions if no manual captions are found in the requested language. Auto-captions
            are generally accurate for clearly spoken English and many other languages.'],
            ['Is the transcript stored or logged?', 'No. The transcript content is returned directly to your browser and
            is never stored, indexed, or shared. It is cleared when you close or refresh the page.'],
            ] as [$q, $a])
            <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                <button type="button"
                    class="faq-btn w-full flex items-center justify-between gap-3 px-4 sm:px-5 py-3.5 sm:py-4 text-left hover:bg-fn-surface transition-colors">
                    <span class="font-semibold text-sm pr-1">{{ $q }}</span>
                    <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div class="faq-body hidden px-4 sm:px-5 pb-4">
                    <p class="text-fn-text2 text-sm leading-relaxed break-words">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<x-tools-content :tool="$tool" />
<x-tools-section />

<style>
    .fmt-card {
        border-color: oklch(0% 0 0 / 10%);
        background: var(--fn-surface);
        transition: all .15s;
    }

    .fmt-card.active {
        border-color: oklch(49% 0.24 264 / 50%);
        background: oklch(49% 0.24 264 / 7%);
    }

    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 11px;
        font-weight: 600;
        color: var(--fn-text3);
        max-width: 100%;
    }

    /* Transcript scrollbar */
    #transcript-output::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    #transcript-output::-webkit-scrollbar-track {
        background: transparent;
    }

    #transcript-output::-webkit-scrollbar-thumb {
        background: oklch(0% 0 0 / 15%);
        border-radius: 4px;
    }

    /* Guard against any accidental horizontal overflow on small screens */
    #state-upload,
    #state-converting,
    #state-download {
        max-width: 100%;
    }

    #video-title,
    #transcript-output,
    .meta-chip {
        overflow-wrap: break-word;
        word-break: break-word;
    }

    /* Extra-narrow phones (< 380px) — tighten spacing & type a bit further */
    @media (max-width: 380px) {
        .step-label {
            font-size: 9px;
        }

        #convert-btn {
            font-size: 14px;
        }

        #transcript-output {
            font-size: 11px;
            padding-left: 10px;
            padding-right: 10px;
        }
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const urlInput    = document.getElementById('yt-url');
  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let lastTranscript = '';
  let lastFilename   = 'transcript.txt';

  // ── URL paste button ──
  document.getElementById('btn-paste-url').addEventListener('click', async () => {
    try { urlInput.value = await navigator.clipboard.readText(); urlInput.dispatchEvent(new Event('input')); } catch(_) {}
  });

  // ── URL validation ──
  urlInput.addEventListener('input', () => {
    const val    = urlInput.value.trim();
    const status = document.getElementById('url-status');
    const vid    = extractVideoId(val);

    if (!val) {
      status.innerHTML = '<span class="text-fn-text3">Supports youtube.com, youtu.be, Shorts, and embed URLs</span>';
      convertBtn.disabled = true;
      return;
    }
    if (vid) {
      status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5 flex-wrap">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><polyline points="20 6 9 17 4 12"/></svg>
        Valid URL · ID: <code class="font-mono break-all">${vid}</code>
      </span>`;
      convertBtn.disabled = false;
      hideError();
    } else {
      status.innerHTML = '<span class="text-fn-red">Not a recognised YouTube URL</span>';
      convertBtn.disabled = true;
    }
  });

  // ── Format cards ──
  document.querySelectorAll('.fmt-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.fmt-card').forEach(c => c.classList.remove('active'));
      radio.closest('.fmt-card').classList.add('active');
      const tsWrap = document.getElementById('opt-timestamps').closest('label');
      const isText = radio.value === 'text';
      tsWrap.style.opacity       = isText ? '1' : '0.4';
      tsWrap.style.pointerEvents = isText ? '' : 'none';
    });
  });

  // ── Fetch transcript ──
  convertBtn.addEventListener('click', startFetch);
  urlInput.addEventListener('keydown', e => { if (e.key === 'Enter' && !convertBtn.disabled) startFetch(); });

  async function startFetch() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const url            = urlInput.value.trim();
    const language       = document.getElementById('opt-language').value;
    const translateTo    = document.getElementById('opt-translate').value || null;
    const outputFormat   = document.querySelector('input[name="output_format"]:checked').value;
    const inclTimestamps = document.getElementById('opt-timestamps').checked;
    const autoCaptions   = document.getElementById('opt-auto').checked;

    document.getElementById('converting-subtitle').textContent =
      `Fetching ${outputFormat.toUpperCase()} · ${language}${translateTo ? ' → ' + translateTo : ''}`;

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 400, 'Validating & extracting video ID…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 55, 1000, 'Fetching transcript via API…');
    }, 500);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 78, 700, 'Processing language & format…');
    }, 1600);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 92, 500, 'Building output…');
    }, 2400);
    const whisperTimer = setTimeout(() => {
      document.getElementById('whisper-notice').classList.remove('hidden');
      document.getElementById('fetching-title').textContent = 'Running Whisper AI…';
    }, 8000);

    const payload = {
      url,
      language,
      output_format:      outputFormat,
      include_timestamps: inclTimestamps && outputFormat === 'text',
      auto_captions:      autoCaptions,
    };
    if (translateTo) payload.translate_to = translateTo;

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/youtube-transcript/', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(payload),
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4); clearTimeout(whisperTimer);

      if (!res.ok) {
        let msg = 'Failed to fetch transcript. The video may have captions disabled.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const data = await res.json();

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(92, 100, 300, 'Done!');

      showResult(data, outputFormat, url);
      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4); clearTimeout(whisperTimer);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function showResult(data, format, url) {
    document.getElementById('video-title').textContent = data.title || 'Untitled Video';
    document.getElementById('video-link').href = data.url || url;

    const chips = document.getElementById('video-meta-chips');
    chips.innerHTML = '';
    [
      data.duration_str  && ['🕐', data.duration_str],
      data.word_count    && ['📝', Number(data.word_count).toLocaleString() + ' words'],
      data.segment_count && ['📋', data.segment_count + ' seg'],
      data.language      && ['🌐', data.language.toUpperCase()],
    ].filter(Boolean).forEach(([icon, label]) => {
      const chip = document.createElement('span');
      chip.className = 'meta-chip';
      chip.innerHTML = `<span>${icon}</span><span>${label}</span>`;
      chips.appendChild(chip);
    });

    const formatLabels = { text: 'Plain text', srt: 'SRT subtitles', vtt: 'WebVTT subtitles', json: 'JSON segments' };
    const extMap       = { text: 'txt', srt: 'srt', vtt: 'vtt', json: 'json' };
    document.getElementById('result-format-label').textContent = formatLabels[format] || format;
    document.getElementById('result-stats').textContent =
      data.char_count ? `${Number(data.char_count).toLocaleString()} chars` : '';

    const ext = extMap[format] || 'txt';
    document.getElementById('download-ext-label').textContent = `.${ext}`;
    lastFilename = `${(data.video_id || 'transcript').replace(/[^a-z0-9]/gi, '_').toLowerCase()}_transcript.${ext}`;

    const content = format === 'json'
      ? JSON.stringify(data.transcript ?? data, null, 2)
      : (data.transcript || '');
    lastTranscript = content;
    document.getElementById('transcript-output').textContent = content;

    const badge = document.getElementById('method-badge');
    badge.innerHTML = '';
    if (data.method) {
      const isWhisper = data.method.includes('whisper');
      const pill = document.createElement('span');
      pill.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold';
      pill.style.cssText = isWhisper
        ? 'background: oklch(60% 0.22 295 / 8%); border: 1px solid oklch(60% 0.22 295 / 25%); color: oklch(55% 0.22 295)'
        : 'background: oklch(67% 0.18 162 / 8%); border: 1px solid oklch(67% 0.18 162 / 25%); color: oklch(50% 0.18 162)';
      pill.innerHTML = `${isWhisper ? '🎙️' : '⚡'} ${data.method}`;
      badge.appendChild(pill);
    }
  }

  document.getElementById('btn-copy').addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(lastTranscript);
      const label = document.getElementById('copy-label');
      label.textContent = 'Copied!';
      setTimeout(() => { label.textContent = 'Copy'; }, 2000);
    } catch(_) {}
  });

  document.getElementById('btn-download-txt').addEventListener('click', () => {
    const blob = new Blob([lastTranscript], { type: 'text/plain;charset=utf-8' });
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = lastFilename;
    a.click();
    URL.revokeObjectURL(a.href);
  });

  function extractVideoId(url) {
    if (!url) return null;
    const s = url.trim().replace(/^(?!https?:\/\/)/i, 'https://');
    try {
      const u = new URL(s);
      if (u.hostname === 'youtu.be') return u.pathname.slice(1).split('?')[0] || null;
      const v = u.searchParams.get('v');
      if (v) return v;
      const m = u.pathname.match(/\/(embed|shorts|v)\/([^/?&]+)/);
      if (m) return m[2];
    } catch(_) {}
    const m = url.match(/(?:v=|youtu\.be\/|embed\/|shorts\/)([a-zA-Z0-9_-]{11})/);
    return m ? m[1] : null;
  }

  function scrollToCard() {
    const card = document.querySelector('#state-converting')?.closest('.bg-fn-surface');
    if (card) window.scrollTo({ top: card.getBoundingClientRect().top + window.pageYOffset - 80, behavior: 'smooth' });
  }

  function showState(state) {
    ['upload', 'converting', 'download'].forEach(s => {
      document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
    });
    document.getElementById('whisper-notice').classList.add('hidden');
    document.getElementById('fetching-title').textContent = 'Fetching Transcript…';
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

  window.resetConverter = function () {
    urlInput.value     = '';
    lastTranscript     = '';
    lastFilename       = 'transcript.txt';
    document.getElementById('url-status').innerHTML = '<span class="text-fn-text3">Supports youtube.com, youtu.be, Shorts, and embed URLs</span>';
    document.getElementById('opt-language').value   = 'en';
    document.getElementById('opt-translate').value  = '';
    document.getElementById('opt-timestamps').checked = false;
    document.getElementById('opt-auto').checked       = true;
    document.querySelector('input[name="output_format"][value="text"]').checked = true;
    document.querySelectorAll('.fmt-card').forEach(c => c.classList.remove('active'));
    document.getElementById('fmt-text-wrap').classList.add('active');
    document.getElementById('opt-timestamps').closest('label').style.opacity = '1';
    document.getElementById('opt-timestamps').closest('label').style.pointerEvents = '';
    convertBtn.disabled = true;
    hideError();
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
