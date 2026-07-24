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
                @foreach([['1','Enter URL'],['2','Converting'],['3','Download']] as [$n, $label])
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

                    {{-- ══ URL PANEL ══ --}}
                    <div id="panel-url">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">YouTube URL</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample" class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Sample</button>
                                <button type="button" id="btn-paste" class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                                    Paste
                                </button>
                                <button type="button" id="btn-clear" class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                            </div>
                        </div>

                        <div class="relative">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 text-fn-text3">
                                <rect x="2" y="2" width="20" height="20" rx="4"/>
                                <polygon points="9.5 8 16 12 9.5 16 9.5 8" fill="currentColor" stroke="none"/>
                            </svg>
                            <input type="url" id="url-input" spellcheck="false" autocomplete="off"
                                placeholder="https://www.youtube.com/watch?v=… or youtu.be/…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-xl pl-10 sm:pl-11 pr-4 py-3 sm:py-3.5 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                        </div>

                        <p id="url-status" class="text-xs mt-1.5"><span class="text-fn-text3">Paste a YouTube video link</span></p>
                    </div>

                    {{-- Options --}}
                    <div class="mt-3 sm:mt-5 p-3 sm:p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                            <p class="text-xs sm:text-sm font-semibold text-fn-text2">Audio Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-2.5 sm:gap-3">
                            <div>
                                <label for="opt-quality" class="text-xs font-semibold text-fn-text2 block mb-1.5">Quality (bitrate)</label>
                                <select id="opt-quality"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40">
                                    <option value="128">128 kbps — smallest file</option>
                                    <option value="192" selected>192 kbps — default</option>
                                    <option value="256">256 kbps</option>
                                    <option value="320">320 kbps — high quality</option>
                                </select>
                            </div>
                            <div>
                                <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Output filename <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="audio.mp3"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-xs sm:text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            </div>
                        </div>

                        <label class="mt-2.5 sm:mt-3 flex items-center gap-2 cursor-pointer select-none px-3 py-2 bg-fn-surface border border-fn-text/10 rounded-lg hover:border-fn-blue/25 transition-colors">
                            <div class="toggle-wrap relative w-8 h-4 shrink-0">
                                <input type="checkbox" id="opt-normalize" class="sr-only peer" />
                                <div class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors"></div>
                                <div class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-fn-text2">Loudness normalization</p>
                                <p class="text-xs text-fn-text3 leading-tight">Evens out volume to a consistent level</p>
                            </div>
                        </label>
                    </div>

                    {{-- Copyright notice --}}
                    <div class="mt-3 sm:mt-4 flex items-start gap-2.5 px-3 sm:px-4 py-2.5 sm:py-3 bg-fn-amber/6 border border-fn-amber/20 rounded-xl">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-amber shrink-0 mt-0.5"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/></svg>
                        <p class="text-xs text-fn-text2 leading-relaxed">Only extract audio you own, that's royalty-free or Creative-Commons licensed, or that you have explicit permission to use. Downloading and redistributing audio from videos you don't have rights to typically violates YouTube's Terms of Service and copyright law.</p>
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
                        Convert to MP3
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-4 sm:py-6">
                    <div class="flex items-center justify-center gap-3 sm:gap-5 mb-5 sm:mb-8">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="text-fn-red sm:w-7 sm:h-7"><rect x="2" y="2" width="20" height="20" rx="4"/><polygon points="9.5 8 16 12 9.5 16 9.5 8" fill="currentColor" stroke="none"/></svg>
                        </div>
                        <div class="flex gap-1">
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:0s"></span>
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.15s"></span>
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.3s"></span>
                        </div>
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-xl sm:text-3xl">🎧</div>
                    </div>

                    <h2 class="text-base sm:text-xl font-bold mb-1.5 sm:mb-2">Converting to MP3…</h2>
                    <p class="text-fn-text3 text-xs sm:text-sm mb-5 sm:mb-8">Extracting and encoding the audio track</p>

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
                            ['proc-1','Resolving video URL'],
                            ['proc-2','Extracting audio stream'],
                            ['proc-3','Encoding to MP3'],
                            ['proc-4','Finalizing file'],
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
                    <h2 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2" id="result-title">Conversion Complete!</h2>
                    <p class="text-fn-text2 text-xs sm:text-sm mb-4 sm:mb-6">Your MP3 is ready to download.</p>

                    <div id="result-sheets-wrap" class="hidden max-w-2xl mx-auto mb-4 sm:mb-6">
                        <div class="flex flex-wrap gap-2 justify-center" id="result-sheets"></div>
                    </div>

                    <div class="max-w-sm mx-auto p-3 sm:p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6 text-left">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-lg sm:text-2xl shrink-0">🎧</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-xs sm:text-sm truncate" id="output-name">audio.mp3</p>
                            <p class="text-fn-text3 text-xs sm:text-sm mt-0.5" id="output-size">MP3 Audio</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <audio id="audio-preview" controls class="w-full max-w-sm mx-auto mb-4 sm:mb-6 hidden"></audio>

                    <a id="download-link" href="#" download="audio.mp3"
                        class="inline-flex items-center gap-2 sm:gap-2.5 px-5 sm:px-8 py-2.5 sm:py-3.5 text-white font-bold text-sm sm:text-base rounded-xl transition-all hover:-translate-y-0.5 mb-3 sm:mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download MP3
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-3.5 sm:px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs sm:text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                            Convert another
                        </button>
                    </div>

                    <p class="mt-4 sm:mt-6 text-fn-text3 text-xs sm:text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green shrink-0"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Your link and file are encrypted and permanently deleted within 1 hour.
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
                ['What links are supported?', 'Standard watch links (youtube.com/watch?v=…), short links (youtu.be/…), and Shorts links (youtube.com/shorts/…) all work — anywhere a single video can be identified from the URL.'],
                ['What bitrate should I pick?', '192 kbps is the default and a good balance of quality and file size. Use 320 kbps for music or anything you want the highest fidelity on, or 128 kbps if you just need small files for speech or podcasts.'],
                ['What does loudness normalization do?', 'It evens out the perceived volume of the track to a consistent target level, useful when the source audio is unusually quiet, loud, or inconsistent across sections.'],
                ['Is it legal to convert a YouTube video to MP3?', 'Only if you own the content, it\'s royalty-free or Creative-Commons licensed, or you have explicit permission from the rights holder. Downloading and redistributing audio you don\'t have rights to typically violates YouTube\'s Terms of Service and copyright law — you\'re responsible for confirming the source is usable this way.'],
                ['Is my link and file private?', 'All requests use AES-256 encryption in transit and any temporary files are permanently deleted within 1 hour. We never read, share, or store your content.'],
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

    .sheet-title    .sheet-dot { background: oklch(62% 0.20 250); }
    .sheet-title                 { color: oklch(62% 0.20 250); border-color: oklch(62% 0.20 250 / 30%); background: oklch(62% 0.20 250 / 6%); }
    .sheet-duration .sheet-dot { background: oklch(60% 0.22 295); }
    .sheet-duration               { color: oklch(60% 0.22 295); border-color: oklch(60% 0.22 295 / 30%); background: oklch(60% 0.22 295 / 6%); }
    .sheet-bitrate  .sheet-dot { background: oklch(67% 0.18 162); }
    .sheet-bitrate                { color: oklch(67% 0.18 162); border-color: oklch(67% 0.18 162 / 30%); background: oklch(67% 0.18 162 / 6%); }
    .sheet-size     .sheet-dot { background: oklch(75% 0.18 75); }
    .sheet-size                   { color: oklch(75% 0.18 75); border-color: oklch(75% 0.18 75 / 30%); background: oklch(75% 0.18 75 / 6%); }
</style>

@push('footer')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_URL = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

  const urlInput    = document.getElementById('url-input');
  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let blobUrl = null;

  const URL_RE = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)[\w-]{6,}/i;

  // ── Sample / Paste / Clear ──
  document.getElementById('btn-sample').addEventListener('click', () => {
    urlInput.value = SAMPLE_URL;
    urlInput.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { urlInput.value = await navigator.clipboard.readText(); urlInput.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    urlInput.value = '';
    urlInput.dispatchEvent(new Event('input'));
  });

  // ── URL input ──
  urlInput.addEventListener('input', () => {
    const v = urlInput.value.trim();
    const status = document.getElementById('url-status');
    const valid = URL_RE.test(v);

    if (!v) {
      status.innerHTML = '<span class="text-fn-text3">Paste a YouTube video link</span>';
    } else if (valid) {
      status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Looks like a valid YouTube link
      </span>`;
    } else {
      status.innerHTML = '<span class="text-fn-amber">Doesn\'t look like a YouTube URL — the server will still try</span>';
    }

    convertBtn.disabled = !v;
    hideError();
  });

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    const url = urlInput.value.trim();
    if (!url) return;
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const customFilename = document.getElementById('opt-filename').value.trim();
    const quality   = document.getElementById('opt-quality').value;
    const normalize = document.getElementById('opt-normalize').checked;

    let outName;
    if (customFilename) {
      outName = customFilename.toLowerCase().endsWith('.mp3') ? customFilename : customFilename + '.mp3';
    } else {
      outName = 'audio.mp3';
    }

    const payload = { url };
    if (quality && quality !== '192') payload.quality = quality;
    if (normalize) payload.normalize = true;

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 500, 'Resolving video URL…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 50, 700, 'Extracting audio stream…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(50, 85, 1000, 'Encoding to MP3…');
    }, 1500);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(85, 92, 500, 'Finalizing file…');
    }, 2700);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/youtube-to-mp3', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      const title   = res.headers.get('X-Title');
      const duration = res.headers.get('X-Duration');
      const bitrate  = res.headers.get('X-Bitrate');
      const sizeMB   = res.headers.get('X-Filesize-MB');

      if (!customFilename && title) outName = title + '.mp3';

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href = blobUrl;
      link.download = outName;

      const audioPreview = document.getElementById('audio-preview');
      audioPreview.src = blobUrl;
      audioPreview.classList.remove('hidden');

      document.getElementById('result-title').textContent = title || 'Conversion Complete!';
      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = (sizeMB ? parseFloat(sizeMB).toFixed(2) + ' MB' : formatBytes(blob.size)) + ' · MP3 Audio';

      renderResultDetails({ duration, bitrate, sizeMB });

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

  function renderResultDetails({ duration, bitrate, sizeMB }) {
    const wrap = document.getElementById('result-sheets-wrap');
    const list = document.getElementById('result-sheets');
    list.innerHTML = '';

    const chips = [];
    if (duration) chips.push(['duration', 'Duration', formatDuration(parseFloat(duration))]);
    if (bitrate)  chips.push(['bitrate', 'Bitrate', bitrate]);
    if (sizeMB)   chips.push(['size', 'Size', parseFloat(sizeMB).toFixed(2) + ' MB']);

    if (chips.length === 0) { wrap.classList.add('hidden'); return; }

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
    urlInput.value = '';
    urlInput.dispatchEvent(new Event('input'));
    document.getElementById('opt-filename').value = '';
    document.getElementById('opt-quality').value = '192';
    document.getElementById('opt-normalize').checked = false;
    document.getElementById('result-sheets-wrap').classList.add('hidden');
    const audioPreview = document.getElementById('audio-preview');
    audioPreview.src = '';
    audioPreview.classList.add('hidden');
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

  function formatDuration(seconds) {
    seconds = Math.round(seconds);
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return m + ':' + String(s).padStart(2, '0');
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
