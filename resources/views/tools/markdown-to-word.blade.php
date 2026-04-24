@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
<script src="https://cdn.jsdelivr.net/npm/marked@12.0.0/marked.min.js" defer></script>
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @foreach([['1','Input Markdown'],['2','Converting'],['3','Download']] as [$n, $label])
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

                    {{-- ── Mode tabs ── --}}
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
                            Write / Paste
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .md
                        </button>
                    </div>

                    {{-- ══ TEXT TAB (editor + live preview) ══ --}}
                    <div id="panel-text">
                        {{-- View toggle --}}
                        <div class="flex items-center justify-between mb-2">
                            <div
                                class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-lg w-fit">
                                <button type="button" id="editor-view-edit"
                                    class="edit-view-btn active flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                    Edit
                                </button>
                                <button type="button" id="editor-view-split"
                                    class="edit-view-btn flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <line x1="12" y1="3" x2="12" y2="21" />
                                    </svg>
                                    Split
                                </button>
                                <button type="button" id="editor-view-preview"
                                    class="edit-view-btn flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Preview
                                </button>
                            </div>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample"
                                    class="flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    Sample
                                </button>
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

                        {{-- Editor + Preview panels --}}
                        <div id="editor-split" class="grid gap-3 grid-cols-1">
                            {{-- Editor --}}
                            <div id="editor-pane">
                                <textarea id="md-textarea" rows="14" spellcheck="false"
                                    placeholder='Write or paste Markdown here, e.g.&#10;&#10;# My Report&#10;&#10;## Introduction&#10;This is a **bold** intro with *italic* text.&#10;&#10;- Point one&#10;- Point two&#10;&#10;| Name | Age |&#10;|------|-----|&#10;| Alice | 30 |'
                                    class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                                <div class="flex items-center justify-between text-fn-text3 text-xs mt-1.5">
                                    <span id="md-meta">0 characters · 0 lines</span>
                                    <span class="text-fn-text3/70">Supports GFM, tables, tasklists, code blocks,
                                        HTML</span>
                                </div>
                            </div>

                            {{-- Preview (hidden by default) --}}
                            <div id="preview-pane" class="hidden">
                                <div
                                    class="bg-fn-surface2 border border-fn-text/10 rounded-xl p-5 max-h-[360px] overflow-auto">
                                    <div id="live-preview" class="md-body">
                                        <p class="text-fn-text3 text-sm text-center">Preview will appear here as you
                                            type…</p>
                                    </div>
                                </div>
                                <p class="text-fn-text3 text-xs mt-1.5">Rendered preview — the final .docx will closely
                                    match this.</p>
                            </div>
                        </div>
                    </div>{{-- /panel-text --}}

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center">
                                    <span class="font-mono font-black text-3xl text-fn-green">M↓</span>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your Markdown file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .md and .markdown — or click to browse</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose Markdown File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input" accept=".md,.markdown,text/markdown,text/plain"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center shrink-0">
                                <span class="font-mono font-black text-base text-fn-green">M↓</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">document.md</p>
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
                    </div>{{-- /panel-file --}}

                    {{-- Document settings --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-fn-text2">Document Settings</p>
                            <span class="text-xs text-fn-text3">Optional — sensible defaults apply</span>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="opt-title" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                Document title
                                <span class="font-normal text-fn-text3 ml-1">(adds as a big heading on first
                                    page)</span>
                            </label>
                            <input type="text" id="opt-title" placeholder="e.g. Q4 Report — Internal"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                        </div>

                        {{-- Font + Size + Spacing + Page --}}
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Font</label>
                                <select id="opt-font"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 cursor-pointer focus:outline-none focus:border-fn-blue/40">
                                    @foreach(['Calibri','Arial','Times New Roman','Georgia','Verdana','Courier New'] as $f)
                                    <option value="{{ $f }}" {{ $f==='Calibri' ? 'selected' : '' }}>{{ $f }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                    Size
                                    <span class="font-normal text-fn-text3 text-xs" id="size-val">11pt</span>
                                </label>
                                <input type="range" id="opt-size" min="6" max="72" value="11" step="1"
                                    class="w-full accent-fn-blue cursor-pointer" />
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Line spacing</label>
                                <div class="flex gap-1">
                                    @foreach([['1.0','1.0'],['1.15','1.15'],['1.5','1.5'],['2.0','2.0']] as [$sval,
                                    $slabel])
                                    <button type="button"
                                        class="spacing-btn {{ $sval === '1.15' ? 'active' : '' }} flex-1 px-2 py-1.5 rounded-lg border text-xs font-semibold transition-all"
                                        data-val="{{ $sval }}">{{ $slabel }}</button>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Page size</label>
                                <select id="opt-page"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 cursor-pointer focus:outline-none focus:border-fn-blue/40">
                                    @foreach([['A4','A4'],['Letter','US Letter'],['Legal','Legal'],['A3','A3']] as [$pv,
                                    $pl])
                                    <option value="{{ $pv }}" {{ $pv==='A4' ? 'selected' : '' }}>{{ $pl }}</option>
                                    @endforeach
                                </select>
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
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Convert to Word
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center">
                            <span class="font-mono font-black text-2xl text-fn-green">M↓</span>
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
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📝</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting to Word…</h2>
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
                        ['proc-1','Uploading Markdown content'],
                        ['proc-2','Parsing headings & tables'],
                        ['proc-3','Applying fonts & styles'],
                        ['proc-4','Building Word document'],
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
                    <p class="text-fn-text2 text-sm mb-6">Your Word document is ready.</p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            📝</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">document.docx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Word Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="document.docx"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Word Document
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
            ['What Markdown syntax is supported?','The full GitHub-Flavored Markdown set: headings (ATX # and Setext
            ===), bold, italic, strikethrough, inline and fenced code blocks, ordered and unordered lists, nested lists,
            task lists (- [ ] / - [x]), tables, blockquotes, horizontal rules, links, image placeholders, and a few raw
            HTML tags (<u>, <mark>, <br>).'],
                    ['Will tables and code blocks look good in Word?','Yes — tables get a styled blue header row, code
                    blocks get a grey background with a blue left border and Courier New font, and inline code is
                    rendered in red monospace. Headings 1–6 use Word\'s built-in heading styles so your Table of
                    Contents will work correctly.'],
                    ['Can I control the font and page size?','Yes — pick from Calibri, Arial, Times New Roman, Georgia,
                    Verdana, or Courier New. Font size ranges from 6 to 72pt. Page size supports A4, Letter, Legal, and
                    A3. Line spacing options are 1.0, 1.15 (default), 1.5, and 2.0.'],
                    ['Can I paste Markdown instead of uploading a file?','Yes — use the "Write / Paste" tab to paste or
                    type Markdown directly. A live preview shows how it will look, then the final .docx closely matches
                    that preview.'],
                    ['Is my content safe and private?','All uploads use AES-256 encryption in transit and are
                    permanently deleted within 1 hour. We never read, share or store your content.'],
                    ] as [$q, $a])
                    <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                        <button type="button"
                            class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left hover:bg-fn-surface2 transition-colors">
                            <span class="font-semibold text-sm">{{ $q }}</span>
                            <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
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
    .tab-btn,
    .edit-view-btn {
        color: var(--fn-text3);
    }

    .tab-btn.active,
    .edit-view-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0 / 12%);
    }

    .spacing-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .spacing-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .spacing-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    #opt-size {
        height: 4px;
        background: oklch(var(--fn-text-l, 80%) 0 0 / 12%);
        border-radius: 999px;
        outline: none;
    }

    /* Split view */
    #editor-split.split-mode {
        grid-template-columns: 1fr 1fr;
    }

    #editor-split.split-mode #preview-pane {
        display: block;
    }

    #editor-split.preview-mode #editor-pane {
        display: none;
    }

    #editor-split.preview-mode #preview-pane {
        display: block;
    }

    /* Markdown preview */
    .md-body {
        color: var(--fn-text);
        font-size: 13px;
        line-height: 1.6;
    }

    .md-body h1,
    .md-body h2,
    .md-body h3,
    .md-body h4,
    .md-body h5,
    .md-body h6 {
        color: var(--fn-blue-l);
        font-weight: 700;
        margin: 18px 0 8px;
        line-height: 1.3;
    }

    .md-body h1 {
        font-size: 22px;
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        padding-bottom: 6px;
    }

    .md-body h2 {
        font-size: 18px;
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        padding-bottom: 4px;
    }

    .md-body h3 {
        font-size: 16px;
    }

    .md-body h4,
    .md-body h5,
    .md-body h6 {
        font-size: 14px;
    }

    .md-body h1:first-child,
    .md-body h2:first-child,
    .md-body h3:first-child {
        margin-top: 0;
    }

    .md-body p {
        margin: 0 0 12px;
    }

    .md-body strong {
        font-weight: 700;
    }

    .md-body em {
        font-style: italic;
    }

    .md-body del {
        text-decoration: line-through;
        color: var(--fn-text3);
    }

    .md-body a {
        color: var(--fn-blue-l);
        text-decoration: underline;
    }

    .md-body mark {
        background: oklch(85% 0.18 95 / 40%);
        color: var(--fn-text);
        padding: 0 2px;
        border-radius: 2px;
    }

    .md-body ul,
    .md-body ol {
        margin: 0 0 12px;
        padding-left: 22px;
    }

    .md-body li {
        margin-bottom: 3px;
    }

    .md-body input[type="checkbox"] {
        margin-right: 6px;
    }

    .md-body blockquote {
        margin: 0 0 12px;
        padding: 6px 14px;
        border-left: 3px solid oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 5%);
        color: var(--fn-text2);
        font-style: italic;
    }

    .md-body blockquote p:last-child {
        margin-bottom: 0;
    }

    .md-body code {
        background: oklch(62% 0.22 25 / 8%);
        color: oklch(62% 0.22 25);
        padding: 1px 5px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }

    .md-body pre {
        background: var(--fn-surface);
        border: 1px solid oklch(49% 0.24 264 / 25%);
        border-left: 3px solid oklch(49% 0.24 264);
        border-radius: 6px;
        padding: 10px 14px;
        overflow-x: auto;
        margin: 0 0 12px;
    }

    .md-body pre code {
        background: transparent;
        padding: 0;
        color: var(--fn-text2);
        font-size: 12px;
    }

    .md-body table {
        border-collapse: collapse;
        width: 100%;
        margin: 0 0 12px;
        font-size: 12px;
    }

    .md-body th,
    .md-body td {
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        padding: 5px 9px;
        text-align: left;
    }

    .md-body th {
        background: oklch(49% 0.24 264 / 10%);
        color: var(--fn-blue-l);
        font-weight: 700;
    }

    .md-body tr:hover td {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 3%);
    }

    .md-body hr {
        border: none;
        border-top: 1px solid oklch(49% 0.24 264 / 35%);
        margin: 16px 0;
    }

    .md-body img {
        max-width: 100%;
        border-radius: 6px;
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_MD = `# Quarterly Report

## Summary

This **quarter** exceeded expectations with *significant* growth across all regions.

> "Our best quarter yet." — CEO

## Key Metrics

| Region  | Revenue | Growth |
|---------|---------|--------|
| EMEA    | $1.2M   | +18%   |
| APAC    | $850K   | +22%   |
| America | $2.1M   | +12%   |

## Action Items

- [x] Finalize Q3 close
- [x] Publish earnings report
- [ ] Schedule town hall
- [ ] Update roadmap

## Code Example

\`\`\`python
def calculate_growth(current, previous):
    return (current - previous) / previous * 100
\`\`\`

Inline code like \`npm install\` and ~~deprecated~~ features render nicely.

---

For questions, see the [contact page](https://example.com).
`;

  // ── Refs ──
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
  const mdTA        = document.getElementById('md-textarea');
  const livePrev    = document.getElementById('live-preview');
  const editorSplit = document.getElementById('editor-split');

  let selectedFile  = null;
  let blobUrl       = null;
  let activeTab     = 'text';
  let activeSpacing = '1.15';
  let editorView    = 'edit';
  let previewTimer  = null;

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
  }

  // ── Editor views ──
  document.getElementById('editor-view-edit').addEventListener('click',    () => setEditorView('edit'));
  document.getElementById('editor-view-split').addEventListener('click',   () => setEditorView('split'));
  document.getElementById('editor-view-preview').addEventListener('click', () => setEditorView('preview'));

  function setEditorView(v) {
    editorView = v;
    document.getElementById('editor-view-edit').classList.toggle('active',    v === 'edit');
    document.getElementById('editor-view-split').classList.toggle('active',   v === 'split');
    document.getElementById('editor-view-preview').classList.toggle('active', v === 'preview');
    editorSplit.classList.remove('split-mode', 'preview-mode');
    if (v === 'split')   editorSplit.classList.add('split-mode');
    if (v === 'preview') editorSplit.classList.add('preview-mode');
    if (v !== 'edit') updatePreview();
  }

  // ── Spacing buttons ──
  document.querySelectorAll('.spacing-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.spacing-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeSpacing = btn.dataset.val;
    });
  });

  // ── Size slider ──
  const sizeSlider = document.getElementById('opt-size');
  sizeSlider.addEventListener('input', () => {
    document.getElementById('size-val').textContent = sizeSlider.value + 'pt';
  });

  // ── Sample / Paste / Clear ──
  document.getElementById('btn-sample').addEventListener('click', () => {
    mdTA.value = SAMPLE_MD;
    mdTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { mdTA.value = await navigator.clipboard.readText(); mdTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    mdTA.value = '';
    mdTA.dispatchEvent(new Event('input'));
  });

  // ── Textarea input ──
  mdTA.addEventListener('input', () => {
    const v = mdTA.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('md-meta').textContent = v.length.toLocaleString() + ' characters · ' + lines + ' lines';
    refreshConvertBtn();
    if (editorView === 'edit') return;
    clearTimeout(previewTimer);
    previewTimer = setTimeout(updatePreview, 250);
  });

  function updatePreview() {
    const md = mdTA.value;
    if (!md.trim()) {
      livePrev.innerHTML = '<p class="text-fn-text3 text-sm text-center">Preview will appear here as you type…</p>';
      return;
    }
    try {
      if (typeof marked !== 'undefined') {
        marked.setOptions({ gfm: true, breaks: false, headerIds: false, mangle: false });
        livePrev.innerHTML = marked.parse(md);
      } else {
        setTimeout(updatePreview, 200);
      }
    } catch (e) {
      console.warn('Preview render failed:', e);
      const esc = md.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
      livePrev.innerHTML = '<pre style="white-space:pre-wrap;font-family:inherit;">' + esc + '</pre>';
    }
  }

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
    if (!name.match(/\.(md|markdown|txt)$/)) {
      showError('Please select a valid Markdown file (.md or .markdown).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · Markdown';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');
    refreshConvertBtn();
  }

  function resetFile() {
    selectedFile    = null;
    fileInput.value = '';
    filePreview.classList.add('hidden');
    filePreview.classList.remove('flex');
    dropZone.classList.remove('has-file');
    refreshConvertBtn();
    hideError();
  }

  function refreshConvertBtn() {
    if (activeTab === 'text') {
      convertBtn.disabled = !mdTA.value.trim();
    } else {
      convertBtn.disabled = !selectedFile;
    }
  }

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const title    = document.getElementById('opt-title').value.trim();
    const fontName = document.getElementById('opt-font').value;
    const fontSize = parseInt(document.getElementById('opt-size').value) || 11;
    const pageSize = document.getElementById('opt-page').value;

    let fetchBody, fetchHeaders = {};
    let outName    = 'document.docx';

    if (activeTab === 'file') {
      const fd = new FormData();
      fd.append('file',         selectedFile);
      if (title)   fd.append('title', title);
      fd.append('font_name',    fontName);
      fd.append('font_size',    fontSize);
      fd.append('line_spacing', activeSpacing);
      fd.append('page_size',    pageSize);
      fetchBody = fd;
      outName = (selectedFile?.name || 'document').replace(/\.(md|markdown|txt)$/i, '') + '.docx';
    } else {
      const payload = {
        markdown:     mdTA.value,
        font_name:    fontName,
        font_size:    fontSize,
        line_spacing: parseFloat(activeSpacing),
        page_size:    pageSize,
      };
      if (title) payload.title = title;
      fetchBody    = JSON.stringify(payload);
      fetchHeaders = { 'Content-Type': 'application/json' };
      outName = (title || 'document').replace(/[^a-z0-9\-_ ]/gi, '').trim() || 'document';
      outName += '.docx';
    }

    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 500, 'Uploading Markdown content…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 55, 700, 'Parsing headings & tables…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 80, 700, 'Applying fonts & styles…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(80, 92, 500, 'Building Word document…');
    }, 2200);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/markdown-to-word', {
        method: 'POST',
        headers: fetchHeaders,
        body: fetchBody,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch (_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · Word Document';

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
    mdTA.value = '';
    mdTA.dispatchEvent(new Event('input'));
    document.getElementById('opt-title').value  = '';
    document.getElementById('opt-font').value   = 'Calibri';
    document.getElementById('opt-size').value   = 11;
    document.getElementById('size-val').textContent = '11pt';
    document.getElementById('opt-page').value   = 'A4';
    activeSpacing = '1.15';
    document.querySelectorAll('.spacing-btn').forEach(b => b.classList.toggle('active', b.dataset.val === '1.15'));
    switchTab('text');
    setEditorView('edit');
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

}); // end DOMContentLoaded
</script>
@endpush

@endsection
