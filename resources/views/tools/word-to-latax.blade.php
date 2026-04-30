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
                @foreach([['1','Input Word'],['2','Converting'],['3','Download']] as [$n, $label])
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
                                class="w-20 h-20 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-fn-blue-l">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                    <polyline points="10 9 9 9 8 9" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your Word file here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .docx files — or click to browse</p>
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
                        <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                        <input type="file" id="file-input"
                            accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center shrink-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" class="text-fn-blue-l">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.docx</p>
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

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">LaTeX Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Left column --}}
                            <div class="flex flex-col gap-3">

                                <div>
                                    <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Output filename
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-filename" placeholder="document.tex"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>

                                <div>
                                    <label for="opt-docclass"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Document class</label>
                                    <select id="opt-docclass"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="article">article — Papers &amp; articles</option>
                                        <option value="report">report — Long reports</option>
                                        <option value="book">book — Books</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label for="opt-fontsize"
                                            class="text-xs font-semibold text-fn-text2 block mb-1.5">Font size</label>
                                        <select id="opt-fontsize"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                            <option value="10">10pt</option>
                                            <option value="11">11pt</option>
                                            <option value="12" selected>12pt</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="opt-papersize"
                                            class="text-xs font-semibold text-fn-text2 block mb-1.5">Paper size</label>
                                        <select id="opt-papersize"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                            <option value="a4paper" selected>A4</option>
                                            <option value="letterpaper">Letter</option>
                                            <option value="legalpaper">Legal</option>
                                            <option value="a3paper">A3</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            {{-- Right column --}}
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Options</label>
                                <div class="flex flex-col gap-1.5">
                                    @foreach([
                                    ['opt-packages', 'Include packages', 'Add \\usepackage declarations', true],
                                    ['opt-toc', 'Table of contents', 'Add \\tableofcontents', false],
                                    ['opt-title', 'Include title', 'Add \\maketitle block', true],
                                    ] as [$tid, $tlabel, $tdesc, $tdefault])
                                    <label
                                        class="flex items-center gap-2 cursor-pointer select-none px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg hover:border-fn-blue/25 transition-colors">
                                        <div class="toggle-wrap relative w-8 h-4 shrink-0">
                                            <input type="checkbox" id="{{ $tid }}" {{ $tdefault ? 'checked' : '' }}
                                                class="sr-only peer" />
                                            <div
                                                class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors">
                                            </div>
                                            <div
                                                class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4">
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-fn-text2">{{ $tlabel }}</p>
                                            <p class="text-xs text-fn-text3 leading-tight">{{ $tdesc }}</p>
                                        </div>
                                    </label>
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

                    <button id="convert-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                        </svg>
                        Convert to LaTeX
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" class="text-fn-blue-l">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
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
                            📄</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting Word to LaTeX…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Parsing headings, styles, tables, and formatting</p>

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
                        ['proc-1','Reading Word document'],
                        ['proc-2','Parsing headings & styles'],
                        ['proc-3','Converting tables & lists'],
                        ['proc-4','Building LaTeX output'],
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
                    <p class="text-fn-text2 text-sm mb-6">Your LaTeX file is ready to compile.</p>

                    {{-- LaTeX preview chip --}}
                    <div id="result-info-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Output details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-chips"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📄</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">document.tex</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">LaTeX Source File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="document.tex"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download .tex File
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
            @foreach([
            ['What Word elements are converted to LaTeX?', 'Headings 1–6 map to \section, \subsection, \subsubsection,
            \paragraph, and \subparagraph. Bold becomes \textbf{}, italic \textit{}, underline \underline{},
            strikethrough \sout{}, and monospace \texttt{}. Bullet lists become itemize, numbered lists enumerate,
            tables become tabular, and hyperlinks use \href{}.'],
            ['Which document classes are available?', 'Three classes are supported: article (best for papers and
            articles without chapters), report (for long documents where Heading 1 maps to \chapter), and book (for full
            books, also with chapter-level headings).'],
            ['What do the package and title options do?', 'Enabling "Include packages" adds all necessary \usepackage
            declarations (inputenc, fontenc, amsmath, graphicx, hyperref, booktabs, etc.). "Include title" adds
            \maketitle to render the document title. "Table of contents" inserts \tableofcontents after \maketitle.'],
            ['What font sizes and paper sizes are supported?', 'Font sizes 10pt, 11pt, and 12pt are available. Paper
            sizes include A4 (default), Letter, Legal, and A3. These are passed directly to the \documentclass
            options.'],
            ['Is my Word document safe and private?', 'All uploads use AES-256 encryption in transit and are permanently
            deleted within 1 hour. We never read, share, or store your content.'],
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
    .chip-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 600;
    }

    .chip-item .chip-dot {
        width: 8px;
        height: 8px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .chip-docclass .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-docclass {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .chip-option .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-option {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .chip-paper .chip-dot {
        background: oklch(67% 0.18 162);
    }

    .chip-paper {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');

  let selectedFile = null;
  let blobUrl      = null;

  // ── File drop zone ──
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
    const name = file.name.toLowerCase();
    if (!name.match(/\.docx$/)) {
      showError('Please select a valid Word file (.docx).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · Word Document';
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
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const customFilename  = document.getElementById('opt-filename').value.trim();
    const documentClass   = document.getElementById('opt-docclass').value;
    const fontSize        = document.getElementById('opt-fontsize').value;
    const paperSize       = document.getElementById('opt-papersize').value;
    const includePackages = document.getElementById('opt-packages').checked;
    const includeToc      = document.getElementById('opt-toc').checked;
    const includeTitle    = document.getElementById('opt-title').checked;

    let outName;
    if (customFilename) {
      outName = customFilename.toLowerCase().endsWith('.tex') ? customFilename : customFilename + '.tex';
    } else {
      outName = selectedFile.name.replace(/\.docx$/i, '') + '.tex';
    }

    const fd = new FormData();
    fd.append('file',             selectedFile);
    fd.append('document_class',   documentClass);
    fd.append('font_size',        fontSize);
    fd.append('paper_size',       paperSize);
    fd.append('include_packages', includePackages);
    fd.append('include_toc',      includeToc);
    fd.append('include_title',    includeTitle);
    fd.append('output',           'file');
    if (customFilename) fd.append('output_filename', outName);

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 500, 'Reading Word document…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 50, 700, 'Parsing headings & styles…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(50, 78, 700, 'Converting tables & lists…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 92, 500, 'Building LaTeX output…');
    }, 2200);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/word-to-latexs', {
        method: 'POST',
        body: fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
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
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · LaTeX Source File';

      renderResultChips(documentClass, paperSize, fontSize, includePackages, includeToc, includeTitle);

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

  function renderResultChips(docClass, paper, fontSize, packages, toc, title) {
    const wrap = document.getElementById('result-info-wrap');
    const list = document.getElementById('result-chips');
    list.innerHTML = '';

    const chips = [
      ['chip-docclass', '\\documentclass', docClass],
      ['chip-paper',    'Paper',           paper.replace('paper','').toUpperCase()],
      ['chip-option',   'Font',            fontSize + 'pt'],
    ];
    if (packages) chips.push(['chip-option', 'Packages', 'included']);
    if (toc)      chips.push(['chip-option', 'TOC', 'enabled']);
    if (title)    chips.push(['chip-option', 'Title', 'included']);

    chips.forEach(([cls, label, val]) => {
      const chip = document.createElement('div');
      chip.className = 'chip-item ' + cls;
      chip.innerHTML = `<span class="chip-dot"></span><span class="chip-label"></span><span style="opacity:.6;margin-left:2px;font-family:monospace;font-size:10px;">${val}</span>`;
      chip.querySelector('.chip-label').textContent = label;
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
    resetFile();
    document.getElementById('opt-filename').value   = '';
    document.getElementById('opt-docclass').value   = 'article';
    document.getElementById('opt-fontsize').value   = '12';
    document.getElementById('opt-papersize').value  = 'a4paper';
    document.getElementById('opt-packages').checked = true;
    document.getElementById('opt-toc').checked      = false;
    document.getElementById('opt-title').checked    = true;
    document.getElementById('result-info-wrap').classList.add('hidden');
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
