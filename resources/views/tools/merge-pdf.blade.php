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
                @foreach([['1','Upload PDFs'],['2','Merging'],['3','Download']] as [$n, $label])
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
                        <h2 class="text-lg font-bold mb-2">Drop PDF files here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Drop 2 or more PDFs — or click to browse from your computer</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF Files
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Up to 50 files · 50MB each free</p>
                        <input type="file" id="file-input" accept=".pdf,application/pdf" multiple
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- Files list --}}
                    <div id="files-list-wrap" class="hidden mt-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">
                                <span id="files-count">0</span> file<span id="files-plural">s</span> · drag to reorder
                            </p>
                            <div class="flex gap-2">
                                <button type="button" id="btn-add-more"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Add more
                                </button>
                                <button type="button" id="btn-clear-all"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    Clear all
                                </button>
                            </div>
                        </div>
                        <div id="files-list" class="space-y-2"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 grid sm:grid-cols-2 gap-3">
                        {{-- Left column: toggles --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-2.5">
                            <p class="text-sm font-semibold text-fn-text2 mb-1">Merge Options</p>
                            @foreach([
                                ['opt-bookmarks',   'Add bookmarks',    'One bookmark per source file',   true],
                                ['opt-page-numbers','Add page numbers', 'Adds numbering at page bottom', false],
                            ] as [$tid, $tlabel, $tdesc, $tdefault])
                            <label class="flex items-start gap-2.5 cursor-pointer select-none">
                                <div class="toggle-wrap relative w-8 h-4 mt-0.5">
                                    <input type="checkbox" id="{{ $tid }}" {{ $tdefault ? 'checked' : '' }} class="sr-only peer" />
                                    <div class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors"></div>
                                    <div class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-fn-text2">{{ $tlabel }}</p>
                                    <p class="text-xs text-fn-text3 leading-tight mt-0.5">{{ $tdesc }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        {{-- Right column: filename + password --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                            <div>
                                <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="merged.pdf"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            </div>
                            <div>
                                <label for="opt-password" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Password Protection
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="opt-password" placeholder="Leave blank for no password"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-10 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                    <button type="button" id="toggle-password"
                                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors">
                                        <svg id="eye-show" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg id="eye-hide" class="hidden" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    </button>
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
                            <path d="M8 6l4-4 4 4"/><path d="M12 2v14"/><rect x="4" y="16" width="16" height="6" rx="1"/>
                        </svg>
                        Merge PDFs
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-3xl">📕</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.3s"></span>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">📚</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Merging your PDFs…</h2>
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
                            ['proc-1','Uploading PDF files'],
                            ['proc-2','Reading pages & metadata'],
                            ['proc-3','Merging into one document'],
                            ['proc-4','Adding bookmarks & encryption'],
                        ] as [$pid, $plabel])
                        <div class="flex items-center gap-3" id="{{ $pid }}">
                            <div class="step-dot w-5 h-5 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center shrink-0 transition-all duration-300">
                                <svg class="check-icon hidden w-3 h-3 text-fn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <svg class="spin-icon hidden w-3 h-3 text-fn-blue-l spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg>
                            </div>
                            <span class="text-sm text-fn-text3">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">✅</div>
                    <h2 class="text-2xl font-bold mb-2">Merge Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6">Your merged PDF is ready.</p>

                    {{-- Stats grid --}}
                    <div class="max-w-2xl mx-auto grid grid-cols-3 gap-2 mb-6">
                        @foreach([
                            ['stat-files','Files merged'],
                            ['stat-pages','Total pages'],
                            ['stat-size','File size'],
                        ] as [$sid, $slabel])
                        <div class="p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <p class="text-xs text-fn-text3 mb-1">{{ $slabel }}</p>
                            <p class="text-lg font-bold text-fn-text" id="{{ $sid }}">—</p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Bookmarks preview --}}
                    <div id="bookmarks-preview" class="hidden max-w-2xl mx-auto mb-6 text-left">
                        <p class="text-sm font-semibold text-fn-text2 mb-2">Bookmarks</p>
                        <div class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-auto max-h-48">
                            <table id="bookmarks-table" class="w-full text-xs"></table>
                        </div>
                    </div>

                    <div class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">merged.pdf</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">PDF Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="merged.pdf"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Merged PDF
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                            Merge more PDFs
                        </button>
                    </div>

                    <p class="mt-6 text-fn-text3 text-sm flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
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
                ['How many PDFs can I merge at once?', 'You can merge between 2 and 50 PDF files at once. Each file can be up to 50MB on the free plan.'],
                ['Can I reorder files before merging?', 'Yes — once your files are uploaded, drag and drop them in the list to set the exact order they should appear in the merged PDF. You can also remove individual files without starting over.'],
                ['What are bookmarks?', 'Bookmarks are a navigation panel in the merged PDF — one bookmark per source file, named after the original filename. They let readers jump straight to the start of each section. Enabled by default.'],
                ['Can I password-protect the merged PDF?', 'Yes — enter a password in the optional password field before merging. The output PDF will be encrypted and require that password to open.'],
                ['Is my file safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted within 1 hour. We never read, share or store your content.'],
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
    /* File item */
    .file-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: var(--fn-surface2);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        border-radius: 12px;
        cursor: grab;
        transition: border-color .15s, background .15s, box-shadow .15s;
        user-select: none;
    }
    .file-item:hover { border-color: oklch(49% 0.24 264 / 25%); }
    .file-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .file-item.drag-over-target {
        border-color: oklch(49% 0.24 264 / 50%);
        background: oklch(49% 0.24 264 / 5%);
        box-shadow: 0 -2px 0 0 oklch(49% 0.24 264);
    }
    .file-item .drag-handle {
        color: var(--fn-text3);
        cursor: grab;
        padding: 2px;
    }
    .file-item .file-order {
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
    .file-item .file-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: oklch(62% 0.22 25 / 12%);
        border: 1px solid oklch(62% 0.22 25 / 20%);
        color: oklch(62% 0.22 25);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }
    .file-item .file-info   { flex: 1; min-width: 0; }
    .file-item .file-name   { font-size: 13px; font-weight: 600; color: var(--fn-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .file-item .file-meta   { font-size: 11px; color: var(--fn-text3); margin-top: 2px; }
    .file-item .file-actions { display: flex; gap: 4px; flex-shrink: 0; }
    .file-item .icon-btn {
        width: 26px; height: 26px;
        border-radius: 6px;
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
        cursor: pointer;
    }
    .file-item .icon-btn:hover { color: var(--fn-text); border-color: oklch(49% 0.24 264 / 30%); }
    .file-item .icon-btn.danger:hover { color: var(--fn-red); border-color: oklch(62% 0.22 25 / 30%); background: oklch(62% 0.22 25 / 6%); }
    .file-item .icon-btn:disabled { opacity: 0.3; cursor: not-allowed; }

    /* Bookmarks table */
    #bookmarks-table th {
        background: oklch(var(--fn-surface2-l, 22%) 0 0 / 1);
        padding: 6px 10px;
        text-align: left;
        font-weight: 700;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        white-space: nowrap;
        font-size: 11px;
    }
    #bookmarks-table td {
        padding: 5px 10px;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 6%);
        font-size: 12px;
    }
    #bookmarks-table tr:last-child td { border-bottom: none; }
</style>

@push('footer')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Refs ──
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');
  const filesListWrap = document.getElementById('files-list-wrap');
  const filesList   = document.getElementById('files-list');

  const MAX_FILES = 50;
  const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50MB

  let selectedFiles = [];
  let blobUrl       = null;
  let dragSrcIdx    = null;

  // ── Drag & drop zone ──
  ['dragenter', 'dragover'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave', 'dragend', 'drop'].forEach(evt => {
    dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', e => {
    if (e.dataTransfer.files.length) handleFiles(e.dataTransfer.files);
  });
  fileInput.addEventListener('change', e => {
    if (e.target.files.length) handleFiles(e.target.files);
    e.target.value = ''; // allow re-adding same file
  });

  // Add-more / Clear-all
  document.getElementById('btn-add-more').addEventListener('click', () => fileInput.click());
  document.getElementById('btn-clear-all').addEventListener('click', () => {
    selectedFiles = [];
    renderList();
    refreshConvertBtn();
    hideError();
  });

  function handleFiles(fileList) {
    hideError();
    const newFiles = Array.from(fileList);

    for (const f of newFiles) {
      if (f.type !== 'application/pdf' && !f.name.toLowerCase().endsWith('.pdf')) {
        showError(`"${f.name}" is not a valid PDF file.`);
        return;
      }
      if (f.size > MAX_FILE_SIZE) {
        showError(`"${f.name}" exceeds the 50MB limit.`);
        return;
      }
    }

    if (selectedFiles.length + newFiles.length > MAX_FILES) {
      showError(`You can merge up to ${MAX_FILES} files at once.`);
      return;
    }

    selectedFiles = selectedFiles.concat(newFiles);
    renderList();
    refreshConvertBtn();
  }

  // ── Render files list ──
  function renderList() {
    if (selectedFiles.length === 0) {
      filesListWrap.classList.add('hidden');
      return;
    }
    filesListWrap.classList.remove('hidden');
    document.getElementById('files-count').textContent = selectedFiles.length;
    document.getElementById('files-plural').textContent = selectedFiles.length === 1 ? '' : 's';

    filesList.innerHTML = '';
    selectedFiles.forEach((file, idx) => {
      const item = document.createElement('div');
      item.className = 'file-item';
      item.draggable = true;
      item.dataset.idx = idx;
      item.innerHTML = `
        <span class="drag-handle" title="Drag to reorder">
          <svg width="12" height="14" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="9" cy="5" r="1.5"/><circle cx="15" cy="5" r="1.5"/>
            <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
            <circle cx="9" cy="19" r="1.5"/><circle cx="15" cy="19" r="1.5"/>
          </svg>
        </span>
        <span class="file-order">${idx + 1}</span>
        <span class="file-icon">📕</span>
        <div class="file-info">
          <p class="file-name"></p>
          <p class="file-meta">${formatBytes(file.size)} · PDF Document</p>
        </div>
        <div class="file-actions">
          <button type="button" class="icon-btn btn-up" title="Move up" ${idx === 0 ? 'disabled' : ''}>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
          </button>
          <button type="button" class="icon-btn btn-down" title="Move down" ${idx === selectedFiles.length - 1 ? 'disabled' : ''}>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <button type="button" class="icon-btn danger btn-remove" title="Remove">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </button>
        </div>`;
      // Safe name insertion (textContent)
      item.querySelector('.file-name').textContent = file.name;

      // Button handlers
      item.querySelector('.btn-up').addEventListener('click', e => { e.stopPropagation(); moveFile(idx, -1); });
      item.querySelector('.btn-down').addEventListener('click', e => { e.stopPropagation(); moveFile(idx, 1); });
      item.querySelector('.btn-remove').addEventListener('click', e => {
        e.stopPropagation();
        selectedFiles.splice(idx, 1);
        renderList();
        refreshConvertBtn();
      });

      // Drag & drop reorder
      item.addEventListener('dragstart', e => {
        dragSrcIdx = idx;
        item.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
      });
      item.addEventListener('dragend', () => {
        item.classList.remove('dragging');
        document.querySelectorAll('.file-item').forEach(el => el.classList.remove('drag-over-target'));
      });
      item.addEventListener('dragover', e => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        if (dragSrcIdx !== null && dragSrcIdx !== idx) {
          item.classList.add('drag-over-target');
        }
      });
      item.addEventListener('dragleave', () => {
        item.classList.remove('drag-over-target');
      });
      item.addEventListener('drop', e => {
        e.preventDefault();
        e.stopPropagation();
        item.classList.remove('drag-over-target');
        if (dragSrcIdx === null || dragSrcIdx === idx) return;
        const [moved] = selectedFiles.splice(dragSrcIdx, 1);
        selectedFiles.splice(idx, 0, moved);
        dragSrcIdx = null;
        renderList();
      });

      filesList.appendChild(item);
    });
  }

  function moveFile(idx, direction) {
    const newIdx = idx + direction;
    if (newIdx < 0 || newIdx >= selectedFiles.length) return;
    const [f] = selectedFiles.splice(idx, 1);
    selectedFiles.splice(newIdx, 0, f);
    renderList();
  }

  function refreshConvertBtn() {
    convertBtn.disabled = selectedFiles.length < 2;
  }

  // ── Password show/hide ──
  document.getElementById('toggle-password').addEventListener('click', () => {
    const input  = document.getElementById('opt-password');
    const isPass = input.type === 'password';
    input.type   = isPass ? 'text' : 'password';
    document.getElementById('eye-show').classList.toggle('hidden', isPass);
    document.getElementById('eye-hide').classList.toggle('hidden', !isPass);
  });

  // ── Merge ──
  convertBtn.addEventListener('click', startMerge);

  async function startMerge() {
    if (selectedFiles.length < 2) {
      showError('Please upload at least 2 PDF files to merge.');
      return;
    }
    hideError();
    showState('converting');
    updateStepIndicator(2);

    const customFilename = document.getElementById('opt-filename').value.trim();
    const outputFilename = customFilename
      ? (customFilename.toLowerCase().endsWith('.pdf') ? customFilename : customFilename + '.pdf')
      : 'merged.pdf';

    const fd = new FormData();
    selectedFiles.forEach(f => fd.append('files[]', f));
    fd.append('add_bookmarks',    document.getElementById('opt-bookmarks').checked);
    fd.append('add_page_numbers', document.getElementById('opt-page-numbers').checked);
    if (customFilename) fd.append('output_filename', outputFilename);
    const pw = document.getElementById('opt-password').value;
    if (pw) fd.append('password', pw);
    fd.append('output', 'file');

    // Animate progress
    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 600, 'Uploading PDF files…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 55, 800, 'Reading pages & metadata…');
    }, 700);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 80, 700, 'Merging into one document…');
    }, 1600);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(80, 92, 500, 'Adding bookmarks & encryption…');
    }, 2400);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/pdf-merge', {
        method: 'POST',
        body: fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Merge failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch (_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      // Stats from headers
      const totalPages  = res.headers.get('X-Total-Pages') || '—';
      const filesMerged = res.headers.get('X-Files-Merged') || selectedFiles.length;
      const sizeKb      = parseFloat(res.headers.get('X-Size-KB')) || (blob.size / 1024);

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link    = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = outputFilename;

      document.getElementById('output-name').textContent = outputFilename;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · PDF Document';

      // Stats grid
      document.getElementById('stat-files').textContent = filesMerged;
      document.getElementById('stat-pages').textContent = totalPages;
      document.getElementById('stat-size').textContent  = formatSizeKb(sizeKb);

      // Build bookmarks preview from file list (since API returns binary, we reconstruct from client-side info)
      const showBookmarks = document.getElementById('opt-bookmarks').checked;
      if (showBookmarks) renderLocalBookmarksPreview();
      else document.getElementById('bookmarks-preview').classList.add('hidden');

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

  // Local bookmarks preview (we don't know actual page counts, but we show file order)
  function renderLocalBookmarksPreview() {
    const wrap  = document.getElementById('bookmarks-preview');
    const table = document.getElementById('bookmarks-table');
    table.innerHTML = `
      <thead>
        <tr>
          <th style="width:40px;">#</th>
          <th>Source file</th>
          <th style="width:100px; text-align:right;">Size</th>
        </tr>
      </thead>`;
    const tbody = document.createElement('tbody');
    selectedFiles.forEach((f, i) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td style="color:var(--fn-blue-l); font-weight:600;">${i + 1}</td>
        <td></td>
        <td style="text-align:right; color:var(--fn-text3);">${formatBytes(f.size)}</td>`;
      tr.children[1].textContent = f.name;
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);
    wrap.classList.remove('hidden');
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
    selectedFiles = [];
    renderList();
    fileInput.value = '';
    document.getElementById('opt-filename').value = '';
    document.getElementById('opt-password').value = '';
    document.getElementById('opt-bookmarks').checked = true;
    document.getElementById('opt-page-numbers').checked = false;
    document.getElementById('bookmarks-preview').classList.add('hidden');
    refreshConvertBtn();
    hideError();
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
    if (!kb) return '—';
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
