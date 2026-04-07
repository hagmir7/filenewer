@extends('layouts.base')

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ MAIN CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @php $cmpSteps = [['1','Upload PDF'],['2','Compressing'],['3','Download']]; @endphp
                @foreach($cmpSteps as [$n,$label])
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
                            <div class="w-20 h-20 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-4xl">
                                📕</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-6">or click to browse from your computer</p>
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
                      <p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>


                        <input type="file" id="file-input" accept=".pdf,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
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

                    {{-- Compression level selector --}}
                    <div class="mt-5">
                        <label class="text-sm font-semibold text-fn-text2 block mb-3">Compression Level</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" id="level-grid">
                            @php
                            $levels = [
                            ['low', 'Low', '150 DPI · 85%', 'Minor reduction, best quality', '~10–25%'],
                            ['medium', 'Medium', '120 DPI · 72%', 'Balanced — good for most cases', '~25–50%'],
                            ['high', 'High', '96 DPI · 60%', 'Significant reduction, decent quality','~50–70%'],
                            ['extreme', 'Extreme', '72 DPI · 40%', 'Maximum reduction, lower quality', '~70–85%'],
                            ];
                            @endphp
                            @foreach($levels as [$lval,$lname,$lspec,$ldesc,$lsaving])
                            <button type="button"
                                class="level-btn {{ $lval === 'extreme' ? 'active' : '' }} flex flex-col items-start gap-1 p-3 rounded-xl border text-left transition-all"
                                data-level="{{ $lval }}">
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-sm font-bold">{{ $lname }}</span>
                                    <span class="saving-badge text-sm font-bold px-1.5 py-0.5 rounded-md">{{ $lsaving
                                        }}</span>
                                </div>
                                <span class="text-sm font-mono opacity-70">{{ $lspec }}</span>
                                <span class="text-sm leading-tight opacity-60">{{ $ldesc }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Password (optional) --}}
                    <div class="mt-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl max-w-sm">
                        <label for="opt-password" class="text-sm font-semibold text-fn-text2 block mb-1.5">
                            PDF Password <span class="font-normal text-fn-text3 ml-1">(if encrypted)</span>
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
                                <svg id="eye-hide" class="hidden" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Error banner --}}
                    <div id="upload-error"
                        class="hidden mt-4 flex items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-fn-red shrink-0" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="error-text">Something went wrong.</span>
                    </div>

                    {{-- Compress button --}}
                    <button id="compress-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="8 6 2 12 8 18" />
                            <polyline points="16 6 22 12 16 18" />
                        </svg>
                        Compress PDF
                    </button>

                </div>{{-- /state-upload --}}

                {{-- ── STATE: Compressing ── --}}
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
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            📦</div>
                    </div>
                    <h2 class="text-xl font-bold mb-2" id="conv-title">Compressing your PDF…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this may take a moment for large files</p>

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
                        @php
                        $cmpProcSteps = [
                        ['proc-1','Uploading & reading PDF'],
                        ['proc-2','Compressing images to target DPI'],
                        ['proc-3','Cleaning PDF structure & streams'],
                        ['proc-4','Finalising compressed file'],
                        ];
                        @endphp
                        @foreach($cmpProcSteps as [$pid,$plabel])
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
                    <h2 class="text-2xl font-bold mb-2">Compression Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6" id="result-subtitle">Your file is ready.</p>

                    {{-- Savings card --}}
                    <div class="max-w-sm mx-auto mb-6">
                        <div class="bg-fn-surface2 border border-fn-green/15 rounded-2xl overflow-hidden">
                            {{-- Reduction hero --}}
                            <div class="px-6 py-5 border-b border-fn-text/7 flex items-center justify-between">
                                <div class="text-left">
                                    <p class="text-sm text-fn-text3 font-semibold mb-1">Size Reduction</p>
                                    <p class="text-4xl font-black text-fn-green" id="reduction-pct">—</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-fn-text3 mb-3">
                                        <span id="orig-size">—</span>
                                        <svg class="inline w-3 h-3 mx-1 text-fn-green" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12" />
                                            <polyline points="12 5 19 12 12 19" />
                                        </svg>
                                        <span id="comp-size">—</span>
                                    </div>
                                    {{-- Mini visual bar --}}
                                    <div class="flex items-end gap-1 justify-end h-8">
                                        <div class="w-5 bg-fn-text/20 rounded-t" id="bar-orig" style="height:100%">
                                        </div>
                                        <div class="w-5 bg-fn-green rounded-t transition-all duration-700" id="bar-comp"
                                            style="height:30%"></div>
                                    </div>
                                </div>
                            </div>
                            {{-- Stats row --}}
                            <div class="flex divide-x divide-fn-text/8">
                                @php
                                $statCols = [
                                ['stat-level', 'Level'],
                                ['stat-saved', 'Saved'],
                                ['stat-orig-kb','Original'],
                                ['stat-comp-kb','Compressed'],
                                ];
                                @endphp
                                @foreach($statCols as [$sid,$slabel])
                                <div class="flex-1 px-3 py-3 text-center">
                                    <p class="text-sm text-fn-text3">{{ $slabel }}</p>
                                    <p class="text-sm font-bold text-fn-text2 mt-0.5" id="{{ $sid }}">—</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- File card --}}
                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">compressed.pdf</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">PDF Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="compressed.pdf"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Compressed PDF
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Compress another
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
            @php
            $cmpFaqs = [
            ['Which compression level should I choose?', 'Extreme (default) gives the maximum size reduction — great for
            sharing or uploading. If quality matters more, use High or Medium. Low is ideal when you need minimal size
            reduction with no visible quality loss, such as for print-ready documents.'],
            ['How does compression work?', 'The compressor works in two passes. First it resizes and recompresses
            embedded images to the target DPI and JPEG quality. Then it cleans the PDF structure by removing unused
            objects, deflating all streams, and stripping content stream padding.'],
            ['Will compression affect text or fonts?', 'No — text, fonts, and vector graphics are lossless and are not
            affected by compression. Only raster images (photos, scanned pages) are affected by the DPI and quality
            settings.'],
            ['Can I compress a password-protected PDF?', 'Yes — enter the PDF password in the optional password field
            before compressing.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ];
            @endphp
            @foreach($cmpFaqs as [$q,$a])
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
    /* Level buttons */
    .level-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .level-btn .saving-badge {
        background: oklch(var(--fn-text-l, 80%) 0 0/8%);
        color: var(--fn-text3);
    }

    .level-btn:hover {
        border-color: oklch(49% 0.24 264/30%);
        color: var(--fn-text);
    }

    .level-btn.active {
        border-color: oklch(49% 0.24 264/50%);
        background: oklch(49% 0.24 264/7%);
        color: var(--fn-text);
    }

    .level-btn.active .saving-badge {
        background: oklch(67% 0.18 162/15%);
        color: oklch(67% 0.18 162);
    }

    /* Extreme level gets a special accent */
    .level-btn[data-level="extreme"].active {
        border-color: oklch(62% 0.22 25/50%);
        background: oklch(62% 0.22 25/6%);
    }

    .level-btn[data-level="extreme"].active .saving-badge {
        background: oklch(62% 0.22 25/15%);
        color: oklch(62% 0.22 25);
    }
</style>

{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

  let selectedFile  = null;
  let activeLevel   = 'extreme';
  let blobUrl       = null;

  // ── Drop zone ──
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const filePreview = document.getElementById('file-preview');

  ['dragenter','dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave','dragend','drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
  fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
  document.getElementById('remove-file').addEventListener('click', e => {
    e.stopPropagation();
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    document.getElementById('compress-btn').disabled = true;
    hideError();
  });

  function handleFile(file) {
    hideError();
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
      showError('Please select a valid PDF file.');
      return;
    }
    if (file.size > 50 * 1024 * 1024) { showError('File exceeds the 50MB free limit.'); return; }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · PDF Document';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');
    document.getElementById('compress-btn').disabled = false;
  }

  // ── Level buttons ──
  document.querySelectorAll('.level-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.level-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeLevel = btn.dataset.level;
    });
  });

  // ── Password toggle ──
  document.getElementById('toggle-password').addEventListener('click', () => {
    const input  = document.getElementById('opt-password');
    const isPass = input.type === 'password';
    input.type   = isPass ? 'text' : 'password';
    document.getElementById('eye-show').classList.toggle('hidden', isPass);
    document.getElementById('eye-hide').classList.toggle('hidden', !isPass);
  });

  // ── Compress ──
  document.getElementById('compress-btn').addEventListener('click', startCompression);

  async function startCompression() {
    if (!selectedFile) return;
    hideError();
    showState('converting');
    updateStepIndicator(2);

    document.getElementById('conv-title').textContent = `Compressing with ${activeLevel} level…`;

    const fd = new FormData();
    fd.append('file',              selectedFile);
    fd.append('compression_level', activeLevel);
    fd.append('output',            'json'); // get stats + base64 so we can show savings
    const pw = document.getElementById('opt-password').value.trim();
    if (pw) fd.append('password', pw);

    setProcessStep('proc-1','active');
    animateProgress(0, 20, 700, 'Uploading & reading PDF…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1','done'); setProcessStep('proc-2','active');
      animateProgress(20, 55, 1200, 'Compressing images to target DPI…');
    }, 800);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2','done'); setProcessStep('proc-3','active');
      animateProgress(55, 78, 900, 'Cleaning PDF structure & streams…');
    }, 2100);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3','done'); setProcessStep('proc-4','active');
      animateProgress(78, 90, 600, 'Finalising compressed file…');
    }, 3100);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/pdf-compress', {
        method: 'POST',
        body:   fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        const d = await res.json().catch(() => ({}));
        throw new Error(d.error || 'Compression failed. Please try again.');
      }

      const ct = res.headers.get('Content-Type') || '';

      let blob, stats = {};

      if (ct.includes('application/json')) {
        // JSON response with base64 — output=json path
        const data = await res.json();
        stats = data;
        // Decode base64 → blob
        const binary = atob(data.pdf_base64 || '');
        const bytes  = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
        blob = new Blob([bytes], { type: 'application/pdf' });
      } else {
        // Binary PDF — read stats from response headers
        blob = await res.blob();
        stats = {
          original_size_kb:   parseFloat(res.headers.get('X-Original-Size-KB'))   || (selectedFile.size / 1024),
          compressed_size_kb: parseFloat(res.headers.get('X-Compressed-Size-KB')) || (blob.size / 1024),
          reduction_percent:  parseFloat(res.headers.get('X-Reduction-Percent'))   || 0,
          compression_level:  res.headers.get('X-Compression-Level') || activeLevel,
          filename:           res.headers.get('Content-Disposition')?.match(/filename="?([^"]+)"?/)?.[1] || null,
        };
      }

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const fileName = stats.filename
        || selectedFile.name.replace(/\.pdf$/i, `_compressed_${activeLevel}.pdf`);

      // Wire download
      const link    = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = fileName;

      // Populate results
      const origKb  = stats.original_size_kb   ?? (selectedFile.size / 1024);
      const compKb  = stats.compressed_size_kb  ?? (blob.size / 1024);
      const pct     = stats.reduction_percent    ?? Math.round((1 - compKb / origKb) * 100);
      const savedKb = origKb - compKb;

      document.getElementById('reduction-pct').textContent = Math.round(pct) + '%';
      document.getElementById('orig-size').textContent     = formatKb(origKb);
      document.getElementById('comp-size').textContent     = formatKb(compKb);
      document.getElementById('stat-level').textContent    = capitalize(stats.compression_level || activeLevel);
      document.getElementById('stat-saved').textContent    = formatKb(savedKb);
      document.getElementById('stat-orig-kb').textContent  = formatKb(origKb);
      document.getElementById('stat-comp-kb').textContent  = formatKb(compKb);
      document.getElementById('output-name').textContent   = fileName;
      document.getElementById('output-size').textContent   = formatKb(compKb) + ' · PDF Document';
      document.getElementById('result-subtitle').textContent =
        `Reduced from ${formatKb(origKb)} to ${formatKb(compKb)} — saved ${Math.round(pct)}%`;

      // Animated bar chart
      const barPct = Math.max(5, Math.round((compKb / origKb) * 100));
      setTimeout(() => {
        document.getElementById('bar-comp').style.height = barPct + '%';
      }, 400);

      setProcessStep('proc-3','done'); setProcessStep('proc-4','done');
      animateProgress(90, 100, 300, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 500);

    } catch(err) {
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showState('upload');
      updateStepIndicator(1);
      showError(err.message || 'Something went wrong. Please try again.');
    }
  }

  // ── Helpers ──
  function formatKb(kb) {
    if (!kb && kb !== 0) return '—';
    if (kb >= 1024) return (kb / 1024).toFixed(2) + ' MB';
    return Math.round(kb) + ' KB';
  }
  function capitalize(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : '—'; }

  function showState(state) {
    ['upload','converting','download'].forEach(s => {
      document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
    });
    if (state === 'download') document.getElementById('state-download').classList.add('bounce-in');
  }

  function updateStepIndicator(active) {
    [1,2,3].forEach(n => {
      const el = document.getElementById('step-' + n);
      el.classList.remove('active','done');
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

  function showError(msg) {
    document.getElementById('error-text').textContent = msg;
    const el = document.getElementById('upload-error');
    el.classList.remove('hidden'); el.classList.add('flex');
  }
  function hideError() {
    const el = document.getElementById('upload-error');
    el.classList.add('hidden'); el.classList.remove('flex');
  }
  function formatBytes(bytes) {
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  window.resetConverter = function () {
    if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    document.getElementById('opt-password').value  = '';
    document.getElementById('compress-btn').disabled = true;
    // Reset bar chart
    document.getElementById('bar-comp').style.height = '30%';
    // Reset to extreme
    document.querySelectorAll('.level-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('.level-btn[data-level="extreme"]').classList.add('active');
    activeLevel = 'extreme';
    hideError();
    showState('upload');
    updateStepIndicator(1);
    animateProgress(0, 0, 0, 'Starting…');
    ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
  };

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
