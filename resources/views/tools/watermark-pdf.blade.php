@extends('layouts.base')

@section('content')

<x-tool-hero :tool="$tool" />
{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @php $wmSteps = [['1','Upload PDF'],['2','Watermarking'],['3','Download']]; @endphp
                @foreach($wmSteps as [$n, $label])
                <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-2" id="step-{{ $n }}">
                    <div class="step-dot w-6 h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                        <span class="text-xs font-bold">{{ $n }}</span>
                    </div>
                    <span class="step-label text-xs font-semibold text-fn-text3 transition-colors">{{ $label }}</span>
                </div>
                @if($n !== '3')
                <div class="w-10 h-px bg-fn-text/10 mx-2"></div>
                @endif
                @endforeach
            </div>

            <div class="p-8 lg:p-10">

                {{-- ── STATE: Upload ── --}}
                <div id="state-upload">

                    <div class="grid lg:grid-cols-2 gap-8">

                        {{-- ── LEFT: Upload + Options ── --}}
                        <div class="space-y-4">

                            {{-- Drop zone --}}
                            <div id="drop-zone"
                                class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-8 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                <div class="flex items-center justify-center mb-4">
                                    <div class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-3xl">📕</div>
                                </div>
                                <h2 class="text-base font-bold mb-1.5">Drop your PDF here</h2>
                                <p class="text-fn-text3 text-xs mb-4">or click to browse</p>
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-fn-blue text-white text-xs font-semibold rounded-lg pointer-events-none">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" y1="3" x2="12" y2="15" />
                                    </svg>
                                    Choose PDF
                                </div>
                                <p class="text-fn-text3 text-xs mt-3">Max 50MB · <a href="/pricing" class="text-fn-blue-l hover:underline">200MB on Pro</a></p>
                                <input type="file" id="file-input" accept=".pdf,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </div>

                            {{-- File preview --}}
                            <div id="file-preview" class="hidden p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-fn-red/12 border border-fn-red/20 flex items-center justify-center text-xl shrink-0">📕</div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-xs truncate" id="file-name">document.pdf</p>
                                    <p class="text-fn-text3 text-xs mt-0.5" id="file-meta">—</p>
                                </div>
                                <button type="button" id="remove-file" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Watermark type toggle --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">Watermark Type</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" id="type-text"
                                        class="wm-type-btn active flex items-center justify-center gap-2 py-2.5 rounded-xl border text-sm font-semibold transition-all"
                                        data-type="text">
                                        <span>🔤</span> Text
                                    </button>
                                    <button type="button" id="type-image"
                                        class="wm-type-btn flex items-center justify-center gap-2 py-2.5 rounded-xl border text-sm font-semibold transition-all"
                                        data-type="image">
                                        <span>🖼️</span> Image
                                    </button>
                                </div>
                            </div>

                            {{-- TEXT options --}}
                            <div id="text-options" class="space-y-3">

                                {{-- Watermark text --}}
                                <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                    <label for="opt-text" class="text-xs font-semibold text-fn-text2 block mb-2">Watermark Text</label>
                                    <input type="text" id="opt-text" value="CONFIDENTIAL" maxlength="60"
                                        class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40" />
                                    <div class="flex gap-2 mt-2 flex-wrap">
                                        @php $presetTexts = ['CONFIDENTIAL','DRAFT','SAMPLE','TOP SECRET','COPY']; @endphp
                                        @foreach($presetTexts as $pt)
                                        <button type="button" class="preset-text-btn px-2 py-0.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue-l hover:border-fn-blue/30 text-xs rounded-lg font-mono transition-all">{{ $pt }}</button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Color + Font size --}}
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                        <label class="text-xs font-semibold text-fn-text2 block mb-2">Color</label>
                                        <div class="grid grid-cols-4 gap-1.5" id="color-grid">
                                            @php
                                            $colors = [
                                            ['red', '#ef4444'],
                                            ['blue', '#3b82f6'],
                                            ['grey', '#9ca3af'],
                                            ['black', '#111827'],
                                            ['green', '#22c55e'],
                                            ['yellow', '#eab308'],
                                            ['white', '#ffffff'],
                                            ];
                                            @endphp
                                            @foreach($colors as [$cval, $chex])
                                            <button type="button"
                                                class="color-btn {{ $cval === 'grey' ? 'active' : '' }} w-7 h-7 rounded-lg border-2 transition-all hover:scale-110"
                                                data-color="{{ $cval }}"
                                                style="background:{{ $chex }}; border-color: {{ $cval === 'grey' ? '#6b7280' : 'transparent' }}"
                                                title="{{ ucfirst($cval) }}">
                                            </button>
                                            @endforeach
                                        </div>
                                        <p class="text-fn-text3 text-xs mt-2" id="color-label">Grey</p>
                                    </div>
                                    <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                        <label class="text-xs font-semibold text-fn-text2 block mb-2">
                                            Font Size — <span id="font-size-val" class="text-fn-blue-l">60</span>
                                        </label>
                                        <input type="range" id="opt-font-size" min="12" max="120" value="60" step="1"
                                            class="w-full accent-fn-blue cursor-pointer mt-1" />
                                        <div class="flex justify-between text-fn-text3 text-xs mt-1">
                                            <span>12</span><span>60</span><span>120</span>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- /text-options --}}

                            {{-- IMAGE options --}}
                            <div id="image-options" class="hidden space-y-3">
                                <div id="img-drop-zone"
                                    class="border-2 border-dashed border-fn-text/15 rounded-xl p-6 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                                    <div class="text-2xl mb-2">🖼️</div>
                                    <p class="text-sm font-semibold mb-1">Drop watermark image</p>
                                    <p class="text-fn-text3 text-xs">PNG or JPG · transparent PNG recommended</p>
                                    <input type="file" id="img-input" accept=".png,.jpg,.jpeg,image/png,image/jpeg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>
                                <div id="img-preview-wrap" class="hidden p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-3">
                                    <img id="img-preview-thumb" src="" alt="" class="w-10 h-10 rounded-lg object-contain bg-fn-surface border border-fn-text/8 shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-xs truncate" id="img-name">logo.png</p>
                                        <p class="text-fn-text3 text-xs mt-0.5" id="img-meta">—</p>
                                    </div>
                                    <button type="button" id="remove-img" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>{{-- /image-options --}}

                        </div>{{-- /left col --}}

                        {{-- ── RIGHT: Shared options + Live Preview ── --}}
                        <div class="space-y-4">

                            {{-- Live preview --}}
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <p class="text-xs font-semibold text-fn-text2 mb-3">Live Preview</p>
                                <div id="preview-canvas-wrap"
                                    class="relative bg-white border border-fn-text/12 rounded-xl overflow-hidden"
                                    style="aspect-ratio:210/297; max-height:280px;">
                                    {{-- Fake page lines --}}
                                    <div class="absolute inset-0 p-6 flex flex-col gap-2 opacity-20">
                                        @for($i = 0; $i < 12; $i++)
                                            <div class="h-px bg-gray-300 rounded" style="width:{{ rand(60,95) }}%">
                                    </div>
                                    @endfor
                                </div>
                                {{-- Watermark overlay --}}
                                <div id="preview-watermark"
                                    class="absolute inset-0 flex items-center justify-center pointer-events-none select-none">
                                    <span id="preview-text"
                                        class="font-bold tracking-widest text-center leading-none"
                                        style="color:rgba(156,163,175,0.35); font-size:clamp(18px,7vw,42px); transform:rotate(-45deg); white-space:nowrap;">
                                        CONFIDENTIAL
                                    </span>
                                    <img id="preview-img" src="" alt="" class="hidden max-w-1/2 max-h-1/2 object-contain" style="opacity:0.3;" />
                                </div>
                            </div>
                            <p class="text-fn-text3 text-xs mt-2 text-center">Approximate preview — actual output may vary</p>
                        </div>

                        {{-- Position --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-2">Position</label>
                            <div class="grid grid-cols-3 gap-1.5" id="position-grid">
                                @php
                                $positions = [
                                ['top-left','↖'],['top','↑'],['top-right','↗'],
                                ['left','←'],['center','⊕'],['right','→'],
                                ['bottom-left','↙'],['bottom','↓'],['bottom-right','↘'],
                                ];
                                @endphp
                                @foreach($positions as [$pval,$picon])
                                <button type="button"
                                    class="pos-btn {{ $pval === 'center' ? 'active' : '' }} py-2 rounded-lg border text-sm font-mono transition-all"
                                    data-pos="{{ $pval }}" title="{{ ucfirst(str_replace('-',' ',$pval)) }}">
                                    {{ $picon }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Opacity + Angle --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">
                                    Opacity — <span id="opacity-val" class="text-fn-blue-l">0.3</span>
                                </label>
                                <input type="range" id="opt-opacity" min="0.05" max="1" value="0.3" step="0.05"
                                    class="w-full accent-fn-blue cursor-pointer mt-1" />
                                <div class="flex justify-between text-fn-text3 text-xs mt-1">
                                    <span>Subtle</span><span>Heavy</span>
                                </div>
                            </div>
                            <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl" id="angle-wrap">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">
                                    Angle — <span id="angle-val" class="text-fn-blue-l">45°</span>
                                </label>
                                <input type="range" id="opt-angle" min="-90" max="90" value="45" step="5"
                                    class="w-full accent-fn-blue cursor-pointer mt-1" />
                                <div class="flex justify-between text-fn-text3 text-xs mt-1">
                                    <span>-90°</span><span>0°</span><span>90°</span>
                                </div>
                            </div>
                        </div>

                        {{-- Pages --}}
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label for="opt-pages" class="text-xs font-semibold text-fn-text2 block mb-1.5">
                                Pages <span class="font-normal text-fn-text3 ml-1">(optional — leave blank for all)</span>
                            </label>
                            <input type="text" id="opt-pages" placeholder="e.g. 1,2,3 or 1-5"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/60" />
                            <p class="text-fn-text3 text-xs mt-1.5">Comma-separated page numbers · leave blank to watermark all pages</p>
                        </div>

                    </div>{{-- /right col --}}
                </div>{{-- /grid --}}

                {{-- Error banner --}}
                <div id="upload-error" class="hidden mt-5 items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-fn-red shrink-0" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span id="error-text">Something went wrong.</span>
                </div>

                {{-- Action button --}}
                <button id="action-btn" type="button" disabled
                    class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                    Apply Watermark
                </button>

            </div>{{-- /state-upload --}}

            {{-- ── STATE: Processing ── --}}
            <div id="state-converting" class="hidden text-center py-6">
                <div class="flex items-center justify-center gap-5 mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-3xl">📕</div>
                    <div class="flex gap-1">
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:0s"></span>
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.15s"></span>
                        <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce" style="animation-delay:.3s"></span>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-3xl">💧</div>
                </div>
                <h2 class="text-xl font-bold mb-2">Applying watermark…</h2>
                <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes just a few seconds</p>
                <div class="max-w-md mx-auto mb-3">
                    <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                        <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between max-w-md mx-auto text-xs text-fn-text3 mb-8">
                    <span id="progress-label">Starting…</span>
                    <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                </div>
                <div class="max-w-xs mx-auto flex flex-col gap-3 text-left">
                    @php
                    $wmProcSteps = [
                    ['proc-1','Uploading & reading PDF'],
                    ['proc-2','Rendering watermark layer'],
                    ['proc-3','Stamping pages'],
                    ['proc-4','Generating output PDF'],
                    ];
                    @endphp
                    @foreach($wmProcSteps as [$pid, $plabel])
                    <div class="flex items-center gap-3" id="{{ $pid }}">
                        <div class="step-dot w-5 h-5 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center shrink-0 transition-all duration-300">
                            <svg class="check-icon hidden w-3 h-3 text-fn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <svg class="spin-icon hidden w-3 h-3 text-fn-blue-l spin" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="text-xs text-fn-text3">{{ $plabel }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── STATE: Download ── --}}
            <div id="state-download" class="hidden text-center py-6">
                <div class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">✅</div>
                <h2 class="text-2xl font-bold mb-2">Watermark Applied!</h2>
                <p class="text-fn-text2 text-sm mb-8">Your watermarked PDF is ready.</p>

                <div class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                    <div class="w-12 h-12 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-2xl shrink-0">💧</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate" id="output-name">watermarked.pdf</p>
                        <p class="text-fn-text3 text-xs mt-0.5" id="output-size">PDF Document</p>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                </div>

                <a id="download-link" href="#" download="watermarked.pdf"
                    class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                    style="background: oklch(67% 0.18 162);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Download Watermarked PDF
                </a>

                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <button type="button" onclick="resetConverter()"
                        class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="1 4 1 10 7 10" />
                            <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                        </svg>
                        Watermark another
                    </button>
                    <a href="/tools" class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                        All tools
                    </a>
                </div>

                <p class="mt-6 text-fn-text3 text-xs flex items-center justify-center gap-1.5">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
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
            $wmFaqs = [
            ['What types of watermark can I add?', 'You can add a text watermark (e.g. CONFIDENTIAL, DRAFT) with full control over colour, font size, opacity, angle, and position — or an image watermark using any PNG or JPG, which is especially useful for logo branding. Transparent-background PNGs work best for image watermarks.'],
            ['Can I watermark only specific pages?', 'Yes — enter comma-separated page numbers in the Pages field (e.g. 1,2,3). Leave the field blank to apply the watermark to every page in the document.'],
            ['What positions are available?', 'Nine positions are supported: center, top, bottom, top-left, top-right, bottom-left, bottom-right, left, and right. Use the 3×3 position grid to pick visually.'],
            ['What opacity should I choose?', '0.3 is the default — balanced and visible without obscuring content. Use 0.1 for a very subtle watermark, 0.5 for medium visibility, or 0.8+ for a heavy stamp. 1.0 is fully opaque.'],
            ['Is my PDF safe and private?', 'All uploads use AES-256 encryption in transit and are permanently deleted within 1 hour. We never read, share or store your content.'],
            ];
            @endphp
            @foreach($wmFaqs as [$q,$a])
            <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                <button type="button" class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left hover:bg-fn-surface2 transition-colors">
                    <span class="font-semibold text-sm">{{ $q }}</span>
                    <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    .wm-type-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
    }

    .wm-type-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264/40%);
        background: oklch(49% 0.24 264/8%);
    }

    .pos-btn {
        color: var(--fn-text3);
        border-color: oklch(var(--fn-text-l, 80%) 0 0/10%);
        background: var(--fn-surface);
    }

    .pos-btn.active {
        color: var(--fn-blue-l);
        border-color: oklch(49% 0.24 264/40%);
        background: oklch(49% 0.24 264/8%);
    }

    .pos-btn:not(.active):hover {
        border-color: oklch(49% 0.24 264/25%);
        color: var(--fn-text);
    }

    .color-btn.active {
        outline: 3px solid oklch(49% 0.24 264);
        outline-offset: 2px;
    }

    /* Preview positioning */
    #preview-watermark {
        transition: all .2s ease;
    }
</style>

{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ── State ──
        let selectedFile = null;
        let selectedImage = null;
        let blobUrl = null;
        let wmType = 'text'; // 'text' | 'image'
        let activeColor = 'grey';
        let activePos = 'center';

        const colorHexMap = {
            red: '#ef4444',
            blue: '#3b82f6',
            grey: '#9ca3af',
            black: '#111827',
            green: '#22c55e',
            yellow: '#eab308',
            white: '#ffffff',
        };

        // ── Watermark type toggle ──
        document.querySelectorAll('.wm-type-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                wmType = btn.dataset.type;
                document.querySelectorAll('.wm-type-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('text-options').classList.toggle('hidden', wmType !== 'text');
                document.getElementById('image-options').classList.toggle('hidden', wmType !== 'image');
                document.getElementById('angle-wrap').style.opacity = '1';
                // Show/hide preview elements
                document.getElementById('preview-text').classList.toggle('hidden', wmType !== 'text');
                document.getElementById('preview-img').classList.toggle('hidden', wmType !== 'image');
                updateActionBtn();
            });
        });

        // ── PDF drop zone ──
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const filePreview = document.getElementById('file-preview');

        ['dragenter', 'dragover'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('drag-over');
            });
        });
        ['dragleave', 'dragend', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-over');
            });
        });
        dropZone.addEventListener('drop', e => {
            if (e.dataTransfer.files[0]) handlePdf(e.dataTransfer.files[0]);
        });
        fileInput.addEventListener('change', e => {
            if (e.target.files[0]) handlePdf(e.target.files[0]);
        });
        document.getElementById('remove-file').addEventListener('click', e => {
            e.stopPropagation();
            selectedFile = null;
            fileInput.value = '';
            filePreview.classList.add('hidden');
            filePreview.classList.remove('flex');
            dropZone.classList.remove('has-file');
            updateActionBtn();
            hideError();
        });

        function handlePdf(file) {
            hideError();
            if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                showError('Please select a valid PDF file.');
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
            updateActionBtn();
        }

        // ── Image drop zone ──
        const imgDropZone = document.getElementById('img-drop-zone');
        const imgInput = document.getElementById('img-input');
        const imgPreviewWrap = document.getElementById('img-preview-wrap');

        ['dragenter', 'dragover'].forEach(evt => {
            imgDropZone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                imgDropZone.classList.add('drag-over');
            });
        });
        ['dragleave', 'dragend', 'drop'].forEach(evt => {
            imgDropZone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                imgDropZone.classList.remove('drag-over');
            });
        });
        imgDropZone.addEventListener('drop', e => {
            if (e.dataTransfer.files[0]) handleImage(e.dataTransfer.files[0]);
        });
        imgInput.addEventListener('change', e => {
            if (e.target.files[0]) handleImage(e.target.files[0]);
        });
        document.getElementById('remove-img').addEventListener('click', () => {
            selectedImage = null;
            imgInput.value = '';
            imgPreviewWrap.classList.add('hidden');
            imgPreviewWrap.classList.remove('flex');
            imgDropZone.classList.remove('has-file');
            document.getElementById('preview-img').src = '';
            updateActionBtn();
        });

        function handleImage(file) {
            hideError();
            if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {
                showError('Please select a PNG or JPG image for the watermark.');
                return;
            }
            selectedImage = file;
            document.getElementById('img-name').textContent = file.name;
            document.getElementById('img-meta').textContent = formatBytes(file.size) + ' · ' + (file.type === 'image/png' ? 'PNG' : 'JPEG');
            // Thumb + preview
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('img-preview-thumb').src = e.target.result;
                const previewImg = document.getElementById('preview-img');
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                document.getElementById('preview-text').classList.add('hidden');
            };
            reader.readAsDataURL(file);
            imgPreviewWrap.classList.remove('hidden');
            imgPreviewWrap.classList.add('flex');
            imgDropZone.classList.add('has-file');
            updateActionBtn();
        }

        // ── Preset text buttons ──
        document.querySelectorAll('.preset-text-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('opt-text').value = btn.textContent.trim();
                updatePreview();
            });
        });

        // ── Color buttons ──
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.color-btn').forEach(b => {
                    b.classList.remove('active');
                    b.style.borderColor = 'transparent';
                });
                btn.classList.add('active');
                btn.style.borderColor = btn.style.backgroundColor;
                activeColor = btn.dataset.color;
                document.getElementById('color-label').textContent = btn.title;
                updatePreview();
            });
        });

        // ── Position grid ──
        document.querySelectorAll('.pos-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.pos-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activePos = btn.dataset.pos;
                updatePreview();
            });
        });

        // ── Sliders ──
        document.getElementById('opt-opacity').addEventListener('input', e => {
            document.getElementById('opacity-val').textContent = parseFloat(e.target.value).toFixed(2);
            updatePreview();
        });
        document.getElementById('opt-angle').addEventListener('input', e => {
            document.getElementById('angle-val').textContent = e.target.value + '°';
            updatePreview();
        });
        document.getElementById('opt-font-size').addEventListener('input', e => {
            document.getElementById('font-size-val').textContent = e.target.value;
            updatePreview();
        });
        document.getElementById('opt-text').addEventListener('input', updatePreview);

        // ── Live preview ──
        function updatePreview() {
            const previewWM = document.getElementById('preview-watermark');
            const previewTxt = document.getElementById('preview-text');
            const previewImg = document.getElementById('preview-img');
            const opacity = parseFloat(document.getElementById('opt-opacity').value);
            const angle = parseInt(document.getElementById('opt-angle').value);

            // Position mapping → flexbox alignment
            const posMap = {
                'center': ['center', 'center'],
                'top': ['flex-start', 'center'],
                'bottom': ['flex-end', 'center'],
                'top-left': ['flex-start', 'flex-start'],
                'top-right': ['flex-start', 'flex-end'],
                'bottom-left': ['flex-end', 'flex-start'],
                'bottom-right': ['flex-end', 'flex-end'],
                'left': ['center', 'flex-start'],
                'right': ['center', 'flex-end'],
            };
            const [alignItems, justifyContent] = posMap[activePos] || ['center', 'center'];
            previewWM.style.alignItems = alignItems;
            previewWM.style.justifyContent = justifyContent;
            previewWM.style.padding = activePos === 'center' ? '0' : '16px';

            if (wmType === 'text') {
                const text = document.getElementById('opt-text').value || 'WATERMARK';
                const fontSize = parseInt(document.getElementById('opt-font-size').value);
                const hex = colorHexMap[activeColor] || '#9ca3af';
                previewTxt.textContent = text;
                previewTxt.style.color = hexWithOpacity(hex, opacity);
                previewTxt.style.transform = `rotate(${angle}deg)`;
                previewTxt.style.fontSize = Math.max(10, Math.round(fontSize * 0.55)) + 'px';
            } else {
                previewImg.style.opacity = opacity;
                previewImg.style.transform = `rotate(${angle}deg)`;
            }
        }

        function hexWithOpacity(hex, opacity) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r},${g},${b},${opacity})`;
        }

        // Init preview
        updatePreview();

        // ── Refresh convert button ──
        function updateActionBtn() {
            const btn = document.getElementById('action-btn');
            if (wmType === 'text') {
                btn.disabled = !selectedFile;
            } else {
                btn.disabled = !selectedFile || !selectedImage;
            }
        }

        // ── Convert ──
        document.getElementById('action-btn').addEventListener('click', startConversion);

        async function startConversion() {
            hideError();
            showState('converting');
            updateStepIndicator(2);

            const opacity = parseFloat(document.getElementById('opt-opacity').value);
            const angle = parseInt(document.getElementById('opt-angle').value);
            const pages = document.getElementById('opt-pages').value.trim();
            const fileName = selectedFile.name.replace(/\.pdf$/i, '_watermarked.pdf');

            const fd = new FormData();
            fd.append('file', selectedFile);
            fd.append('watermark_type', wmType);
            fd.append('position', activePos);
            fd.append('opacity', opacity);
            fd.append('angle', angle);
            if (pages) fd.append('pages', pages);

            if (wmType === 'text') {
                fd.append('watermark_text', document.getElementById('opt-text').value.trim() || 'CONFIDENTIAL');
                fd.append('color', activeColor);
                fd.append('font_size', document.getElementById('opt-font-size').value);
            } else {
                fd.append('watermark_image', selectedImage);
            }

            setProcessStep('proc-1', 'active');
            animateProgress(0, 25, 700, 'Uploading & reading PDF…');

            const t2 = setTimeout(() => {
                setProcessStep('proc-1', 'done');
                setProcessStep('proc-2', 'active');
                animateProgress(25, 55, 900, 'Rendering watermark layer…');
            }, 800);
            const t3 = setTimeout(() => {
                setProcessStep('proc-2', 'done');
                setProcessStep('proc-3', 'active');
                animateProgress(55, 78, 800, 'Stamping pages…');
            }, 1800);
            const t4 = setTimeout(() => {
                setProcessStep('proc-3', 'done');
                setProcessStep('proc-4', 'active');
                animateProgress(78, 90, 600, 'Generating output PDF…');
            }, 2700);

            try {
                const res = await fetch('https://api.filenewer.com/api/tools/pdf-watermark', {
                    method: 'POST',
                    body: fd
                });
                clearTimeout(t2);
                clearTimeout(t3);
                clearTimeout(t4);
                if (!res.ok) {
                    const d = await res.json().catch(() => ({}));
                    throw new Error(d.error || 'Watermarking failed. Please try again.');
                }
                const blob = await res.blob();
                if (blobUrl) URL.revokeObjectURL(blobUrl);
                blobUrl = URL.createObjectURL(blob);

                const link = document.getElementById('download-link');
                link.href = blobUrl;
                link.download = fileName;

                document.getElementById('output-name').textContent = fileName;
                document.getElementById('output-size').textContent = formatBytes(blob.size) + ' · PDF Document';

                setProcessStep('proc-3', 'done');
                setProcessStep('proc-4', 'done');
                animateProgress(90, 100, 300, 'Done!');
                setTimeout(() => {
                    showState('download');
                    updateStepIndicator(3);
                }, 500);

            } catch (err) {
                clearTimeout(t2);
                clearTimeout(t3);
                clearTimeout(t4);
                showError(err.message);
                showState('upload');
                updateStepIndicator(1);
            }
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
                if (n < active) el.classList.add('done');
                if (n === active) el.classList.add('active');
            });
        }

        function setProcessStep(id, state) {
            const el = document.getElementById(id);
            if (!el) return;
            const dot = el.querySelector('.step-dot');
            const check = el.querySelector('.check-icon');
            const spin = el.querySelector('.spin-icon');
            check.classList.add('hidden');
            spin.classList.add('hidden');
            dot.style.borderColor = '';
            dot.style.background = '';
            if (state === 'active') {
                spin.classList.remove('hidden');
                dot.style.borderColor = 'oklch(49% 0.24 264)';
                dot.style.background = 'oklch(49% 0.24 264/15%)';
            }
            if (state === 'done') {
                check.classList.remove('hidden');
                dot.style.borderColor = 'oklch(67% 0.18 162)';
                dot.style.background = 'oklch(67% 0.18 162/15%)';
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

        window.resetConverter = function() {
            if (blobUrl) {
                URL.revokeObjectURL(blobUrl);
                blobUrl = null;
            }
            // Reset files
            selectedFile = null;
            selectedImage = null;
            fileInput.value = '';
            imgInput.value = '';
            filePreview.classList.add('hidden');
            filePreview.classList.remove('flex');
            imgPreviewWrap.classList.add('hidden');
            imgPreviewWrap.classList.remove('flex');
            dropZone.classList.remove('has-file');
            imgDropZone.classList.remove('has-file');
            // Reset type to text
            wmType = 'text';
            document.getElementById('type-text').classList.add('active');
            document.getElementById('type-image').classList.remove('active');
            document.getElementById('text-options').classList.remove('hidden');
            document.getElementById('image-options').classList.add('hidden');
            document.getElementById('preview-text').classList.remove('hidden');
            document.getElementById('preview-img').classList.add('hidden');
            document.getElementById('preview-img').src = '';
            // Reset fields
            document.getElementById('opt-text').value = 'CONFIDENTIAL';
            document.getElementById('opt-opacity').value = '0.3';
            document.getElementById('opt-angle').value = '45';
            document.getElementById('opt-font-size').value = '60';
            document.getElementById('opt-pages').value = '';
            document.getElementById('opacity-val').textContent = '0.30';
            document.getElementById('angle-val').textContent = '45°';
            document.getElementById('font-size-val').textContent = '60';
            // Reset color to grey
            activeColor = 'grey';
            document.querySelectorAll('.color-btn').forEach(b => {
                b.classList.remove('active');
                b.style.borderColor = 'transparent';
            });
            const greyBtn = document.querySelector('.color-btn[data-color="grey"]');
            greyBtn.classList.add('active');
            greyBtn.style.borderColor = '#6b7280';
            document.getElementById('color-label').textContent = 'Grey';
            // Reset position to center
            activePos = 'center';
            document.querySelectorAll('.pos-btn').forEach(b => b.classList.remove('active'));
            document.querySelector('.pos-btn[data-pos="center"]').classList.add('active');
            updatePreview();
            updateActionBtn();
            hideError();
            showState('upload');
            updateStepIndicator(1);
            animateProgress(0, 0, 0, 'Starting…');
            ['proc-1', 'proc-2', 'proc-3', 'proc-4'].forEach(id => setProcessStep(id, ''));
        };

        function showError(msg) {
            const el = document.getElementById('upload-error');
            document.getElementById('error-text').textContent = msg;
            el.classList.remove('hidden');
            el.classList.add('flex');
        }

        function hideError() {
            const el = document.getElementById('upload-error');
            el.classList.add('hidden');
            el.classList.remove('flex');
        }

        function formatBytes(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(1) + ' MB';
        }

        // ── FAQ ──
        document.querySelectorAll('.faq-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const body = btn.nextElementSibling;
                const icon = btn.querySelector('.faq-icon');
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

@endsection
