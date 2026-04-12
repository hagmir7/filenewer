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
                @php $ocrSteps = [['1','Upload PDF'],['2','Extracting'],['3','Result']]; @endphp
                @foreach($ocrSteps as [$n,$label])
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
                        <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports digital and scanned PDFs · or click to browse</p>
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

                    {{-- File preview --}}
                    <div id="file-preview"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-2xl shrink-0">
                            📕</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="file-name">document.pdf</p>
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
                    <div class="mt-5 grid sm:grid-cols-3 gap-3">

                        {{-- DPI --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-sm font-semibold text-fn-text2 block mb-2">
                                DPI — <span id="dpi-val" class="text-fn-blue-l">300</span>
                                <span class="font-normal text-fn-text3 ml-1" id="dpi-hint">(Recommended)</span>
                            </label>
                            <input type="range" id="opt-dpi" min="72" max="600" value="300" step="1"
                                class="w-full accent-fn-blue cursor-pointer" />
                            <div class="flex justify-between text-fn-text3 text-sm mt-1">
                                <span>72 Fast</span><span>300</span><span>600 Best</span>
                            </div>
                        </div>

                        {{-- Pages --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label for="opt-pages" class="text-sm font-semibold text-fn-text2 block mb-2">
                                Pages <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                            </label>
                            <input type="text" id="opt-pages" placeholder="e.g. 1,2,3 or blank for all"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <p class="text-fn-text3 text-sm mt-1.5">Leave blank to extract all pages</p>
                        </div>

                        {{-- Output --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-sm font-semibold text-fn-text2 block mb-2">Output</label>
                            <div class="flex flex-col gap-2">
                                @php $ocrOutputs = [['json','Preview text inline'],['file','Download .txt file']];
                                @endphp
                                @foreach($ocrOutputs as [$oval,$olabel])
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="ocr-output" value="{{ $oval }}" {{ $oval==='json'
                                        ? 'checked' : '' }} class="accent-fn-blue" />
                                    <span class="text-sm text-fn-text2 font-semibold">{{ $olabel }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Error banner --}}
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

                    {{-- Extract button --}}
                    <button id="extract-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Extract Text
                    </button>

                </div>{{-- /state-upload --}}

                {{-- ── STATE: Extracting ── --}}
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
                            class="w-16 h-16 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-3xl">
                            🔍</div>
                    </div>
                    <h2 class="text-xl font-bold mb-2">Extracting text…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Processing each page — scanned pages may take a moment</p>
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
                        @php $ocrProcSteps = [
                        ['proc-1','Uploading & reading PDF'],
                        ['proc-2','Detecting text vs scanned pages'],
                        ['proc-3','Extracting & preprocessing text'],
                        ['proc-4','Assembling full text output'],
                        ]; @endphp
                        @foreach($ocrProcSteps as [$pid,$plabel])
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
                <div id="state-result" class="hidden">

                    {{-- Stats bar --}}
                    <div class="flex flex-wrap gap-2 mb-5" id="ocr-stats-bar">
                        @php
                        $ocrStatChips = [
                        ['stat-pages', 'Pages'],
                        ['stat-words', 'Words'],
                        ['stat-chars', 'Characters'],
                        ['stat-dpi', 'DPI'],
                        ];
                        @endphp
                        @foreach($ocrStatChips as [$sid,$slabel])
                        <div
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface2 border border-fn-text/8 rounded-lg">
                            <span class="text-sm text-fn-text3">{{ $slabel }}:</span>
                            <span class="text-sm font-bold text-fn-text2" id="{{ $sid }}">—</span>
                        </div>
                        @endforeach
                        {{-- Method badges --}}
                        <div id="method-badges" class="flex gap-1.5 flex-wrap"></div>
                    </div>

                    {{-- Page tabs + text area --}}
                    <div id="preview-section">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2 flex-wrap" id="page-tabs"></div>
                            <div class="flex gap-2 shrink-0">
                                <button type="button" id="btn-copy-text"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" />
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                    </svg>
                                    <span id="copy-label">Copy</span>
                                </button>
                                <a id="btn-download-txt" href="#" download="extracted.txt"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-green/10 border border-fn-green/25 text-fn-green text-sm font-semibold rounded-lg transition-all hover:bg-fn-green/20">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    Download .txt
                                </a>
                            </div>
                        </div>

                        <textarea id="ocr-output" rows="18" readonly spellcheck="false"
                            class="w-full bg-fn-surface2 border border-fn-text/8 text-fn-text text-sm font-mono rounded-xl px-5 py-4 focus:outline-none resize-none leading-relaxed cursor-default"></textarea>

                        {{-- Empty page notice --}}
                        <div id="empty-page-notice" class="hidden mt-2 flex items-center gap-2 text-sm text-fn-text3">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            No text detected on this page — it may be blank or contain only images.
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-6 flex items-center justify-between flex-wrap gap-3">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Extract another PDF
                        </button>
                        <a href="/tools"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            All tools
                        </a>
                    </div>

                    <p class="mt-5 text-fn-text3 text-sm flex items-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your file is encrypted and permanently deleted within 1 hour.
                    </p>

                </div>{{-- /state-result --}}

                {{-- Download-only result (output=file) --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Text Extracted!</h2>
                    <p class="text-fn-text2 text-sm mb-8" id="dl-subtitle">Your text file is ready.</p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            📄</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">extracted.txt</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Text File</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="extracted.txt"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download .txt File
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetConverter()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Extract another
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
            $ocrFaqs = [
            ['What types of PDF does this work on?', 'Both digital PDFs (with embedded selectable text) and scanned PDFs
            (image-based pages). Digital pages are extracted instantly with perfect accuracy. Scanned pages are rendered
            to high-resolution images, preprocessed for contrast and sharpness, and then text is extracted.'],
            ['What DPI should I use?', '300 DPI is the recommended setting for most scanned PDFs. Use 400–600 DPI for
            very small or dense text. Lower DPI (72–150) is faster but may reduce accuracy on scanned pages. Digital
            PDFs are not affected by DPI.'],
            ['What does the method badge mean?', 'Each page shows either "Digital" or "Image". Digital means text was
            extracted directly from the PDF — fast and perfectly accurate. Image means the page was rendered and OCR was
            applied — used for scanned or image-based pages.'],
            ['Can I extract specific pages only?', 'Yes — enter comma-separated page numbers in the Pages field (e.g.
            1,3,5). Leave blank to extract all pages.'],
            ['Can I download the extracted text?', 'Yes — choose "Download .txt file" in the Output options before
            extracting, or use the Download .txt button that appears alongside the inline preview.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share or store your content.'],
            ];
            @endphp
            @foreach($ocrFaqs as [$q,$a])
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
@push('styles')
    <style>
        .page-tab {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/10%);
            background: var(--fn-surface);
            color: var(--fn-text3);
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }

        .page-tab.active {
            background: oklch(49% 0.24 264/10%);
            border-color: oklch(49% 0.24 264/35%);
            color: var(--fn-blue-l);
        }

        .page-tab:not(.active):hover {
            border-color: oklch(49% 0.24 264/20%);
            color: var(--fn-text);
        }

        .method-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            border: 1px solid;
        }

        .method-badge.digital {
            background: oklch(67% 0.18 162/12%);
            border-color: oklch(67% 0.18 162/30%);
            color: oklch(67% 0.18 162);
        }

        .method-badge.image {
            background: oklch(75% 0.15 55/12%);
            border-color: oklch(75% 0.15 55/30%);
            color: oklch(65% 0.15 55);
        }
    </style>
@endpush

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      let selectedFile = null;
      let blobUrl      = null;
      let ocrPages     = []; // array of page objects from API

      // ── DPI slider ──
      const dpiHints = [[72,100,'Fast'],[101,199,'Draft'],[200,250,'Good'],[251,350,'Recommended'],[351,450,'High'],[451,600,'Maximum']];
      document.getElementById('opt-dpi').addEventListener('input', e => {
        const v = +e.target.value;
        document.getElementById('dpi-val').textContent  = v;
        const hint = dpiHints.find(([lo,hi]) => v >= lo && v <= hi);
        document.getElementById('dpi-hint').textContent = hint ? `(${hint[2]})` : '';
      });

      // ── Drop zone ──
      const dropZone   = document.getElementById('drop-zone');
      const fileInput  = document.getElementById('file-input');
      const filePreview = document.getElementById('file-preview');

      ['dragenter','dragover'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); });
      });
      ['dragleave','dragend','drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); });
      });
      dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });
      fileInput.addEventListener('change', e => { if (e.target.files[0]) handleFile(e.target.files[0]); });
      document.getElementById('remove-file').addEventListener('click', e => {
        e.stopPropagation();
        selectedFile    = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
        dropZone.classList.remove('has-file');
        document.getElementById('extract-btn').disabled = true;
        hideError();
      });

      function handleFile(file) {
        hideError();
        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
          showError('Please select a valid PDF file.');
          return;
        }
        if (file.size > 50 * 1024 * 1024) { showError('File exceeds the 50MB free limit.'); return; }
        selectedFile = file;
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · PDF Document';
        filePreview.classList.remove('hidden');
        filePreview.classList.add('flex');
        dropZone.classList.add('has-file');
        document.getElementById('extract-btn').disabled = false;
      }

      // ── Extract ──
      document.getElementById('extract-btn').addEventListener('click', startExtraction);

      async function startExtraction() {
        if (!selectedFile) return;
        hideError();

        const outputMode = document.querySelector('input[name="ocr-output"]:checked').value;
        const dpi        = document.getElementById('opt-dpi').value;
        const pages      = document.getElementById('opt-pages').value.trim();

        showState('converting');
        updateStepIndicator(2);

        const fd = new FormData();
        fd.append('file',   selectedFile);
        fd.append('output', outputMode);
        fd.append('dpi',    dpi);
        if (pages) fd.append('pages', pages);

        setProcessStep('proc-1','active');
        animateProgress(0, 20, 700, 'Uploading & reading PDF…');

        const t2 = setTimeout(() => {
          setProcessStep('proc-1','done'); setProcessStep('proc-2','active');
          animateProgress(20, 50, 1000, 'Detecting text vs scanned pages…');
        }, 800);
        const t3 = setTimeout(() => {
          setProcessStep('proc-2','done'); setProcessStep('proc-3','active');
          animateProgress(50, 78, 1200, 'Extracting & preprocessing text…');
        }, 1900);
        const t4 = setTimeout(() => {
          setProcessStep('proc-3','done'); setProcessStep('proc-4','active');
          animateProgress(78, 90, 700, 'Assembling full text output…');
        }, 3300);

        try {
          const res = await fetch('https://api.filenewer.com/api/tools/ocr-pdf', {
            method: 'POST',
            body:   fd,
          });

          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

          if (!res.ok) {
            const d = await res.json().catch(() => ({}));
            throw new Error(d.error || 'OCR failed. Please try again.');
          }

          setProcessStep('proc-3','done'); setProcessStep('proc-4','done');
          animateProgress(90, 100, 300, 'Done!');

          if (outputMode === 'file') {
            // Binary .txt download
            const blob     = await res.blob();
            const fileName = selectedFile.name.replace(/\.pdf$/i, '_extracted.txt');
            if (blobUrl) URL.revokeObjectURL(blobUrl);
            blobUrl = URL.createObjectURL(blob);

            document.getElementById('download-link').href     = blobUrl;
            document.getElementById('download-link').download = fileName;
            document.getElementById('output-name').textContent = fileName;
            document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · Text File';
            document.getElementById('dl-subtitle').textContent =
              `Text extracted from ${selectedFile.name}`;

            setTimeout(() => { showState('download'); updateStepIndicator(3); }, 500);

          } else {
            // JSON response — show inline preview
            const data = await res.json();
            ocrPages = data.pages ?? [];

            // Stats
            document.getElementById('stat-pages').textContent = data.total_pages ?? ocrPages.length;
            document.getElementById('stat-words').textContent = (data.word_count ?? 0).toLocaleString();
            document.getElementById('stat-chars').textContent = (data.char_count ?? 0).toLocaleString();
            document.getElementById('stat-dpi').textContent   = (data.dpi ?? dpi) + ' DPI';

            // Method badges
            const hasDigital = ocrPages.some(p => p.method === 'digital');
            const hasImage   = ocrPages.some(p => p.method === 'image');
            const badgesEl   = document.getElementById('method-badges');
            badgesEl.innerHTML = '';
            if (hasDigital) badgesEl.innerHTML += `<span class="method-badge digital">✓ Digital</span>`;
            if (hasImage)   badgesEl.innerHTML += `<span class="method-badge image">⚙ Image OCR</span>`;

            // Build page tabs
            const tabsEl = document.getElementById('page-tabs');
            tabsEl.innerHTML = '';
            // "All" tab
            const allTab = document.createElement('button');
            allTab.type = 'button';
            allTab.className = 'page-tab active';
            allTab.textContent = 'All pages';
            allTab.addEventListener('click', () => showPageText(-1, data.full_text, allTab));
            tabsEl.appendChild(allTab);

            ocrPages.forEach((page, idx) => {
              const tab = document.createElement('button');
              tab.type = 'button';
              tab.className = 'page-tab';
              tab.textContent = `P${page.page}`;
              tab.title = `Page ${page.page} · ${page.word_count ?? 0} words · ${page.method}`;
              tab.addEventListener('click', () => showPageText(idx, page.text, tab));
              tabsEl.appendChild(tab);
            });

            // Show full text initially
            const outputTA = document.getElementById('ocr-output');
            outputTA.value = data.full_text ?? '';
            document.getElementById('empty-page-notice').classList.add('hidden');

            // Wire download btn
            const txtBlob = new Blob([data.full_text ?? ''], { type: 'text/plain;charset=utf-8;' });
            if (blobUrl) URL.revokeObjectURL(blobUrl);
            blobUrl = URL.createObjectURL(txtBlob);
            const dlBtn   = document.getElementById('btn-download-txt');
            dlBtn.href     = blobUrl;
            dlBtn.download = selectedFile.name.replace(/\.pdf$/i, '_extracted.txt');

            setTimeout(() => { showState('result'); updateStepIndicator(3); }, 500);
          }

        } catch(err) {
          clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
          showState('upload');
          updateStepIndicator(1);
          showError(err.message || 'Something went wrong. Please try again.');
        }
      }

      function showPageText(idx, text, clickedTab) {
        document.querySelectorAll('.page-tab').forEach(t => t.classList.remove('active'));
        clickedTab.classList.add('active');
        document.getElementById('ocr-output').value = text ?? '';
        const isEmpty = !text || text.trim() === '';
        document.getElementById('empty-page-notice').classList.toggle('hidden', !isEmpty || idx === -1);

        // Update download blob to current page text if single page
        if (idx >= 0 && blobUrl) {
          URL.revokeObjectURL(blobUrl);
          blobUrl = URL.createObjectURL(new Blob([text ?? ''], { type: 'text/plain;charset=utf-8;' }));
          document.getElementById('btn-download-txt').href = blobUrl;
        }
      }

      // ── Copy ──
      document.getElementById('btn-copy-text').addEventListener('click', async () => {
        try {
          await navigator.clipboard.writeText(document.getElementById('ocr-output').value);
          const label = document.getElementById('copy-label');
          label.textContent = 'Copied!';
          setTimeout(() => { label.textContent = 'Copy'; }, 2000);
        } catch(_) {}
      });

      // ── Helpers ──
      function showState(state) {
        ['upload','converting','result','download'].forEach(s => {
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
          dot.style.background  = 'oklch(49% 0.24 264/15%)';
        }
        if (state === 'done') {
          check.classList.remove('hidden');
          dot.style.borderColor = 'oklch(67% 0.18 162)';
          dot.style.background  = 'oklch(67% 0.18 162/15%)';
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

      function showError(msg) {
        document.getElementById('error-text').textContent = msg;
        const el = document.getElementById('upload-error');
        el.classList.remove('hidden'); el.classList.add('flex');
      }
      function hideError() {
        const el = document.getElementById('upload-error');
        el.classList.add('hidden'); el.classList.remove('flex');
      }
      function formatBytes(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
      }

      window.resetConverter = function () {
        if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
        selectedFile    = null;
        fileInput.value = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
        dropZone.classList.remove('has-file');
        document.getElementById('extract-btn').disabled = true;
        document.getElementById('opt-dpi').value   = '300';
        document.getElementById('dpi-val').textContent = '300';
        document.getElementById('dpi-hint').textContent = '(Recommended)';
        document.getElementById('opt-pages').value = '';
        document.querySelector('input[name="ocr-output"][value="json"]').checked = true;
        document.getElementById('ocr-output').value = '';
        document.getElementById('page-tabs').innerHTML = '';
        document.getElementById('method-badges').innerHTML = '';
        ocrPages = [];
        hideError();
        showState('upload');
        updateStepIndicator(1);
        animateProgress(0, 0, 0, 'Starting…');
        ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
      };

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
