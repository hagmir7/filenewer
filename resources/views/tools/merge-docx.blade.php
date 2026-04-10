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
            ['1', 'Upload Files'],
            ['2', 'Merging'],
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
                                📑</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your Word files here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Select 2&ndash;20 .docx files &middot; or click to browse
                        </p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose Files
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 200MB total</p>
                        <input type="file" id="file-input" multiple
                            accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File list --}}
                    <div id="file-list-wrap" class="hidden mt-5">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-semibold text-fn-text2"><span id="file-count">0</span> files selected
                            </p>
                            <div class="flex items-center gap-2">
                                <button type="button" id="add-more-btn"
                                    class="text-sm font-semibold text-fn-blue hover:text-fn-blue-l transition-colors flex items-center gap-1">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round">
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg>
                                    Add more
                                </button>
                                <button type="button" id="clear-all-btn"
                                    class="text-sm font-semibold text-fn-red/70 hover:text-fn-red transition-colors">
                                    Clear all
                                </button>
                            </div>
                        </div>
                        <p class="text-fn-text3 text-xs mb-3">Drag to reorder &middot; files merge top to bottom</p>
                        <div id="file-list" class="space-y-2"></div>
                        <input type="file" id="file-input-extra" multiple
                            accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="hidden" />
                    </div>

                    {{-- Options --}}
                    <div class="mt-6 space-y-3">

                        {{-- Row 1: Page Break + Table of Contents --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Page Break --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Page Break Between
                                    Docs</label>
                                <label class="toggle-label flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="opt-page-break" checked
                                        class="w-4 h-4 rounded border-fn-text/20 accent-fn-blue cursor-pointer" />
                                    <span class="text-sm text-fn-text2">Yes</span>
                                </label>
                                <p class="text-fn-text3 text-sm mt-1.5">Insert a page break before each merged document.
                                </p>
                            </div>

                            {{-- Table of Contents --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Add Table of
                                    Contents</label>
                                <label class="toggle-label flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="opt-toc"
                                        class="w-4 h-4 rounded border-fn-text/20 accent-fn-blue cursor-pointer" />
                                    <span class="text-sm text-fn-text2">Yes</span>
                                </label>
                                <p class="text-fn-text3 text-sm mt-1.5">Add a TOC page at the beginning of the merged
                                    document.</p>
                            </div>
                        </div>

                        {{-- Row 2: Separator Text + Output Filename --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Separator Text --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-separator" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Separator Text
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-separator"
                                    placeholder="e.g. --- Document {n}: {filename} ---"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Use {n} for doc number, {filename} for the file
                                    name.</p>
                            </div>

                            {{-- Output Filename --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="e.g. merged.docx"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to merged.docx</p>
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

                    {{-- Merge button --}}
                    <button id="convert-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Merge Documents
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📑</div>
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
                            📄</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Merging your documents&hellip;</h2>
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
                    ['proc-1', 'Uploading documents'],
                    ['proc-2', 'Reading & parsing each file'],
                    ['proc-3', 'Merging content & styles'],
                    ['proc-4', 'Packaging final document'],
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
                    <h2 class="text-2xl font-bold mb-2">Merge Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-8" id="download-subtitle">Your merged document is ready.</p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0"
                            id="output-icon">📄</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">merged.docx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Word Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="merged.docx"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span id="download-btn-label">Download DOCX</span>
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Merge more files
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
                        Your files are encrypted and permanently deleted within 1 hour.
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
            ['Is this really free?', 'Files up to 50MB total are completely free with no account needed. Pro plans
            unlock 200MB and batch processing.'],
            ['How many files can I merge?', 'You can merge between 2 and 20 .docx files at once. Simply drag and drop or
            click to browse.'],
            ['Can I control the merge order?', 'Yes, after uploading you can drag and drop files in the list to reorder
            them. Documents are merged from top to bottom.'],
            ['Will formatting be preserved?', 'Yes, styles, fonts, images, tables, and formatting from each document are
            preserved in the merged output.'],
            ['What is the separator text?', 'An optional text line inserted between each merged document. Use {n} for
            the document number and {filename} for the original file name.'],
            ['Can I add a Table of Contents?', 'Yes, enable the Table of Contents option to insert an auto-generated TOC
            at the beginning of the merged document.'],
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
    .file-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        border-radius: 12px;
        cursor: grab;
        transition: all .15s;
    }

    .file-row:active {
        cursor: grabbing;
    }

    .file-row.dragging {
        opacity: .5;
        border-color: oklch(49% 0.24 264 / 40%);
    }

    .file-row.drag-over-row {
        border-color: oklch(49% 0.24 264 / 60%);
        background: oklch(49% 0.24 264 / 6%);
    }

    .file-row .grip {
        color: var(--fn-text3);
        flex-shrink: 0;
    }

    .file-row .file-num {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: oklch(49% 0.24 264 / 10%);
        color: var(--fn-blue-l);
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

      var dropZone     = document.getElementById('drop-zone');
      var fileInput    = document.getElementById('file-input');
      var fileInputEx  = document.getElementById('file-input-extra');
      var convertBtn   = document.getElementById('convert-btn');
      var fileListWrap = document.getElementById('file-list-wrap');
      var fileListEl   = document.getElementById('file-list');
      var fileCountEl  = document.getElementById('file-count');
      var addMoreBtn   = document.getElementById('add-more-btn');
      var clearAllBtn  = document.getElementById('clear-all-btn');
      var uploadError  = document.getElementById('upload-error');
      var errorText    = document.getElementById('error-text');

      var selectedFiles = []; // Array of File objects in merge order
      var blobUrl       = null;

      // ── File handling ──
      ['dragenter', 'dragover'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
      });
      ['dragleave', 'dragend', 'drop'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
      });
      dropZone.addEventListener('drop', function (e) { addFiles(e.dataTransfer.files); });
      fileInput.addEventListener('change', function (e) { addFiles(e.target.files); e.target.value = ''; });
      fileInputEx.addEventListener('change', function (e) { addFiles(e.target.files); e.target.value = ''; });
      addMoreBtn.addEventListener('click', function () { fileInputEx.click(); });
      clearAllBtn.addEventListener('click', function () { selectedFiles = []; renderFileList(); });

      function addFiles(fileList) {
        hideError();
        for (var i = 0; i < fileList.length; i++) {
          var file = fileList[i];
          var ext = file.name.toLowerCase().slice(file.name.lastIndexOf('.'));
          if (ext !== '.docx') {
            showError('Only .docx files are supported. Skipped: ' + file.name);
            continue;
          }
          if (selectedFiles.length >= 20) {
            showError('Maximum 20 files allowed.');
            break;
          }
          selectedFiles.push(file);
        }
        renderFileList();
      }

      function renderFileList() {
        fileListEl.innerHTML = '';
        fileCountEl.textContent = selectedFiles.length;

        if (selectedFiles.length === 0) {
          fileListWrap.classList.add('hidden');
          dropZone.classList.remove('has-file');
          convertBtn.disabled = true;
          return;
        }

        fileListWrap.classList.remove('hidden');
        dropZone.classList.add('has-file');
        convertBtn.disabled = selectedFiles.length < 2;

        selectedFiles.forEach(function (file, idx) {
          var row = document.createElement('div');
          row.className = 'file-row';
          row.draggable = true;
          row.dataset.idx = idx;
          row.innerHTML =
            '<span class="grip"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="6" r="2"/><circle cx="16" cy="6" r="2"/><circle cx="8" cy="12" r="2"/><circle cx="16" cy="12" r="2"/><circle cx="8" cy="18" r="2"/><circle cx="16" cy="18" r="2"/></svg></span>' +
            '<span class="file-num">' + (idx + 1) + '</span>' +
            '<div class="flex-1 min-w-0"><p class="font-semibold text-sm truncate">' + escHtml(file.name) + '</p>' +
            '<p class="text-fn-text3 text-xs">' + formatBytes(file.size) + '</p></div>' +
            '<button type="button" class="remove-row shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">' +
            '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';

          row.querySelector('.remove-row').addEventListener('click', function () {
            selectedFiles.splice(idx, 1);
            renderFileList();
          });

          // Drag reorder
          row.addEventListener('dragstart', function (e) {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', idx);
            row.classList.add('dragging');
          });
          row.addEventListener('dragend', function () { row.classList.remove('dragging'); });
          row.addEventListener('dragover', function (e) { e.preventDefault(); row.classList.add('drag-over-row'); });
          row.addEventListener('dragleave', function () { row.classList.remove('drag-over-row'); });
          row.addEventListener('drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            row.classList.remove('drag-over-row');
            var fromIdx = parseInt(e.dataTransfer.getData('text/plain'));
            var toIdx   = parseInt(row.dataset.idx);
            if (fromIdx === toIdx) return;
            var moved = selectedFiles.splice(fromIdx, 1)[0];
            selectedFiles.splice(toIdx, 0, moved);
            renderFileList();
          });

          fileListEl.appendChild(row);
        });
      }

      // ── Convert ──
      convertBtn.addEventListener('click', startConversion);

      async function startConversion() {
        if (selectedFiles.length < 2) {
          showError('Please select at least 2 .docx files to merge.');
          return;
        }

        hideError();
        showState('converting');
        updateStepIndicator(2);

        var pageBreak      = document.getElementById('opt-page-break').checked;
        var addToc          = document.getElementById('opt-toc').checked;
        var separatorText   = document.getElementById('opt-separator').value.trim();
        var customFilename  = document.getElementById('opt-filename').value.trim();
        var outputFilename  = customFilename
          ? (customFilename.indexOf('.') !== -1 ? customFilename : customFilename + '.docx')
          : 'merged.docx';

        var formData = new FormData();
        selectedFiles.forEach(function (file) {
          formData.append('files[]', file);
        });
        formData.append('page_break',      pageBreak ? 'true' : 'false');
        formData.append('add_toc',         addToc    ? 'true' : 'false');
        formData.append('preserve_styles', 'true');
        formData.append('output_filename', outputFilename);
        if (separatorText) formData.append('separator_text', separatorText);

        // Animate
        setProcessStep('proc-1', 'active');
        animateProgress(0, 20, 800, 'Uploading documents\u2026');

        var t2 = setTimeout(function () {
          setProcessStep('proc-1', 'done');
          setProcessStep('proc-2', 'active');
          animateProgress(20, 50, 1200, 'Reading & parsing each file\u2026');
        }, 900);

        var t3 = setTimeout(function () {
          setProcessStep('proc-2', 'done');
          setProcessStep('proc-3', 'active');
          animateProgress(50, 78, 1500, 'Merging content & styles\u2026');
        }, 2300);

        var t4 = setTimeout(function () {
          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'active');
          animateProgress(78, 90, 700, 'Packaging final document\u2026');
        }, 4000);

        try {
          var res = await fetch('https://api.filenewer.com/api/tools/merge-docx', {
            method: 'POST',
            body:   formData
          });

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!res.ok) {
            var errMsg = 'Merge failed. Please try again.';
            try { var d = await res.json(); if (d.error) errMsg = d.error; } catch (_) {}
            throw new Error(errMsg);
          }

          var blob = await res.blob();

          if (blobUrl) URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(blob);

          var link    = document.getElementById('download-link');
          link.href     = blobUrl;
          link.download = outputFilename;

          var mergedCount = res.headers.get('X-Files-Merged') || selectedFiles.length;
          document.getElementById('output-name').textContent        = outputFilename;
          document.getElementById('output-size').textContent        = formatBytes(blob.size) + ' \u00b7 ' + mergedCount + ' files merged';
          document.getElementById('download-btn-label').textContent = 'Download DOCX';
          document.getElementById('download-subtitle').textContent  = mergedCount + ' documents merged successfully.';

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
        selectedFiles = [];
        renderFileList();
        document.getElementById('opt-filename').value   = '';
        document.getElementById('opt-separator').value  = '';
        document.getElementById('opt-page-break').checked = true;
        document.getElementById('opt-toc').checked        = false;
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
