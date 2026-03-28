{{-- resources/views/tools/pdf-to-word.blade.php --}}
@extends('layouts.base')

@section('title', 'PDF to Word Converter – Free Online | Filenewer')

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
                        <span class="text-xs font-bold">{{ $n }}</span>
                    </div>
                    <span class="step-label text-xs font-semibold text-fn-text3 transition-colors">{{ $label }}</span>
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
                        <p class="text-fn-text3 text-xs mt-5">Max 50MB free · <a href=""
                                class="text-fn-blue-l hover:underline">200MB on Pro</a></p>
                        {{-- Hidden real file input --}}
                        <input type="file" id="file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview (shown after selection) --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.pdf</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="file-meta">— · PDF Document</p>
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
                    <div class="mt-6 grid sm:grid-cols-3 gap-3">
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-2">Output Format</label>
                            <select id="opt-format"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                <option value="docx">Word 2016+ (.docx)</option>
                                <option value="doc">Word 97-2003 (.doc)</option>
                                <option value="odt">OpenDocument (.odt)</option>
                                <option value="rtf">Rich Text (.rtf)</option>
                            </select>
                        </div>
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-2">OCR Language</label>
                            <select id="opt-ocr-lang"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                <option value="eng">English</option>
                                <option value="fra">French</option>
                                <option value="deu">German</option>
                                <option value="spa">Spanish</option>
                                <option value="ara">Arabic</option>
                            </select>
                        </div>
                        <div
                            class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex flex-col justify-center gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-images" checked
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Preserve images</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-tables" checked
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Preserve tables</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-ocr"
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Enable OCR</span>
                            </label>
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
                        Convert to Word
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
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📝</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2" id="conv-title">Converting your file…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 15 seconds</p>

                    <div class="max-w-md mx-auto mb-3">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-xs text-fn-text3 mb-8">
                        <span id="progress-label">Starting…</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>

                    {{-- Processing steps --}}
                    <div class="max-w-xs mx-auto flex flex-col gap-3 text-left">
                        @foreach([
                        ['proc-1','Uploading & validating PDF'],
                        ['proc-2','Analysing layout & structure'],
                        ['proc-3','Reconstructing tables & fonts'],
                        ['proc-4','Generating Word document'],
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
                            <span class="text-xs text-fn-text3">{{ $plabel }}</span>
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
                    <p class="text-fn-text2 text-sm mb-2">Your Word document is ready.</p>
                    <p class="text-fn-text3 text-xs mb-8">
                        File will be deleted in <span class="text-fn-amber font-semibold font-mono"
                            id="expiry-timer">60:00</span>
                    </p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            📝</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">document.docx</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="output-size">Word Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Word File
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
                        <a href=""
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            All tools
                        </a>
                    </div>

                    <p class="mt-6 text-fn-text3 text-xs flex items-center justify-center gap-1.5">
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
            ['Will my formatting be preserved?', 'Yes — Filenewer uses a multi-pass layout engine that detects columns,
            tables, fonts, images, headers and footers. Accuracy is near-perfect for digital PDFs.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ['Can I convert scanned (image-based) PDFs?', 'Yes — enable the OCR option before converting. Supports 50+
            languages. Best results at 300 DPI or higher.'],
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

{{-- ══ JAVASCRIPT — inline at bottom of @section('content') ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

  // ── Element refs ──
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let selectedFile   = null;
  let expiryInterval = null;

  // ── Drag & drop ──
  ['dragenter', 'dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      dropZone.classList.add('drag-over');
    });
  });

  ['dragleave', 'dragend', 'drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      dropZone.classList.remove('drag-over');
    });
  });

  dropZone.addEventListener('drop', e => {
    const file = e.dataTransfer.files[0];
    if (file) handleFile(file);
  });

  // ── File input change ──
  fileInput.addEventListener('change', e => {
    if (e.target.files[0]) handleFile(e.target.files[0]);
  });

  // ── Remove file ──
  removeFile.addEventListener('click', e => {
    e.stopPropagation();
    resetFile();
  });

  // ── Handle selected file ──
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
    document.getElementById('output-name').textContent = file.name.replace(/\.pdf$/i, '.docx');

    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');
    convertBtn.disabled = false;
  }

  function resetFile() {
    selectedFile      = null;
    fileInput.value   = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    convertBtn.disabled = true;
    hideError();
  }

  // ── Convert button ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    if (!selectedFile) return;

    hideError();
    showState('converting');
    updateStepIndicator(2);

    // Build form data
    const formData = new FormData();
    formData.append('pdf',             selectedFile);
    formData.append('format',          document.getElementById('opt-format').value);
    formData.append('ocr_lang',        document.getElementById('opt-ocr-lang').value);
    formData.append('preserve_images', document.getElementById('opt-images').checked ? '1' : '0');
    formData.append('preserve_tables', document.getElementById('opt-tables').checked  ? '1' : '0');
    formData.append('enable_ocr',      document.getElementById('opt-ocr').checked     ? '1' : '0');
    formData.append('_token',          '{{ csrf_token() }}');

    // Animate progress steps while server processes
    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 800, 'Uploading file…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done');
      setProcessStep('proc-2', 'active');
      animateProgress(20, 50, 1000, 'Analysing layout…');
    }, 1000);

    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done');
      setProcessStep('proc-3', 'active');
      animateProgress(50, 75, 1200, 'Reconstructing tables & fonts…');
    }, 2200);

    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done');
      setProcessStep('proc-4', 'active');
      animateProgress(75, 90, 1000, 'Generating Word document…');
    }, 3600);

    try {
      const res  = await fetch('{{ route("tools.pdf-to-word.convert") }}', {
        method: 'POST',
        body:   formData,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      const data = await res.json();

      if (!res.ok || !data.success) {
        throw new Error(data.message || 'Conversion failed. Please try again.');
      }

      // Finish progress
      setProcessStep('proc-3', 'done');
      setProcessStep('proc-4', 'done');
      animateProgress(90, 100, 400, 'Done!');

      setTimeout(() => {
        document.getElementById('download-link').href        = data.download_url;
        document.getElementById('output-size').textContent  = formatBytes(data.file_size) + ' · Word Document';
        showState('download');
        updateStepIndicator(3);
        startExpiryTimer(3600);
      }, 500);

    } catch (err) {
        console.log(err);

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  // ── State switcher ──
  function showState(state) {
    ['upload', 'converting', 'download'].forEach(s => {
      const el = document.getElementById('state-' + s);
      el.classList.toggle('hidden', s !== state);
    });
    if (state === 'download') {
      document.getElementById('state-download').classList.add('bounce-in');
    }
  }

  // ── Step indicator ──
  function updateStepIndicator(active) {
    [1, 2, 3].forEach(n => {
      const el = document.getElementById('step-' + n);
      el.classList.remove('active', 'done');
      if (n < active)   el.classList.add('done');
      if (n === active) el.classList.add('active');
    });
  }

  // ── Processing steps ──
  function setProcessStep(id, state) {
    const el    = document.getElementById(id);
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

  // ── Progress bar ──
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

  // ── Expiry countdown ──
  function startExpiryTimer(seconds) {
    clearInterval(expiryInterval);
    let rem = seconds;
    expiryInterval = setInterval(() => {
      rem--;
      const m  = String(Math.floor(rem / 60)).padStart(2, '0');
      const s  = String(rem % 60).padStart(2, '0');
      const el = document.getElementById('expiry-timer');
      if (el) el.textContent = m + ':' + s;
      if (rem <= 0) clearInterval(expiryInterval);
    }, 1000);
  }

  // ── Reset ──
  window.resetConverter = function () {
    resetFile();
    showState('upload');
    updateStepIndicator(1);
    clearInterval(expiryInterval);
    animateProgress(0, 0, 0, 'Starting…');
    ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
  };

  // ── Error helpers ──
  function showError(msg) {
    errorText.textContent = msg;
    uploadError.classList.remove('hidden');
    uploadError.classList.add('flex');
  }
  function hideError() {
    uploadError.classList.add('hidden');
    uploadError.classList.remove('flex');
  }

  // ── Format bytes ──
  function formatBytes(bytes) {
    if (bytes < 1024)        return bytes + ' B';
    if (bytes < 1048576)     return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  // ── FAQ accordion ──
  document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const body = btn.nextElementSibling;
      const icon = btn.querySelector('.faq-icon');
      const isOpen = !body.classList.contains('hidden');

      // Close all
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

@endsection
