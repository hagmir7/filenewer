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
                @foreach([['1','Input LaTeX'],['2','Compiling'],['3','Download']] as [$n, $label])
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

                    {{-- Mode tabs --}}
                    <div
                        class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-6 w-fit">
                        <button type="button" id="tab-text"
                            class="tab-btn active flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 7 4 4 20 4 20 7" />
                                <line x1="9" y1="20" x2="15" y2="20" />
                                <line x1="12" y1="4" x2="12" y2="20" />
                            </svg>
                            Paste LaTeX
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .tex
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">LaTeX source</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Sample</button>
                                <button type="button" id="btn-paste"
                                    class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                        <rect x="8" y="2" width="8" height="4" rx="1" />
                                    </svg>
                                    Paste
                                </button>
                                <button type="button" id="btn-clear"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">Clear</button>
                            </div>
                        </div>

                        <textarea id="latex-textarea" rows="12" spellcheck="false"
                            placeholder='\documentclass[12pt,a4paper]{article}&#10;\usepackage[utf8]{inputenc}&#10;\begin{document}&#10;\title{My Document}&#10;\maketitle&#10;\section{Introduction}&#10;Hello, \textbf{world}!&#10;\end{document}'
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>

                        <div class="flex items-center justify-between text-xs mt-1.5">
                            <span id="latex-status" class="text-fn-text3">Paste a complete LaTeX document starting with
                                \documentclass</span>
                            <span id="latex-meta" class="text-fn-text3/70">0 chars · 0 lines</span>
                        </div>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-red/40 hover:bg-fn-red/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-fn-red">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                        <polyline points="10 9 9 9 8 9" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your .tex file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .tex files — or click to browse</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose .tex File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input" accept=".tex,text/x-tex,application/x-tex,text/plain"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" class="text-fn-red">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">document.tex</p>
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
                    </div>

                    {{-- Detected structure preview --}}
                    <div id="detected-content"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-blue/15 rounded-xl">
                        <div class="flex items-center gap-2 mb-3">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-blue-l">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <p class="text-sm font-semibold text-fn-text2">Detected in your document</p>
                        </div>
                        <div class="flex flex-wrap gap-2" id="detected-chips"></div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">Compiler Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Left --}}
                            <div class="flex flex-col gap-3">
                                <div>
                                    <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Output filename
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-filename" placeholder="document.pdf"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>

                                <div>
                                    <label for="opt-compiler"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">LaTeX compiler</label>
                                    <select id="opt-compiler"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="pdflatex" selected>pdfLaTeX — fast, standard</option>
                                        <option value="lualatex">LuaLaTeX — Unicode &amp; advanced fonts</option>
                                        <option value="xelatex">XeLaTeX — system fonts support</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="opt-passes"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Compile passes</label>
                                    <select id="opt-passes"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="1">1 pass — quick output</option>
                                        <option value="2" selected>2 passes — resolve references</option>
                                        <option value="3">3 passes — TOC &amp; bibliographies</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Right --}}
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Options</label>
                                <div class="flex flex-col gap-1.5">
                                    @foreach([
                                    ['opt-synctex', 'SyncTeX', 'Enable source ↔ PDF sync', false],
                                    ['opt-draft', 'Draft mode', 'Skip images for faster output', false],
                                    ['opt-log', 'Return log', 'Include compiler log in response', false],
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
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Compile to PDF
                    </button>
                </div>

                {{-- ── STATE: Compiling ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" class="text-fn-red">
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
                            📕</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Compiling LaTeX to PDF…</h2>
                    <p class="text-fn-text3 text-sm mb-8" id="compiling-subtitle">Running pdfLaTeX — resolving
                        references &amp; cross-links</p>

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
                        ['proc-1','Reading LaTeX source'],
                        ['proc-2','Running compiler pass 1'],
                        ['proc-3','Resolving references'],
                        ['proc-4','Generating PDF output'],
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
                            <span class="text-sm text-fn-text3 proc-label">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Compilation Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6">Your PDF is ready to download.</p>

                    {{-- Compilation info chips --}}
                    <div id="result-info-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Compilation details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-chips"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">document.pdf</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">PDF Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="document.pdf"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download PDF
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Compile another
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
            ['Which LaTeX compilers are supported?', 'Three compilers are available: pdfLaTeX (the standard choice —
            fast and broadly compatible), LuaLaTeX (best for Unicode content and advanced OpenType font support), and
            XeLaTeX (ideal for documents that use system-installed fonts). pdfLaTeX is recommended for most
            documents.'],
            ['How many compile passes do I need?', 'One pass is fine for simple documents. Two passes (the default)
            resolves internal cross-references and hyperlinks. Three passes are needed when your document includes a
            table of contents, bibliography entries, or complex label references that need multiple resolutions.'],
            ['What happens if my LaTeX has a compile error?', 'If the compiler encounters a fatal error, you will see a
            descriptive error message. Enable the "Return log" option to receive the full compiler log — this is the
            most effective way to pinpoint issues like missing packages, undefined commands, or malformed
            environments.'],
            ['Can I upload a .tex file with custom packages?', 'Standard LaTeX packages (amsmath, graphicx, hyperref,
            booktabs, geometry, etc.) are pre-installed on the compile server. Custom or third-party packages not in the
            TeX Live distribution may not be available and could cause compilation to fail.'],
            ['Is my LaTeX source safe and private?', 'All uploads use AES-256 encryption in transit and are permanently
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
    .tab-btn {
        color: var(--fn-text3);
    }

    .tab-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0 / 12%);
    }

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

    .chip-compiler .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-compiler {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .chip-passes .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-passes {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .chip-option .chip-dot {
        background: oklch(67% 0.18 162);
    }

    .chip-option {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }

    .chip-detect .chip-dot {
        background: oklch(72% 0.18 55);
    }

    .chip-detect {
        color: oklch(72% 0.18 55);
        border-color: oklch(72% 0.18 55 / 30%);
        background: oklch(72% 0.18 55 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_LATEX = `\\documentclass[12pt,a4paper]{article}
% ── Packages ─────────────────────────────
\\usepackage[utf8]{inputenc}
\\usepackage[T1]{fontenc}
\\usepackage{lmodern}
\\usepackage{amsmath}
\\usepackage{graphicx}
\\usepackage{hyperref}
\\usepackage{booktabs}
\\usepackage{geometry}
\\geometry{a4paper, margin=1in}
\\hypersetup{colorlinks=true, linkcolor=blue, urlcolor=blue}
% ── Document info ─────────────────────────
\\title{Sample Document}
\\author{Your Name}
\\date{\\today}
% ── Begin document ─────────────────────────
\\begin{document}
\\maketitle
\\tableofcontents
\\section{Introduction}
This is the \\textbf{introduction} with \\textit{italic} and \\underline{underline} text.
\\subsection{Background}
More detail here. Inline math: $E = mc^2$. Display math:
\\[ \\int_0^\\infty e^{-x^2}\\,dx = \\frac{\\sqrt{\\pi}}{2} \\]
\\section{Tables}
\\begin{table}[h!]
\\centering
\\begin{tabular}{lll}
\\toprule
\\textbf{Name} & \\textbf{Age} & \\textbf{City} \\\\
\\midrule
Alice & 30 & London \\\\
Bob   & 25 & Paris  \\\\
\\bottomrule
\\end{tabular}
\\caption{Sample table}
\\end{table}
\\begin{itemize}
  \\item First item
  \\item Second item
\\end{itemize}
\\end{document}
`;

  const tabText     = document.getElementById('tab-text');
  const tabFile     = document.getElementById('tab-file');
  const panelText   = document.getElementById('panel-text');
  const panelFile   = document.getElementById('panel-file');
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');
  const latexTA     = document.getElementById('latex-textarea');

  let selectedFile = null;
  let blobUrl      = null;
  let activeTab    = 'text';
  let detectTimer  = null;

  // ── Tabs ──
  tabText.addEventListener('click', () => switchTab('text'));
  tabFile.addEventListener('click', () => switchTab('file'));

  function switchTab(tab) {
    activeTab = tab;
    tabText.classList.toggle('active', tab === 'text');
    tabFile.classList.toggle('active', tab === 'file');
    panelText.classList.toggle('hidden', tab !== 'text');
    panelFile.classList.toggle('hidden', tab !== 'file');
    hideError();
    refreshConvertBtn();
    refreshDetection();
  }

  // ── Sample / Paste / Clear ──
  document.getElementById('btn-sample').addEventListener('click', () => {
    latexTA.value = SAMPLE_LATEX;
    latexTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { latexTA.value = await navigator.clipboard.readText(); latexTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    latexTA.value = '';
    latexTA.dispatchEvent(new Event('input'));
  });

  // ── Textarea ──
  latexTA.addEventListener('input', () => {
    const v = latexTA.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('latex-meta').textContent = v.length.toLocaleString() + ' chars · ' + lines + ' lines';

    const status = document.getElementById('latex-status');
    if (!v.trim()) {
      status.innerHTML = '<span class="text-fn-text3">Paste a complete LaTeX document starting with \\documentclass</span>';
    } else {
      const stats = analyzeLatex(v);
      if (stats.hasDocumentClass) {
        const parts = [];
        if (stats.hasBeginDocument) parts.push('valid structure');
        if (stats.sectionCount > 0) parts.push(stats.sectionCount + ' section' + (stats.sectionCount !== 1 ? 's' : ''));
        if (stats.hasMath) parts.push('math');
        if (stats.hasTable) parts.push('tables');
        status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Valid LaTeX detected${parts.length ? ' · ' + parts.join(' · ') : ''}
        </span>`;
      } else {
        status.innerHTML = '<span class="text-fn-amber">No \\documentclass found — ensure it\'s a complete document</span>';
      }
    }

    refreshConvertBtn();
    clearTimeout(detectTimer);
    detectTimer = setTimeout(refreshDetection, 250);
  });

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

  async function handleFile(file) {
    hideError();
    const name = file.name.toLowerCase();
    if (!name.match(/\.(tex|txt)$/)) {
      showError('Please select a valid LaTeX file (.tex).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · LaTeX source';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');

    if (file.size < 5 * 1024 * 1024) {
      try {
        const text = await file.text();
        detectFromText(text);
      } catch(_) {}
    }

    refreshConvertBtn();
  }

  function resetFile() {
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    document.getElementById('detected-content').classList.add('hidden');
    refreshConvertBtn();
    hideError();
  }

  function refreshConvertBtn() {
    if (activeTab === 'text') convertBtn.disabled = !latexTA.value.trim();
    else                      convertBtn.disabled = !selectedFile;
  }

  // ── Detection ──
  function refreshDetection() {
    if (activeTab === 'text') {
      const v = latexTA.value.trim();
      if (!v) { document.getElementById('detected-content').classList.add('hidden'); return; }
      detectFromText(v);
    }
  }

  function detectFromText(src) {
    const stats = analyzeLatex(src);
    const wrap  = document.getElementById('detected-content');
    const list  = document.getElementById('detected-chips');
    list.innerHTML = '';

    const chips = [];
    if (stats.documentClass) chips.push(['chip-compiler', '\\documentclass', stats.documentClass]);
    if (stats.sectionCount > 0) chips.push(['chip-passes', 'Sections', stats.sectionCount + '']);
    if (stats.packageCount > 0) chips.push(['chip-option', 'Packages', stats.packageCount + '']);
    if (stats.hasMath)  chips.push(['chip-detect', 'Math', 'detected']);
    if (stats.hasTable) chips.push(['chip-detect', 'Tables', 'detected']);
    if (stats.hasToc)   chips.push(['chip-detect', 'TOC', 'detected']);
    if (stats.hasBib)   chips.push(['chip-detect', 'Bibliography', 'detected']);

    if (chips.length === 0) { wrap.classList.add('hidden'); return; }

    chips.forEach(([cls, label, val]) => {
      const chip = document.createElement('div');
      chip.className = 'chip-item ' + cls;
      chip.innerHTML = `<span class="chip-dot"></span><span class="chip-label"></span><span style="opacity:.6;margin-left:2px;font-family:monospace;font-size:10px;">${val}</span>`;
      chip.querySelector('.chip-label').textContent = label;
      list.appendChild(chip);
    });
    wrap.classList.remove('hidden');
  }

  // Lightweight LaTeX analyzer
  function analyzeLatex(src) {
    const cleaned = src.replace(/%[^\n]*/g, ''); // strip comments

    const docClassMatch = cleaned.match(/\\documentclass(?:\[.*?\])?\{([\w]+)\}/);
    const documentClass = docClassMatch ? docClassMatch[1] : null;

    const sectionRe = /\\(?:chapter|section|subsection|subsubsection)\s*\{/g;
    let sectionCount = 0;
    while (sectionRe.exec(cleaned) !== null) sectionCount++;

    const pkgRe = /\\usepackage(?:\[.*?\])?\{[\w,\s]+\}/g;
    let packageCount = 0;
    while (pkgRe.exec(cleaned) !== null) packageCount++;

    return {
      documentClass,
      hasDocumentClass:  !!documentClass,
      hasBeginDocument:  /\\begin\s*\{document\}/.test(cleaned),
      sectionCount,
      packageCount,
      hasMath:  /\$|\\\[|\\begin\s*\{(equation|align|math)/.test(cleaned),
      hasTable: /\\begin\s*\{(tabular|table|longtable)/.test(cleaned),
      hasToc:   /\\tableofcontents/.test(cleaned),
      hasBib:   /\\bibliography|\\begin\s*\{thebibliography\}/.test(cleaned),
    };
  }

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const customFilename = document.getElementById('opt-filename').value.trim();
    const compiler       = document.getElementById('opt-compiler').value;
    const passes         = document.getElementById('opt-passes').value;
    const synctex        = document.getElementById('opt-synctex').checked;
    const draft          = document.getElementById('opt-draft').checked;
    const returnLog      = document.getElementById('opt-log').checked;

    // Update compiling subtitle
    const compilerLabel = { pdflatex: 'pdfLaTeX', lualatex: 'LuaLaTeX', xelatex: 'XeLaTeX' }[compiler] || compiler;
    document.getElementById('compiling-subtitle').textContent =
      `Running ${compilerLabel} — ${passes} pass${passes > 1 ? 'es' : ''}, resolving references`;

    // Update pass labels
    const passLabels = ['proc-2', 'proc-3'];
    if (passes >= 2) {
      const el = document.getElementById('proc-3');
      if (el) el.querySelector('.proc-label').textContent = 'Compiler pass 2 — cross-references';
    }

    let outName;
    if (customFilename) {
      outName = customFilename.toLowerCase().endsWith('.pdf') ? customFilename : customFilename + '.pdf';
    } else if (activeTab === 'file' && selectedFile) {
      outName = selectedFile.name.replace(/\.tex$/i, '') + '.pdf';
    } else {
      outName = 'document.pdf';
    }

    let fetchBody;
    let latexSrc = '';

    if (activeTab === 'file') {
      const fd = new FormData();
      fd.append('file',     selectedFile);
      fd.append('compiler', compiler);
      fd.append('passes',   passes);
      fd.append('synctex',  synctex);
      fd.append('draft',    draft);
      fd.append('log',      returnLog);
      fd.append('output',   'file');
      if (customFilename) fd.append('output_filename', outName);
      fetchBody = fd;
      try {
        if (selectedFile.size < 5 * 1024 * 1024) latexSrc = await selectedFile.text();
      } catch(_) {}
    } else {
      latexSrc = latexTA.value;
      const fd = new FormData();
      const blob = new Blob([latexSrc], { type: 'text/plain' });
      fd.append('file',     blob, 'document.tex');
      fd.append('compiler', compiler);
      fd.append('passes',   passes);
      fd.append('synctex',  synctex);
      fd.append('draft',    draft);
      fd.append('log',      returnLog);
      fd.append('output',   'file');
      if (customFilename) fd.append('output_filename', outName);
      fetchBody = fd;
    }

    setProcessStep('proc-1', 'active');
    animateProgress(0, 18, 400, 'Reading LaTeX source…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(18, 45, 800, `Running ${compilerLabel} pass 1…`);
    }, 500);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(45, 75, 900, passes >= 2 ? `Running ${compilerLabel} pass 2…` : 'Resolving references…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(75, 92, 600, 'Generating PDF output…');
    }, 2400);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/latex-to-pdf', {
        method: 'POST',
        body:   fetchBody,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Compilation failed. Please check your LaTeX source.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · PDF Document';

      renderResultChips(compiler, passes, synctex, draft, latexSrc);

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

  function renderResultChips(compiler, passes, synctex, draft, src) {
    const wrap = document.getElementById('result-info-wrap');
    const list = document.getElementById('result-chips');
    list.innerHTML = '';

    const compilerLabel = { pdflatex: 'pdfLaTeX', lualatex: 'LuaLaTeX', xelatex: 'XeLaTeX' }[compiler] || compiler;
    const chips = [
      ['chip-compiler', 'Compiler', compilerLabel],
      ['chip-passes',   'Passes',   passes + 'x'],
    ];
    if (synctex) chips.push(['chip-option', 'SyncTeX', 'enabled']);
    if (draft)   chips.push(['chip-option', 'Draft', 'mode']);

    if (src) {
      const stats = analyzeLatex(src);
      if (stats.documentClass) chips.push(['chip-detect', '\\documentclass', stats.documentClass]);
    }

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
    latexTA.value = '';
    latexTA.dispatchEvent(new Event('input'));
    document.getElementById('opt-filename').value  = '';
    document.getElementById('opt-compiler').value  = 'pdflatex';
    document.getElementById('opt-passes').value    = '2';
    document.getElementById('opt-synctex').checked = false;
    document.getElementById('opt-draft').checked   = false;
    document.getElementById('opt-log').checked     = false;
    document.getElementById('detected-content').classList.add('hidden');
    document.getElementById('result-info-wrap').classList.add('hidden');
    switchTab('text');
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
      const body   = btn.nextElementSibling;
      const icon   = btn.querySelector('.faq-icon');
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
