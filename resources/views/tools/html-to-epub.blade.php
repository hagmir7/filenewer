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
                @foreach([['1','Input HTML'],['2','Converting'],['3','Download']] as [$n, $label])
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
                            Paste HTML
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .html
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">HTML source</p>
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

                        <textarea id="html-textarea" rows="12" spellcheck="false"
                            placeholder='<html>&#10;<head><title>My Book</title></head>&#10;<body>&#10;  <h1>Introduction</h1>&#10;  <p>Welcome to my book.</p>&#10;  <h1>Chapter 1</h1>&#10;  <p>Chapter content here.</p>&#10;  <h2>Section 1.1</h2>&#10;  <p>More content...</p>&#10;</body>&#10;</html>'
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>

                        <div class="flex items-center justify-between text-xs mt-1.5">
                            <span id="html-status" class="text-fn-text3">Paste HTML — h1 tags become chapter
                                splits</span>
                            <span id="html-meta" class="text-fn-text3/70">0 chars · 0 lines</span>
                        </div>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-orange/10 border border-fn-orange/20 flex items-center justify-center">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-fn-orange" style="color:oklch(72% 0.19 41)">
                                        <polyline points="16 18 22 12 16 6" />
                                        <polyline points="8 6 2 12 8 18" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your HTML file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .html / .htm files — or click to browse</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose HTML File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input" accept=".html,.htm,text/html"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                                style="background:oklch(72% 0.19 41 / 12%); border: 1px solid oklch(72% 0.19 41 / 20%)">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" style="color:oklch(72% 0.19 41)">
                                    <polyline points="16 18 22 12 16 6" />
                                    <polyline points="8 6 2 12 8 18" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">book.html</p>
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

                        {{-- Cover image upload --}}
                        <div class="mt-4">
                            <label class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                Cover image
                                <span class="font-normal text-fn-text3 ml-1">(optional — .jpg, .png)</span>
                            </label>
                            <div id="cover-drop-zone"
                                class="relative flex items-center gap-3 px-4 py-3 bg-fn-surface2 border border-dashed border-fn-text/15 rounded-xl cursor-pointer hover:border-fn-blue/30 transition-colors">
                                <div id="cover-placeholder" class="flex items-center gap-3 w-full">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-fn-surface border border-fn-text/10 flex items-center justify-center shrink-0 text-fn-text3">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <polyline points="21 15 16 10 5 21" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-fn-text3">Click or drag a cover image here</span>
                                </div>
                                <div id="cover-preview" class="hidden items-center gap-3 w-full">
                                    <img id="cover-thumb" src="" alt="Cover"
                                        class="w-9 h-12 object-cover rounded-lg border border-fn-text/10 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold truncate" id="cover-name">cover.jpg</p>
                                        <p class="text-xs text-fn-text3" id="cover-size">—</p>
                                    </div>
                                    <button type="button" id="remove-cover"
                                        class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="file" id="cover-input" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </div>
                        </div>
                    </div>

                    {{-- Detected structure preview --}}
                    <div id="detected-content"
                        class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-blue/15 rounded-xl">
                        <div class="flex items-center gap-2 mb-3">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-fn-blue-l">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                            </svg>
                            <p class="text-sm font-semibold text-fn-text2">Your EPUB will contain</p>
                        </div>
                        <div class="flex flex-wrap gap-2" id="detected-chips"></div>
                    </div>

                    {{-- Metadata options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">eBook Metadata</p>
                            <span class="text-xs text-fn-text3">Optional — auto-extracted from HTML if omitted</span>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">

                            <div class="flex flex-col gap-3">
                                <div>
                                    <label for="opt-title" class="text-xs font-semibold text-fn-text2 block mb-1.5">Book
                                        title</label>
                                    <input type="text" id="opt-title" placeholder="Auto-extracted from &lt;title&gt;"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>
                                <div>
                                    <label for="opt-author"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Author</label>
                                    <input type="text" id="opt-author"
                                        placeholder="Auto-extracted from &lt;meta name=author&gt;"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>
                                <div>
                                    <label for="opt-publisher"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Publisher</label>
                                    <input type="text" id="opt-publisher" placeholder="My Publisher"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                                </div>
                            </div>

                            <div class="flex flex-col gap-3">
                                <div>
                                    <label for="opt-description"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Description</label>
                                    <textarea id="opt-description" rows="3"
                                        placeholder="Auto-extracted from &lt;meta name=description&gt;"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60 resize-none"></textarea>
                                </div>
                                <div>
                                    <label for="opt-language"
                                        class="text-xs font-semibold text-fn-text2 block mb-1.5">Language</label>
                                    <select id="opt-language"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/40 appearance-none cursor-pointer">
                                        <option value="en" selected>English</option>
                                        <option value="ar">Arabic (عربي)</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="es">Spanish</option>
                                        <option value="it">Italian</option>
                                        <option value="pt">Portuguese</option>
                                        <option value="nl">Dutch</option>
                                        <option value="zh">Chinese</option>
                                        <option value="ja">Japanese</option>
                                        <option value="ru">Russian</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="opt-filename" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                        Output filename
                                        <span class="font-normal text-fn-text3 ml-1">(optional)</span>
                                    </label>
                                    <input type="text" id="opt-filename" placeholder="book.epub"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
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
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                        Convert to EPUB
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center"
                            style="background:oklch(72% 0.19 41 / 10%); border: 1px solid oklch(72% 0.19 41 / 20%)">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" style="color:oklch(72% 0.19 41)">
                                <polyline points="16 18 22 12 16 6" />
                                <polyline points="8 6 2 12 8 18" />
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
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📖</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting HTML to EPUB…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Splitting chapters, embedding assets &amp; packaging eBook</p>

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
                        ['proc-1','Reading HTML content'],
                        ['proc-2','Splitting chapters at &lt;h1&gt;'],
                        ['proc-3','Embedding images &amp; metadata'],
                        ['proc-4','Packaging EPUB archive'],
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
                            <span class="text-sm text-fn-text3">{!! $plabel !!}</span>
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
                    <p class="text-fn-text2 text-sm mb-6">Your EPUB is ready — open it in Apple Books, Kobo, or any EPUB
                        reader.</p>

                    {{-- Result chips --}}
                    <div id="result-info-wrap" class="hidden max-w-2xl mx-auto mb-6">
                        <p class="text-xs font-semibold text-fn-text2 mb-2 text-left">eBook details</p>
                        <div class="flex flex-wrap gap-2 justify-start" id="result-chips"></div>
                    </div>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-blue/12 border border-fn-blue/20 flex items-center justify-center text-2xl shrink-0">
                            📖</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">book.epub</p>
                            <p class="text-fn-text3 text-sm mt-0.5" id="output-size">EPUB eBook</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#" download="book.epub"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download EPUB File
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


{{-- ══ SUPPORTED ELEMENTS ══ --}}
<section class="py-12 border-t border-fn-text/7 bg-fn-surface2">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-lg font-bold mb-1 text-center">Supported HTML Elements</h2>
        <p class="text-fn-text3 text-sm text-center mb-6">All standard HTML elements are preserved in the EPUB output
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
            @foreach([
            ['&lt;h1&gt;', 'Chapter split + heading'],
            ['&lt;h2&gt; – &lt;h6&gt;', 'Section headings'],
            ['&lt;p&gt;', 'Paragraph'],
            ['&lt;strong&gt; / &lt;b&gt;', 'Bold text'],
            ['&lt;em&gt; / &lt;i&gt;', 'Italic text'],
            ['&lt;u&gt;', 'Underline'],
            ['&lt;a href&gt;', 'Hyperlink'],
            ['&lt;img src&gt;', 'Embedded image'],
            ['&lt;img src="data:..."&gt;', 'Base64 image'],
            ['&lt;table&gt;', 'Styled table'],
            ['&lt;ul&gt; / &lt;ol&gt;', 'Lists'],
            ['&lt;blockquote&gt;', 'Quote block'],
            ['&lt;code&gt; / &lt;pre&gt;', 'Code block'],
            ['&lt;hr&gt;', 'Horizontal rule'],
            ['&lt;style&gt;', 'Inline CSS preserved'],
            ['&lt;title&gt;', 'Auto-extract title'],
            ['&lt;meta name="author"&gt;', 'Auto-extract author'],
            ['&lt;meta name="description"&gt;', 'Auto-extract description'],
            ] as [$tag, $desc])
            <div class="flex items-start gap-2 p-2.5 bg-fn-surface border border-fn-text/8 rounded-xl">
                <code class="text-xs font-mono text-fn-blue-l shrink-0 leading-tight mt-px">{!! $tag !!}</code>
                <span class="text-xs text-fn-text3 leading-tight">{{ $desc }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-3">
            @foreach([
            ['How are chapters split?', 'Every <h1> tag in your HTML becomes a new chapter in the EPUB. Headings <h2>
                    through <h6> become section headings within a chapter. If your document has no <h1> tags, the entire
                            content becomes a single chapter.'],
                            ['Can I add a cover image?', 'Yes — when using the file upload mode, you can attach a cover
                            image (.jpg or .png) alongside your HTML file. The cover is embedded as the first page of
                            the EPUB and appears in your reader\'s library grid.'],
                            ['What metadata is auto-extracted from HTML?', 'If you leave the title, author, or
                            description fields blank, the converter reads them directly from your HTML — the <title> tag
                                becomes the book title, and
                                <meta name="author"> and
                                <meta name="description"> fill in the other fields automatically.'],
                                ['Does it support right-to-left languages like Arabic?', 'Yes. Set the language to
                                Arabic (or any RTL language) and the EPUB will be generated with the correct reading
                                direction and text alignment. The converter handles Unicode and multi-byte character
                                sets fully.'],
                                ['Are inline images and base64 images supported?', 'Yes. Images referenced via <img
                                    src="path"> are embedded if accessible, and base64-encoded images (<img
                                    src="data:image/...;base64,...">) are embedded directly from the HTML. Embedded
                                images in the EPUB work offline on any reader.'],
                                ['Is my HTML safe and private?', 'All uploads use AES-256 encryption in transit and are
                                permanently deleted within 1 hour. We never read, share, or store your content.'],
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

    .chip-chapters .chip-dot {
        background: oklch(62% 0.20 250);
    }

    .chip-chapters {
        color: oklch(62% 0.20 250);
        border-color: oklch(62% 0.20 250 / 30%);
        background: oklch(62% 0.20 250 / 6%);
    }

    .chip-meta .chip-dot {
        background: oklch(60% 0.22 295);
    }

    .chip-meta {
        color: oklch(60% 0.22 295);
        border-color: oklch(60% 0.22 295 / 30%);
        background: oklch(60% 0.22 295 / 6%);
    }

    .chip-images .chip-dot {
        background: oklch(72% 0.18 55);
    }

    .chip-images {
        color: oklch(72% 0.18 55);
        border-color: oklch(72% 0.18 55 / 30%);
        background: oklch(72% 0.18 55 / 6%);
    }

    .chip-lang .chip-dot {
        background: oklch(67% 0.18 162);
    }

    .chip-lang {
        color: oklch(67% 0.18 162);
        border-color: oklch(67% 0.18 162 / 30%);
        background: oklch(67% 0.18 162 / 6%);
    }

    .chip-cover .chip-dot {
        background: oklch(72% 0.19 41);
    }

    .chip-cover {
        color: oklch(72% 0.19 41);
        border-color: oklch(72% 0.19 41 / 30%);
        background: oklch(72% 0.19 41 / 6%);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_HTML = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>The Great Adventure</title>
  <meta name="author" content="Jane Doe">
  <meta name="description" content="An epic tale of discovery.">
</head>
<body>
  <h1>Introduction</h1>
  <p>Welcome to <strong>The Great Adventure</strong> — a story about courage, discovery, and the human spirit.</p>
  <blockquote>The journey of a thousand miles begins with a single step.</blockquote>

  <h1>Chapter 1: The Departure</h1>
  <p>It was a crisp autumn morning when our hero first set foot on the path that would change everything.</p>
  <h2>Section 1.1: Packing the Bag</h2>
  <p>She packed light — just a <em>journal</em>, a compass, and a worn copy of her favourite book.</p>
  <ul>
    <li>Compass — always north</li>
    <li>Journal — capture every moment</li>
    <li>Book — never travel without stories</li>
  </ul>

  <h1>Chapter 2: The Road</h1>
  <p>The first day was hardest. By nightfall she had covered twenty miles and found shelter in an old barn.</p>
  <h2>Section 2.1: A Stranger</h2>
  <p>A traveller sat by the fire. He introduced himself as <strong>Marcus</strong> and offered to share his meal.</p>
  <table>
    <tr><th>Supply</th><th>Quantity</th></tr>
    <tr><td>Bread</td><td>Half a loaf</td></tr>
    <tr><td>Water</td><td>One canteen</td></tr>
  </table>

  <h1>Epilogue</h1>
  <p>Years later, she would look back on that journey as the moment everything truly began.</p>
</body>
</html>`;

  const tabText     = document.getElementById('tab-text');
  const tabFile     = document.getElementById('tab-file');
  const panelText   = document.getElementById('panel-text');
  const panelFile   = document.getElementById('panel-file');
  const dropZone    = document.getElementById('drop-zone');
  const fileInput   = document.getElementById('file-input');
  const coverInput  = document.getElementById('cover-input');
  const convertBtn  = document.getElementById('convert-btn');
  const filePreview = document.getElementById('file-preview');
  const removeFile  = document.getElementById('remove-file');
  const uploadError = document.getElementById('upload-error');
  const errorText   = document.getElementById('error-text');
  const htmlTA      = document.getElementById('html-textarea');

  let selectedFile  = null;
  let selectedCover = null;
  let blobUrl       = null;
  let activeTab     = 'text';
  let detectTimer   = null;

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
    htmlTA.value = SAMPLE_HTML;
    htmlTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { htmlTA.value = await navigator.clipboard.readText(); htmlTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    htmlTA.value = '';
    htmlTA.dispatchEvent(new Event('input'));
  });

  // ── Textarea input ──
  htmlTA.addEventListener('input', () => {
    const v     = htmlTA.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('html-meta').textContent = v.length.toLocaleString() + ' chars · ' + lines + ' lines';

    const status = document.getElementById('html-status');
    if (!v.trim()) {
      status.innerHTML = '<span class="text-fn-text3">Paste HTML — h1 tags become chapter splits</span>';
    } else {
      const stats = analyzeHtml(v);
      if (stats.h1Count > 0 || stats.pCount > 0) {
        const parts = [];
        if (stats.h1Count > 0)    parts.push(`${stats.h1Count} chapter${stats.h1Count !== 1 ? 's' : ''}`);
        if (stats.imgCount > 0)   parts.push(`${stats.imgCount} image${stats.imgCount !== 1 ? 's' : ''}`);
        if (stats.tableCount > 0) parts.push(`${stats.tableCount} table${stats.tableCount !== 1 ? 's' : ''}`);
        status.innerHTML = `<span class="text-fn-green flex items-center gap-1.5">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Valid HTML detected${parts.length ? ' · ' + parts.join(' · ') : ''}
        </span>`;
      } else {
        status.innerHTML = '<span class="text-fn-amber">No headings or paragraphs found — ensure this is valid HTML</span>';
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
    if (!name.match(/\.(html|htm)$/)) {
      showError('Please select a valid HTML file (.html or .htm).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · HTML Document';
    filePreview.classList.remove('hidden');
    filePreview.classList.add('flex');
    dropZone.classList.add('has-file');

    if (file.size < 5 * 1024 * 1024) {
      try {
        const text = await file.text();
        detectFromText(text);
        autoFillMeta(text);
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

  // ── Cover image ──
  coverInput.addEventListener('change', e => { if (e.target.files[0]) handleCover(e.target.files[0]); });
  document.getElementById('remove-cover').addEventListener('click', e => {
    e.stopPropagation(); e.preventDefault();
    resetCover();
  });

  function handleCover(file) {
    if (!file.type.match(/^image\/(jpeg|png)$/)) return;
    selectedCover = file;
    const url = URL.createObjectURL(file);
    document.getElementById('cover-thumb').src = url;
    document.getElementById('cover-name').textContent = file.name;
    document.getElementById('cover-size').textContent = formatBytes(file.size);
    document.getElementById('cover-placeholder').classList.add('hidden');
    document.getElementById('cover-preview').classList.remove('hidden');
    document.getElementById('cover-preview').classList.add('flex');
  }

  function resetCover() {
    selectedCover = null;
    coverInput.value = '';
    const thumb = document.getElementById('cover-thumb');
    if (thumb.src.startsWith('blob:')) URL.revokeObjectURL(thumb.src);
    thumb.src = '';
    document.getElementById('cover-placeholder').classList.remove('hidden');
    document.getElementById('cover-preview').classList.add('hidden');
    document.getElementById('cover-preview').classList.remove('flex');
  }

  function refreshConvertBtn() {
    if (activeTab === 'text') convertBtn.disabled = !htmlTA.value.trim();
    else                      convertBtn.disabled = !selectedFile;
  }

  // ── Auto-fill meta from HTML ──
  function autoFillMeta(html) {
    const titleEl  = document.getElementById('opt-title');
    const authorEl = document.getElementById('opt-author');
    const descEl   = document.getElementById('opt-description');

    if (!titleEl.value) {
      const t = html.match(/<title[^>]*>(.*?)<\/title>/i);
      if (t) titleEl.value = t[1].trim();
    }
    if (!authorEl.value) {
      const a = html.match(/<meta\s+name=["']author["']\s+content=["'](.*?)["']/i)
             || html.match(/<meta\s+content=["'](.*?)["']\s+name=["']author["']/i);
      if (a) authorEl.value = a[1].trim();
    }
    if (!descEl.value) {
      const d = html.match(/<meta\s+name=["']description["']\s+content=["'](.*?)["']/i)
             || html.match(/<meta\s+content=["'](.*?)["']\s+name=["']description["']/i);
      if (d) descEl.value = d[1].trim();
    }
  }

  // ── Detection preview ──
  function refreshDetection() {
    if (activeTab === 'text') {
      const v = htmlTA.value.trim();
      if (!v) { document.getElementById('detected-content').classList.add('hidden'); return; }
      detectFromText(v);
      autoFillMeta(v);
    }
  }

  function detectFromText(html) {
    const stats = analyzeHtml(html);
    const wrap  = document.getElementById('detected-content');
    const list  = document.getElementById('detected-chips');
    list.innerHTML = '';

    const chips = [];
    if (stats.h1Count > 0)    chips.push(['chip-chapters', 'Chapters', stats.h1Count + '']);
    if (stats.h2Count > 0)    chips.push(['chip-chapters', 'Sections', stats.h2Count + '']);
    if (stats.imgCount > 0)   chips.push(['chip-images',   'Images',   stats.imgCount + '']);
    if (stats.tableCount > 0) chips.push(['chip-meta',     'Tables',   stats.tableCount + '']);
    if (stats.hasCode)        chips.push(['chip-meta',     'Code blocks', '✓']);
    if (stats.hasStyle)       chips.push(['chip-lang',     'CSS styles', '✓']);
    if (stats.autoTitle)      chips.push(['chip-lang',     'Title',    stats.autoTitle]);

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

  function analyzeHtml(html) {
    const stripped = html.replace(/<!--[\s\S]*?-->/g, '');
    const h1Count    = (stripped.match(/<h1[\s>]/gi)  || []).length;
    const h2Count    = (stripped.match(/<h2[\s>]/gi)  || []).length;
    const pCount     = (stripped.match(/<p[\s>]/gi)   || []).length;
    const imgCount   = (stripped.match(/<img[\s>]/gi) || []).length;
    const tableCount = (stripped.match(/<table[\s>]/gi) || []).length;
    const hasCode    = /<code[\s>]|<pre[\s>]/i.test(stripped);
    const hasStyle   = /<style[\s>]/i.test(stripped);
    const titleM     = stripped.match(/<title[^>]*>(.*?)<\/title>/i);
    const autoTitle  = titleM ? titleM[1].trim().substring(0, 24) : null;
    return { h1Count, h2Count, pCount, imgCount, tableCount, hasCode, hasStyle, autoTitle };
  }

  // ── Convert ──
  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const title       = document.getElementById('opt-title').value.trim();
    const author      = document.getElementById('opt-author').value.trim();
    const publisher   = document.getElementById('opt-publisher').value.trim();
    const description = document.getElementById('opt-description').value.trim();
    const language    = document.getElementById('opt-language').value;
    const customFile  = document.getElementById('opt-filename').value.trim();

    let outName;
    if (customFile) {
      outName = customFile.toLowerCase().endsWith('.epub') ? customFile : customFile + '.epub';
    } else if (title) {
      outName = title.replace(/[^a-z0-9]/gi, '_').toLowerCase() + '.epub';
    } else if (activeTab === 'file' && selectedFile) {
      outName = selectedFile.name.replace(/\.(html|htm)$/i, '') + '.epub';
    } else {
      outName = 'book.epub';
    }

    setProcessStep('proc-1', 'active');
    animateProgress(0, 20, 500, 'Reading HTML content…');

    const t2 = setTimeout(() => {
      setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active');
      animateProgress(20, 50, 800, 'Splitting chapters at <h1>…');
    }, 600);
    const t3 = setTimeout(() => {
      setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active');
      animateProgress(50, 78, 700, 'Embedding images & metadata…');
    }, 1500);
    const t4 = setTimeout(() => {
      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active');
      animateProgress(78, 92, 600, 'Packaging EPUB archive…');
    }, 2400);

    try {
      let res;

      if (activeTab === 'text') {
        // JSON body for raw HTML
        const payload = { html: htmlTA.value };
        if (title)       payload.title       = title;
        if (author)      payload.author      = author;
        if (publisher)   payload.publisher   = publisher;
        if (description) payload.description = description;
        if (language)    payload.language    = language;

        res = await fetch('https://api.filenewer.com/api/tools/html-to-epub', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body:    JSON.stringify(payload),
        });
      } else {
        // FormData for file upload
        const fd = new FormData();
        fd.append('file', selectedFile);
        if (title)         fd.append('title',       title);
        if (author)        fd.append('author',      author);
        if (publisher)     fd.append('publisher',   publisher);
        if (description)   fd.append('description', description);
        if (language)      fd.append('language',    language);
        if (selectedCover) fd.append('cover_image', selectedCover);

        res = await fetch('https://api.filenewer.com/api/tools/html-to-epub', {
          method: 'POST',
          body:   fd,
        });
      }

      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please check your HTML and try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch(_) {}
        throw new Error(msg);
      }

      const blob = await res.blob();

      // Read response headers
      const chapters = res.headers.get('X-Chapters') || null;
      const images   = res.headers.get('X-Images')   || null;
      const resTitle = res.headers.get('X-Title')    || title  || null;
      const resAuthor= res.headers.get('X-Author')   || author || null;

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(blob);

      const link = document.getElementById('download-link');
      link.href     = blobUrl;
      link.download = outName;

      document.getElementById('output-name').textContent = outName;
      document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · EPUB eBook';

      renderResultChips({ chapters, images, resTitle, resAuthor, language, hasCover: !!selectedCover });

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

  function renderResultChips({ chapters, images, resTitle, resAuthor, language, hasCover }) {
    const wrap = document.getElementById('result-info-wrap');
    const list = document.getElementById('result-chips');
    list.innerHTML = '';

    const chips = [];
    if (chapters)   chips.push(['chip-chapters', 'Chapters', chapters]);
    if (images)     chips.push(['chip-images',   'Images',   images]);
    if (resTitle)   chips.push(['chip-meta',     'Title',    resTitle.substring(0, 20)]);
    if (resAuthor)  chips.push(['chip-meta',     'Author',   resAuthor.substring(0, 20)]);
    if (language)   chips.push(['chip-lang',     'Language', language.toUpperCase()]);
    if (hasCover)   chips.push(['chip-cover',    'Cover',    'embedded']);

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
    resetCover();
    htmlTA.value = '';
    htmlTA.dispatchEvent(new Event('input'));
    document.getElementById('opt-title').value       = '';
    document.getElementById('opt-author').value      = '';
    document.getElementById('opt-publisher').value   = '';
    document.getElementById('opt-description').value = '';
    document.getElementById('opt-language').value    = 'en';
    document.getElementById('opt-filename').value    = '';
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
