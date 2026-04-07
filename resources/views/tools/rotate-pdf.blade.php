@extends('layouts.base')
@push('scripts')
<x-ld-json :tool="$tool" />
@endpush
@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ MAIN CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @php $rotSteps = [['1','Upload PDF'],['2','Set Rotation'],['3','Download']]; @endphp
                @foreach($rotSteps as [$n,$label])
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
                        <input type="file" id="file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- Error --}}
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

                </div>{{-- /state-upload --}}

                {{-- ── STATE: Loading page info ── --}}
                <div id="state-loading" class="hidden text-center py-12">
                    <svg class="spin w-10 h-10 text-fn-blue-l mx-auto mb-4" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60"
                            stroke-dashoffset="20" stroke-linecap="round" />
                    </svg>
                    <p class="text-fn-text2 font-semibold">Reading PDF pages…</p>
                    <p class="text-fn-text3 text-sm mt-1">Fetching page dimensions and current rotation</p>
                </div>

                {{-- ── STATE: Configure rotation ── --}}
                <div id="state-configure" class="hidden">

                    {{-- File info bar --}}
                    <div class="flex items-center gap-4 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-6">
                        <div
                            class="w-10 h-10 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="cfg-file-name">document.pdf</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="cfg-file-meta">—</p>
                        </div>
                        <button type="button" id="change-file-btn"
                            class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Change file
                        </button>
                    </div>

                    {{-- Global rotation controls --}}
                    <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-fn-text2 mb-0.5">Rotate All Pages</p>
                                <p class="text-fn-text3 text-sm">Apply the same rotation to every page at once</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @php
                                $rotBtns = [
                                ['90', '↻ 90°', 'Rotate right 90°'],
                                ['180', '↻ 180°', 'Flip upside down'],
                                ['270', '↺ 90°', 'Rotate left 90°'],
                                ['0', '✕ Reset', 'Reset all to 0°'],
                                ];
                                @endphp
                                @foreach($rotBtns as [$rval,$rlabel,$rtitle])
                                <button type="button"
                                    class="global-rot-btn px-3 py-2 rounded-xl border text-sm font-bold transition-all"
                                    data-rot="{{ $rval }}" title="{{ $rtitle }}">
                                    {{ $rlabel }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Page grid --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">Pages — <span id="page-count-label">0
                                    pages</span></p>
                            <p class="text-fn-text3 text-sm">Click a page to cycle rotation · use buttons for precise
                                control</p>
                        </div>
                        <div id="page-grid" class="grid gap-3"
                            style="grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));"></div>
                    </div>

                    {{-- Apply button --}}
                    <button type="button" id="apply-btn"
                        class="w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all hover:bg-fn-blue-l hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Apply Rotation & Download
                    </button>

                    {{-- Apply error --}}
                    <div id="apply-error"
                        class="hidden mt-3 flex items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-fn-red shrink-0" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="apply-error-text"></span>
                    </div>

                </div>{{-- /state-configure --}}

                {{-- ── STATE: Applying ── --}}
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
                            🔄</div>
                    </div>
                    <h2 class="text-xl font-bold mb-2">Rotating pages…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes just a few seconds</p>
                    <div class="max-w-md mx-auto mb-3">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-sm text-fn-text3">
                        <span id="progress-label">Starting…</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Rotation Applied!</h2>
                    <p class="text-fn-text2 text-sm mb-8">Your rotated PDF is ready.</p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">rotated.pdf</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">PDF Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="rotated.pdf"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Rotated PDF
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" id="rotate-again-btn"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Rotate another
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
            $rotFaqs = [
            ['Can I rotate individual pages differently?', 'Yes — every page gets its own rotation control. Click a page
            thumbnail to cycle through 0°, 90°, 180°, and 270°, or use the ↻ and ↺ buttons on each card for precise
            control. The thumbnail updates live so you can see exactly how it will look.'],
            ['What rotation options are available?', '0° (original), 90° clockwise, 180° (upside down), and 270° (90°
            counter-clockwise). You can also apply a rotation globally to all pages at once using the Rotate All
            controls.'],
            ['Does it preserve the existing rotation of my pages?', 'Yes — when you upload a PDF the tool reads the
            current rotation of every page via the page info API and displays it. Your adjustments are relative
            additions to the existing rotation.'],
            ['Can I rotate only specific pages?', 'Yes — simply leave pages you don\'t want to rotate at 0° (or their
            current rotation). Only pages where the rotation differs from the original will have rotation applied.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ];
            @endphp
            @foreach($rotFaqs as [$q,$a])
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

@push('styles')
    {{-- ══ STYLES ══ --}}
    <style>
        .global-rot-btn {
            color: var(--fn-text2);
            border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
            background: var(--fn-surface);
        }

        .global-rot-btn:hover {
            border-color: oklch(49% 0.24 264/30%);
            color: var(--fn-blue-l);
            background: oklch(49% 0.24 264/6%);
        }

        .page-card {
            border: 2px solid oklch(var(--fn-text-l, 80%) 0 0/10%);
            border-radius: 12px;
            background: var(--fn-surface2);
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
            user-select: none;
        }

        .page-card:hover {
            border-color: oklch(49% 0.24 264/35%);
        }

        .page-card.rotated {
            border-color: oklch(49% 0.24 264/50%);
            background: oklch(49% 0.24 264/5%);
        }

        .page-thumb {
            aspect-ratio: 210/297;
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .page-thumb-lines {
            position: absolute;
            inset: 8px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            opacity: 0.15;
        }

        .page-thumb-line {
            height: 2px;
            background: #374151;
            border-radius: 1px;
        }

        .page-rot-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 6px;
            transition: all .2s;
        }

        .page-rot-badge.is-zero {
            background: oklch(var(--fn-surface2-l, 22%) 0 0/1);
            color: var(--fn-text3);
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/10%);
        }

        .page-rot-badge.not-zero {
            background: oklch(49% 0.24 264/12%);
            color: var(--fn-blue-l);
            border: 1px solid oklch(49% 0.24 264/30%);
        }

        .page-ctrl-btn {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/12%);
            background: var(--fn-surface);
            color: var(--fn-text3);
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            cursor: pointer;
        }

        .page-ctrl-btn:hover {
            border-color: oklch(49% 0.24 264/30%);
            color: var(--fn-blue-l);
        }
    </style>
@endpush

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      // ── State ──
      let selectedFile  = null;
      let blobUrl       = null;
      let pageData      = [];   // [{ page, width, height, rotation (original) }]
      let userRotations = [];   // per-page additional rotation (0/90/180/270)

      // ── Drop zone ──
      const dropZone   = document.getElementById('drop-zone');
      const fileInput  = document.getElementById('file-input');

      ['dragenter','dragover'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
      });
      ['dragleave','dragend','drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
      });
      dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
      fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });

      function handleFile(file) {
        hideError();
        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
          showError('Please select a valid PDF file.');
          return;
        }
        if (file.size > 50 * 1024 * 1024) { showError('File exceeds the 50MB free limit.'); return; }
        selectedFile = file;
        loadPageInfo();
      }

      // ── Change file ──
      document.getElementById('change-file-btn').addEventListener('click', () => {
        showState('upload');
        updateStepIndicator(1);
        selectedFile  = null;
        fileInput.value = '';
        pageData      = [];
        userRotations = [];
        document.getElementById('page-grid').innerHTML = '';
      });

      // ── Load page info via /api/tools/pdf-pages ──
      async function loadPageInfo() {
        showState('loading');
        updateStepIndicator(2);

        const fd = new FormData();
        fd.append('file', selectedFile);

        try {
          const res  = await fetch('https://api.filenewer.com/api/tools/pdf-pages', { method: 'POST', body: fd });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Could not read PDF pages.');

          pageData      = data.pages ?? [];
          userRotations = pageData.map(() => 0);

          // Populate file info bar
          document.getElementById('cfg-file-name').textContent = selectedFile.name;
          document.getElementById('cfg-file-meta').textContent =
            formatBytes(selectedFile.size) + ' · ' + pageData.length + ' page' + (pageData.length !== 1 ? 's' : '');
          document.getElementById('page-count-label').textContent =
            pageData.length + ' page' + (pageData.length !== 1 ? 's' : '');

          buildPageGrid();
          showState('configure');

        } catch(err) {
          showState('upload');
          updateStepIndicator(1);
          showError(err.message || 'Failed to read PDF. Please try again.');
        }
      }

      // ── Build page grid ──
      function buildPageGrid() {
        const grid = document.getElementById('page-grid');
        grid.innerHTML = '';

        pageData.forEach((page, idx) => {
          const card = document.createElement('div');
          card.className = 'page-card p-2';
          card.id = `page-card-${idx}`;
          card.innerHTML = pageCardHTML(page, idx, userRotations[idx]);
          grid.appendChild(card);

          // Click to cycle
          card.querySelector('.page-thumb').addEventListener('click', () => cycleRotation(idx));
          // CW button
          card.querySelector('.btn-cw').addEventListener('click', e => { e.stopPropagation(); addRotation(idx, 90); });
          // CCW button
          card.querySelector('.btn-ccw').addEventListener('click', e => { e.stopPropagation(); addRotation(idx, -90); });
        });
      }

      function pageCardHTML(page, idx, userRot) {
        const totalRot   = (page.rotation + userRot + 360) % 360;
        const isLandscape = (totalRot === 90 || totalRot === 270);
        const badgeClass  = userRot === 0 ? 'is-zero' : 'not-zero';
        const badgeText   = userRot === 0 ? `${totalRot}°` : `+${userRot}° → ${totalRot}°`;

        return `
          <div class="page-thumb mb-2" style="transform-origin:center; ${isLandscape ? 'aspect-ratio:297/210' : ''}">
            <div class="absolute inset-0" style="transform:rotate(${totalRot}deg); transition:transform .3s ease;">
              <div style="position:absolute;inset:0;background:white;border-radius:6px;"></div>
              <div class="page-thumb-lines">
                <div class="page-thumb-line" style="width:85%"></div>
                <div class="page-thumb-line" style="width:70%"></div>
                <div class="page-thumb-line" style="width:90%"></div>
                <div class="page-thumb-line" style="width:60%"></div>
                <div class="page-thumb-line" style="width:80%"></div>
                <div class="page-thumb-line" style="width:65%"></div>
                <div class="page-thumb-line" style="width:75%"></div>
              </div>
            </div>
          </div>
          <div class="flex items-center justify-between px-1">
            <div>
              <p class="text-sm font-bold text-fn-text2">P${page.page}</p>
              <span class="page-rot-badge ${badgeClass}">${badgeText}</span>
            </div>
            <div class="flex gap-1">
              <button class="page-ctrl-btn btn-ccw" title="Rotate left 90°">↺</button>
              <button class="page-ctrl-btn btn-cw"  title="Rotate right 90°">↻</button>
            </div>
          </div>`;
      }

      function cycleRotation(idx) {
        userRotations[idx] = (userRotations[idx] + 90) % 360;
        refreshCard(idx);
      }

      function addRotation(idx, delta) {
        userRotations[idx] = ((userRotations[idx] + delta) + 360) % 360;
        refreshCard(idx);
      }

      function refreshCard(idx) {
        const card = document.getElementById(`page-card-${idx}`);
        if (!card) return;
        card.innerHTML = pageCardHTML(pageData[idx], idx, userRotations[idx]);
        card.classList.toggle('rotated', userRotations[idx] !== 0);
        card.querySelector('.page-thumb').addEventListener('click', () => cycleRotation(idx));
        card.querySelector('.btn-cw').addEventListener('click',  e => { e.stopPropagation(); addRotation(idx, 90); });
        card.querySelector('.btn-ccw').addEventListener('click', e => { e.stopPropagation(); addRotation(idx, -90); });
      }

      // ── Global rotation buttons ──
      document.querySelectorAll('.global-rot-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const rot = parseInt(btn.dataset.rot);
          userRotations = userRotations.map(() => rot);
          buildPageGrid(); // rebuild all cards
        });
      });

      // ── Apply rotation ──
      document.getElementById('apply-btn').addEventListener('click', applyRotation);

      async function applyRotation() {
        document.getElementById('apply-error').classList.add('hidden');

        // Determine which pages need rotation (user rotation ≠ 0)
        // If all pages have the same non-zero rotation → use global rotation param
        // Otherwise → per-page approach: send multiple requests or group by rotation value
        // API supports: rotation + optional pages= comma list
        // Strategy: group pages by their userRotation value, send one request per group,
        // then combine. If only one rotation value is used → single request.

        const rotGroups = {};
        userRotations.forEach((rot, idx) => {
          if (rot === 0) return; // skip no-change pages
          if (!rotGroups[rot]) rotGroups[rot] = [];
          rotGroups[rot].push(pageData[idx].page);
        });

        const allZero = Object.keys(rotGroups).length === 0;
        if (allZero) {
          document.getElementById('apply-error-text').textContent = 'No rotation applied — please rotate at least one page.';
          document.getElementById('apply-error').classList.remove('hidden');
          return;
        }

        showState('converting');
        animateProgress(0, 30, 600, 'Preparing rotation…');

        try {
          let resultBlob;
          const rotEntries = Object.entries(rotGroups);

          if (rotEntries.length === 1) {
            // Single rotation value — one API call
            const [rotation, pages] = rotEntries[0];
            const allPages = pages.length === pageData.length;
            resultBlob = await callRotateApi(selectedFile, rotation, allPages ? null : pages.join(','));
            animateProgress(30, 90, 800, 'Rotating pages…');

          } else {
            // Multiple rotation values — chain calls: each call takes output of previous as input
            animateProgress(30, 50, 500, 'Rotating first group…');
            let currentBlob = null;

            for (let i = 0; i < rotEntries.length; i++) {
              const [rotation, pages] = rotEntries[i];
              const sourceFile = currentBlob
                ? new File([currentBlob], selectedFile.name, { type: 'application/pdf' })
                : selectedFile;

              currentBlob = await callRotateApi(sourceFile, rotation, pages.join(','));
              animateProgress(50 + Math.round((i + 1) / rotEntries.length * 35), 85, 400,
                `Rotating group ${i + 1} of ${rotEntries.length}…`);
            }
            resultBlob = currentBlob;
          }

          animateProgress(90, 100, 300, 'Done!');

          if (blobUrl) URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(resultBlob);

          const fileName = selectedFile.name.replace(/\.pdf$/i, '_rotated.pdf');
          const link = document.getElementById('download-link');
          link.href     = blobUrl;
          link.download = fileName;

          document.getElementById('output-name').textContent = fileName;
          document.getElementById('output-size').textContent = formatBytes(resultBlob.size) + ' · PDF Document';

          setTimeout(() => { showState('download'); updateStepIndicator(3); }, 500);

        } catch(err) {
          showState('configure');
          document.getElementById('apply-error-text').textContent = err.message || 'Rotation failed. Please try again.';
          document.getElementById('apply-error').classList.remove('hidden');
        }
      }

      async function callRotateApi(file, rotation, pages) {
        const fd = new FormData();
        fd.append('file',     file);
        fd.append('rotation', rotation);
        if (pages) fd.append('pages', pages);

        const res = await fetch('https://api.filenewer.com/api/tools/pdf-rotate', { method: 'POST', body: fd });
        if (!res.ok) {
          const d = await res.json().catch(() => ({}));
          throw new Error(d.error || 'Rotation failed.');
        }
        return await res.blob();
      }

      // ── Rotate again button ──
      document.getElementById('rotate-again-btn').addEventListener('click', () => {
        // Go back to configure with same file
        userRotations = pageData.map(() => 0);
        buildPageGrid();
        showState('configure');
        updateStepIndicator(2);
      });

      // ── Helpers ──
      function showState(state) {
        ['upload','loading','configure','converting','download'].forEach(s => {
          document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
        });
      }

      function updateStepIndicator(active) {
        [1,2,3].forEach(n => {
          const el = document.getElementById('step-' + n);
          el.classList.remove('active','done');
          if (n < active)   el.classList.add('done');
          if (n === active) el.classList.add('active');
        });
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
        document.getElementById('upload-error').classList.remove('hidden');
        document.getElementById('upload-error').classList.add('flex');
      }
      function hideError() {
        document.getElementById('upload-error').classList.add('hidden');
        document.getElementById('upload-error').classList.remove('flex');
      }
      function formatBytes(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
      }

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
@endpush

@endsection
