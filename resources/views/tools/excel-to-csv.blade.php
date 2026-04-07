@extends('layouts.base')

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Upload Excel'],['2','Converting'],['3','Download']] as [$n, $label])
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
                                class="w-20 h-20 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-4xl">
                                📗</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your Excel file here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .xlsx and .xls · or click to browse</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose Excel File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 200MB free </p>
                        <input type="file" id="file-input"
                            accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📗</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">report.xlsx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">— · Excel Spreadsheet</p>
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

                        {{-- Row 1: Output mode + Sheet selector --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Output mode --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Output Mode</label>
                                <select id="opt-output"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none cursor-pointer">
                                    <option value="file">First sheet → single .csv</option>
                                    <option value="zip">All sheets → ZIP of .csv files</option>
                                </select>
                                <p class="text-fn-text3 text-sm mt-1.5" id="output-mode-hint">Downloads the first sheet
                                    as a single CSV file.</p>
                            </div>

                            {{-- Sheet name / index --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl" id="sheet-option-wrap">
                                <label for="opt-sheet" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Sheet Name or Index
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-sheet" placeholder='e.g. Sales or 0'
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5" id="sheet-hint">Leave blank to use the first
                                    sheet.</p>
                            </div>
                        </div>

                        {{-- Row 2: Separator + Output filename --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Separator --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">CSV Separator</label>
                                <div class="grid grid-cols-4 gap-2 mb-2">
                                    @foreach([[',','Comma'],[';','Semicolon'],['\\t','Tab'],['|','Pipe']] as [$sep,
                                    $lbl])
                                    <button type="button"
                                        class="sep-btn {{ $sep === ',' ? 'active' : '' }} py-1.5 rounded-lg border text-sm font-mono font-bold transition-all"
                                        data-sep="{{ $sep }}">
                                        {{ $sep === '\\t' ? 'TAB' : $sep }}
                                    </button>
                                    @endforeach
                                </div>
                                <p class="text-fn-text3 text-sm" id="sep-hint">Comma — standard CSV format</p>
                            </div>

                            {{-- Output filename --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="e.g. export.csv"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to your Excel filename with .csv or
                                    .zip</p>
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
                        Convert to CSV
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            📗</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div id="conv-output-icon"
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            📊</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting your file…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 15 seconds</p>

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
                        ['proc-1','Uploading & reading workbook'],
                        ['proc-2','Detecting sheets & structure'],
                        ['proc-3','Serialising rows to CSV'],
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
                    <p class="text-fn-text2 text-sm mb-8" id="download-subtitle">Your CSV file is ready.</p>

                    {{-- Sheet tabs (shown when output=zip / multi-sheet preview) --}}
                    <div id="sheet-tabs-wrap" class="hidden max-w-2xl mx-auto mb-4 text-left">
                        <div class="flex items-center gap-1 flex-wrap mb-3" id="sheet-tabs"></div>
                        <div class="bg-fn-surface2 border border-fn-text/8 rounded-xl overflow-auto max-h-52">
                            <table id="csv-preview-table" class="w-full text-sm border-collapse"></table>
                        </div>
                        <p class="text-fn-text3 text-sm mt-2" id="sheet-preview-meta"></p>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0"
                            id="output-icon">📊</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">output.csv</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">CSV File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="output.csv"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span id="download-btn-label">Download CSV</span>
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
            ['Does it support both .xlsx and .xls?', 'Yes — both modern .xlsx (Excel 2007+) and legacy .xls (Excel
            97-2003) formats are fully supported.'],
            ['Can I convert a specific sheet only?', 'Yes — enter a sheet name (e.g. Sales) or a zero-based index (e.g.
            0 for the first sheet) in the Sheet Name or Index field. Leave blank to convert all sheets.'],
            ['What happens with multi-sheet workbooks?', 'Choose "All sheets → ZIP" to get every sheet as its own .csv
            file bundled in a ZIP archive. Choose "First sheet" to get a single .csv from only the first (or specified)
            sheet.'],
            ['Can I change the CSV separator?', 'Yes — choose comma (standard), semicolon (common in Europe), tab, or
            pipe from the separator selector before converting.'],
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

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ STYLES ══ --}}
<style>
    .sep-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
    }

    .sep-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .sep-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    .sheet-tab {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
        cursor: pointer;
        transition: all .15s;
    }

    .sheet-tab.active {
        background: oklch(49% 0.24 264 / 10%);
        border-color: oklch(49% 0.24 264 / 35%);
        color: var(--fn-blue-l);
    }

    #csv-preview-table th {
        padding: 6px 10px;
        text-align: left;
        font-weight: 700;
        font-size: 11px;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        white-space: nowrap;
        background: oklch(var(--fn-surface2-l, 22%) 0 0 / 1);
    }

    #csv-preview-table td {
        padding: 5px 10px;
        font-size: 11px;
        color: var(--fn-text2);
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 6%);
        white-space: nowrap;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #csv-preview-table tr:last-child td {
        border-bottom: none;
    }

    #csv-preview-table tr:hover td {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 4%);
    }
</style>

{{-- ══ JAVASCRIPT ══ --}}
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
  const outputSel   = document.getElementById('opt-output');
  const sheetInput  = document.getElementById('opt-sheet');
  const sheetHint   = document.getElementById('sheet-hint');
  const outputHint  = document.getElementById('output-mode-hint');

  let selectedFile  = null;
  let blobUrl       = null;
  let activeSep     = ',';
  let sheetData     = {}; // { sheetName: csvString } — populated from text response for preview

  // ── Separator buttons ──
  const sepHints = {
    ',':  'Comma — standard CSV format',
    ';':  'Semicolon — common in European locales',
    '\\t': 'Tab — TSV format, no quoting issues',
    '|':  'Pipe — useful when data contains commas',
  };

  document.querySelectorAll('.sep-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.sep-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeSep = btn.dataset.sep;
      document.getElementById('sep-hint').textContent = sepHints[activeSep] ?? '';
    });
  });

  // ── Output mode toggle ──
  outputSel.addEventListener('change', () => {
    const isZip = outputSel.value === 'zip';
    outputHint.textContent = isZip
      ? 'All sheets exported as individual CSV files, bundled in a ZIP archive.'
      : 'Downloads the first (or specified) sheet as a single CSV file.';
    sheetHint.textContent = isZip
      ? 'Leave blank to convert all sheets, or specify one to include only that sheet.'
      : 'Leave blank to use the first sheet.';
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
  const ACCEPTED_EXTS  = ['.xlsx', '.xls'];
  const ACCEPTED_TYPES = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-excel',
  ];

  function handleFile(file) {
    hideError();
    const ext = file.name.toLowerCase().slice(file.name.lastIndexOf('.'));
    if (!ACCEPTED_EXTS.includes(ext) && !ACCEPTED_TYPES.includes(file.type)) {
      showError('Please select a valid Excel file (.xlsx or .xls).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · Excel Spreadsheet';
    const fnInput = document.getElementById('opt-filename');
    if (!fnInput.value) fnInput.value = file.name.replace(/\.xlsx?$/i, '.csv');
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

    const outputMode     = outputSel.value;           // 'file' | 'zip'
    const sheetVal       = sheetInput.value.trim();
    const customFilename = document.getElementById('opt-filename').value.trim();
    const isZip          = outputMode === 'zip';
    const baseName       = selectedFile.name.replace(/\.xlsx?$/i, '');
    const defaultExt     = isZip ? '.zip' : '.csv';
    const outputFilename = customFilename
      ? (customFilename.includes('.') ? customFilename : customFilename + defaultExt)
      : baseName + defaultExt;

    const formData = new FormData();
    formData.append('file',   selectedFile);
    formData.append('output', outputMode);
    if (sheetVal)       formData.append('sheet_name', sheetVal);
    if (activeSep !== ',') formData.append('separator', activeSep === '\\t' ? '\t' : activeSep);

    // Animate
    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 700, 'Uploading & reading workbook…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done');
      setProcessStep('proc-2', 'active');
      animateProgress(20, 50, 900, 'Detecting sheets & structure…');
    }, 800);

    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done');
      setProcessStep('proc-3', 'active');
      animateProgress(50, 75, 900, 'Serialising rows to CSV…');
    }, 1800);

    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done');
      setProcessStep('proc-4', 'active');
      animateProgress(75, 90, 700, 'Packaging output file…');
    }, 2900);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/excel-to-csv', {
        method: 'POST',
        body:   formData,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let errMsg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) errMsg = d.error; } catch (_) {}
        throw new Error(errMsg);
      }

      const blob = await res.blob();

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link    = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = outputFilename;

      document.getElementById('output-name').textContent       = outputFilename;
      document.getElementById('output-size').textContent       = formatBytes(blob.size) + (isZip ? ' · ZIP Archive' : ' · CSV File');
      document.getElementById('download-btn-label').textContent = isZip ? 'Download ZIP' : 'Download CSV';
      document.getElementById('download-subtitle').textContent  = isZip
        ? 'Your CSV files are packed and ready.'
        : 'Your CSV file is ready.';
      document.getElementById('output-icon').textContent        = isZip ? '🗜️' : '📊';

      // ── Sheet preview: request again with output=text to get the JSON for preview ──
      // Only show preview for file mode (single sheet); skip for zip
      const sheetTabsWrap = document.getElementById('sheet-tabs-wrap');
      if (!isZip) {
        try {
          const previewForm = new FormData();
          previewForm.append('file',   selectedFile);
          previewForm.append('output', 'text');
          if (sheetVal) previewForm.append('sheet_name', sheetVal);
          if (activeSep !== ',') previewForm.append('separator', activeSep === '\\t' ? '\t' : activeSep);

          const previewRes = await fetch('https://api.filenewer.com/api/tools/excel-to-csv', {
            method: 'POST',
            body:   previewForm,
          });

          if (previewRes.ok) {
            const data = await previewRes.json();
            // data.sheets = { SheetName: "csv string", ... }
            sheetData = data.sheets ?? {};
            const names = data.sheet_names ?? Object.keys(sheetData);
            if (names.length > 0) {
              buildSheetTabs(names);
              renderCsvPreview(sheetData[names[0]], names[0], data.total_sheets ?? names.length);
              sheetTabsWrap.classList.remove('hidden');
            } else {
              sheetTabsWrap.classList.add('hidden');
            }
          } else {
            sheetTabsWrap.classList.add('hidden');
          }
        } catch (_) {
          sheetTabsWrap.classList.add('hidden');
        }
      } else {
        sheetTabsWrap.classList.add('hidden');
      }

      setProcessStep('proc-3', 'done');
      setProcessStep('proc-4', 'done');
      animateProgress(90, 100, 300, 'Done!');

      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 500);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  // ── Sheet tabs ──
  function buildSheetTabs(names) {
    const container = document.getElementById('sheet-tabs');
    container.innerHTML = '';
    names.forEach((name, i) => {
      const btn = document.createElement('button');
      btn.type      = 'button';
      btn.textContent = name;
      btn.className = 'sheet-tab' + (i === 0 ? ' active' : '');
      btn.addEventListener('click', () => {
        document.querySelectorAll('.sheet-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderCsvPreview(sheetData[name], name, Object.keys(sheetData).length);
      });
      container.appendChild(btn);
    });
  }

  // ── CSV table renderer ──
  function renderCsvPreview(csvString, sheetName, totalSheets) {
    const lines   = (csvString || '').trim().split('\n').filter(Boolean);
    const headers = lines.length > 0 ? parseCsvLine(lines[0]) : [];
    const rows    = lines.slice(1, 11);
    const total   = lines.length - 1;

    document.getElementById('sheet-preview-meta').textContent =
      `"${sheetName}" · ${total} row${total !== 1 ? 's' : ''} · ${headers.length} column${headers.length !== 1 ? 's' : ''}` +
      (total > 10 ? ' · showing first 10' : '') +
      (totalSheets > 1 ? ` · ${totalSheets} sheets total` : '');

    const table = document.getElementById('csv-preview-table');
    table.innerHTML = '';

    if (headers.length === 0) return;

    const thead = document.createElement('thead');
    const trh   = document.createElement('tr');
    headers.forEach(h => {
      const th = document.createElement('th');
      th.textContent = h;
      trh.appendChild(th);
    });
    thead.appendChild(trh);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    rows.forEach(line => {
      const cells = parseCsvLine(line);
      const tr    = document.createElement('tr');
      headers.forEach((_, i) => {
        const td = document.createElement('td');
        td.textContent = cells[i] ?? '';
        td.title       = cells[i] ?? '';
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);
  }

  function parseCsvLine(line) {
    const result = [];
    let cur = '', inQ = false;
    for (let i = 0; i < line.length; i++) {
      const ch = line[i];
      if (ch === '"') {
        if (inQ && line[i + 1] === '"') { cur += '"'; i++; }
        else inQ = !inQ;
      } else if ((ch === ',' || ch === ';' || ch === '\t' || ch === '|') && !inQ) {
        result.push(cur); cur = '';
      } else {
        cur += ch;
      }
    }
    result.push(cur);
    return result;
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
    document.getElementById('opt-filename').value = '';
    document.getElementById('opt-sheet').value    = '';
    outputSel.value = 'file';
    outputHint.textContent = 'Downloads the first (or specified) sheet as a single CSV file.';
    sheetHint.textContent  = 'Leave blank to use the first sheet.';
    // Reset separator to comma
    document.querySelectorAll('.sep-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('.sep-btn[data-sep=","]').classList.add('active');
    activeSep = ',';
    document.getElementById('sep-hint').textContent = sepHints[','];
    sheetData = {};
    document.getElementById('sheet-tabs-wrap').classList.add('hidden');
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

});
</script>

@endsection
