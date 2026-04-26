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
                @foreach([['1','Upload PDF'],['2','Converting'],['3','Download']] as [$n, $label])
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

                    {{-- Drop zone --}}
                    <div id="drop-zone"
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                        <div class="flex items-center justify-center mb-5">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-4xl">
                                📕</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-6">or click to browse from your computer</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                        <input type="file" id="file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.pdf</p>
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

                    {{-- Output mode --}}
                    <div class="mt-5">
                        <label class="text-sm font-semibold text-fn-text2 block mb-2">Output Mode</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            @foreach([
                            ['zip', '📦', 'All pages as ZIP', 'One PNG per page in a zip archive'],
                            ['single', '🖼', 'Single page', 'Just the first page (or specified page)'],
                            ['base64', '⚙️', 'Base64 JSON', 'For frontend / mobile integration'],
                            ] as [$mval, $micon, $mname, $mdesc])
                            <button type="button"
                                class="mode-card {{ $mval === 'zip' ? 'active' : '' }} flex flex-col items-start gap-1 p-3 rounded-xl border text-left transition-all"
                                data-mode="{{ $mval }}">
                                <div class="flex items-center gap-1.5 w-full">
                                    <span class="text-base">{{ $micon }}</span>
                                    <span class="text-sm font-bold">{{ $mname }}</span>
                                </div>
                                <span class="text-xs leading-tight opacity-70">{{ $mdesc }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Settings --}}
                    <div class="mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">

                        {{-- DPI slider --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-fn-text2">
                                    Resolution — <span class="text-fn-blue-l" id="dpi-val">200</span> DPI
                                </label>
                                <span class="text-xs text-fn-text3" id="dpi-est">~800 KB / page</span>
                            </div>
                            <input type="range" id="opt-dpi" min="72" max="600" value="200" step="1"
                                class="w-full accent-fn-blue cursor-pointer mb-2" />
                            <div class="flex gap-1">
                                @foreach([
                                ['72', '72', 'Web preview'],
                                ['150', '150', 'General use'],
                                ['200', '200', 'Default'],
                                ['300', '300', 'Print quality'],
                                ['600', '600', 'High resolution'],
                                ] as [$dval, $dlabel, $ddesc])
                                <button type="button"
                                    class="dpi-preset {{ $dval === '200' ? 'active' : '' }} flex-1 px-2 py-1.5 rounded-lg border text-xs font-semibold transition-all"
                                    data-val="{{ $dval }}" title="{{ $ddesc }}">
                                    <span class="block">{{ $dlabel }}</span>
                                    <span class="block text-fn-text3 text-xs font-normal" style="font-size:10px;">{{
                                        $ddesc }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Pages selector (zip + base64 only) --}}
                        <div id="pages-section">
                            <label for="opt-pages" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                Pages
                                <span class="font-normal text-fn-text3 ml-1">(optional — leave blank for all)</span>
                            </label>
                            <input type="text" id="opt-pages"
                                placeholder="e.g. 1,3,5 or 1-10 or leave blank for all pages"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                        </div>

                        {{-- Single page (single mode only) --}}
                        <div id="single-page-section" class="hidden">
                            <label for="opt-single-page" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                Page number
                                <span class="font-normal text-fn-text3 ml-1">(default: 1)</span>
                            </label>
                            <input type="number" id="opt-single-page" min="1" placeholder="1"
                                class="w-32 bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40" />
                        </div>

                        {{-- Password (encrypted PDF) --}}
                        <div>
                            <label for="opt-password" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                PDF Password
                                <span class="font-normal text-fn-text3 ml-1">(only if encrypted)</span>
                            </label>
                            <div class="relative max-w-sm">
                                <input type="password" id="opt-password" placeholder="Leave blank if not protected"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <button type="button" id="toggle-password"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors">
                                    <svg id="eye-show" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg id="eye-hide" class="hidden" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                </button>
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

                    {{-- Convert button --}}
                    <button id="convert-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <polyline points="21 15 16 10 5 21" />
                        </svg>
                        Convert to PNG
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
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
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-3xl">
                            🖼</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting your PDF…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes just a few seconds</p>

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
                        ['proc-1','Uploading & validating PDF'],
                        ['proc-2','Reading pages at selected DPI'],
                        ['proc-3','Rendering each page as PNG'],
                        ['proc-4','Packaging output'],
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
                    <h2 class="text-2xl font-bold mb-2">Conversion Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6" id="result-subtitle">Your PNG files are ready.</p>

                    {{-- Pages preview gallery (base64 mode only) --}}
                    <div id="pages-gallery-wrap" class="hidden max-w-3xl mx-auto mb-6 text-left">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-semibold text-fn-text2">
                                <span id="pages-count">0</span> page<span id="pages-plural">s</span> rendered
                            </p>
                            <span class="text-xs text-fn-text3" id="pages-total-size">—</span>
                        </div>
                        <div id="pages-gallery"
                            class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 max-h-[360px] overflow-auto p-2 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        </div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div class="w-12 h-12 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-2xl shrink-0"
                            id="output-icon">📦</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">document_pages.zip</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">ZIP Archive</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="output.zip"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span id="download-label">Download ZIP</span>
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Convert another PDF
                        </button>
                    </div>

                    <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
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
            @foreach([
            ['Why choose PNG over JPG?', 'PNG is lossless — every pixel is preserved exactly, with no compression
            artifacts. It also supports transparency. Choose PNG when your PDF contains screenshots, sharp text,
            diagrams, or anything where quality matters more than file size. JPG is better for photographs where small
            artifacts are invisible and file size matters.'],
            ['What DPI should I pick?', 'For viewing on screens, 150 DPI is plenty. The default 200 DPI strikes a good
            balance. Use 300 DPI if you plan to print, and 600 DPI for archival or detailed close-ups. Higher DPI
            dramatically increases file size — at 600 DPI a single page can be 6MB+.'],
            ['How do output modes work?', 'ZIP returns all pages packed into one downloadable .zip file. Single returns
            one PNG (the first page by default, or whichever page number you specify). Base64 returns a JSON object with
            each page as a base64-encoded string — useful for displaying images directly in a webapp without saving
            files.'],
            ['Can I convert an encrypted PDF?', 'Yes — paste the password into the optional password field. The output
            PNGs themselves are not encrypted.'],
            ['Is my file safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
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

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ STYLES ══ --}}
<style>
    .mode-card {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text2);
    }

    .mode-card:hover {
        border-color: oklch(49% 0.24 264 / 30%);
        color: var(--fn-text);
    }

    .mode-card.active {
        border-color: oklch(49% 0.24 264 / 50%);
        background: oklch(49% 0.24 264 / 7%);
        color: var(--fn-text);
    }

    .dpi-preset {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .dpi-preset.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .dpi-preset:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    #opt-dpi {
        height: 4px;
        background: oklch(var(--fn-text-l, 80%) 0 0 / 12%);
        border-radius: 999px;
        outline: none;
    }

    .page-thumb {
        position: relative;
        aspect-ratio: 1 / 1.4;
        background: var(--fn-surface);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        border-radius: 8px;
        overflow: hidden;
        transition: border-color .15s, transform .15s;
    }

    .page-thumb:hover {
        border-color: oklch(49% 0.24 264 / 30%);
        transform: translateY(-1px);
    }

    .page-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: white;
    }

    .page-thumb .page-label {
        position: absolute;
        bottom: 4px;
        left: 4px;
        right: 4px;
        background: oklch(0% 0 0 / 70%);
        color: white;
        padding: 2px 6px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 4px;
        text-align: center;
        backdrop-filter: blur(4px);
        display: flex;
        justify-content: space-between;
        gap: 4px;
    }

    .page-thumb .page-label .pn {
        font-family: monospace;
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  // ── Refs ──
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let selectedFile = null;
  let blobUrl      = null;
  let activeMode   = 'zip';

  // ── Mode selector ──
  document.querySelectorAll('.mode-card').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.mode-card').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeMode = btn.dataset.mode;
      // Show/hide single vs pages
      document.getElementById('pages-section').classList.toggle('hidden', activeMode === 'single');
      document.getElementById('single-page-section').classList.toggle('hidden', activeMode !== 'single');
    });
  });

  // ── DPI slider + presets ──
  const dpiSlider = document.getElementById('opt-dpi');
  dpiSlider.addEventListener('input', () => {
    const v = parseInt(dpiSlider.value) || 200;
    document.getElementById('dpi-val').textContent = v;
    document.getElementById('dpi-est').textContent = estimateSize(v);
    // Update preset buttons
    document.querySelectorAll('.dpi-preset').forEach(b => {
      b.classList.toggle('active', parseInt(b.dataset.val) === v);
    });
  });

  document.querySelectorAll('.dpi-preset').forEach(btn => {
    btn.addEventListener('click', () => {
      const v = btn.dataset.val;
      dpiSlider.value = v;
      dpiSlider.dispatchEvent(new Event('input'));
    });
  });

  function estimateSize(dpi) {
    if (dpi <= 80)  return '~200 KB / page';
    if (dpi <= 160) return '~500 KB / page';
    if (dpi <= 220) return '~800 KB / page';
    if (dpi <= 350) return '~2 MB / page';
    return '~6 MB / page';
  }

  // ── Drag & drop ──
  ['dragenter', 'dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave', 'dragend', 'drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
  fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
  removeFile.addEventListener('click', e => { e.stopPropagation(); resetFile(); });

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
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · PDF Document';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');
    refreshConvertBtn();
  }

  function resetFile() {
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    refreshConvertBtn();
    hideError();
  }

  function refreshConvertBtn() {
    convertBtn.disabled = !selectedFile;
  }

  // ── Password toggle ──
  document.getElementById('toggle-password').addEventListener('click', () => {
    const input  = document.getElementById('opt-password');
    const isPass = input.type === 'password';
    input.type   = isPass ? 'text' : 'password';
    document.getElementById('eye-show').classList.toggle('hidden', isPass);
    document.getElementById('eye-hide').classList.toggle('hidden', !isPass);
  });

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    if (!selectedFile) return;
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const dpi      = parseInt(dpiSlider.value) || 200;
    const password = document.getElementById('opt-password').value.trim();

    const fd = new FormData();
    fd.append('file',   selectedFile);
    fd.append('output', activeMode);
    fd.append('dpi',    dpi);

    if (activeMode === 'single') {
      const pageNum = document.getElementById('opt-single-page').value.trim();
      if (pageNum) fd.append('pages', pageNum);
    } else {
      const pages = document.getElementById('opt-pages').value.trim();
      if (pages) fd.append('pages', pages);
    }

    if (password) fd.append('password', password);

    // Animate
    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 500, 'Uploading & validating PDF…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 55, 700, 'Reading pages at ' + dpi + ' DPI…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 80, 800, 'Rendering each page as PNG…');
    }, 1500);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(80, 92, 500, 'Packaging output…');
    }, 2500);

    try {
      const res = await fetch('https://api.filenewer.com/api/convert/pdf/png/', {
        method: 'POST',
        body: fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch (_) {}
        throw new Error(msg);
      }

      const baseName = selectedFile.name.replace(/\.pdf$/i, '');

      if (activeMode === 'base64') {
        // JSON response with base64 pages
        const data = await res.json();
        await renderBase64Result(data, baseName);
      } else {
        // Binary: zip or single PNG
        const blob = await res.blob();
        renderBinaryResult(blob, baseName, activeMode);
      }

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

  function renderBinaryResult(blob, baseName, mode) {
    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = URL.createObjectURL(blob);

    const link = document.getElementById('download-link');

    if (mode === 'single') {
      const pageNum    = document.getElementById('opt-single-page').value.trim() || '1';
      const outputName = `${baseName}_page_${pageNum}.png`;
      link.href = blobUrl;
      link.download = outputName;
      document.getElementById('output-name').textContent = outputName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · PNG Image';
      document.getElementById('output-icon').textContent = '🖼';
      document.getElementById('download-label').textContent = 'Download PNG';
      document.getElementById('result-subtitle').textContent = 'Your PNG image is ready.';
    } else {
      const outputName = `${baseName}_pages.zip`;
      link.href = blobUrl;
      link.download = outputName;
      document.getElementById('output-name').textContent = outputName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · ZIP Archive';
      document.getElementById('output-icon').textContent = '📦';
      document.getElementById('download-label').textContent = 'Download ZIP';
      document.getElementById('result-subtitle').textContent = 'Your PNG files are ready in a zip archive.';
    }

    document.getElementById('pages-gallery-wrap').classList.add('hidden');
  }

  async function renderBase64Result(data, baseName) {
    const pages = data.pages || [];
    const totalPages = data.total_pages ?? pages.length;

    document.getElementById('pages-count').textContent  = pages.length;
    document.getElementById('pages-plural').textContent = pages.length === 1 ? '' : 's';

    const totalSize = pages.reduce((sum, p) => sum + (p.size_kb || 0), 0);
    document.getElementById('pages-total-size').textContent = formatSizeKb(totalSize) + ' total';

    // Render gallery thumbnails
    const gallery = document.getElementById('pages-gallery');
    gallery.innerHTML = '';
    pages.forEach(p => {
      const thumb = document.createElement('a');
      thumb.className = 'page-thumb';
      thumb.href = 'data:image/png;base64,' + p.base64;
      thumb.download = p.filename;
      thumb.title = `Click to download — ${p.width}×${p.height}, ${formatSizeKb(p.size_kb)}`;
      thumb.innerHTML = `
        <img src="data:image/png;base64,${p.base64}" alt="Page ${p.page}" />
        <div class="page-label">
          <span class="pn">p.${p.page}</span>
          <span>${formatSizeKb(p.size_kb || 0)}</span>
        </div>`;
      gallery.appendChild(thumb);
    });
    document.getElementById('pages-gallery-wrap').classList.remove('hidden');

    // Build a zip using JSZip if available, otherwise just offer JSON download
    const jsonBlob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json;charset=utf-8;' });
    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = URL.createObjectURL(jsonBlob);

    const link = document.getElementById('download-link');
    const outputName = `${baseName}_pages.json`;
    link.href = blobUrl;
    link.download = outputName;
    document.getElementById('output-name').textContent = outputName;
    document.getElementById('output-size').textContent = formatBytes(jsonBlob.size) + ' · JSON Response';
    document.getElementById('output-icon').textContent = '⚙️';
    document.getElementById('download-label').textContent = 'Download JSON';
    document.getElementById('result-subtitle').textContent = `${totalPages} page${totalPages !== 1 ? 's' : ''} rendered as base64. Click any thumbnail to download that page individually.`;
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
    check.classList.add('hidden');
    spin.classList.add('hidden');
    dot.style.borderColor = '';
    dot.style.background  = '';
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
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    resetFile();
    document.getElementById('opt-password').value = '';
    document.getElementById('opt-pages').value = '';
    document.getElementById('opt-single-page').value = '';
    dpiSlider.value = 200;
    dpiSlider.dispatchEvent(new Event('input'));
    document.querySelectorAll('.mode-card').forEach(b => b.classList.toggle('active', b.dataset.mode === 'zip'));
    document.getElementById('pages-section').classList.remove('hidden');
    document.getElementById('single-page-section').classList.add('hidden');
    document.getElementById('pages-gallery-wrap').classList.add('hidden');
    activeMode = 'zip';
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
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }
  function formatSizeKb(kb) {
    if (!kb && kb !== 0) return '—';
    if (kb >= 1024) return (kb / 1024).toFixed(2) + ' MB';
    return Math.round(kb) + ' KB';
  }

  // ── FAQ ──
  document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const body   = btn.nextElementSibling;
      const icon   = btn.querySelector('.faq-icon');
      const isOpen = !body.classList.contains('hidden');
      document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
      document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
      if (!isOpen) {
        body.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
      }
    });
  });

}); // end DOMContentLoaded
</script>
@endpush

@endsection
