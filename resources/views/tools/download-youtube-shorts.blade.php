@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ DOWNLOADER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Enter URL'],['2','Downloading'],['3','Download']] as [$n, $label])
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

                    {{-- ══ URL PANEL ══ --}}
                    <div id="panel-url">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">YouTube URL</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Sample</button>
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
                                <button type="button" id="btn-clear"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                            </div>
                        </div>

                        <div class="relative">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-fn-text3">
                                <rect x="2" y="2" width="20" height="20" rx="4" />
                                <polygon points="9.5 8 16 12 9.5 16 9.5 8" fill="currentColor" stroke="none" />
                            </svg>
                            <input type="url" id="url-input" spellcheck="false" autocomplete="off"
                                placeholder="https://www.youtube.com/watch?v=… or youtu.be/… or /shorts/…"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/50" />
                        </div>

                        <div class="flex items-center justify-between text-xs mt-1.5">
                            <span id="url-status" class="text-fn-text3">Paste a YouTube video, Shorts, or youtu.be
                                link</span>
                            <button type="button" id="btn-check" disabled
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-semibold rounded-lg transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:border-fn-blue/40 hover:enabled:text-fn-blue-l">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                                Check available qualities
                            </button>
                        </div>
                    </div>

                    {{-- Video preview (after check) --}}
                    <div id="video-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-28 h-16 rounded-lg overflow-hidden bg-fn-text/10 shrink-0 flex items-center justify-center">
                            <img id="preview-thumb" src="" alt="" class="w-full h-full object-cover hidden" />
                            <svg id="preview-thumb-fallback" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" class="text-fn-text3">
                                <rect x="2" y="2" width="20" height="20" rx="4" />
                                <polygon points="9.5 8 16 12 9.5 16 9.5 8" fill="currentColor" stroke="none" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="preview-title">Video title</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="preview-meta">—</p>
                        </div>
                        <button type="button" id="remove-preview"
                            class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    {{-- Detected qualities preview --}}
                    <div id="detected-content"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-blue/15 rounded-xl">
                        <div class="flex items-center gap-2 mb-3">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-blue-l">
                                <polygon points="23 7 16 12 23 17 23 7" />
                                <rect x="1" y="5" width="15" height="14" rx="2" />
                            </svg>
                            <p class="text-sm font-semibold text-fn-text2">Available qualities for this video</p>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2" id="detected-qualities"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">Download Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Output filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="video.mp4"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            </div>

                            <div>
                                <label for="opt-max-height" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Cap resolution
                                    <span class="font-normal text-fn-text3 ml-1">(max_height)</span>
                                </label>
                                <select id="opt-max-height"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40">
                                    <option value="">Highest available</option>
                                    <option value="2160">2160p (4K)</option>
                                    <option value="1440">1440p (2K)</option>
                                    <option value="1080">1080p (Full HD)</option>
                                    <option value="720">720p (HD)</option>
                                    <option value="480">480p</option>
                                    <option value="360">360p</option>
                                </select>
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
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Video
                    </button>
                </div>

                {{-- ── STATE: Downloading ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" class="text-fn-red">
                                <rect x="2" y="2" width="20" height="20" rx="4" />
                                <polygon points="9.5 8 16 12 9.5 16 9.5 8" fill="currentColor" stroke="none" />
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
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            🎬</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Downloading video…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Resolving stream, fetching qualities, and merging audio/video
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
                        ['proc-1','Resolving video URL'],
                        ['proc-2','Selecting best quality'],
                        ['proc-3','Fetching video stream'],
                        ['proc-4','Finalizing file'],
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
                            <span class="text-sm text-fn-text3">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Download Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6">Your video is ready to save.</p>

                    {{-- Quality used --}}
                    <div id="result-sheets-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Download details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-sheets"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            🎬</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">video.mp4</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">MP4 Video</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="video.mp4"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Video File
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Download another
                        </button>
                    </div>

                    <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your link and file are encrypted and permanently deleted within 1 hour.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @foreach([
            ['What links are supported?', 'Standard watch links (youtube.com/watch?v=…), short links (youtu.be/…), and
            Shorts links (youtube.com/shorts/…) are all supported. Playlist and channel URLs are not.'],
            ['What does "Check available qualities" do?', 'It calls the info endpoint for the video and lists the
            resolutions and formats actually available for that upload, so you know what to expect before downloading —
            no file is downloaded at this step.'],
            ['What does the resolution cap do?', 'By default the highest available quality is downloaded. Setting a cap
            (e.g. 1080p) tells the server to pick the best stream at or below that height, which is useful for smaller
            file sizes or faster downloads.'],
            ['Can I download audio only?', 'Not from this tool — this converts and downloads the full video (video +
            audio merged) at your selected quality. Use a dedicated audio-extraction tool if you only need the sound.'],
            ['Is this legal to use?', 'Only download videos you own, that are licensed for reuse, or that you otherwise
            have the right to download. Respect YouTube\'s Terms of Service and copyright law in your jurisdiction.'],
            ['Is my link and video private?', 'All requests use AES-256 encryption in transit and any temporary files
            are permanently deleted within 1 hour. We never read, share, or store your content.'],
            ] as [$q, $a])
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

    .sheet-chip .sheet-dot {
        width: 8px;
        height: 8px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .sheet-chip .sheet-count {
        font-family: monospace;
        font-size: 10px;
        color: var(--fn-text3);
        margin-left: auto;
        padding-left: 4px;
    }

    .sheet-summary .sheet-dot {
        background: oklch(62% 0.20 250);
    }

    .sheet-summary {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .sheet-schema .sheet-dot {
        background: oklch(60% 0.22 295);
    }

    .sheet-schema {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .sheet-table .sheet-dot {
        background: oklch(67% 0.18 162);
    }

    .sheet-table {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }

    /* quality chip variants */
    .sheet-quality .sheet-dot {
        background: oklch(58% 0.22 25);
    }

    .sheet-quality {
        color: oklch(58% 0.22 25);
        border-color: oklch(58% 0.22 25 / 30%);
        background: oklch(58% 0.22 25 / 6%);
    }

    .sheet-audio .sheet-dot {
        background: oklch(62% 0.20 250);
    }

    .sheet-audio {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_URL = 'https://www.youtube.com/shorts/dQw4w9WgXcQ';

  const urlInput    = document.getElementById('url-input');
  const btnCheck    = document.getElementById('btn-check');
  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');
  const videoPreview = document.getElementById('video-preview');

  let blobUrl      = null;
  let lastInfo     = null; // cached info response from the check endpoint

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
    resetPreview();
  });
  document.getElementById('remove-preview').addEventListener('click', resetPreview);

  // ── URL input ──
  urlInput.addEventListener('input', () => {
    const v = urlInput.value.trim();
    const status = document.getElementById('url-status');
    const valid = URL_RE.test(v);

    if (!v) {
      status.innerHTML = '<span class="text-fn-text3">Paste a YouTube video, Shorts, or youtu.be link</span>';
    } else if (valid) {
      status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Looks like a valid YouTube link
      </span>`;
    } else {
      status.innerHTML = '<span class="text-fn-amber">Doesn\'t look like a YouTube URL — the server will still try</span>';
    }

    btnCheck.disabled = !v;
    convertBtn.disabled = !v;

    // Invalidate stale check results if the URL changes
    if (lastInfo && lastInfo.url !== v) {
      lastInfo = null;
      document.getElementById('detected-content').classList.add('hidden');
      resetPreview();
    }
    hideError();
  });

  function resetPreview() {
    videoPreview.classList.add('hidden');
    videoPreview.classList.remove('flex');
    document.getElementById('preview-thumb').classList.add('hidden');
    document.getElementById('preview-thumb-fallback').classList.remove('hidden');
  }

  // ── Check available qualities ──
  btnCheck.addEventListener('click', checkQualities);

  async function checkQualities() {
    const url = urlInput.value.trim();
    if (!url) return;
    hideError();

    btnCheck.disabled = true;
    const originalHTML = btnCheck.innerHTML;
    btnCheck.innerHTML = `<svg class="spin" width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Checking…`;

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/youtube-info', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ url }),
      });

      if (!res.ok) {
        let msg = 'Could not fetch info for this link. Please check the URL.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const data = await res.json();
      lastInfo = { url, data };
      renderPreview(data);
      renderQualities(data);

    } catch (err) {
      console.error(err);
      showError(err.message || 'Something went wrong while checking qualities.');
    } finally {
      btnCheck.disabled = !urlInput.value.trim();
      btnCheck.innerHTML = originalHTML;
    }
  }

  function renderPreview(data) {
    document.getElementById('preview-title').textContent = data.title || 'Video';
    const bits = [];
    if (data.duration)  bits.push(formatDuration(data.duration));
    if (data.uploader)  bits.push(data.uploader);
    document.getElementById('preview-meta').textContent = bits.length ? bits.join(' · ') : '—';

    const thumb = document.getElementById('preview-thumb');
    const fallback = document.getElementById('preview-thumb-fallback');
    if (data.thumbnail) {
      thumb.src = data.thumbnail;
      thumb.classList.remove('hidden');
      fallback.classList.add('hidden');
    } else {
      thumb.classList.add('hidden');
      fallback.classList.remove('hidden');
    }

    videoPreview.classList.remove('hidden');
    videoPreview.classList.add('flex');
  }

  function renderQualities(data) {
    const wrap = document.getElementById('detected-content');
    const list = document.getElementById('detected-qualities');
    list.innerHTML = '';

    const formats = Array.isArray(data.formats) ? data.formats : [];
    if (formats.length === 0) {
      wrap.classList.add('hidden');
      return;
    }

    formats.forEach(f => {
      const label = f.height ? f.height + 'p' : (f.label || 'Audio');
      const variant = f.height ? 'quality' : 'audio';
      const size = f.filesize ? formatBytes(f.filesize) : (f.ext ? f.ext.toUpperCase() : '—');
      const chip = document.createElement('div');
      chip.className = 'sheet-chip sheet-' + variant;
      chip.innerHTML = `
        <span class="sheet-dot"></span>
        <span class="sheet-label"></span>
        <span class="sheet-count">${size}</span>`;
      chip.querySelector('.sheet-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  // ── Download ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    const url = urlInput.value.trim();
    if (!url) return;
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const customFilename = document.getElementById('opt-filename').value.trim();
    const maxHeight      = document.getElementById('opt-max-height').value;

    let outName;
    if (customFilename) {
      outName = customFilename.toLowerCase().endsWith('.mp4') ? customFilename : customFilename + '.mp4';
    } else {
      outName = 'video.mp4';
    }

    const payload = { url };
    if (maxHeight) payload.max_height = parseInt(maxHeight, 10);

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 500, 'Resolving video URL…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 45, 700, 'Selecting best quality…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(45, 85, 1200, 'Fetching video stream…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(85, 92, 500, 'Finalizing file…');
    }, 2800);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/youtube-download', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Download failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · MP4 Video';

      renderResultDetails(maxHeight);

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

  function renderResultDetails(maxHeight) {
    const wrap = document.getElementById('result-sheets-wrap');
    const list = document.getElementById('result-sheets');
    list.innerHTML = '';

    const chips = [];
    chips.push(['quality', maxHeight ? 'Capped at ' + maxHeight + 'p' : 'Highest quality', '—']);
    if (lastInfo && lastInfo.data && lastInfo.data.title) {
      chips.push(['audio', 'Video + Audio', 'merged']);
    }

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
    document.getElementById('opt-max-height').value = '';
    document.getElementById('detected-content').classList.add('hidden');
    document.getElementById('result-sheets-wrap').classList.add('hidden');
    resetPreview();
    lastInfo = null;
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
