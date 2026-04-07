@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush

@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ MAIN CARD ══ --}}
<section class="pb-16">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- ── Mode tabs ── --}}
            <div class="flex items-center gap-1 p-2 border-b border-fn-text/7 bg-fn-surface2">
                <button type="button" id="tab-single"
                    class="tab-btn active flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    Single Convert
                </button>
                <button type="button" id="tab-batch"
                    class="tab-btn flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6" />
                        <line x1="8" y1="12" x2="21" y2="12" />
                        <line x1="8" y1="18" x2="21" y2="18" />
                        <line x1="3" y1="6" x2="3.01" y2="6" />
                        <line x1="3" y1="12" x2="3.01" y2="12" />
                        <line x1="3" y1="18" x2="3.01" y2="18" />
                    </svg>
                    Batch Convert
                </button>
                {{-- Live clock --}}
                <div class="ml-auto flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/8 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    <span class="text-sm font-mono font-semibold text-fn-text2" id="live-clock">—</span>
                    <span class="text-fn-text3 text-sm" id="live-unix">—</span>
                </div>
            </div>

            <div class="p-6 lg:p-8">

                {{-- ══ TIMEZONE BAR (shared) ══ --}}
                <div
                    class="flex flex-wrap items-center gap-3 mb-6 p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <label class="text-sm font-semibold text-fn-text2 shrink-0">From</label>
                        <select id="from-tz"
                            class="flex-1 bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1.5 font-sans focus:outline-none cursor-pointer min-w-0">
                        </select>
                    </div>
                    <button type="button" id="swap-tz"
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue-l hover:border-fn-blue/30 transition-all shrink-0"
                        title="Swap timezones">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="17 1 21 5 17 9" />
                            <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                            <polyline points="7 23 3 19 7 15" />
                            <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <label class="text-sm font-semibold text-fn-text2 shrink-0">To</label>
                        <select id="to-tz"
                            class="flex-1 bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-2 py-1.5 font-sans focus:outline-none cursor-pointer min-w-0">
                        </select>
                    </div>
                    <div class="flex items-center gap-1.5 text-sm text-fn-text3 shrink-0">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="2" y1="12" x2="22" y2="12" />
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                        <span id="tz-detected-label">Detected from browser</span>
                    </div>
                </div>

                {{-- ══ SINGLE TAB ══ --}}
                <div id="panel-single">

                    {{-- Input row --}}
                    <div class="flex gap-2 mb-4">
                        <div class="relative flex-1">
                            <input type="text" id="single-input"
                                placeholder="Enter timestamp, date, or try: now · today · yesterday · tomorrow"
                                class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm rounded-xl px-4 py-3 pr-24 font-mono focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 placeholder:font-sans" />
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex gap-1.5">
                                <button type="button" id="btn-now"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-blue-l hover:border-fn-blue/30 text-sm font-semibold rounded-lg transition-all">
                                    Now
                                </button>
                                <button type="button" id="btn-clear-single"
                                    class="px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-red text-sm font-semibold rounded-lg transition-all">
                                    ✕
                                </button>
                            </div>
                        </div>
                        <button type="button" id="single-convert-btn"
                            class="flex items-center gap-2 px-5 py-3 bg-fn-blue text-white text-sm font-bold rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 shrink-0"
                            disabled>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                            </svg>
                            Convert
                        </button>
                    </div>

                    {{-- Quick format examples --}}
                    <div class="flex flex-wrap gap-1.5 mb-6">
                        <span class="text-sm text-fn-text3 mr-1 self-center">Try:</span>
                        @php
                        $quickExamples = [
                        '1704067200', '2024-01-01T00:00:00Z', 'now', 'today', 'yesterday',
                        '2024-06-01 12:00:00', '01/15/2024',
                        ];
                        @endphp
                        @foreach($quickExamples as $ex)
                        <button type="button"
                            class="example-btn px-2 py-0.5 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text hover:border-fn-blue/25 text-sm font-mono rounded-lg transition-all"
                            data-val="{{ $ex }}">{{ $ex }}</button>
                        @endforeach
                    </div>

                    {{-- Error --}}
                    <div id="single-error"
                        class="hidden mb-4 flex items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-red">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="single-error-text"></span>
                    </div>

                    {{-- Result grid --}}
                    <div id="single-result" class="hidden">

                        {{-- Header meta --}}
                        <div class="flex flex-wrap items-center gap-2 mb-4 px-1">
                            <span class="text-sm font-mono text-fn-text3" id="res-input-label"></span>
                            <span class="text-fn-text3 text-sm">→</span>
                            <span class="text-sm font-semibold text-fn-text2" id="res-tz-label"></span>
                            <span id="res-dst-badge"
                                class="hidden text-sm px-2 py-0.5 bg-fn-amber/12 border border-fn-amber/30 text-fn-amber rounded-md font-semibold">DST</span>
                            <span class="text-sm text-fn-text3 ml-auto" id="res-relative"></span>
                        </div>

                        {{-- Format cards grid --}}
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2" id="format-cards"></div>

                    </div>

                    {{-- Loading shimmer --}}
                    <div id="single-loading" class="hidden grid sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        @for($i = 0; $i < 12; $i++) <div
                            class="h-14 bg-fn-surface2 rounded-xl animate-pulse border border-fn-text/5">
                    </div>
                    @endfor
                </div>

            </div>{{-- /panel-single --}}

            {{-- ══ BATCH TAB ══ --}}
            <div id="panel-batch" class="hidden">

                <div class="grid lg:grid-cols-2 gap-6">

                    {{-- Input --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-fn-text2">Input Values <span
                                    class="font-normal text-fn-text3 ml-1">(one per line)</span></p>
                            <div class="flex gap-2">
                                <button type="button" id="btn-load-examples"
                                    class="text-sm text-fn-blue-l hover:underline font-semibold">Load examples</button>
                                <button type="button" id="btn-clear-batch"
                                    class="text-sm text-fn-text3 hover:text-fn-red font-semibold">Clear</button>
                            </div>
                        </div>
                        <textarea id="batch-input" rows="14" spellcheck="false"
                            placeholder="1704067200&#10;2024-01-15T08:30:00Z&#10;now&#10;yesterday&#10;2024-06-01 12:00:00"
                            class="w-full bg-fn-surface2 border border-fn-text/10 text-fn-text text-sm font-mono rounded-xl px-4 py-3 focus:outline-none focus:border-fn-blue/40 placeholder:text-fn-text3/40 resize-none leading-relaxed"></textarea>
                        <button type="button" id="batch-convert-btn"
                            class="w-full flex items-center justify-center gap-2 py-3 bg-fn-blue text-white text-sm font-bold rounded-xl transition-all hover:bg-fn-blue-l disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                            </svg>
                            Convert All
                        </button>
                    </div>

                    {{-- Results --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-fn-text2">Results</p>
                            <div class="flex gap-2">
                                <span id="batch-stats" class="hidden text-sm text-fn-text3"></span>
                                <button type="button" id="btn-copy-batch"
                                    class="hidden flex items-center gap-1 px-2 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text text-sm font-semibold rounded-lg transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" />
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                    </svg>
                                    <span id="batch-copy-label">Copy JSON</span>
                                </button>
                                <a id="btn-download-batch" href="#" download="timestamps.json"
                                    class="hidden flex items-center gap-1 px-2 py-1 bg-fn-green/10 border border-fn-green/25 text-fn-green text-sm font-semibold rounded-lg hover:bg-fn-green/20 transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    Download JSON
                                </a>
                            </div>
                        </div>

                        <div id="batch-results-wrap" class="space-y-2 max-h-96 overflow-y-auto pr-1">
                            <div id="batch-placeholder"
                                class="flex flex-col items-center justify-center h-48 text-fn-text3 text-sm gap-2 border-2 border-dashed border-fn-text/8 rounded-xl">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Results will appear here
                            </div>
                        </div>

                        <div id="batch-error"
                            class="hidden flex items-center gap-2 px-3 py-2 bg-fn-red/8 border border-fn-red/25 rounded-lg text-sm text-fn-red">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                            </svg>
                            <span id="batch-error-text"></span>
                        </div>
                    </div>

                </div>
            </div>{{-- /panel-batch --}}

        </div>{{-- /card body --}}
    </div>{{-- /card --}}
    </div>
</section>


{{-- ══ FORMAT REFERENCE ══ --}}
<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Accepted Input Formats</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php
            $inputFormats = [
            ['Unix seconds', '1704067200', 'Standard Unix timestamp'],
            ['Unix milliseconds','1704067200000', '13-digit timestamp'],
            ['ISO 8601', '2024-01-01T00:00:00Z', 'With UTC suffix'],
            ['ISO 8601 offset', '2024-01-01T03:00:00+03:00', 'With timezone offset'],
            ['Date + time', '2024-01-01 12:00:00', 'Space-separated'],
            ['Date only', '2024-01-01', 'YYYY-MM-DD'],
            ['US format', '01/15/2024', 'MM/DD/YYYY'],
            ['EU format', '15/01/2024', 'DD/MM/YYYY'],
            ['Human readable', 'January 01, 2024', 'Long date'],
            ['RFC 2822', 'Mon, 01 Jan 2024 00:00:00 +0000', 'Email header format'],
            ['Relative — now', 'now / today', 'Current moment'],
            ['Relative — past', 'yesterday / tomorrow', 'Relative days'],
            ];
            @endphp
            @foreach($inputFormats as [$label,$example,$desc])
            <div class="p-3 bg-fn-surface border border-fn-text/8 rounded-xl">
                <p class="text-sm font-semibold text-fn-text2 mb-1">{{ $label }}</p>
                <p class="text-sm font-mono text-fn-blue-l mb-1">{{ $example }}</p>
                <p class="text-sm text-fn-text3">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

@push('styles')
    {{-- ══ STYLES ══ --}}
    <style>
        .tab-btn {
            color: var(--fn-text3);
        }

        .tab-btn.active {
            background: var(--fn-surface);
            color: var(--fn-text);
            box-shadow: 0 1px 6px oklch(0% 0 0/14%);
        }

        .format-card {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 10px 14px;
            background: var(--fn-surface2);
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
            border-radius: 12px;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            position: relative;
        }

        .format-card:hover {
            border-color: oklch(49% 0.24 264/30%);
            background: oklch(49% 0.24 264/4%);
        }

        .format-card .card-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--fn-text3);
        }

        .format-card .card-value {
            font-size: 12px;
            font-weight: 600;
            color: var(--fn-text);
            font-family: monospace;
            word-break: break-all;
        }

        .format-card .card-copy {
            position: absolute;
            top: 8px;
            right: 10px;
            opacity: 0;
            font-size: 10px;
            color: var(--fn-blue-l);
            font-weight: 600;
            transition: opacity .15s;
        }

        .format-card:hover .card-copy {
            opacity: 1;
        }

        .format-card.copied {
            border-color: oklch(67% 0.18 162/40%);
            background: oklch(67% 0.18 162/6%);
        }

        .batch-result-card {
            padding: 10px 14px;
            background: var(--fn-surface2);
            border: 1px solid oklch(var(--fn-text-l, 80%) 0 0/8%);
            border-radius: 10px;
            transition: all .15s;
        }

        .batch-result-card.success {
            border-left: 3px solid oklch(67% 0.18 162);
        }

        .batch-result-card.failed {
            border-left: 3px solid oklch(62% 0.22 25);
            background: oklch(62% 0.22 25/5%);
        }

        .example-btn:hover {
            background: oklch(49% 0.24 264/8%);
        }
    </style>
@endpush

@push('footer')
    {{-- ══ JAVASCRIPT ══ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

      // ── Timezone list ──
      const TIMEZONES = [
        ['UTC',                  'UTC'],
        ['Asia/Riyadh',          'Saudi Arabia (AST +3)'],
        ['Asia/Dubai',           'UAE (+4)'],
        ['Asia/Karachi',         'Pakistan (+5)'],
        ['Asia/Kolkata',         'India (+5:30)'],
        ['Asia/Dhaka',           'Bangladesh (+6)'],
        ['Asia/Bangkok',         'Thailand (+7)'],
        ['Asia/Shanghai',        'China (+8)'],
        ['Asia/Tokyo',           'Japan (+9)'],
        ['Asia/Seoul',           'South Korea (+9)'],
        ['Australia/Sydney',     'Australia AEST (+10/11)'],
        ['Pacific/Auckland',     'New Zealand (+12/13)'],
        ['Europe/London',        'UK (GMT/BST)'],
        ['Europe/Paris',         'France (CET +1/2)'],
        ['Europe/Berlin',        'Germany (CET +1/2)'],
        ['Europe/Moscow',        'Russia Moscow (+3)'],
        ['Africa/Cairo',         'Egypt (+2/3)'],
        ['Africa/Nairobi',       'Kenya (+3)'],
        ['Africa/Lagos',         'Nigeria (+1)'],
        ['Africa/Johannesburg',  'South Africa (+2)'],
        ['America/New_York',     'US Eastern'],
        ['America/Chicago',      'US Central'],
        ['America/Denver',       'US Mountain'],
        ['America/Los_Angeles',  'US Pacific'],
        ['America/Toronto',      'Canada Eastern'],
        ['America/Vancouver',    'Canada Pacific'],
        ['America/Sao_Paulo',    'Brazil (-3)'],
        ['America/Mexico_City',  'Mexico (-6/-5)'],
        ['America/Argentina/Buenos_Aires', 'Argentina (-3)'],
      ];

      // Detect browser timezone
      const browserTz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';

      // Populate selects
      function populateTzSelect(selectEl, defaultTz) {
        selectEl.innerHTML = '';
        let found = false;
        TIMEZONES.forEach(([tz, label]) => {
          const opt = document.createElement('option');
          opt.value       = tz;
          opt.textContent = `${tz} — ${label}`;
          if (tz === defaultTz) { opt.selected = true; found = true; }
          selectEl.appendChild(opt);
        });
        // If browser tz not in list, prepend it
        if (!found) {
          const opt = document.createElement('option');
          opt.value       = defaultTz;
          opt.textContent = defaultTz + ' — Your timezone';
          opt.selected    = true;
          selectEl.insertBefore(opt, selectEl.firstChild);
        }
      }

      const fromTzEl = document.getElementById('from-tz');
      const toTzEl   = document.getElementById('to-tz');
      populateTzSelect(fromTzEl, 'UTC');
      populateTzSelect(toTzEl,   browserTz);
      document.getElementById('tz-detected-label').textContent = `To: ${browserTz} (detected)`;

      // Swap
      document.getElementById('swap-tz').addEventListener('click', () => {
        const tmp = fromTzEl.value;
        fromTzEl.value = toTzEl.value;
        toTzEl.value   = tmp;
      });

      // ── Tab switching ──
      document.getElementById('tab-single').addEventListener('click', () => switchTab('single'));
      document.getElementById('tab-batch').addEventListener('click',  () => switchTab('batch'));

      function switchTab(tab) {
        document.getElementById('tab-single').classList.toggle('active', tab === 'single');
        document.getElementById('tab-batch').classList.toggle('active',  tab === 'batch');
        document.getElementById('panel-single').classList.toggle('hidden', tab !== 'single');
        document.getElementById('panel-batch').classList.toggle('hidden',  tab !== 'batch');
      }

      // ── Live clock ──
      function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').textContent = now.toLocaleTimeString();
        document.getElementById('live-unix').textContent  = '· ' + Math.floor(now.getTime() / 1000);
      }
      updateClock();
      setInterval(updateClock, 1000);

      // ── Single tab ──
      const singleInput  = document.getElementById('single-input');
      const singleBtn    = document.getElementById('single-convert-btn');
      let   debounceTimer = null;

      singleInput.addEventListener('input', () => {
        singleBtn.disabled = !singleInput.value.trim();
        // Auto-convert with debounce
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          if (singleInput.value.trim()) doSingleConvert();
        }, 600);
      });

      singleInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') { clearTimeout(debounceTimer); doSingleConvert(); }
      });

      singleBtn.addEventListener('click', () => { clearTimeout(debounceTimer); doSingleConvert(); });

      document.getElementById('btn-now').addEventListener('click', () => {
        singleInput.value = 'now';
        singleBtn.disabled = false;
        clearTimeout(debounceTimer);
        doSingleConvert();
      });

      document.getElementById('btn-clear-single').addEventListener('click', () => {
        singleInput.value = '';
        singleBtn.disabled = true;
        document.getElementById('single-result').classList.add('hidden');
        document.getElementById('single-error').classList.add('hidden');
        document.getElementById('single-loading').classList.add('hidden');
      });

      document.querySelectorAll('.example-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          singleInput.value = btn.dataset.val;
          singleBtn.disabled = false;
          clearTimeout(debounceTimer);
          doSingleConvert();
        });
      });

      // Re-convert when timezones change
      fromTzEl.addEventListener('change', () => { if (singleInput.value.trim()) doSingleConvert(); });
      toTzEl.addEventListener('change',   () => { if (singleInput.value.trim()) doSingleConvert(); });

      async function doSingleConvert() {
        const value = singleInput.value.trim();
        if (!value) return;

        document.getElementById('single-error').classList.add('hidden');
        document.getElementById('single-result').classList.add('hidden');
        document.getElementById('single-loading').classList.remove('hidden');

        try {
          const payload = {
            value,
            from_tz: fromTzEl.value,
            to_tz:   toTzEl.value,
          };

          const res  = await fetch('https://api.filenewer.com/api/tools/timestamp', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || data.detail || 'Conversion failed.');

          renderSingleResult(data);
        } catch(err) {
          document.getElementById('single-loading').classList.add('hidden');
          document.getElementById('single-error-text').textContent = err.message;
          document.getElementById('single-error').classList.remove('hidden');
          document.getElementById('single-error').classList.add('flex');
        }
      }

      function renderSingleResult(data) {
        document.getElementById('single-loading').classList.add('hidden');
        const f = data.formats ?? {};

        document.getElementById('res-input-label').textContent = data.input ?? '';
        document.getElementById('res-tz-label').textContent    =
          `${data.from_timezone ?? ''} → ${data.to_timezone ?? ''}  ·  UTC${f.utc_offset ?? ''}`;
        document.getElementById('res-relative').textContent = f.relative ?? '';

        const dstBadge = document.getElementById('res-dst-badge');
        data.is_dst ? dstBadge.classList.remove('hidden') : dstBadge.classList.add('hidden');

        // Format cards
        const formatDefs = [
          ['Human Readable',   f.human_readable],
          ['ISO 8601',         f.iso_8601],
          ['ISO 8601 UTC',     f.iso_8601_utc],
          ['RFC 2822',         f.rfc_2822],
          ['RFC 3339',         f.rfc_3339],
          ['Unix Seconds',     f.unix_seconds],
          ['Unix Milliseconds',f.unix_ms],
          ['Unix Nanoseconds', f.unix_ns],
          ['Date Only',        f.date_only],
          ['Time Only',        f.time_only],
          ['Local DateTime',   f.datetime_local],
          ['Day of Week',      f.day_of_week],
          ['Day of Year',      f.day_of_year],
          ['Week Number',      'Week ' + f.week_number],
          ['Quarter',          f.quarter],
          ['UTC Offset',       f.utc_offset],
        ];

        const container = document.getElementById('format-cards');
        container.innerHTML = '';
        formatDefs.forEach(([label, value]) => {
          if (value == null) return;
          const card = document.createElement('div');
          card.className = 'format-card';
          card.innerHTML = `
            <span class="card-label">${label}</span>
            <span class="card-value">${value}</span>
            <span class="card-copy">Copy</span>`;
          card.addEventListener('click', () => {
            navigator.clipboard.writeText(String(value)).catch(() => {});
            card.classList.add('copied');
            card.querySelector('.card-copy').textContent = 'Copied!';
            setTimeout(() => {
              card.classList.remove('copied');
              card.querySelector('.card-copy').textContent = 'Copy';
            }, 1500);
          });
          container.appendChild(card);
        });

        document.getElementById('single-result').classList.remove('hidden');
      }

      // ── Batch tab ──
      const batchInput = document.getElementById('batch-input');
      const batchBtn   = document.getElementById('batch-convert-btn');
      let   batchBlob  = null;

      batchInput.addEventListener('input', () => {
        batchBtn.disabled = !batchInput.value.trim();
      });

      document.getElementById('btn-load-examples').addEventListener('click', () => {
        batchInput.value = '1704067200\n2024-01-15T08:30:00Z\nnow\nyesterday\n2024-06-01 12:00:00';
        batchBtn.disabled = false;
      });

      document.getElementById('btn-clear-batch').addEventListener('click', () => {
        batchInput.value = '';
        batchBtn.disabled = true;
        document.getElementById('batch-placeholder').classList.remove('hidden');
        document.getElementById('batch-stats').classList.add('hidden');
        document.getElementById('btn-copy-batch').classList.add('hidden');
        document.getElementById('btn-download-batch').classList.add('hidden');
        document.getElementById('batch-error').classList.add('hidden');
        // Remove result cards
        const wrap = document.getElementById('batch-results-wrap');
        wrap.querySelectorAll('.batch-result-card').forEach(el => el.remove());
      });

      batchBtn.addEventListener('click', doBatchConvert);

      async function doBatchConvert() {
        const raw    = batchInput.value.trim();
        if (!raw) return;
        const values = raw.split('\n').map(l => l.trim()).filter(Boolean);

        batchBtn.disabled = true;
        batchBtn.innerHTML = `<svg class="spin w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Converting…`;

        document.getElementById('batch-error').classList.add('hidden');
        document.getElementById('batch-placeholder').classList.add('hidden');
        const wrap = document.getElementById('batch-results-wrap');
        wrap.querySelectorAll('.batch-result-card').forEach(el => el.remove());

        try {
          const res  = await fetch('https://api.filenewer.com/api/tools/timestamp/batch', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({
              values,
              from_tz: fromTzEl.value,
              to_tz:   toTzEl.value,
            }),
          });
          const data = await res.json();
          if (!res.ok) throw new Error(data.error || 'Batch conversion failed.');

          const results = data.results ?? [];

          // Stats
          document.getElementById('batch-stats').textContent =
            `${data.success ?? results.filter(r=>r.success).length} success · ${data.failed ?? results.filter(r=>!r.success).length} failed`;
          document.getElementById('batch-stats').classList.remove('hidden');

          // Render cards
          results.forEach(result => {
            const card = document.createElement('div');
            card.className = 'batch-result-card ' + (result.success ? 'success' : 'failed');

            if (result.success) {
              const f = result.formats ?? {};
              card.innerHTML = `
                <div class="flex items-start justify-between gap-2 mb-1.5">
                  <span class="text-sm font-mono text-fn-text3 truncate">${escHtml(String(result.input))}</span>
                  <span class="text-sm text-fn-text3 shrink-0">${f.relative ?? ''}</span>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-0.5">
                  <div class="flex gap-1.5"><span class="text-fn-text3" style="font-size:10px">ISO</span><span class="font-mono text-fn-text2" style="font-size:10px">${f.iso_8601 ?? '—'}</span></div>
                  <div class="flex gap-1.5"><span class="text-fn-text3" style="font-size:10px">Unix</span><span class="font-mono text-fn-text2" style="font-size:10px">${f.unix_seconds ?? '—'}</span></div>
                  <div class="flex gap-1.5"><span class="text-fn-text3" style="font-size:10px">Human</span><span class="font-mono text-fn-text2" style="font-size:10px">${f.human_readable ?? '—'}</span></div>
                  <div class="flex gap-1.5"><span class="text-fn-text3" style="font-size:10px">UTC offset</span><span class="font-mono text-fn-text2" style="font-size:10px">${f.utc_offset ?? '—'}</span></div>
                </div>`;
            } else {
              card.innerHTML = `
                <div class="flex items-center gap-2">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-red shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                  <span class="text-sm font-mono text-fn-text3">${escHtml(String(result.input))}</span>
                  <span class="text-sm text-fn-red ml-auto">${escHtml(result.error ?? 'Failed')}</span>
                </div>`;
            }
            wrap.appendChild(card);
          });

          // Copy / Download
          const jsonStr = JSON.stringify(data, null, 2);
          if (batchBlob) URL.revokeObjectURL(batchBlob.url);
          const blob = new Blob([jsonStr], { type: 'application/json' });
          const url  = URL.createObjectURL(blob);
          batchBlob  = { url };

          const copyBtn = document.getElementById('btn-copy-batch');
          const dlBtn   = document.getElementById('btn-download-batch');
          copyBtn.classList.remove('hidden');
          dlBtn.classList.remove('hidden');
          dlBtn.href     = url;
          dlBtn.download = 'timestamps.json';

          copyBtn.onclick = async () => {
            await navigator.clipboard.writeText(jsonStr).catch(() => {});
            document.getElementById('batch-copy-label').textContent = 'Copied!';
            setTimeout(() => { document.getElementById('batch-copy-label').textContent = 'Copy JSON'; }, 2000);
          };

        } catch(err) {
          document.getElementById('batch-error-text').textContent = err.message;
          document.getElementById('batch-error').classList.remove('hidden');
          document.getElementById('batch-error').classList.add('flex');
          document.getElementById('batch-placeholder').classList.remove('hidden');
        } finally {
          batchBtn.disabled = false;
          batchBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Convert All`;
        }
      }

      function escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
      }

    }); // end DOMContentLoaded
    </script>
@endpush

@endsection
