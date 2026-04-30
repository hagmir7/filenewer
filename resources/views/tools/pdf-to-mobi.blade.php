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
                @foreach([['1','Upload PDF'],['2','Converting'],['3','Download']] as [$n, $label])
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
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-amber/40 hover:bg-fn-amber/4 relative">
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
                        <h2 class="text-lg font-bold mb-2">Drop your PDF here</h2>
                        <p class="text-fn-text3 text-sm mb-6">Supports .pdf files — or click to browse</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF File
                        </div>
                        <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                        <input type="file" id="file-input" accept=".pdf,application/pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File preview --}}
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
                            <p class="font-semibold text-sm truncate" id="file-name">book.pdf</p>
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
                            <p class="text-sm font-semibold text-fn-text2">eBook Settings</p>
                            <span class="text-xs text-fn-text3">Optional</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">

                            {{-- Left column --}}
                            <div class="flex flex-col gap-3">

                                <div>
                                    <label for="opt-title" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Book title
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-title" placeholder="My Book"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>

                                <div>
                                    <label for="opt-author" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Author
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-author" placeholder="John Smith"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>

                                <div>
                                    <label for="opt-language"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Language</label>
                                    <select id="opt-language"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="en" selected>English</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="es">Spanish</option>
                                        <option value="it">Italian</option>
                                        <option value="pt">Portuguese</option>
                                        <option value="nl">Dutch</option>
                                        <option value="ar">Arabic</option>
                                        <option value="zh">Chinese</option>
                                        <option value="ja">Japanese</option>
                                        <option value="ru">Russian</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Right column --}}
                            <div class="flex flex-col gap-3">

                                <div>
                                    <label for="opt-password" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        PDF password
                                        <span class="font-normal text-fn-text3 ml-1">(if encrypted)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="opt-password"
                                            placeholder="Leave blank if not protected"
                                            class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 pr-9 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                        <button type="button" id="toggle-password"
                                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-fn-text3 hover:text-fn-text transition-colors">
                                            <svg id="eye-show" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                            <svg id="eye-hide" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="hidden">
                                                <path
                                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                                <line x1="1" y1="1" x2="23" y2="23" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Output format --}}
                                <div>
                                    <label class="text-xs font-semibold text-fn-text2 block mb-1.5">Output
                                        format</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label id="fmt-mobi-wrap"
                                            class="fmt-btn active flex flex-col items-center gap-1.5 px-3 py-2.5 border rounded-lg cursor-pointer transition-all text-center">
                                            <input type="radio" name="output_format" value="mobi" id="fmt-mobi" checked
                                                class="sr-only" />
                                            <span class="text-lg">📱</span>
                                            <span class="text-xs font-bold">.mobi</span>
                                            <span class="text-xs text-fn-text3 leading-tight">Kindle · ⭐⭐⭐⭐⭐</span>
                                        </label>
                                        <label id="fmt-epub-wrap"
                                            class="fmt-btn flex flex-col items-center gap-1.5 px-3 py-2.5 border rounded-lg cursor-pointer transition-all text-center">
                                            <input type="radio" name="output_format" value="epub" id="fmt-epub"
                                                class="sr-only" />
                                            <span class="text-lg">📖</span>
                                            <span class="text-xs font-bold">.epub</span>
                                            <span class="text-xs text-fn-text3 leading-tight">Universal · ⭐⭐⭐</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-fn-text3 mt-1.5" id="fmt-hint">.mobi uses Calibre for the
                                        best Kindle quality</p>
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
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10" />
                            <path d="M16 8l4-4m0 0h-4m4 0v4" />
                        </svg>
                        <span id="convert-btn-label">Convert to MOBI</span>
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
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
                            class="w-16 h-16 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-3xl">
                            📱</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2" id="converting-title">Converting PDF to MOBI…</h2>
                    <p class="text-fn-text3 text-sm mb-8" id="converting-subtitle">Running Calibre — extracting text
                        &amp; building eBook structure</p>

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
                        ['proc-1','Reading PDF content'],
                        ['proc-2','Extracting text & structure'],
                        ['proc-3','Applying eBook metadata'],
                        ['proc-4','Building MOBI file'],
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
                    <h2 class="text-2xl font-bold mb-2">Conversion Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-6" id="download-subtitle">Your eBook is ready — open it in Kindle
                        or any compatible reader.</p>

                    {{-- Result metadata chips --}}
                    <div id="result-info-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">Conversion details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-chips"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            📱</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">book.mobi</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">Kindle eBook</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="book.mobi"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        <span id="download-btn-label">Download MOBI File</span>
                    </a>

                    {{-- Kindle tip --}}
                    <div id="kindle-tip"
                        class="max-w-sm mx-auto mb-5 p-3 bg-fn-amber/6 border border-fn-amber/20 rounded-xl flex items-start gap-2.5 text-left">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-fn-amber shrink-0 mt-0.5">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <p class="text-xs text-fn-text2 leading-relaxed">To read on Kindle, send this file to your <span
                                class="font-semibold">@kindle.com</span> email address or transfer via USB.</p>
                    </div>

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


{{-- ══ METHOD COMPARISON ══ --}}
<section class="py-12 border-t border-fn-text/7 bg-fn-surface2">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-lg font-bold mb-4 text-center">Output Method Comparison</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="p-5 bg-fn-surface border border-fn-amber/20 rounded-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-lg">
                        📱</div>
                    <div>
                        <p class="font-bold text-sm">.mobi — Calibre</p>
                        <p class="text-xs text-fn-amber font-semibold">⭐⭐⭐⭐⭐ Best quality</p>
                    </div>
                </div>
                <p class="text-xs text-fn-text2 leading-relaxed">Full Kindle-native format via Calibre. Preserves
                    headings, tables, images, and metadata with maximum fidelity. Recommended for all Kindle devices and
                    apps.</p>
            </div>
            <div class="p-5 bg-fn-surface border border-fn-text/8 rounded-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-lg">
                        📖</div>
                    <div>
                        <p class="font-bold text-sm">.epub — Fallback</p>
                        <p class="text-xs text-fn-text3 font-semibold">⭐⭐⭐ Universal</p>
                    </div>
                </div>
                <p class="text-xs text-fn-text2 leading-relaxed">Open standard supported by virtually all eReaders
                    (Apple Books, Kobo, etc.). Use this if you need cross-device compatibility rather than
                    Kindle-specific output.</p>
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
            ['What\'s the difference between .mobi and .epub output?', 'MOBI uses Calibre for conversion and produces a
            native Kindle format with 5-star quality — preserving headings, images, tables, and metadata precisely. EPUB
            is a universal open format readable on Apple Books, Kobo, and most eReaders, but it uses a lighter
            conversion path. Choose MOBI for Kindle, EPUB for everything else.'],
            ['How do I read the MOBI file on my Kindle?', 'You can send the .mobi file to your personal Kindle email
            address (found in your Amazon account settings) and it will appear in your library wirelessly.
            Alternatively, connect your Kindle via USB and copy the file to the "documents" folder.'],
            ['Can I convert a password-protected PDF?', 'Yes. Enter the PDF password in the "PDF password" field before
            converting. The password is used only to unlock the file for conversion and is never stored or logged.'],
            ['What metadata fields are embedded?', 'The title, author, and language fields are written directly into the
            eBook metadata. This means the book title and author name appear correctly in your Kindle library instead of
            a generic filename.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted
            within 1 hour. We never read, share, or store your content. PDF passwords are used only during conversion
            and are not retained.'],
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
    .fmt-btn {
        border-color: var(--fn-text-10, oklch(0% 0 0 / 10%));
        color: var(--fn-text2);
        background: var(--fn-surface);
        transition: all .15s;
    }

    .fmt-btn.active {
        border-color: oklch(62% 0.20 250 / 50%);
        background: oklch(62% 0.20 250 / 6%);
        color: oklch(62% 0.20 250);
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

    .chip-format .chip-dot {
        background: oklch(72% 0.18 55);
    }

    .chip-format {
        color: oklch(72% 0.18 55);
        border-color: oklch(72% 0.18 55 / 30%);
        background: oklch(72% 0.18 55 / 6%);
    }

    .chip-meta .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-meta {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .chip-lang .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-lang {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .chip-lock .chip-dot {
        background: oklch(67% 0.18 162);
    }

    .chip-lock {
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

  // ── Format toggle ──
  document.querySelectorAll('input[name="output_format"]').forEach(radio => {
    radio.addEventListener('change', () => {
      const isMobi = radio.value === 'mobi';
      document.getElementById('fmt-mobi-wrap').classList.toggle('active', isMobi);
      document.getElementById('fmt-epub-wrap').classList.toggle('active', !isMobi);
      document.getElementById('fmt-hint').textContent = isMobi
        ? '.mobi uses Calibre for the best Kindle quality'
        : '.epub is supported on Apple Books, Kobo & more';
      document.getElementById('convert-btn-label').textContent = isMobi ? 'Convert to MOBI' : 'Convert to EPUB';
      document.getElementById('kindle-tip').style.display = isMobi ? '' : 'none';
    });
  });

  // ── Password toggle ──
  document.getElementById('toggle-password').addEventListener('click', () => {
    const inp  = document.getElementById('opt-password');
    const show = document.getElementById('eye-show');
    const hide = document.getElementById('eye-hide');
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    show.classList.toggle('hidden', !isText);
    hide.classList.toggle('hidden', isText);
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

  function handleFile(file) {
    hideError();
    const name = file.name.toLowerCase();
    if (!name.endsWith('.pdf')) {
      showError('Please select a valid PDF file (.pdf).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · PDF Document';
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

    const title    = document.getElementById('opt-title').value.trim();
    const author   = document.getElementById('opt-author').value.trim();
    const language = document.getElementById('opt-language').value;
    const password = document.getElementById('opt-password').value;
    const format   = document.querySelector('input[name="output_format"]:checked').value;
    const isMobi   = format === 'mobi';

    // Update converting state labels
    document.getElementById('converting-title').textContent    = `Converting PDF to ${isMobi ? 'MOBI' : 'EPUB'}…`;
    document.getElementById('converting-subtitle').textContent = isMobi
      ? 'Running Calibre — extracting text & building eBook structure'
      : 'Building EPUB — extracting content & packaging eBook';
    document.querySelector('#proc-4 .proc-label').textContent = `Building ${isMobi ? 'MOBI' : 'EPUB'} file`;

    // Determine output filename
    const baseName = selectedFile.name.replace(/\.pdf$/i, '');
    const outName  = (title ? title.replace(/[^a-z0-9]/gi, '_').toLowerCase() : baseName) + '.' + format;

    const endpoint = `https://api.filenewer.com/api/convert/pdf-to-${format}`;

    const fd = new FormData();
    fd.append('file', selectedFile);
    if (title)    fd.append('title',    title);
    if (author)   fd.append('author',   author);
    if (language) fd.append('language', language);
    if (password) fd.append('password', password);

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 500, 'Reading PDF content…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 50, 900, 'Extracting text & structure…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(50, 75, 700, 'Applying eBook metadata…');
    }, 1600);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(75, 92, 600, `Building ${isMobi ? 'MOBI' : 'EPUB'} file…`);
    }, 2400);

    try {
      const res = await fetch(endpoint, { method: 'POST', body: fd });

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please check your PDF and try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        // Hint for password-protected PDFs
        if (res.status === 400 && !password) msg += ' If this PDF is password-protected, please enter the password.';
        throw new Error(msg);
      }

      const blob = await res.blob();

      // Read response headers for metadata
      const pages  = res.headers.get('X-Pages')   || null;
      const method = res.headers.get('X-Method')  || (isMobi ? 'calibre' : 'epub-fallback');
      const sizeKb = res.headers.get('X-Size-KB') || null;

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent =
        formatBytes(blob.size) + ` · ${isMobi ? 'Kindle MOBI' : 'EPUB eBook'}`;
      document.getElementById('download-btn-label').textContent = `Download ${isMobi ? 'MOBI' : 'EPUB'} File`;
      document.getElementById('download-subtitle').textContent = isMobi
        ? 'Your eBook is ready — open it in Kindle or any compatible reader.'
        : 'Your eBook is ready — open it in Apple Books, Kobo, or any EPUB reader.';
      document.getElementById('kindle-tip').style.display = isMobi ? '' : 'none';

      renderResultChips({ format, title, author, language, password: !!password, pages, method });

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

  function renderResultChips({ format, title, author, language, password, pages, method }) {
    const wrap = document.getElementById('result-info-wrap');
    const list = document.getElementById('result-chips');
    list.innerHTML = '';

    const chips = [
      ['chip-format', 'Format',  '.' + format.toUpperCase()],
      ['chip-lang',   'Method',  method],
      ['chip-lang',   'Language', language.toUpperCase()],
    ];
    if (title)    chips.push(['chip-meta', 'Title',  title]);
    if (author)   chips.push(['chip-meta', 'Author', author]);
    if (pages)    chips.push(['chip-meta', 'Pages',  pages + 'p']);
    if (password) chips.push(['chip-lock', 'Password', 'used']);

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
    document.getElementById('opt-title').value    = '';
    document.getElementById('opt-author').value   = '';
    document.getElementById('opt-language').value = 'en';
    document.getElementById('opt-password').value = '';
    document.getElementById('opt-password').type  = 'password';
    document.getElementById('eye-show').classList.remove('hidden');
    document.getElementById('eye-hide').classList.add('hidden');
    document.getElementById('fmt-mobi').checked   = true;
    document.getElementById('fmt-mobi-wrap').classList.add('active');
    document.getElementById('fmt-epub-wrap').classList.remove('active');
    document.getElementById('fmt-hint').textContent = '.mobi uses Calibre for the best Kindle quality';
    document.getElementById('convert-btn-label').textContent = 'Convert to MOBI';
    document.getElementById('kindle-tip').style.display = '';
    document.getElementById('result-info-wrap').classList.add('hidden');
    showState('upload');
    updateStepIndicator(1);
    animateProgress(0, 0, 0, 'Starting…');
    ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
    document.querySelector('#proc-4 .proc-label').textContent = 'Building MOBI file';
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
