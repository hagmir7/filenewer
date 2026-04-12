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
            ['1', 'Upload Text'],
            ['2', 'Converting'],
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
                                class="w-20 h-20 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-4xl">
                                📝</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your text file here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .txt files &middot; or click to browse</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose Text File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 200MB free</p>
                        <input type="file" id="file-input" accept=".txt,text/plain"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-green/12 border border-fn-green/20 flex items-center justify-center text-2xl shrink-0">
                            📝</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.txt</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="file-meta">&mdash; &middot; Text File</p>
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

                        {{-- Row 1: Document Title + Font --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Document Title --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-title" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Document Title
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-title" placeholder="e.g. My Report"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Adds a title heading at the top of the document.
                                </p>
                            </div>

                            {{-- Font --}}
                            @php
                            $fontOptions = [
                            ['Calibri', 'Calibri'],
                            ['Arial', 'Arial'],
                            ['Times New Roman', 'Times NR'],
                            ['Georgia', 'Georgia'],
                            ['Verdana', 'Verdana'],
                            ['Courier New', 'Courier'],
                            ];
                            @endphp
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Font</label>
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    @foreach($fontOptions as [$fontVal, $fontLabel])
                                    <button type="button"
                                        class="font-btn {{ $fontVal === 'Calibri' ? 'active' : '' }} py-1.5 rounded-lg border text-xs font-semibold transition-all"
                                        data-font="{{ $fontVal }}">
                                        {{ $fontLabel }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Font Size + Line Spacing --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Font Size --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-font-size" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Font Size
                                    <span class="font-normal text-fn-text3 ml-1">(<span
                                            id="font-size-value">11</span>pt)</span>
                                </label>
                                <input type="range" id="opt-font-size" min="6" max="72" value="11"
                                    class="w-full accent-fn-blue cursor-pointer" />
                                <div class="flex justify-between text-fn-text3 text-xs mt-1">
                                    <span>6pt</span>
                                    <span>72pt</span>
                                </div>
                            </div>

                            {{-- Line Spacing --}}
                            @php
                            $spacingOptions = [
                            ['1.0', '1.0'],
                            ['1.15', '1.15'],
                            ['1.5', '1.5'],
                            ['2.0', '2.0'],
                            ];
                            @endphp
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Line Spacing</label>
                                <div class="grid grid-cols-4 gap-2 mb-2">
                                    @foreach($spacingOptions as [$spVal, $spLabel])
                                    <button type="button"
                                        class="spacing-btn {{ $spVal === '1.15' ? 'active' : '' }} py-1.5 rounded-lg border text-sm font-mono font-bold transition-all"
                                        data-spacing="{{ $spVal }}">
                                        {{ $spLabel }}
                                    </button>
                                    @endforeach
                                </div>
                                <p class="text-fn-text3 text-sm" id="spacing-hint">1.15 &mdash; default Word spacing</p>
                            </div>
                        </div>

                        {{-- Row 3: Page Size + Encoding --}}
                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Page Size --}}
                            @php
                            $pageOptions = [
                            ['A4', 'A4'],
                            ['Letter', 'Letter'],
                            ['Legal', 'Legal'],
                            ['A3', 'A3'],
                            ];
                            @endphp
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Page Size</label>
                                <div class="grid grid-cols-4 gap-2 mb-2">
                                    @foreach($pageOptions as [$pgVal, $pgLabel])
                                    <button type="button"
                                        class="page-btn {{ $pgVal === 'A4' ? 'active' : '' }} py-1.5 rounded-lg border text-sm font-semibold transition-all"
                                        data-page="{{ $pgVal }}">
                                        {{ $pgLabel }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Encoding --}}
                            @php
                            $encOptions = [
                            ['utf-8', 'UTF-8'],
                            ['ascii', 'ASCII'],
                            ['latin-1', 'Latin-1'],
                            ];
                            @endphp
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Text Encoding</label>
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    @foreach($encOptions as [$enc, $encLabel])
                                    <button type="button"
                                        class="enc-btn {{ $enc === 'utf-8' ? 'active' : '' }} py-1.5 rounded-lg border text-sm font-mono font-bold transition-all"
                                        data-enc="{{ $enc }}">
                                        {{ $encLabel }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Row 4: Auto-detection toggles --}}
                        <div class="grid sm:grid-cols-3 gap-3">

                            {{-- Detect Headings --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Detect Headings</label>
                                <label class="toggle-label flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="opt-detect-headings" checked
                                        class="w-4 h-4 rounded border-fn-text/20 accent-fn-blue cursor-pointer" />
                                    <span class="text-sm text-fn-text2">Auto-detect #, ===, ALL CAPS</span>
                                </label>
                            </div>

                            {{-- Detect Lists --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Detect Lists</label>
                                <label class="toggle-label flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="opt-detect-lists" checked
                                        class="w-4 h-4 rounded border-fn-text/20 accent-fn-blue cursor-pointer" />
                                    <span class="text-sm text-fn-text2">Auto-detect -, *, 1. items</span>
                                </label>
                            </div>

                            {{-- Detect Tables --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-sm font-semibold text-fn-text2 block mb-2">Detect Tables</label>
                                <label class="toggle-label flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="opt-detect-tables" checked
                                        class="w-4 h-4 rounded border-fn-text/20 accent-fn-blue cursor-pointer" />
                                    <span class="text-sm text-fn-text2">Auto-detect | pipe tables</span>
                                </label>
                            </div>
                        </div>

                        {{-- Row 5: Output filename --}}
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label for="opt-filename" class="text-sm font-semibold text-fn-text2 block mb-2">
                                    Output Filename
                                    <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                </label>
                                <input type="text" id="opt-filename" placeholder="e.g. report.docx"
                                    class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                <p class="text-fn-text3 text-sm mt-1.5">Defaults to your text filename with .docx</p>
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
                        Convert to Word
                    </button>

                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-green/10 border border-fn-green/20 flex items-center justify-center text-3xl">
                            📝</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div id="conv-output-icon"
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📄</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting your file&hellip;</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 15 seconds</p>

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
                    ['proc-1', 'Uploading & reading text file'],
                    ['proc-2', 'Detecting headings, lists & tables'],
                    ['proc-3', 'Building Word document'],
                    ['proc-4', 'Applying formatting & packaging'],
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
                    <h2 class="text-2xl font-bold mb-2">Conversion Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-8" id="download-subtitle">Your Word document is ready.</p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0"
                            id="output-icon">📄</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">output.docx</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Word Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="output.docx"
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
            200MB files and batch conversion.'],
            ['Will my headings be detected automatically?', 'Yes, the converter auto-detects Markdown-style headings (#,
            ##), underline-style headings (=== and ---), and ALL CAPS lines as headings in your Word document.'],
            ['Does it detect bullet and numbered lists?', 'Yes, lines starting with -, *, +, or numbered patterns like
            1. or 2) are automatically converted to proper Word lists.'],
            ['Can it handle tables in my text file?', 'Yes, pipe-delimited tables (lines starting with |) are detected
            and converted to formatted Word tables automatically.'],
            ['What fonts are available?', 'You can choose from Calibri (default), Arial, Times New Roman, Georgia,
            Verdana, or Courier New. Font size is adjustable from 6pt to 72pt.'],
            ['What page sizes are supported?', 'A4 (default), Letter, Legal, and A3 page sizes are all supported.'],
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

<x-tools-content :tool="$tool" />

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ STYLES ══ --}}
<style>
    .font-btn,
    .spacing-btn,
    .page-btn,
    .enc-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0 / 10%);
        background: var(--fn-surface);
    }

    .font-btn.active,
    .spacing-btn.active,
    .page-btn.active,
    .enc-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264 / 40%);
        background: oklch(49% 0.24 264 / 8%);
    }

    .font-btn:not(.active):hover,
    .spacing-btn:not(.active):hover,
    .page-btn:not(.active):hover,
    .enc-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264 / 25%);
        color: var(--fn-text);
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
      var fontSizeSlider = document.getElementById('opt-font-size');
      var fontSizeValue  = document.getElementById('font-size-value');

      var selectedFile   = null;
      var blobUrl        = null;
      var activeFont     = 'Calibri';
      var activeSpacing  = '1.15';
      var activePage     = 'A4';
      var activeEnc      = 'utf-8';

      // Font size slider
      fontSizeSlider.addEventListener('input', function () {
        fontSizeValue.textContent = fontSizeSlider.value;
      });

      // Font buttons
      document.querySelectorAll('.font-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.font-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          activeFont = btn.dataset.font;
        });
      });

      // Spacing buttons
      var spacingHints = {
        '1.0':  '1.0 \u2014 single spacing, compact',
        '1.15': '1.15 \u2014 default Word spacing',
        '1.5':  '1.5 \u2014 comfortable reading',
        '2.0':  '2.0 \u2014 double spacing, academic'
      };
      document.querySelectorAll('.spacing-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.spacing-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          activeSpacing = btn.dataset.spacing;
          document.getElementById('spacing-hint').textContent = spacingHints[activeSpacing] || '';
        });
      });

      // Page size buttons
      document.querySelectorAll('.page-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.page-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          activePage = btn.dataset.page;
        });
      });

      // Encoding buttons
      document.querySelectorAll('.enc-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.querySelectorAll('.enc-btn').forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');
          activeEnc = btn.dataset.enc;
        });
      });

      // Drag & drop
      ['dragenter', 'dragover'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
      });
      ['dragleave', 'dragend', 'drop'].forEach(function (evt) {
        dropZone.addEventListener(evt, function (e) { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
      });
      dropZone.addEventListener('drop', function (e) { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
      fileInput.addEventListener('change', function (e) { if (e.target.files[0]) handleFile(e.target.files[0]); });
      removeFile.addEventListener('click', function (e) { e.stopPropagation(); resetFile(); });

      var ACCEPTED_EXTS  = ['.txt'];
      var ACCEPTED_TYPES = ['text/plain'];

      function handleFile(file) {
        hideError();
        var ext = file.name.toLowerCase().slice(file.name.lastIndexOf('.'));
        if (ACCEPTED_EXTS.indexOf(ext) === -1 && ACCEPTED_TYPES.indexOf(file.type) === -1) {
          showError('Please select a valid text file (.txt).');
          return;
        }
        if (file.size > 50 * 1024 * 1024) {
          showError('File exceeds the 50MB free limit.');
          return;
        }
        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' \u00b7 Text File';
        var fnInput = document.getElementById('opt-filename');
        if (!fnInput.value) fnInput.value = file.name.replace(/\.txt$/i, '.docx');
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

      convertBtn.addEventListener('click', startConversion);

      async function startConversion() {
        if (!selectedFile) return;

        hideError();
        showState('converting');
        updateStepIndicator(2);

        var title           = document.getElementById('opt-title').value.trim();
        var detectHeadings  = document.getElementById('opt-detect-headings').checked;
        var detectLists     = document.getElementById('opt-detect-lists').checked;
        var detectTables    = document.getElementById('opt-detect-tables').checked;
        var customFilename  = document.getElementById('opt-filename').value.trim();
        var baseName        = selectedFile.name.replace(/\.txt$/i, '');
        var outputFilename  = customFilename
          ? (customFilename.indexOf('.') !== -1 ? customFilename : customFilename + '.docx')
          : baseName + '.docx';

        var formData = new FormData();
        formData.append('file',             selectedFile);
        formData.append('font_name',        activeFont);
        formData.append('font_size',        fontSizeSlider.value);
        formData.append('line_spacing',     activeSpacing);
        formData.append('page_size',        activePage);
        formData.append('encoding',         activeEnc);
        formData.append('detect_headings',  detectHeadings  ? 'true' : 'false');
        formData.append('detect_lists',     detectLists     ? 'true' : 'false');
        formData.append('detect_tables',    detectTables    ? 'true' : 'false');
        if (title) formData.append('title', title);

        // Animate
        setProcessStep('proc-1', 'active');
        animateProgress(0, 20, 700, 'Uploading & reading text file\u2026');

        var t2 = setTimeout(function () {
          setProcessStep('proc-1', 'done');
          setProcessStep('proc-2', 'active');
          animateProgress(20, 50, 900, 'Detecting headings, lists & tables\u2026');
        }, 800);

        var t3 = setTimeout(function () {
          setProcessStep('proc-2', 'done');
          setProcessStep('proc-3', 'active');
          animateProgress(50, 75, 900, 'Building Word document\u2026');
        }, 1800);

        var t4 = setTimeout(function () {
          setProcessStep('proc-3', 'done');
          setProcessStep('proc-4', 'active');
          animateProgress(75, 90, 700, 'Applying formatting & packaging\u2026');
        }, 2900);

        try {
          var res = await fetch('https://api.filenewer.com/api/tools/txt-to-word', {
            method: 'POST',
            body:   formData
          });

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!res.ok) {
            var errMsg = 'Conversion failed. Please try again.';
            try { var d = await res.json(); if (d.error) errMsg = d.error; } catch (_) {}
            throw new Error(errMsg);
          }

          var blob = await res.blob();

          if (blobUrl) URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(blob);

          var link    = document.getElementById('download-link');
          link.href     = blobUrl;
          link.download = outputFilename;

          document.getElementById('output-name').textContent        = outputFilename;
          document.getElementById('output-size').textContent        = formatBytes(blob.size) + ' \u00b7 Word Document';
          document.getElementById('download-btn-label').textContent = 'Download DOCX';
          document.getElementById('download-subtitle').textContent  = 'Your Word document is ready.';

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
        document.getElementById('opt-title').value    = '';
        // Reset font
        document.querySelectorAll('.font-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelector('.font-btn[data-font="Calibri"]').classList.add('active');
        activeFont = 'Calibri';
        // Reset font size
        fontSizeSlider.value = 11;
        fontSizeValue.textContent = '11';
        // Reset spacing
        document.querySelectorAll('.spacing-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelector('.spacing-btn[data-spacing="1.15"]').classList.add('active');
        activeSpacing = '1.15';
        document.getElementById('spacing-hint').textContent = spacingHints['1.15'];
        // Reset page size
        document.querySelectorAll('.page-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelector('.page-btn[data-page="A4"]').classList.add('active');
        activePage = 'A4';
        // Reset encoding
        document.querySelectorAll('.enc-btn').forEach(function (b) { b.classList.remove('active'); });
        document.querySelector('.enc-btn[data-enc="utf-8"]').classList.add('active');
        activeEnc = 'utf-8';
        // Reset detection checkboxes
        document.getElementById('opt-detect-headings').checked = true;
        document.getElementById('opt-detect-lists').checked    = true;
        document.getElementById('opt-detect-tables').checked   = true;
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
