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
            @php
            $steps = [
            ['1', 'Upload Word'],
            ['2', 'Splitting'],
            ['3', 'Download'],
            ];
            @endphp
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach($steps as [$n, $label])
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
                                class="w-20 h-20 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-4xl">
                                📄</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your Word file here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .docx files &middot; or click to browse</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose Word File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 200MB free</p>
                        <input type="file" id="file-input"
                            accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            📄</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.docx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">&mdash; &middot; Word Document</p>
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

                        {{-- Row 1: Split Mode --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-sm font-semibold text-fn-text2 block mb-3">Split Mode</label>
                            @php
                            $splitModes = [
                            ['page', 'By Page Break', 'Split at every page break in the document'],
                            ['heading', 'By Heading', 'Split at each heading of a chosen level'],
                            ['chunk', 'By Paragraph Count', 'Split every N paragraphs'],
                            ['range', 'By Page Range', 'Extract specific pages or page ranges'],
                            ];
                            @endphp
                            <div class="grid sm:grid-cols-2 gap-2">
                                @foreach($splitModes as [$modeVal, $modeLabel, $modeDesc])
                                <button type="button"
                                    class="split-mode-btn {{ $modeVal === 'page' ? 'active' : '' }} p-3 rounded-xl border text-left transition-all"
                                    data-mode="{{ $modeVal }}">
                                    <span class="block text-sm font-semibold">{{ $modeLabel }}</span>
                                    <span class="block text-xs text-fn-text3 mt-0.5">{{ $modeDesc }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Conditional: Heading Level (shown when split_by=heading) --}}
                        <div id="opt-heading-wrap" class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-sm font-semibold text-fn-text2 block mb-2">Heading Level</label>
                            @php
                            $headingLevels = [
                            ['1', 'H1'],
                            ['2', 'H2'],
                            ['3', 'H3'],
                            ['4', 'H4'],
                            ['5', 'H5'],
                            ['6', 'H6'],
                            ];
                            @endphp
                            <div class="grid grid-cols-6 gap-2">
                                @foreach($headingLevels as [$hVal, $hLabel])
                                <button type="button"
                                    class="heading-btn {{ $hVal === '1' ? 'active' : '' }} py-1.5 rounded-lg border text-sm font-bold transition-all"
                                    data-level="{{ $hVal }}">
                                    {{ $hLabel }}
                                </button>
                                @endforeach
                            </div>
                            <p class="text-fn-text3 text-sm mt-2">Split at each Heading 1 (chapters). Use H2 for
                                sections, H3 for sub-sections.</p>
                        </div>

                        {{-- Conditional: Chunk Size (shown when split_by=chunk) --}}
                        <div id="opt-chunk-wrap" class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label for="opt-chunk-size" class="text-sm font-semibold text-fn-text2 block mb-2">
                                Paragraphs per Part
                                <span class="font-normal text-fn-text3 ml-1">(<span id="chunk-value">10</span>)</span>
                            </label>
                            <input type="range" id="opt-chunk-size" min="1" max="100" value="10"
                                class="w-full accent-fn-blue cursor-pointer" />
                            <div class="flex justify-between text-fn-text3 text-xs mt-1">
                                <span>1</span>
                                <span>100</span>
                            </div>
                        </div>

                        {{-- Conditional: Page Ranges (shown when split_by=range) --}}
                        <div id="opt-range-wrap" class="hidden p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label for="opt-pages" class="text-sm font-semibold text-fn-text2 block mb-2">
                                Pages or Ranges
                            </label>
                            <input type="text" id="opt-pages" placeholder="e.g. 1,3,5 or [[1,3],[4,6],[7,10]]"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <p class="text-fn-text3 text-sm mt-1.5">Single pages: 1,3,5 &middot; Ranges: [[1,3],[4,6]]
                                &middot; Mix both as needed.</p>
                        </div>

                        {{-- Row 2: Output filename --}}
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="e.g. split_output.zip"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to your filename with _split.zip</p>
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

                    {{-- Split button --}}
                    <button id="convert-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Split Document
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📄</div>
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
                            📑</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Splitting your document&hellip;</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 30 seconds</p>

                    <div class="max-w-md mx-auto mb-3">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-sm text-fn-text3 mb-8">
                        <span id="progress-label">Starting&hellip;</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>

                    @php
                    $procSteps = [
                    ['proc-1', 'Uploading & reading document'],
                    ['proc-2', 'Analyzing structure & split points'],
                    ['proc-3', 'Splitting into parts'],
                    ['proc-4', 'Packaging ZIP archive'],
                    ];
                    @endphp
                    <div class="max-w-xs mx-auto flex flex-col gap-3 text-left">
                        @foreach($procSteps as [$pid, $plabel])
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
                    <h2 class="text-2xl font-bold mb-2">Split Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-8" id="download-subtitle">Your split files are ready.</p>

                    {{-- Parts list --}}
                    <div id="parts-wrap" class="hidden max-w-lg mx-auto mb-6">
                        <p class="text-fn-text2 text-sm font-semibold mb-2 text-left">Parts</p>
                        <div id="parts-list" class="space-y-2 text-left"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0"
                            id="output-icon">🗜️</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">split_output.zip</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">ZIP Archive</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="split_output.zip"
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
                            Split another
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

            </div>
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @php
            $faqs = [
            ['Is this really free?', 'Files up to 50MB are completely free with no account needed. Pro plans unlock
            200MB files and batch processing.'],
            ['What split modes are available?', 'Four modes: split by page breaks, by heading level (H1-H6), by
            paragraph count (every N paragraphs), or by specific page ranges.'],
            ['How does split by heading work?', 'The tool finds every heading of your chosen level (e.g. Heading 1 for
            chapters) and creates a separate .docx file for each section.'],
            ['Can I extract specific pages?', 'Yes, use the Page Range mode. Enter individual pages like 1,3,5 or ranges
            like [[1,3],[4,6]] to extract exactly the pages you need.'],
            ['What format are the output files?', 'Each part is a standalone .docx file. All parts are bundled together
            in a single ZIP archive for easy download.'],
            ['Will formatting be preserved?', 'Yes, all styles, fonts, images, tables, headers, and footers from the
            original document are preserved in each split part.'],
            ['Is my file safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ];
            @endphp

            @foreach($faqs as [$q, $a])
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
    .split-mode-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
    }

    .split-mode-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .split-mode-btn.active span:first-child {
        color: var(--fn-blue-l);
    }

    .split-mode-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    .heading-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
    }

    .heading-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .heading-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    .part-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        border-radius: 10px;
    }

    .part-row .part-num {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: oklch(67% 0.18 162 / 12%);
        color: oklch(67% 0.18 162);
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    input[type="range"] {
        height: 6px;
        border-radius: 3px;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

      var dropZone    = document.getElementById('drop-zone');
      var fileInput   = document.getElementById('file-input');
      var convertBtn  = document.getElementById('convert-btn');
      var filePreview = document.getElementById('file-preview');
      var removeFile  = document.getElementById('remove-file');
      var uploadError = document.getElementById('upload-error');
      var errorText   = document.getElementById('error-text');
      var chunkSlider = document.getElementById('opt-chunk-size');
      var chunkValue  = document.getElementById('chunk-value');

      var selectedFile = null;
      var blobUrl      = null;
      var activeSplit  = 'page';
      var activeHeading = '1';

      // ── Split mode buttons ──
      document.querySelectorAll('.split-mode-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.split-mode-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          activeSplit = btn.dataset.mode;
          document.getElementById('opt-heading-wrap').classList.toggle('hidden', activeSplit !== 'heading');
          document.getElementById('opt-chunk-wrap').classList.toggle('hidden', activeSplit !== 'chunk');
          document.getElementById('opt-range-wrap').classList.toggle('hidden', activeSplit !== 'range');
        });
      });

      // ── Heading level buttons ──
      document.querySelectorAll('.heading-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.heading-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          activeHeading = btn.dataset.level;
        });
      });

      // ── Chunk slider ──
      chunkSlider.addEventListener('input', function () {
        chunkValue.textContent = chunkSlider.value;
      });

      // ── Drag & drop ──
      ['dragenter', 'dragover'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
      });
      ['dragleave', 'dragend', 'drop'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
      });
      dropZone.addEventListener('drop', function (e) { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
      fileInput.addEventListener('change', function (e) { if (e.target.files[0]) handleFile(e.target.files[0]); });
      removeFile.addEventListener('click', function (e) { e.stopPropagation(); resetFile(); });

      function handleFile(file) {
        hideError();
        var ext = file.name.toLowerCase().slice(file.name.lastIndexOf('.'));
        if (ext !== '.docx') {
          showError('Please select a valid .docx file.');
          return;
        }
        if (file.size > 50 * 1024 * 1024) {
          showError('File exceeds the 50MB free limit.');
          return;
        }
        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' \u00b7 Word Document';
        var fnInput = document.getElementById('opt-filename');
        if (!fnInput.value) fnInput.value = file.name.replace(/\.docx$/i, '_split.zip');
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

        var customFilename = document.getElementById('opt-filename').value.trim();
        var baseName       = selectedFile.name.replace(/\.docx$/i, '');
        var outputFilename = customFilename
          ? (customFilename.indexOf('.') !== -1 ? customFilename : customFilename + '.zip')
          : baseName + '_split.zip';

        var formData = new FormData();
        formData.append('file',     selectedFile);
        formData.append('split_by', activeSplit);
        formData.append('output',   'zip');

        if (activeSplit === 'heading') formData.append('heading_level', activeHeading);
        if (activeSplit === 'chunk')   formData.append('chunk_size', chunkSlider.value);
        if (activeSplit === 'range') {
          var pagesVal = document.getElementById('opt-pages').value.trim();
          if (!pagesVal) { showError('Please enter pages or page ranges.'); showState('upload'); updateStepIndicator(1); return; }
          formData.append('pages', pagesVal);
        }

        // Animate
        setProcessStep('proc-1', 'active');
        animateProgress(0, 20, 800, 'Uploading & reading document\u2026');

        var t2 = setTimeout(function () {
          setProcessStep('proc-1', 'done');
          setProcessStep('proc-2', 'active');
          animateProgress(20, 50, 1200, 'Analyzing structure & split points\u2026');
        }, 900);

        var t3 = setTimeout(function () {
          setProcessStep('proc-2', 'done');
          setProcessStep('proc-3', 'active');
          animateProgress(50, 78, 1500, 'Splitting into parts\u2026');
        }, 2300);

        var t4 = setTimeout(function () {
          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'active');
          animateProgress(78, 90, 700, 'Packaging ZIP archive\u2026');
        }, 4000);

        // Also fetch JSON metadata in parallel (non-blocking)
        var jsonForm = new FormData();
        jsonForm.append('file',     selectedFile);
        jsonForm.append('split_by', activeSplit);
        jsonForm.append('output',   'json');
        if (activeSplit === 'heading') jsonForm.append('heading_level', activeHeading);
        if (activeSplit === 'chunk')   jsonForm.append('chunk_size', chunkSlider.value);
        if (activeSplit === 'range') {
          var pv = document.getElementById('opt-pages').value.trim();
          if (pv) jsonForm.append('pages', pv);
        }

        try {
          var results = await Promise.all([
            fetch('https://api.filenewer.com/api/tools/split-docx', { method: 'POST', body: formData }),
            fetch('https://api.filenewer.com/api/tools/split-docx', { method: 'POST', body: jsonForm }).catch(function () { return null; })
          ]);

          var zipRes  = results[0];
          var jsonRes = results[1];

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!zipRes.ok) {
            var errMsg = 'Split failed. Please try again.';
            try { var d = await zipRes.json(); if (d.error) errMsg = d.error; } catch (_) {}
            throw new Error(errMsg);
          }

          var blob = await zipRes.blob();

          if (blobUrl) URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(blob);

          var link    = document.getElementById('download-link');
          link.href     = blobUrl;
          link.download = outputFilename;

          document.getElementById('output-name').textContent        = outputFilename;
          document.getElementById('output-size').textContent        = formatBytes(blob.size) + ' \u00b7 ZIP Archive';
          document.getElementById('download-btn-label').textContent = 'Download ZIP';

          // Parts list from JSON
          var partsWrap = document.getElementById('parts-wrap');
          if (jsonRes && jsonRes.ok) {
            try {
              var meta = await jsonRes.json();
              document.getElementById('download-subtitle').textContent = 'Split into ' + (meta.total_parts || '?') + ' parts.';
              if (meta.parts && meta.parts.length > 0) {
                var listEl = document.getElementById('parts-list');
                listEl.innerHTML = '';
                meta.parts.forEach(function (part) {
                  var row = document.createElement('div');
                  row.className = 'part-row';
                  row.innerHTML =
                    '<span class="part-num">' + part.index + '</span>' +
                    '<div class="flex-1 min-w-0">' +
                    '<p class="font-semibold text-sm truncate">' + escHtml(part.filename) + '</p>' +
                    '<p class="text-fn-text3 text-xs">' + (part.title ? escHtml(part.title) + ' \u00b7 ' : '') + (part.paragraphs || 0) + ' paragraphs \u00b7 ' + (part.size_kb || 0) + ' KB</p>' +
                    '</div>';
                  listEl.appendChild(row);
                });
                partsWrap.classList.remove('hidden');
              } else {
                partsWrap.classList.add('hidden');
              }
            } catch (_) {
              partsWrap.classList.add('hidden');
              document.getElementById('download-subtitle').textContent = 'Your split files are ready.';
            }
          } else {
            partsWrap.classList.add('hidden');
            document.getElementById('download-subtitle').textContent = 'Your split files are ready.';
          }

          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'done');
          animateProgress(90, 100, 300, 'Done!');

          setTimeout(function () { showState('download'); updateStepIndicator(3); }, 500);

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
        ['upload', 'converting', 'download'].forEach(function (s) {
          document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
        });
        if (state === 'download') document.getElementById('state-download').classList.add('bounce-in');

        var card = document.querySelector('.bg-fn-surface.border.rounded-2xl');
        if (card) {
          var offset = card.getBoundingClientRect().top + window.pageYOffset - 20;
          window.scrollTo({ top: offset, behavior: 'smooth' });
        }
      }

      function updateStepIndicator(active) {
        [1, 2, 3].forEach(function (n) {
          var el = document.getElementById('step-' + n);
          el.classList.remove('active', 'done');
          if (n < active)   el.classList.add('done');
          if (n === active) el.classList.add('active');
        });
      }

      function setProcessStep(id, state) {
        var el = document.getElementById(id);
        if (!el) return;
        var dot   = el.querySelector('.step-dot');
        var check = el.querySelector('.check-icon');
        var spin  = el.querySelector('.spin-icon');
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
        var start = performance.now();
        function step(now) {
          var t   = Math.min((now - start) / duration, 1);
          var pct = Math.round(from + (to - from) * t);
          document.getElementById('progress-fill').style.width = pct + '%';
          document.getElementById('progress-pct').textContent  = pct + '%';
          if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      }

      window.resetConverter = function () {
        if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
        resetFile();
        document.getElementById('opt-filename').value = '';
        document.getElementById('opt-pages').value    = '';
        // Reset split mode
        document.querySelectorAll('.split-mode-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelector('.split-mode-btn[data-mode="page"]').classList.add('active');
        activeSplit = 'page';
        document.getElementById('opt-heading-wrap').classList.add('hidden');
        document.getElementById('opt-chunk-wrap').classList.add('hidden');
        document.getElementById('opt-range-wrap').classList.add('hidden');
        // Reset heading level
        document.querySelectorAll('.heading-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelector('.heading-btn[data-level="1"]').classList.add('active');
        activeHeading = '1';
        // Reset chunk
        chunkSlider.value = 10;
        chunkValue.textContent = '10';
        // Reset parts
        document.getElementById('parts-wrap').classList.add('hidden');
        showState('upload');
        updateStepIndicator(1);
        animateProgress(0, 0, 0, 'Starting\u2026');
        ['proc-1','proc-2','proc-3','proc-4'].forEach(function (id) { setProcessStep(id, ''); });
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

      function escHtml(str) {
        var d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
      }

      // ── FAQ ──
      document.querySelectorAll('.faq-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var body   = btn.nextElementSibling;
          var icon   = btn.querySelector('.faq-icon');
          var isOpen = !body.classList.contains('hidden');
          document.querySelectorAll('.faq-body').forEach(function (b) { b.classList.add('hidden'); });
          document.querySelectorAll('.faq-icon').forEach(function (i) { i.style.transform = ''; });
          if (!isOpen) {
            body.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
          }
        });
      });

    });
</script>
@endpush

@endsection
