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
                @foreach([['1','Input YAML'],['2','Converting'],['3','JSON']] as [$n, $label])
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
                            Paste YAML
                        </button>
                        <button type="button" id="tab-file"
                            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Upload .yaml
                        </button>
                    </div>

                    {{-- ══ TEXT TAB ══ --}}
                    <div id="panel-text">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-fn-text2">YAML source</p>
                            <div class="flex gap-1">
                                <button type="button" id="btn-sample"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Sample</button>
                                <button type="button" id="btn-multi-sample"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all">Multi-doc</button>
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

                        <textarea id="yaml-textarea" rows="12" spellcheck="false"
                            placeholder='Paste your YAML here, e.g.&#10;&#10;username: booker12&#10;identifier: 9012&#10;department: Sales&#10;location: Manchester&#10;tags:&#10;  - admin&#10;  - editor'
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>

                        <div class="flex items-center justify-between text-xs mt-1.5">
                            <span id="yaml-status" class="text-fn-text3">Paste YAML to continue</span>
                            <span id="yaml-meta" class="text-fn-text3/70">0 chars · 0 lines</span>
                        </div>
                    </div>

                    {{-- ══ FILE TAB ══ --}}
                    <div id="panel-file" class="hidden">
                        <div id="drop-zone"
                            class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-12 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                            <div class="flex items-center justify-center mb-5">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-3xl">
                                    📄</div>
                            </div>
                            <h2 class="text-lg font-bold mb-2">Drop your YAML file here</h2>
                            <p class="text-fn-text3 text-sm mb-6">Supports .yaml and .yml — or click to browse</p>
                            <div
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Choose YAML File
                            </div>
                            <p class="text-fn-text3 text-sm mt-5">Max 50MB free</p>
                            <input type="file" id="file-input"
                                accept=".yaml,.yml,application/x-yaml,text/yaml,text/x-yaml,text/plain"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>

                        <div id="file-preview"
                            class="hidden mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-fn-purple/12 border border-fn-purple/20 flex items-center justify-center text-xl shrink-0">
                                📄</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" id="file-name">data.yaml</p>
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

                    {{-- Options --}}
                    <div class="mt-5 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-fn-text2">JSON Options</p>
                            <span class="text-xs text-fn-text3">Sensible defaults applied</span>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="p-3 bg-fn-surface border border-fn-text/8 rounded-lg">
                                <label class="text-xs font-semibold text-fn-text2 block mb-2">
                                    Indent — <span class="text-fn-blue-l" id="indent-val">4</span> spaces
                                </label>
                                <input type="range" id="opt-indent" min="1" max="8" value="4" step="1"
                                    class="w-full accent-fn-blue cursor-pointer mb-1" />
                                <div class="flex justify-between text-fn-text3 text-xs">
                                    <span>1</span><span>2</span><span>4</span><span>8</span>
                                </div>
                            </div>
                            <div class="p-3 bg-fn-surface border border-fn-text/8 rounded-lg space-y-2.5">
                                @foreach([
                                ['opt-sort', 'Sort keys', 'Alphabetically order keys', false],
                                ['opt-ascii', 'Escape non-ASCII', 'Convert é → \\u00e9 etc', false],
                                ] as [$tid, $tlabel, $tdesc, $tdefault])
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
                                        <p class="text-xs font-semibold text-fn-text2">{{ $tlabel }}</p>
                                        <p class="text-xs text-fn-text3 leading-tight mt-0.5">{{ $tdesc }}</p>
                                    </div>
                                </label>
                                @endforeach
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
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                        Convert to JSON
                    </button>
                </div>

                {{-- ── STATE: Converting ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-5 mb-8">
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-purple/10 border border-fn-purple/20 flex items-center justify-center text-2xl">
                            📄</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-2xl font-mono font-black text-fn-amber">
                            { }</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Converting to JSON…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes just a moment</p>

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
                        ['proc-1','Reading YAML content'],
                        ['proc-2','Resolving anchors & aliases'],
                        ['proc-3','Converting types to JSON'],
                        ['proc-4','Formatting output'],
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
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-fn-green/25 bg-fn-green/8 text-fn-green text-sm font-bold">
                            <span>✅</span><span>JSON Ready</span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach([
                            ['stat-type', 'Type'],
                            ['stat-keys', 'Items'],
                            ['stat-docs', 'Documents'],
                            ['stat-size', 'JSON size'],
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
                            <a id="btn-download" href="#" download="output.json"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-fn-green/10 border border-fn-green/25 text-fn-green text-xs font-semibold rounded-lg hover:bg-fn-green/20 transition-all">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download .json
                            </a>
                        </div>
                    </div>

                    <pre id="json-output"
                        class="bg-fn-surface2 border border-fn-text/8 rounded-xl p-5 text-sm font-mono text-fn-text2 leading-relaxed overflow-auto max-h-[500px] whitespace-pre"></pre>

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
                        Your data is encrypted and permanently deleted within 1 hour.
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
            ['Why convert YAML to JSON?','Many APIs, JavaScript apps, and configuration tools expect JSON specifically.
            Converting YAML configs to JSON lets you feed them into systems that don\'t natively understand YAML, or use
            them with browser/Node.js code that natively parses JSON.'],
            ['What about multi-document YAML files?','Multi-document YAML files (separated by `---`) are automatically
            merged into a single JSON array, with each document becoming an array element. The "Documents" stat in the
            result tells you how many documents were detected.'],
            ['How are YAML-specific features handled?','Anchors and aliases (`&name` / `*name`) are resolved inline so
            the JSON output is fully self-contained. Timestamps are converted to ISO 8601 strings. YAML\'s
            "yes/no/on/off" become true/false. Null variants (`null`, `~`, empty) all become JSON null.'],
            ['Should I escape non-ASCII characters?','By default, accents and emoji are kept as-is for readability.
            Enable "Escape non-ASCII" if you need pure 7-bit ASCII output (`café` → `caf\\u00e9`) for systems that
            don\'t handle UTF-8 cleanly.'],
            ['Is my data safe and private?','All uploads use AES-256 encryption in transit and are permanently deleted
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

    #opt-indent {
        height: 4px;
        background: oklch(var(--fn-text-l, 80%) 0 0 / 12%);
        border-radius: 999px;
        outline: none;
    }

    #json-output .j-key {
        color: oklch(62% 0.20 250);
    }

    #json-output .j-str {
        color: oklch(67% 0.18 162);
    }

    #json-output .j-num {
        color: oklch(72% 0.18 60);
    }

    #json-output .j-bool {
        color: oklch(62% 0.22 25);
        font-weight: 600;
    }

    #json-output .j-null {
        color: var(--fn-text3);
        font-style: italic;
    }

    #json-output .j-mark {
        color: var(--fn-text3);
    }
</style>

@push('footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {

  const SAMPLE_YAML = `username: booker12
identifier: 9012
first_name: Rachel
last_name: Booker
department: Sales
location: Manchester
roles:
  - admin
  - editor
active: true
tags: null`;

  const MULTI_SAMPLE = `name: Alice
age: 30
---
name: Bob
age: 25
---
name: Carol
age: 35`;

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
  const yamlTA      = document.getElementById('yaml-textarea');
  const yamlStatus  = document.getElementById('yaml-status');

  let selectedFile = null;
  let blobUrl      = null;
  let activeTab    = 'text';
  let jsonOutput   = '';

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

  const indentSlider = document.getElementById('opt-indent');
  indentSlider.addEventListener('input', () => {
    document.getElementById('indent-val').textContent = indentSlider.value;
  });

  document.getElementById('btn-sample').addEventListener('click', () => {
    yamlTA.value = SAMPLE_YAML;
    yamlTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-multi-sample').addEventListener('click', () => {
    yamlTA.value = MULTI_SAMPLE;
    yamlTA.dispatchEvent(new Event('input'));
  });
  document.getElementById('btn-paste').addEventListener('click', async () => {
    try { yamlTA.value = await navigator.clipboard.readText(); yamlTA.dispatchEvent(new Event('input')); } catch(_) {}
  });
  document.getElementById('btn-clear').addEventListener('click', () => {
    yamlTA.value = '';
    yamlTA.dispatchEvent(new Event('input'));
  });

  yamlTA.addEventListener('input', () => {
    const v = yamlTA.value;
    const lines = v ? v.split('\n').length : 0;
    const docs  = v ? (v.split(/^---\s*$/m).filter(s => s.trim()).length || 1) : 0;
    document.getElementById('yaml-meta').textContent = v.length.toLocaleString() + ' chars · ' + lines + ' lines';
    if (v.trim()) {
      yamlStatus.innerHTML = `<span class="text-fn-text3">${docs} document${docs !== 1 ? 's' : ''} detected</span>`;
    } else {
      yamlStatus.innerHTML = '<span class="text-fn-text3">Paste YAML to continue</span>';
    }
    refreshConvertBtn();
  });

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
    if (!name.match(/\.(yaml|yml|txt)$/)) {
      showError('Please select a valid YAML file (.yaml or .yml).');
      return;
    }
    if (file.size > 50 * 1024 * 1024) {
      showError('File exceeds the 50MB free limit.');
      return;
    }
    selectedFile = file;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-meta').textContent = formatBytes(file.size) + ' · YAML';
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
    if (activeTab === 'text') convertBtn.disabled = !yamlTA.value.trim();
    else                      convertBtn.disabled = !selectedFile;
  }

  convertBtn.addEventListener('click', startConversion);

  async function startConversion() {
    hideError();
    showState('converting');
    updateStepIndicator(2);
    scrollToCard();

    const indent      = parseInt(indentSlider.value) || 4;
    const sortKeys    = document.getElementById('opt-sort').checked;
    const ensureAscii = document.getElementById('opt-ascii').checked;

    let endpoint, fetchBody, fetchHeaders = {};

    if (activeTab === 'file') {
      endpoint = 'https://api.filenewer.com/api/tools/yaml-file-to-json';
      const fd = new FormData();
      fd.append('file',         selectedFile);
      fd.append('indent',       indent);
      fd.append('sort_keys',    sortKeys);
      fd.append('ensure_ascii', ensureAscii);
      fd.append('output',       'text');
      fetchBody = fd;
    } else {
      endpoint = 'https://api.filenewer.com/api/tools/yaml-text-to-json';
      fetchBody = JSON.stringify({
        yaml:         yamlTA.value,
        indent:       indent,
        sort_keys:    sortKeys,
        ensure_ascii: ensureAscii,
        output:       'text',
      });
      fetchHeaders = { 'Content-Type': 'application/json' };
    }

    setProcessStep('proc-1', 'active');
    animateProgress(0, 30, 400, 'Reading YAML content…');
    const t2 = setTimeout(() => { setProcessStep('proc-1', 'done'); setProcessStep('proc-2', 'active'); animateProgress(30, 55, 400, 'Resolving anchors & aliases…'); }, 400);
    const t3 = setTimeout(() => { setProcessStep('proc-2', 'done'); setProcessStep('proc-3', 'active'); animateProgress(55, 80, 500, 'Converting types to JSON…'); }, 900);
    const t4 = setTimeout(() => { setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'active'); animateProgress(80, 92, 400, 'Formatting output…'); }, 1500);

    try {
      const res = await fetch(endpoint, { method: 'POST', headers: fetchHeaders, body: fetchBody });
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

      if (!res.ok) {
        let msg = 'Conversion failed. Please try again.';
        try { const d = await res.json(); if (d.error) msg = d.error; } catch (_) {}
        throw new Error(msg);
      }

      const data = await res.json();
      jsonOutput = data.json ?? '';
      renderResult(data);

      setProcessStep('proc-3', 'done'); setProcessStep('proc-4', 'done');
      animateProgress(92, 100, 250, 'Done!');
      setTimeout(() => { showState('download'); updateStepIndicator(3); }, 350);

    } catch (err) {
      console.error(err);
      clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
      showError(err.message || 'Something went wrong. Please try again.');
      showState('upload');
      updateStepIndicator(1);
    }
  }

  function renderResult(data) {
    document.getElementById('stat-type').textContent  = data.type ?? '—';
    document.getElementById('stat-keys').textContent  = data.key_count ?? data.item_count ?? 0;
    document.getElementById('stat-docs').textContent  = data.documents ?? 1;
    document.getElementById('stat-size').textContent  = formatSizeKb(data.size_json_kb);

    document.getElementById('json-output').innerHTML = highlightJson(jsonOutput);

    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = URL.createObjectURL(new Blob([jsonOutput], { type: 'application/json;charset=utf-8;' }));
    const baseName = activeTab === 'file' && selectedFile
      ? selectedFile.name.replace(/\.(yaml|yml|txt)$/i, '')
      : 'output';
    const dl = document.getElementById('btn-download');
    dl.href = blobUrl;
    dl.download = baseName + '.json';

    document.getElementById('btn-copy').onclick = async () => {
      try {
        await navigator.clipboard.writeText(jsonOutput);
        document.getElementById('copy-label').textContent = 'Copied!';
        setTimeout(() => { document.getElementById('copy-label').textContent = 'Copy'; }, 2000);
      } catch(_) {}
    };
  }

  // Lightweight JSON syntax highlighter
  function highlightJson(json) {
    if (!json) return '<span style="color:var(--fn-text3)">(empty)</span>';
    const esc = String(json).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    return esc.replace(
      /("(\\u[a-fA-F0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(\.\d+)?([eE][-+]?\d+)?)/g,
      function (match) {
        if (/^"/.test(match)) {
          if (/:$/.test(match)) {
            return '<span class="j-key">' + match.replace(/:\s*$/, '') + '</span><span class="j-mark">:</span>';
          }
          return '<span class="j-str">' + match + '</span>';
        }
        if (/true|false/.test(match)) return '<span class="j-bool">' + match + '</span>';
        if (/null/.test(match))       return '<span class="j-null">' + match + '</span>';
        return '<span class="j-num">' + match + '</span>';
      }
    );
  }

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
    yamlTA.value = '';
    yamlTA.dispatchEvent(new Event('input'));
    indentSlider.value = 4;
    document.getElementById('indent-val').textContent = '4';
    document.getElementById('opt-sort').checked  = false;
    document.getElementById('opt-ascii').checked = false;
    jsonOutput = '';
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
  function formatSizeKb(kb) {
    if (kb === null || kb === undefined) return '—';
    if (kb < 1) return Math.round(kb * 1024) + ' B';
    if (kb >= 1024) return (kb / 1024).toFixed(2) + ' MB';
    return kb.toFixed(2) + ' KB';
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
