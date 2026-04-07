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
                        <p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>
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
                            <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">— · PDF Document</p>
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

                    {{-- Options --}}
                    <div class="mt-6 space-y-3">

                        {{-- Row 1: Output mode + Page selector --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Output mode --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Output Mode</label>
                                <select id="opt-output"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                    <option value="zip">All pages → ZIP of JPGs</option>
                                    <option value="single">Single page → JPG</option>
                                </select>
                                <p class="text-fn-text3 text-sm mt-1.5" id="output-mode-hint">Every page exported as a
                                    JPG, bundled in a ZIP archive.</p>
                            </div>

                            {{-- Page number (only relevant for single) --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl" id="page-option-wrap">
                                <label for="opt-page" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Page Number
                                    <span class="font-normal text-fn-text3 ml-1" id="page-opt-note">(ZIP mode:
                                        ignored)</span>
                                </label>
                                <input type="number" id="opt-page" min="1" value="1" placeholder="e.g. 3"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 disabled:opacity-40"
                                    disabled />
                                <p class="text-fn-text3 text-sm mt-1.5">Leave blank or 1 for first page</p>
                            </div>
                        </div>

                        {{-- Row 2: DPI + Quality --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                    DPI — <span id="dpi-val" class="text-fn-blue-l">200</span>
                                    <span class="font-normal text-fn-text3 ml-1" id="dpi-hint">(Default · General
                                        use)</span>
                                </label>
                                <input type="range" id="opt-dpi" min="72" max="600" value="200" step="1"
                                    class="w-full accent-fn-blue cursor-pointer" />
                                <div class="flex justify-between text-fn-text3 text-sm mt-1">
                                    <span>72 Web</span><span>150</span><span>200</span><span>300 Print</span><span>600
                                        Hi-res</span>
                                </div>
                            </div>

                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                    JPEG Quality — <span id="quality-val" class="text-fn-blue-l">85</span>%
                                    <span class="font-normal text-fn-text3 ml-1" id="quality-hint">(Default)</span>
                                </label>
                                <input type="range" id="opt-quality" min="1" max="100" value="85" step="1"
                                    class="w-full accent-fn-blue cursor-pointer" />
                                <div class="flex justify-between text-fn-text3 text-sm mt-1">
                                    <span>1 Tiny</span><span>60</span><span>85</span><span>95</span><span>100 Max</span>
                                </div>
                            </div>
                        </div>

                        {{-- Row 3: Password --}}
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-password" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    PDF Password
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <div class="relative">
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

                            {{-- DPI/Quality quick presets --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Quick Presets</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach([
                                    ['Web preview','72','60'],
                                    ['General use','150','75'],
                                    ['Default','200','85'],
                                    ['Print ready','300','90'],
                                    ] as [$plabel, $pdpi, $pq])
                                    <button type="button"
                                        class="preset-btn text-sm px-2 py-1.5 rounded-lg border border-fn-text/10 bg-fn-surface text-fn-text2 hover:border-fn-blue/40 hover:text-fn-text hover:bg-fn-blue/5 transition-all text-left"
                                        data-dpi="{{ $pdpi }}" data-quality="{{ $pq }}">
                                        {{ $plabel }}<br>
                                        <span class="text-fn-text3 text-sm">{{ $pdpi }} DPI · Q{{ $pq }}</span>
                                    </button>
                                    @endforeach
                                </div>
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
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Convert to JPG
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
                            class="w-16 h-16 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-3xl">
                            🖼️</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting your file…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 20 seconds</p>

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
                        ['proc-2','Rendering pages at selected DPI'],
                        ['proc-3','Compressing & optimising JPGs'],
                        ['proc-4','Packaging output file'],
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
                    <p class="text-fn-text2 text-sm mb-8" id="download-subtitle">Your images are ready.</p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            🖼️</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">document_pages.zip</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">JPG Images</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="document_pages.zip"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span id="download-btn-label">Download ZIP</span>
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Convert another
                        </button>
                        <a href="/tools"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            All tools
                        </a>
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
            ['Is this really free?', 'Files up to 50MB are completely free with no account needed. Pro plans unlock
            200MB files and batch conversion.'],
            ['How many pages can I convert?', 'All pages in your PDF are converted and bundled into a single ZIP
            archive. Choose "Single page" mode if you only need one specific page as a JPG.'],
            ['What DPI should I choose?', '200 DPI at quality 85 is the sweet spot for most uses. Use 300 DPI for
            print-quality images, or 72 DPI for fast web previews with small file sizes.'],
            ['Can I convert a password-protected PDF?', 'Yes — enter your PDF password in the optional password field
            before converting.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
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

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      // ── Element refs ──
      const dropZone     = document.getElementById('drop-zone');
      const fileInput    = document.getElementById('file-input');
      const convertBtn   = document.getElementById('convert-btn');
      const filePreview  = document.getElementById('file-preview');
      const removeFile   = document.getElementById('remove-file');
      const uploadError  = document.getElementById('upload-error');
      const errorText    = document.getElementById('error-text');
      const outputSelect = document.getElementById('opt-output');
      const pageInput    = document.getElementById('opt-page');
      const dpiRange     = document.getElementById('opt-dpi');
      const qualityRange = document.getElementById('opt-quality');
      const dpiVal       = document.getElementById('dpi-val');
      const qualityVal   = document.getElementById('quality-val');
      const dpiHint      = document.getElementById('dpi-hint');
      const qualityHint  = document.getElementById('quality-hint');
      const togglePwdBtn = document.getElementById('toggle-password');
      const pwdInput     = document.getElementById('opt-password');
      const eyeShow      = document.getElementById('eye-show');
      const eyeHide      = document.getElementById('eye-hide');
      const pageOptNote  = document.getElementById('page-opt-note');
      const outputModeHint = document.getElementById('output-mode-hint');

      let selectedFile = null;
      let blobUrl      = null;

      // ── DPI hints ──
      const dpiHints = [
        [72,  72,  'Web preview · Very small'],
        [73,  149, 'Below general use'],
        [150, 150, 'General use · Small'],
        [151, 199, 'Good quality'],
        [200, 200, 'Default · Medium'],
        [201, 299, 'Above default'],
        [300, 300, 'Print ready · Large'],
        [301, 599, 'High resolution'],
        [600, 600, 'Hi-res · Very large'],
      ];

      const qualityHints = [
        [1,  59,  'Low quality'],
        [60, 74,  'Web preview'],
        [75, 84,  'General use'],
        [85, 89,  'Default'],
        [90, 94,  'Print ready'],
        [95, 99,  'High quality'],
        [100,100, 'Maximum quality'],
      ];

      function getDpiHint(v) {
        return dpiHints.find(([lo, hi]) => v >= lo && v <= hi)?.[2] ?? '';
      }
      function getQualityHint(v) {
        return qualityHints.find(([lo, hi]) => v >= lo && v <= hi)?.[2] ?? '';
      }

      dpiRange.addEventListener('input', () => {
        dpiVal.textContent  = dpiRange.value;
        dpiHint.textContent = '(' + getDpiHint(+dpiRange.value) + ')';
      });

      qualityRange.addEventListener('input', () => {
        qualityVal.textContent  = qualityRange.value;
        qualityHint.textContent = '(' + getQualityHint(+qualityRange.value) + ')';
      });

      // Init hints
      dpiHint.textContent     = '(' + getDpiHint(200) + ')';
      qualityHint.textContent = '(' + getQualityHint(85) + ')';

      // ── Preset buttons ──
      document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const d = +btn.dataset.dpi;
          const q = +btn.dataset.quality;
          dpiRange.value     = d;
          qualityRange.value = q;
          dpiVal.textContent     = d;
          qualityVal.textContent = q;
          dpiHint.textContent     = '(' + getDpiHint(d) + ')';
          qualityHint.textContent = '(' + getQualityHint(q) + ')';
        });
      });

      // ── Output mode toggle ──
      outputSelect.addEventListener('change', () => {
        const isSingle = outputSelect.value === 'single';
        pageInput.disabled = !isSingle;
        pageOptNote.textContent = isSingle ? '(leave blank for page 1)' : '(ZIP mode: ignored)';
        outputModeHint.textContent = isSingle
          ? 'Exports one specific page as a single JPG file.'
          : 'Every page exported as a JPG, bundled in a ZIP archive.';
      });

      // ── Password toggle ──
      togglePwdBtn.addEventListener('click', () => {
        const isPassword = pwdInput.type === 'password';
        pwdInput.type = isPassword ? 'text' : 'password';
        eyeShow.classList.toggle('hidden', isPassword);
        eyeHide.classList.toggle('hidden', !isPassword);
      });

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

      // ── Handle file ──
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
        convertBtn.disabled = false;
      }

      function resetFile() {
        selectedFile    = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
        dropZone.classList.remove('has-file');
        convertBtn.disabled = true;
        hideError();
      }

      // ── Convert ──
      convertBtn.addEventListener('click', startConversion);

      async function startConversion() {
        if (!selectedFile) return;

        hideError();
        showState('converting');
        updateStepIndicator(2);

        const outputMode = outputSelect.value; // 'zip' | 'single'
        const dpi        = dpiRange.value;
        const quality    = qualityRange.value;
        const password   = pwdInput.value.trim();
        const page       = pageInput.value.trim();

        const baseName   = selectedFile.name.replace(/\.pdf$/i, '');
        const isSingle   = outputMode === 'single';
        const pageNum    = isSingle && page ? parseInt(page, 10) : 1;

        const formData = new FormData();
        formData.append('file',    selectedFile);
        formData.append('output',  outputMode);
        formData.append('dpi',     dpi);
        formData.append('quality', quality);
        if (password) formData.append('password', password);
        if (isSingle && page && parseInt(page, 10) > 1) formData.append('page', page);

        // Animate progress
        setProcessStep('proc-1', 'active');
        animateProgress(0, 20, 800, 'Uploading file…');

        const t2 = setTimeout(() => {
          setProcessStep('proc-1', 'done');
          setProcessStep('proc-2', 'active');
          animateProgress(20, 55, 1200, 'Rendering pages at ' + dpi + ' DPI…');
        }, 1000);

        const t3 = setTimeout(() => {
          setProcessStep('proc-2', 'done');
          setProcessStep('proc-3', 'active');
          animateProgress(55, 78, 1000, 'Compressing & optimising JPGs…');
        }, 2400);

        const t4 = setTimeout(() => {
          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'active');
          animateProgress(78, 90, 800, 'Packaging output file…');
        }, 3600);

        try {
          const res = await fetch('https://api.filenewer.com/api/tools/pdf-to-jpg', {
            method: 'POST',
            body:   formData,
          });

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!res.ok) {
            let errMsg = 'Conversion failed. Please try again.';
            try { const d = await res.json(); if (d.error) errMsg = d.error; } catch (_) {}
            throw new Error(errMsg);
          }

          const contentType = res.headers.get('Content-Type') || '';
          let blob, fileName, downloadLabel, subtitle;

          if (contentType.includes('application/json')) {
            // base64 JSON response (shouldn't happen with zip/single, but handle gracefully)
            const data = await res.json();
            // Re-construct as a zip from base64 pages using JSZip if available,
            // otherwise just download the JSON for debugging
            const jsonStr = JSON.stringify(data, null, 2);
            blob          = new Blob([jsonStr], { type: 'application/json' });
            fileName      = baseName + '_pages.json';
            downloadLabel = 'Download JSON';
            subtitle      = `${data.total_pages ?? ''} pages · ${data.dpi ?? dpi} DPI · Q${data.quality ?? quality}`;
          } else if (isSingle) {
            blob          = await res.blob();
            fileName      = baseName + '_page_' + pageNum + '.jpg';
            downloadLabel = 'Download JPG';
            subtitle      = 'Single page JPG · ' + formatBytes(blob.size);
          } else {
            blob          = await res.blob();
            fileName      = baseName + '_pages.zip';
            downloadLabel = 'Download ZIP';
            subtitle      = 'ZIP of JPG images · ' + formatBytes(blob.size);
          }

          if (blobUrl) URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(blob);

          const link    = document.getElementById('download-link');
          link.href     = blobUrl;
          link.download = fileName;

          document.getElementById('output-name').textContent      = fileName;
          document.getElementById('output-size').textContent      = subtitle;
          document.getElementById('download-btn-label').textContent = downloadLabel;
          document.getElementById('download-subtitle').textContent  = isSingle
            ? 'Your JPG image is ready.'
            : 'Your JPG images are packed and ready.';

          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'done');
          animateProgress(90, 100, 400, 'Done!');

          setTimeout(() => { showState('download'); updateStepIndicator(3); }, 500);

        } catch (err) {
          console.error(err);
          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
          showError(err.message || 'Something went wrong. Please try again.');
          showState('upload');
          updateStepIndicator(1);
        }
      }

      // ── Helpers ──
      function showState(state) {
        ['upload', 'converting', 'download'].forEach(s => {
          document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
        });
        if (state === 'download') document.getElementById('state-download').classList.add('bounce-in');
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
        pwdInput.value         = '';
        pageInput.value        = '1';
        dpiRange.value         = 200;
        qualityRange.value     = 85;
        dpiVal.textContent     = 200;
        qualityVal.textContent = 85;
        dpiHint.textContent     = '(' + getDpiHint(200) + ')';
        qualityHint.textContent = '(' + getQualityHint(85) + ')';
        outputSelect.value     = 'zip';
        pageInput.disabled     = true;
        pageOptNote.textContent = '(ZIP mode: ignored)';
        outputModeHint.textContent = 'Every page exported as a JPG, bundled in a ZIP archive.';
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

      // ── FAQ accordion ──
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
