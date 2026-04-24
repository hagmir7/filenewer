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
                @foreach([['1','Upload Word'],['2','Converting'],['3','Markdown']] as [$n, $label])
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
                                📝</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your Word document here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .docx and .doc — or click to browse</p>
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
                            accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            📝</div>
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

                    {{-- Simplified options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <p class="text-sm font-semibold text-fn-text2 mb-3">Options</p>

                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-2.5">
                            @foreach([
                            ['opt-toc', '📚', 'Include table of contents', 'Auto-generated from headings', false],
                            ['opt-tables', '▦', 'Convert tables', 'Keep tables as Markdown tables', true],
                            ['opt-images', '🖼', 'Image placeholders', 'Insert ![Image N](...) markers', false],
                            ['opt-emphasis', 'B', 'Keep bold & italic', 'Preserve **bold** and *italic*', true],
                            ] as [$tid, $ticon, $tlabel, $tdesc, $tdefault])
                            <label class="flex items-start gap-2.5 cursor-pointer select-none">
                                <div class="toggle-wrap relative w-8 h-4 mt-0.5 shrink-0">
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
                                    <p class="text-xs font-semibold text-fn-text2 flex items-center gap-1.5">
                                        <span class="text-fn-text3">{{ $ticon }}</span>
                                        {{ $tlabel }}
                                    </p>
                                    <p class="text-xs text-fn-text3 leading-tight mt-0.5">{{ $tdesc }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        {{-- Advanced (collapsed) --}}
                        <details class="mt-3 pt-3 border-t border-fn-text/8">
                            <summary
                                class="text-xs font-semibold text-fn-text3 hover:text-fn-text cursor-pointer list-none flex items-center gap-1.5">
                                <svg class="w-3 h-3 transition-transform" id="adv-chev" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.4" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                                Advanced
                            </summary>
                            <div class="mt-3 grid sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Heading
                                        style</label>
                                    <div class="flex gap-1">
                                        <button type="button"
                                            class="heading-btn active px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                            data-val="atx">
                                            <span class="font-mono">#</span> ATX
                                        </button>
                                        <button type="button"
                                            class="heading-btn px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                            data-val="setext">
                                            <span class="font-mono">===</span> Setext
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Code blocks</label>
                                    <div class="flex gap-1">
                                        <button type="button"
                                            class="code-btn active px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                            data-val="fenced">
                                            <span class="font-mono">```</span> Fenced
                                        </button>
                                        <button type="button"
                                            class="code-btn px-2.5 py-1 rounded-lg border text-xs font-semibold transition-all"
                                            data-val="indented">
                                            Indented
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </details>
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
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                        Convert to Markdown
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📝</div>
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
                            <span class="font-mono font-black text-2xl text-fn-green">M↓</span>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting to Markdown…</h2>
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
                        ['proc-1','Uploading Word document'],
                        ['proc-2','Reading paragraphs & headings'],
                        ['proc-3','Converting styles to Markdown'],
                        ['proc-4','Building final output'],
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

                {{-- ── STATE: Result ── --}}
                <div id="state-download" class="hidden">

                    {{-- Success header --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-fn-green/25 bg-fn-green/8 text-fn-green text-sm font-bold">
                            <span>✅</span>
                            <span>Conversion Complete</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap" id="stats-chips">
                            @foreach([
                            ['stat-words', 'Words'],
                            ['stat-chars', 'Chars'],
                            ['stat-tables', 'Tables'],
                            ['stat-images', 'Images'],
                            ['stat-headings','Headings'],
                            ] as [$sid, $slabel])
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-fn-surface2 border border-fn-text/8 rounded-lg text-xs">
                                <span class="text-fn-text3">{{ $slabel }}</span>
                                <span class="font-bold text-fn-text" id="{{ $sid }}">—</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="ml-auto flex items-center gap-2">
                            <button type="button" id="btn-copy"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                                <span id="copy-label">Copy</span>
                            </button>
                            <a id="btn-download" href="#" download="document.md"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-green/10 border border-fn-green/25 text-fn-green text-xs font-semibold rounded-lg hover:bg-fn-green/20 transition-all">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download .md
                            </a>
                        </div>
                    </div>

                    {{-- View toggle --}}
                    <div
                        class="flex items-center gap-1 p-1 bg-fn-surface2 border border-fn-text/8 rounded-xl mb-3 w-fit">
                        <button type="button" id="view-preview"
                            class="view-btn active flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Rendered
                        </button>
                        <button type="button" id="view-source"
                            class="view-btn flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6" />
                                <polyline points="8 6 2 12 8 18" />
                            </svg>
                            Source
                        </button>
                    </div>

                    {{-- Rendered preview --}}
                    <div id="preview-wrap"
                        class="bg-fn-surface2 border border-fn-text/8 rounded-xl p-6 max-h-[500px] overflow-auto">
                        <div id="md-preview" class="md-body"></div>
                    </div>

                    {{-- Source view --}}
                    <div id="source-wrap" class="hidden relative">
                        <pre id="md-source"
                            class="bg-fn-surface2 border border-fn-text/8 rounded-xl p-5 text-xs font-mono text-fn-text2 leading-relaxed overflow-auto max-h-[500px] whitespace-pre-wrap break-words cursor-text"></pre>
                    </div>

                    {{-- Headings outline (collapsible) --}}
                    <div id="headings-wrap" class="hidden mt-4">
                        <button type="button" id="btn-toggle-headings"
                            class="flex items-center gap-2 text-sm font-semibold text-fn-text2 hover:text-fn-blue-l transition-colors">
                            <svg id="hd-chev" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"
                                class="transition-transform">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                            Document Outline
                            <span class="text-xs text-fn-text3 font-normal" id="headings-count">0 headings</span>
                        </button>
                        <div id="headings-list"
                            class="hidden mt-3 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl"></div>
                    </div>

                    <div class="mt-5 flex items-center justify-center gap-3 flex-wrap">
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
            ['What is Markdown used for?','Markdown is a lightweight text format used by GitHub READMEs, static site
            generators (Jekyll, Hugo, Next.js), documentation tools, note-taking apps (Obsidian, Notion), and most
            developer tooling. It\'s easy to read as plain text and renders cleanly as formatted HTML.'],
            ['What elements are preserved?','Headings (H1–H6), bold, italic, lists, tables, code blocks, blockquotes,
            links, and optional image placeholders. Fonts, colors, and page layout are not preserved since Markdown is a
            plain-text format.'],
            ['ATX vs Setext headings — which should I choose?','ATX (default) uses # symbols and supports all 6 heading
            levels — this is what most tools expect. Setext uses === or --- underlines but only supports H1 and H2. Pick
            ATX unless you have a specific need for Setext.'],
            ['Will my tables be preserved?','Yes — tables are converted to Markdown table syntax with | pipes and header
            separator rows. You can turn this off with the "Convert tables" option if you prefer paragraph text
            instead.'],
            ['Is my file safe and private?','All uploads use AES-256 encryption in transit and are permanently deleted
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

<x-tools-content :tool="$tool" />

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ STYLES ══ --}}
<style>
    .heading-btn,
    .code-btn,
    .view-btn {
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
        color: var(--fn-text3);
    }

    .heading-btn.active,
    .code-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .view-btn.active {
        background: var(--fn-surface);
        color: var(--fn-text);
        box-shadow: 0 1px 4px oklch(0% 0 0 / 12%);
        border-color: transparent;
    }

    .heading-btn:not(.active):hover,
    .code-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
    }

    details summary::-webkit-details-marker {
        display: none;
    }

    details[open] #adv-chev {
        transform: rotate(90deg);
    }

    /* Markdown preview styling */
    .md-body {
        color: var(--fn-text);
        font-size: 14px;
        line-height: 1.7;
    }

    .md-body h1,
    .md-body h2,
    .md-body h3,
    .md-body h4,
    .md-body h5,
    .md-body h6 {
        color: var(--fn-text);
        font-weight: 700;
        margin: 24px 0 10px;
        line-height: 1.3;
    }

    .md-body h1 {
        font-size: 28px;
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        padding-bottom: 8px;
    }

    .md-body h2 {
        font-size: 22px;
        border-bottom: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        padding-bottom: 6px;
    }

    .md-body h3 {
        font-size: 18px;
    }

    .md-body h4 {
        font-size: 16px;
    }

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
        margin: 0 0 14px;
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

    .md-body a:hover {
        color: var(--fn-text);
    }

    .md-body ul,
    .md-body ol {
        margin: 0 0 14px;
        padding-left: 24px;
    }

    .md-body li {
        margin-bottom: 4px;
    }

    .md-body blockquote {
        margin: 0 0 14px;
        padding: 8px 16px;
        border-left: 3px solid oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 5%);
        color: var(--fn-text2);
    }

    .md-body blockquote p:last-child {
        margin-bottom: 0;
    }

    .md-body code {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 8%);
        color: var(--fn-text);
        padding: 1px 6px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 12px;
    }

    .md-body pre {
        background: var(--fn-surface);
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        border-radius: 8px;
        padding: 12px 16px;
        overflow-x: auto;
        margin: 0 0 14px;
    }

    .md-body pre code {
        background: transparent;
        padding: 0;
        font-size: 12px;
        line-height: 1.6;
    }

    .md-body table {
        border-collapse: collapse;
        width: 100%;
        margin: 0 0 14px;
        font-size: 13px;
    }

    .md-body th,
    .md-body td {
        border: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        padding: 6px 10px;
        text-align: left;
    }

    .md-body th {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 4%);
        font-weight: 700;
    }

    .md-body tr:hover td {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 3%);
    }

    .md-body hr {
        border: none;
        border-top: 1px solid oklch(var(--fn-text-l, 80%) 0 0 / 12%);
        margin: 20px 0;
    }

    .md-body img {
        max-width: 100%;
        border-radius: 6px;
    }

    /* Headings outline list */
    .heading-item {
        display: flex;
        align-items: baseline;
        gap: 8px;
        padding: 4px 6px;
        border-radius: 6px;
        font-size: 12px;
        color: var(--fn-text2);
        transition: background .15s;
        cursor: default;
    }

    .heading-item:hover {
        background: oklch(var(--fn-text-l, 80%) 0 0 / 4%);
    }

    .heading-item .h-level {
        font-size: 10px;
        font-weight: 700;
        color: var(--fn-blue-l);
        background: oklch(49% 0.24 264 / 8%);
        padding: 1px 5px;
        border-radius: 4px;
        flex-shrink: 0;
        font-family: monospace;
    }
</style>

@push('footer')
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

  let selectedFile    = null;
  let blobUrl         = null;
  let activeHeading   = 'atx';
  let activeCode      = 'fenced';
  let markdownSource  = '';

  // ── Heading / code style buttons ──
  document.querySelectorAll('.heading-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.heading-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeHeading = btn.dataset.val;
    });
  });
  document.querySelectorAll('.code-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.code-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeCode = btn.dataset.val;
    });
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

  function handleFile(file) {
    hideError();
    const name = file.name.toLowerCase();
    if (!name.match(/\.docx?$/) && !['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(file.type)) {
      showError('Please select a valid Word document (.docx or .doc).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    const ext = name.endsWith('.docx') ? 'DOCX' : 'DOC';
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · Word ' + ext;
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
    scrollToCard();

    const fd = new FormData();
    fd.append('file',              selectedFile);
    fd.append('include_toc',       document.getElementById('opt-toc').checked);
    fd.append('include_tables',    document.getElementById('opt-tables').checked);
    fd.append('include_images',    document.getElementById('opt-images').checked);
    fd.append('preserve_emphasis', document.getElementById('opt-emphasis').checked);
    fd.append('heading_style',     activeHeading);
    fd.append('code_block_style',  activeCode);
    fd.append('output',            'json');

    // Animate
    setProcessStep('proc-1', 'active');
    animateProgress(0, 25, 500, 'Uploading Word document…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(25, 55, 700, 'Reading paragraphs & headings…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(55, 80, 700, 'Converting styles to Markdown…');
    }, 1400);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(80, 92, 500, 'Building final output…');
    }, 2200);

    try {
      const res = await fetch('https://api.filenewer.com/api/tools/word-to-markdown', {
        method: 'POST',
        body: fd,
      });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch (_) {}
        throw new Error(msg);
      }

      const data = await res.json();
      markdownSource = data.markdown ?? '';

      renderResult(data);

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

  // ── Render result ──
  function renderResult(data) {
    const md       = data.markdown ?? '';
    const headings = data.headings ?? [];

    // Stats
    document.getElementById('stat-words').textContent    = (data.word_count ?? 0).toLocaleString();
    document.getElementById('stat-chars').textContent    = (data.char_count ?? 0).toLocaleString();
    document.getElementById('stat-tables').textContent   = data.table_count ?? 0;
    document.getElementById('stat-images').textContent   = data.image_count ?? 0;
    document.getElementById('stat-headings').textContent = headings.length;

    // Rendered preview — defer so the UI can paint "Converting done" first
    const previewEl = document.getElementById('md-preview');
    previewEl.innerHTML = '<p style="color:var(--fn-text3);text-align:center;padding:20px;">Rendering preview…</p>';
    setTimeout(() => {
      try {
        previewEl.innerHTML = mdToHtml(md);
      } catch (e) {
        console.error('Preview render failed:', e);
        previewEl.innerHTML = '<p style="color:var(--fn-red);text-align:center;padding:20px;">Preview could not render — use the Source view instead.</p>';
      }
    }, 50);

    // Source
    document.getElementById('md-source').textContent = md;

    // Download link
    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = URL.createObjectURL(new Blob([md], { type: 'text/markdown;charset=utf-8;' }));
    const outName = (selectedFile?.name || 'document').replace(/\.docx?$/i, '') + '.md';
    const dl = document.getElementById('btn-download');
    dl.href = blobUrl;
    dl.download = outName;

    // Copy button
    document.getElementById('btn-copy').onclick = async () => {
      try {
        await navigator.clipboard.writeText(md);
        document.getElementById('copy-label').textContent = 'Copied!';
        setTimeout(() => { document.getElementById('copy-label').textContent = 'Copy'; }, 2000);
      } catch(_) {}
    };

    // Headings outline
    const wrap = document.getElementById('headings-wrap');
    if (headings.length > 0) {
      const list = document.getElementById('headings-list');
      list.innerHTML = '';
      headings.forEach(h => {
        const item = document.createElement('div');
        item.className = 'heading-item';
        item.style.paddingLeft = (6 + (h.level - 1) * 16) + 'px';
        item.innerHTML = `<span class="h-level">H${h.level}</span><span class="h-text"></span>`;
        item.querySelector('.h-text').textContent = h.text;
        list.appendChild(item);
      });
      document.getElementById('headings-count').textContent = headings.length + ' heading' + (headings.length !== 1 ? 's' : '');
      wrap.classList.remove('hidden');
    } else {
      wrap.classList.add('hidden');
    }
  }

  // ── View toggle ──
  document.getElementById('view-preview').addEventListener('click', () => setView('preview'));
  document.getElementById('view-source').addEventListener('click',  () => setView('source'));

  function setView(v) {
    document.getElementById('view-preview').classList.toggle('active', v === 'preview');
    document.getElementById('view-source').classList.toggle('active',  v === 'source');
    document.getElementById('preview-wrap').classList.toggle('hidden', v !== 'preview');
    document.getElementById('source-wrap').classList.toggle('hidden',  v !== 'source');
  }

  // ── Headings toggle ──
  document.getElementById('btn-toggle-headings').addEventListener('click', () => {
    const list = document.getElementById('headings-list');
    const chev = document.getElementById('hd-chev');
    const isOpen = !list.classList.contains('hidden');
    if (isOpen) {
      list.classList.add('hidden');
      chev.style.transform = '';
    } else {
      list.classList.remove('hidden');
      chev.style.transform = 'rotate(180deg)';
    }
  });

  // ── Markdown → HTML renderer (uses marked.js if available) ──
  function mdToHtml(md) {
    if (!md) return '<p style="color:var(--fn-text3);text-align:center;">No content</p>';

    // If marked.js is available, use it (much faster + safer for huge docs)
    if (typeof marked !== 'undefined') {
      try {
        marked.setOptions({
          gfm: true,
          breaks: false,
          headerIds: false,
          mangle: false,
        });
        return marked.parse(md);
      } catch (e) {
        console.warn('marked.js failed, falling back to plain text:', e);
      }
    }

    // Fallback: escape and show as preformatted text (no regex — won't freeze)
    const esc = md.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    return '<pre style="white-space:pre-wrap;font-family:inherit;font-size:14px;line-height:1.7;">' + esc + '</pre>';
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
    document.getElementById('opt-toc').checked       = false;
    document.getElementById('opt-tables').checked    = true;
    document.getElementById('opt-images').checked    = false;
    document.getElementById('opt-emphasis').checked  = true;
    document.querySelectorAll('.heading-btn').forEach(b => b.classList.toggle('active', b.dataset.val === 'atx'));
    document.querySelectorAll('.code-btn').forEach(b => b.classList.toggle('active', b.dataset.val === 'fenced'));
    activeHeading = 'atx';
    activeCode    = 'fenced';
    markdownSource = '';
    setView('preview');
    document.getElementById('md-preview').innerHTML = '';
    document.getElementById('md-source').textContent = '';
    document.getElementById('headings-wrap').classList.add('hidden');
    document.getElementById('headings-list').classList.add('hidden');
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
