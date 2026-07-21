@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-10 sm:pb-16">
    <div class="max-w-5xl mx-auto px-3 sm:px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-xl sm:rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-3 sm:px-8 py-3 sm:py-5 border-b border-fn-text/7 bg-fn-surface2 overflow-x-auto">
                @foreach([['1','Add Sources'],['2','Processing'],['3','Download']] as [$n, $label])
                <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-1.5 sm:gap-2 shrink-0" id="step-{{ $n }}">
                    <div class="step-dot w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                        <span class="text-xs sm:text-sm font-bold">{{ $n }}</span>
                    </div>
                    <span class="step-label text-xs sm:text-sm font-semibold text-fn-text3 transition-colors whitespace-nowrap">{{ $label }}</span>
                </div>
                @if($n !== '3')
                <div class="w-4 sm:w-10 h-px bg-fn-text/10 mx-1 sm:mx-2 shrink-0"></div>
                @endif
                @endforeach
            </div>

            <div class="p-3 sm:p-6 lg:p-10">

                {{-- ── STATE: Upload ── --}}
                <div id="state-upload">

                    <div class="grid sm:grid-cols-2 gap-3 sm:gap-4">

                        {{-- ══ VIDEO SOURCE ══ --}}
                        <div class="p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <div class="flex items-center gap-2 mb-2 sm:mb-3">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-blue-l shrink-0"><rect x="2" y="6" width="15" height="12" rx="2"/><polygon points="22 8 17 12 22 16 22 8"/></svg>
                                <p class="text-xs sm:text-sm font-semibold text-fn-text2">Video source</p>
                            </div>

                            <div class="flex items-center gap-1 p-1 bg-fn-surface border border-fn-text/8 rounded-lg mb-2 sm:mb-3 w-fit">
                                <button type="button" data-src="video" data-mode="file" class="src-tab active flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-md text-xs font-semibold transition-all">Upload</button>
                                <button type="button" data-src="video" data-mode="url" class="src-tab flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-md text-xs font-semibold transition-all">URL</button>
                            </div>

                            <div id="video-panel-file">
                                <div id="video-drop" class="drop-zone border-2 border-dashed border-fn-text/15 rounded-xl p-4 sm:p-6 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-2 text-fn-blue-l"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <p class="text-xs sm:text-sm font-semibold">Drop video or click</p>
                                    <p class="text-fn-text3 text-xs mt-1">MP4, MOV, AVI…</p>
                                    <input type="file" id="video-file-input" accept="video/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                                <div id="video-file-preview" class="hidden mt-2 sm:mt-3 p-2.5 bg-fn-surface border border-fn-text/8 rounded-lg flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center shrink-0 text-base">🎬</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-xs truncate" id="video-file-name">video.mp4</p>
                                        <p class="text-fn-text3 text-xs" id="video-file-meta">—</p>
                                    </div>
                                    <button type="button" id="video-file-remove" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div id="video-panel-url" class="hidden">
                                <input type="url" id="video-url-input" spellcheck="false" autocomplete="off"
                                    placeholder="https://example.com/video.mp4"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2.5 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                            </div>
                        </div>

                        {{-- ══ AUDIO SOURCE ══ --}}
                        <div class="p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <div class="flex items-center gap-2 mb-2 sm:mb-3">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-purple shrink-0"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                                <p class="text-xs sm:text-sm font-semibold text-fn-text2">Voice / audio source</p>
                            </div>

                            <div class="flex items-center gap-1 p-1 bg-fn-surface border border-fn-text/8 rounded-lg mb-2 sm:mb-3 w-fit">
                                <button type="button" data-src="audio" data-mode="file" class="src-tab active flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-md text-xs font-semibold transition-all">Upload</button>
                                <button type="button" data-src="audio" data-mode="url" class="src-tab flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-md text-xs font-semibold transition-all">URL</button>
                                <button type="button" data-src="audio" data-mode="youtube" class="src-tab flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-md text-xs font-semibold transition-all">YouTube</button>
                            </div>

                            <div id="audio-panel-file">
                                <div id="audio-drop" class="drop-zone border-2 border-dashed border-fn-text/15 rounded-xl p-4 sm:p-6 text-center cursor-pointer hover:border-fn-purple/40 hover:bg-fn-purple/4 relative">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-2 text-fn-purple"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <p class="text-xs sm:text-sm font-semibold">Drop audio or click</p>
                                    <p class="text-fn-text3 text-xs mt-1">MP3, WAV, M4A…</p>
                                    <input type="file" id="audio-file-input" accept="audio/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                                <div id="audio-file-preview" class="hidden mt-2 sm:mt-3 p-2.5 bg-fn-surface border border-fn-text/8 rounded-lg flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center shrink-0 text-base">🎙️</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-xs truncate" id="audio-file-name">voice.mp3</p>
                                        <p class="text-fn-text3 text-xs" id="audio-file-meta">—</p>
                                    </div>
                                    <button type="button" id="audio-file-remove" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div id="audio-panel-url" class="hidden">
                                <input type="url" id="audio-url-input" spellcheck="false" autocomplete="off"
                                    placeholder="https://example.com/voice.mp3"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2.5 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                            </div>

                            <div id="audio-panel-youtube" class="hidden">
                                <input type="url" id="audio-youtube-input" spellcheck="false" autocomplete="off"
                                    placeholder="https://youtu.be/… or /watch?v=…"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2.5 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                            </div>
                        </div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-3 sm:mt-5 p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                            <p class="text-xs sm:text-sm font-semibold text-fn-text2">Mix Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="flex flex-col gap-2.5 sm:gap-3">
                            <label class="flex items-center gap-2 cursor-pointer select-none px-3 py-2 bg-fn-surface border border-fn-text/10 rounded-lg hover:border-fn-blue/25 transition-colors">
                                <div class="toggle-wrap relative w-8 h-4 shrink-0">
                                    <input type="checkbox" id="opt-replace" checked class="sr-only peer" />
                                    <div class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors"></div>
                                    <div class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-fn-text2">Replace original audio</p>
                                    <p class="text-xs text-fn-text3 leading-tight">Off mixes voice with the original track instead</p>
                                </div>
                            </label>

                            <div id="volume-controls" class="hidden grid sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label for="opt-vol-video" class="text-xs font-semibold text-fn-text2">Original audio volume</label>
                                        <span class="text-xs font-mono text-fn-text3" id="vol-video-val">0.3</span>
                                    </div>
                                    <input type="range" id="opt-vol-video" min="0" max="1" step="0.1" value="0.3" class="w-full accent-fn-blue" />
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label for="opt-vol-audio" class="text-xs font-semibold text-fn-text2">Voice volume</label>
                                        <span class="text-xs font-mono text-fn-text3" id="vol-audio-val">1.0</span>
                                    </div>
                                    <input type="range" id="opt-vol-audio" min="0" max="1" step="0.1" value="1.0" class="w-full accent-fn-purple" />
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Output filename <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-filename" placeholder="output.mp4"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>
                                <div>
                                    <label for="opt-format" class="text-xs font-semibold text-fn-text2 block mb-1.5">Output format</label>
                                    <select id="opt-format"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40">
                                        <option value="mp4">MP4</option>
                                        <option value="avi">AVI</option>
                                        <option value="mkv">MKV</option>
                                        <option value="webm">WebM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Error banner --}}
                    <div id="upload-error"
                        class="hidden mt-3 sm:mt-4 items-center gap-2.5 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-xs sm:text-sm text-fn-text2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-fn-red shrink-0" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span id="error-text">Something went wrong.</span>
                    </div>

                    <button id="convert-btn" type="button" disabled
                        class="mt-4 sm:mt-6 w-full py-3 sm:py-3.5 bg-fn-blue text-white font-bold text-sm sm:text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                        Add Voice to Video
                    </button>
                </div>

                {{-- ── STATE: Duration mismatch ── --}}
                <div id="state-mismatch" class="hidden py-2 sm:py-4">
                    <div class="flex items-center gap-2.5 sm:gap-3 mb-4 sm:mb-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/25 flex items-center justify-center text-xl sm:text-2xl shrink-0">⏱️</div>
                        <div>
                            <h2 class="text-base sm:text-xl font-bold">Durations don't match</h2>
                            <p class="text-fn-text3 text-xs sm:text-sm">Choose which side to speed-adjust before merging</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5 sm:gap-3 mb-4 sm:mb-6">
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl text-center">
                            <p class="text-xs text-fn-text3 mb-1">Video duration</p>
                            <p class="text-base sm:text-lg font-bold font-mono" id="mismatch-video-dur">—</p>
                        </div>
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl text-center">
                            <p class="text-xs text-fn-text3 mb-1">Audio duration</p>
                            <p class="text-base sm:text-lg font-bold font-mono" id="mismatch-audio-dur">—</p>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-fn-text2 mb-4 sm:mb-6 p-3 bg-fn-amber/6 border border-fn-amber/20 rounded-xl" id="mismatch-suggestion">—</p>

                    <div class="grid sm:grid-cols-2 gap-2.5 sm:gap-3">
                        <button type="button" id="btn-adjust-audio" class="p-3 sm:p-4 text-left bg-fn-surface2 border border-fn-text/10 rounded-xl hover:border-fn-blue/40 hover:bg-fn-blue/4 transition-all">
                            <p class="text-xs sm:text-sm font-bold mb-1">Adjust audio speed</p>
                            <p class="text-xs text-fn-text3" id="mismatch-opt-audio">Match audio to video duration</p>
                        </button>
                        <button type="button" id="btn-adjust-video" class="p-3 sm:p-4 text-left bg-fn-surface2 border border-fn-text/10 rounded-xl hover:border-fn-purple/40 hover:bg-fn-purple/4 transition-all">
                            <p class="text-xs sm:text-sm font-bold mb-1">Adjust video speed</p>
                            <p class="text-xs text-fn-text3" id="mismatch-opt-video">Match video to audio duration</p>
                        </button>
                    </div>

                    <button type="button" id="btn-mismatch-back" class="mt-4 sm:mt-5 flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-fn-text3 hover:text-fn-text transition-colors">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        Back to sources
                    </button>
                </div>

                {{-- ── STATE: Processing ── --}}
                <div id="state-converting" class="hidden text-center py-4 sm:py-6">
                    <div class="flex items-center justify-center gap-3 sm:gap-5 mb-5 sm:mb-8">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-fn-blue-l sm:w-7 sm:h-7"><rect x="2" y="6" width="15" height="12" rx="2"/><polygon points="22 8 17 12 22 16 22 8"/></svg>
                        </div>
                        <div class="flex gap-1">
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:0s"></span>
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.15s"></span>
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.3s"></span>
                        </div>
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-xl sm:text-3xl">🎙️</div>
                    </div>

                    <h2 class="text-base sm:text-xl font-bold mb-1.5 sm:mb-2">Merging voice into video…</h2>
                    <p class="text-fn-text3 text-xs sm:text-sm mb-5 sm:mb-8">Checking durations, adjusting speed if needed, and mixing tracks</p>

                    <div class="max-w-md mx-auto mb-2.5 sm:mb-3">
                        <div class="h-1.5 sm:h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-xs sm:text-sm text-fn-text3 mb-5 sm:mb-8">
                        <span id="progress-label">Starting…</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>

                    <div class="max-w-xs mx-auto flex flex-col gap-2.5 sm:gap-3 text-left">
                        @foreach([
                            ['proc-1','Reading video & audio sources'],
                            ['proc-2','Checking durations'],
                            ['proc-3','Adjusting speed & merging'],
                            ['proc-4','Finalizing output file'],
                        ] as [$pid, $plabel])
                        <div class="flex items-center gap-2.5 sm:gap-3" id="{{ $pid }}">
                            <div class="step-dot w-4 h-4 sm:w-5 sm:h-5 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center shrink-0 transition-all duration-300">
                                <svg class="check-icon hidden w-3 h-3 text-fn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <svg class="spin-icon hidden w-3 h-3 text-fn-blue-l spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg>
                            </div>
                            <span class="text-xs sm:text-sm text-fn-text3">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-4 sm:py-6">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-2xl sm:text-4xl mx-auto mb-3 sm:mb-5">✅</div>
                    <h2 class="text-lg sm:text-2xl font-bold mb-1.5 sm:mb-2">Voice Added!</h2>
                    <p class="text-fn-text2 text-xs sm:text-sm mb-4 sm:mb-6">Your merged video is ready to download.</p>

                    <div id="result-sheets-wrap" class="hidden max-w-2xl mx-auto mb-4 sm:mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Output details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-sheets"></div>
                    </div>

                    <div class="max-w-sm mx-auto p-3 sm:p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6 text-left">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg sm:text-2xl shrink-0">🎬</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-xs sm:text-sm truncate" id="output-name">output.mp4</p>
                            <p class="text-fn-text3 text-xs sm:text-sm mt-0.5" id="output-size">Video File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="output.mp4"
                        class="inline-flex items-center gap-2 sm:gap-2.5 px-5 sm:px-8 py-2.5 sm:py-3.5 text-white font-bold text-sm sm:text-base rounded-xl transition-all hover:-translate-y-0.5 mb-3 sm:mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Video
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-3.5 sm:px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs sm:text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                            Do another
                        </button>
                    </div>

                    <p class="mt-4 sm:mt-6 text-fn-text3 text-xs sm:text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green shrink-0"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Your files are encrypted and permanently deleted within 1 hour.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-10 sm:py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-3 sm:px-6">
        <h2 class="text-lg sm:text-2xl font-bold tracking-tight mb-5 sm:mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-2.5 sm:space-y-3">
            @foreach([
                ['What happens if the video and audio durations don\'t match?', 'You get a 422 response with the exact durations, the difference in seconds, and the speed ratios needed. Resubmit the same sources with speed_adjust_target set to "audio" (speeds the voice track up or down) or "video" (speeds the footage up or down) to bring them within 0.5s of each other.'],
                ['What\'s the difference between replace and mix?', 'With replace_audio on (default), the original video audio is dropped entirely and swapped for your voice track. Turning it off mixes the voice with the original audio instead, with independent volume_video and volume_audio controls so you can duck the original track under narration.'],
                ['Can I use a YouTube link as the voice source?', 'Yes — pass any youtube.com/watch or youtu.be link as audio_url and the audio track is extracted automatically. Video sources only accept direct file uploads or HTTP(S) URLs, not YouTube links.'],
                ['What output formats are supported?', 'mp4, avi, mkv, and webm. MP4 is the default and the safest choice for compatibility across devices and platforms.'],
                ['Do I have to check durations first?', 'No — if you already know the durations match (or don\'t care), submit both sources directly and it processes in one step. The duration check only blocks you when a mismatch is actually detected.'],
                ['Is my video and audio private?', 'All uploads use AES-256 encryption in transit and are permanently deleted within 1 hour. We never read, share, or store your content.'],
            ] as [$q, $a])
            <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                <button type="button" class="faq-btn w-full flex items-center justify-between px-3.5 sm:px-5 py-3 sm:py-4 text-left hover:bg-fn-surface2 transition-colors">
                    <span class="font-semibold text-xs sm:text-sm pr-3">{{ $q }}</span>
                    <svg class="faq-icon w-3.5 h-3.5 sm:w-4 sm:h-4 text-fn-text3 shrink-0 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-body hidden px-3.5 sm:px-5 pb-3 sm:pb-4">
                    <p class="text-fn-text2 text-xs sm:text-sm leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<x-tools-content :tool="$tool" />
<x-tools-section />

<style>
    .src-tab, .tab-btn { color: var(--fn-text3); }
    .src-tab.active, .tab-btn.active { background: var(--fn-surface2); color: var(--fn-text); box-shadow: 0 1px 4px oklch(0% 0 0 / 12%); }
    #video-panel-file ~ .src-tab.active, .src-tab.active { background: var(--fn-surface); }

    .sheet-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 600;
    }
    .sheet-chip .sheet-dot { width: 8px; height: 8px; border-radius: 2px; flex-shrink: 0; }
    .sheet-chip .sheet-count { font-family: monospace; font-size: 10px; color: var(--fn-text3); margin-left: auto; padding-left: 4px; }

    .sheet-video  .sheet-dot { background: oklch(62% 0.20 250); }
    .sheet-video               { color: oklch(62% 0.20 250); border-color: oklch(62% 0.20 250 / 30%); background: oklch(62% 0.20 250 / 6%); }
    .sheet-audio  .sheet-dot { background: oklch(60% 0.22 295); }
    .sheet-audio               { color: oklch(60% 0.22 295); border-color: oklch(60% 0.22 295 / 30%); background: oklch(60% 0.22 295 / 6%); }
    .sheet-speed  .sheet-dot { background: oklch(75% 0.18 75); }
    .sheet-speed               { color: oklch(75% 0.18 75); border-color: oklch(75% 0.18 75 / 30%); background: oklch(75% 0.18 75 / 6%); }
    .sheet-mode   .sheet-dot { background: oklch(67% 0.18 162); }
    .sheet-mode                { color: oklch(67% 0.18 162); border-color: oklch(67% 0.18 162 / 30%); background: oklch(67% 0.18 162 / 6%); }
</style>

@push('footer')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let videoFile = null, audioFile = null;
  let videoMode = 'file', audioMode = 'file';
  let blobUrl = null;
  let pendingMismatch = null; // holds mismatch_info while user picks a side

  // ── Source tabs (video: file/url · audio: file/url/youtube) ──
  document.querySelectorAll('.src-tab').forEach(btn => {
    btn.addEventListener('click', () => {
      const src = btn.dataset.src, mode = btn.dataset.mode;
      document.querySelectorAll(`.src-tab[data-src="${src}"]`).forEach(b => b.classList.toggle('active', b === btn));
      ['file', 'url', 'youtube'].forEach(m => {
        const panel = document.getElementById(`${src}-panel-${m}`);
        if (panel) panel.classList.toggle('hidden', m !== mode);
      });
      if (src === 'video') videoMode = mode; else audioMode = mode;
      hideError();
      refreshConvertBtn();
    });
  });

  // ── Video file drop/select ──
  setupDropZone('video-drop', 'video-file-input', file => {
    videoFile = file;
    document.getElementById('video-file-name').textContent = file.name;
    document.getElementById('video-file-meta').textContent = formatBytes(file.size);
    document.getElementById('video-file-preview').classList.remove('hidden');
    document.getElementById('video-file-preview').classList.add('flex');
    refreshConvertBtn();
  });
  document.getElementById('video-file-remove').addEventListener('click', e => {
    e.stopPropagation();
    videoFile = null;
    document.getElementById('video-file-input').value = '';
    document.getElementById('video-file-preview').classList.add('hidden');
    refreshConvertBtn();
  });

  // ── Audio file drop/select ──
  setupDropZone('audio-drop', 'audio-file-input', file => {
    audioFile = file;
    document.getElementById('audio-file-name').textContent = file.name;
    document.getElementById('audio-file-meta').textContent = formatBytes(file.size);
    document.getElementById('audio-file-preview').classList.remove('hidden');
    document.getElementById('audio-file-preview').classList.add('flex');
    refreshConvertBtn();
  });
  document.getElementById('audio-file-remove').addEventListener('click', e => {
    e.stopPropagation();
    audioFile = null;
    document.getElementById('audio-file-input').value = '';
    document.getElementById('audio-file-preview').classList.add('hidden');
    refreshConvertBtn();
  });

  function setupDropZone(zoneId, inputId, onFile) {
    const zone = document.getElementById(zoneId);
    const input = document.getElementById(inputId);
    ['dragenter', 'dragover'].forEach(evt => zone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); zone.classList.add('drag-over'); }));
    ['dragleave', 'dragend', 'drop'].forEach(evt => zone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); zone.classList.remove('drag-over'); }));
    zone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) onFile(e.dataTransfer.files[0]); });
    input.addEventListener('change', e => { if (e.target.files[0]) onFile(e.target.files[0]); });
  }

  // ── URL inputs also gate the button ──
  ['video-url-input', 'audio-url-input', 'audio-youtube-input'].forEach(id => {
    document.getElementById(id).addEventListener('input', () => { hideError(); refreshConvertBtn(); });
  });

  function refreshConvertBtn() {
    const hasVideo = videoMode === 'file' ? !!videoFile : !!document.getElementById('video-url-input').value.trim();
    const hasAudio = audioMode === 'file' ? !!audioFile
                    : audioMode === 'url'  ? !!document.getElementById('audio-url-input').value.trim()
                    : !!document.getElementById('audio-youtube-input').value.trim();
    convertBtn.disabled = !(hasVideo && hasAudio);
  }

  // ── Replace/mix toggle ──
  const optReplace = document.getElementById('opt-replace');
  const volumeControls = document.getElementById('volume-controls');
  optReplace.addEventListener('change', () => volumeControls.classList.toggle('hidden', optReplace.checked));

  const volVideo = document.getElementById('opt-vol-video');
  const volAudio = document.getElementById('opt-vol-audio');
  volVideo.addEventListener('input', () => document.getElementById('vol-video-val').textContent = parseFloat(volVideo.value).toFixed(1));
  volAudio.addEventListener('input', () => document.getElementById('vol-audio-val').textContent = parseFloat(volAudio.value).toFixed(1));

  // ── Build FormData for current sources + options ──
  function buildFormData(speedAdjustTarget) {
    const fd = new FormData();

    if (videoMode === 'file') fd.append('video', videoFile);
    else fd.append('video_url', document.getElementById('video-url-input').value.trim());

    if (audioMode === 'file') fd.append('audio', audioFile);
    else if (audioMode === 'url') fd.append('audio_url', document.getElementById('audio-url-input').value.trim());
    else fd.append('audio_url', document.getElementById('audio-youtube-input').value.trim());

    const replace = optReplace.checked;
    fd.append('replace_audio', replace ? 'true' : 'false');
    if (!replace) {
      fd.append('volume_video', volVideo.value);
      fd.append('volume_audio', volAudio.value);
    }

    const customFilename = document.getElementById('opt-filename').value.trim();
    if (customFilename) fd.append('output_filename', customFilename);
    fd.append('output_format', document.getElementById('opt-format').value);

    if (speedAdjustTarget) fd.append('speed_adjust_target', speedAdjustTarget);

    return fd;
  }

  // ── Convert ──
  convertBtn.addEventListener('click', () => startConversion(null));
  document.getElementById('btn-adjust-audio').addEventListener('click', () => startConversion('audio'));
  document.getElementById('btn-adjust-video').addEventListener('click', () => startConversion('video'));
  document.getElementById('btn-mismatch-back').addEventListener('click', () => {
    showState('upload'); updateStepIndicator(1); pendingMismatch = null;
  });

  async function startConversion(speedAdjustTarget) {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 500, 'Reading video & audio sources…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 45, 600, 'Checking durations…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(45, 85, 1400, speedAdjustTarget ? 'Adjusting speed & merging…' : 'Merging tracks…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(85, 92, 500, 'Finalizing output file…');
    }, 3000);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/add-voice-to-video', {
        method: 'POST',
        body: buildFormData(speedAdjustTarget),
      });
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (res.status === 422) {
        const data = await res.json();
        if (data.mismatch) {
          renderMismatch(data);
          showState('mismatch');
          updateStepIndicator(1);
          return;
        }
        throw new Error(data.error || 'Duration mismatch detected.');
      }

      if (!res.ok) {
        let msg = 'Processing failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      const customFilename = document.getElementById('opt-filename').value.trim();
      const format = document.getElementById('opt-format').value;
      let outName;
      if (customFilename) {
        outName = customFilename.toLowerCase().endsWith('.' + format) ? customFilename : customFilename + '.' + format;
      } else {
        outName = 'video_with_voice.' + format;
      }

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · ' + format.toUpperCase() + ' Video';

      renderResultDetails(res.headers, speedAdjustTarget, optReplace.checked);

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(92, 100, 300, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 400);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function renderMismatch(data) {
    pendingMismatch = data;
    const info = data.mismatch_info || {};
    document.getElementById('mismatch-video-dur').textContent = info.video_duration_str || '—';
    document.getElementById('mismatch-audio-dur').textContent = info.audio_duration_str || '—';
    document.getElementById('mismatch-suggestion').textContent = info.suggestion || 'Durations differ. Choose a side to speed-adjust.';

    const opts = data.options || {};
    document.getElementById('mismatch-opt-audio').textContent = opts.audio || 'Match audio to video duration';
    document.getElementById('mismatch-opt-video').textContent = opts.video || 'Match video to audio duration';
  }

  function renderResultDetails(headers, speedAdjustTarget, replaceAudio) {
    const wrap = document.getElementById('result-sheets-wrap');
    const list = document.getElementById('result-sheets');
    list.innerHTML = '';

    const chips = [];
    chips.push(['mode', replaceAudio ? 'Replaced audio' : 'Mixed audio', '—']);

    const outDur = headers.get('X-Output-Duration');
    if (outDur) chips.push(['video', 'Output duration', parseFloat(outDur).toFixed(1) + 's']);

    const speedAdjusted = headers.get('X-Speed-Adjusted');
    if (speedAdjusted === 'True' || speedAdjustTarget) {
      const ratio = headers.get('X-Speed-Ratio');
      chips.push(['speed', 'Speed-adjusted: ' + (speedAdjustTarget || '—'), ratio ? parseFloat(ratio).toFixed(2) + 'x' : '—']);
    }

    const method = headers.get('X-Method');
    if (method) chips.push(['audio', 'Method', method]);

    chips.forEach(([variant, label, count]) => {
      const chip = document.createElement('div');
      chip.className = 'sheet-chip sheet-' + variant;
      chip.innerHTML = `
        <span class="sheet-dot"></span>
        <span class="sheet-label"></span>
        <span class="sheet-count">${count}</span>`;
      chip.querySelector('.sheet-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  // ── Helpers ──
  function scrollToCard() {
    const card = document.querySelector('#state-converting')?.closest('.bg-fn-surface');
    if (card) {
      const top = card.getBoundingClientRect().top + window.pageYOffset - 80;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  }

  function showState(state) {
    ['upload', 'mismatch', 'converting', 'download'].forEach(s => {
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
      const t = Math.min((now - start) / duration, 1);
      const pct = Math.round(from + (to - from) * t);
      document.getElementById('progress-fill').style.width = pct + '%';
      document.getElementById('progress-pct').textContent = pct + '%';
      if (t < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  window.resetConverter = function () {
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }

    videoFile = null; audioFile = null;
    document.getElementById('video-file-input').value = '';
    document.getElementById('audio-file-input').value = '';
    document.getElementById('video-file-preview').classList.add('hidden');
    document.getElementById('audio-file-preview').classList.add('hidden');
    document.getElementById('video-url-input').value = '';
    document.getElementById('audio-url-input').value = '';
    document.getElementById('audio-youtube-input').value = '';
    document.getElementById('opt-filename').value = '';
    document.getElementById('opt-format').value = 'mp4';
    optReplace.checked = true;
    volumeControls.classList.add('hidden');
    volVideo.value = 0.3; document.getElementById('vol-video-val').textContent = '0.3';
    volAudio.value = 1.0; document.getElementById('vol-audio-val').textContent = '1.0';
    document.getElementById('result-sheets-wrap').classList.add('hidden');

    // reset tabs to file/file
    document.querySelectorAll('.src-tab').forEach(b => b.classList.toggle('active', b.dataset.mode === 'file'));
    ['video-panel-file','audio-panel-file'].forEach(id => document.getElementById(id).classList.remove('hidden'));
    ['video-panel-url','audio-panel-url','audio-panel-youtube'].forEach(id => document.getElementById(id).classList.add('hidden'));
    videoMode = 'file'; audioMode = 'file';

    pendingMismatch = null;
    hideError();
    showState('upload');
    updateStepIndicator(1);
    animateProgress(0, 0, 0, 'Starting…');
    ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
    refreshConvertBtn();
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
      const body = btn.nextElementSibling;
      const icon = btn.querySelector('.faq-icon');
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
