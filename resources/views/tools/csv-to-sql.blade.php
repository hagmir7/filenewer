@extends('layouts.base')

@section('content')

<x-tool-hero :tool="$tool" />

<!-- ══════════════════════ TOOL ══════════════════════ -->
<section id="tool" class="py-16 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="tool-heading">
    <div class="max-w-7xl mx-auto px-6">

        <h2 id="tool-heading" class="sr-only">CSV to SQL Converter Tool</h2>

        <!-- Options Bar -->
        <div class="flex flex-wrap items-center gap-4 mb-6">

            <div class="flex items-center gap-2">
                <label for="sql-dialect" class="text-fn-text3 text-xs font-medium whitespace-nowrap">SQL Dialect</label>
                <select id="sql-dialect"
                    class="bg-fn-bg border border-white/[0.07] text-fn-text2 text-xs font-mono rounded-lg px-3 py-2 focus:outline-none focus:border-fn-blue/50 cursor-pointer">
                    <option value="mysql">MySQL</option>
                    <option value="postgresql">PostgreSQL</option>
                    <option value="sqlite">SQLite</option>
                    <option value="mssql">SQL Server</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label for="table-name" class="text-fn-text3 text-xs font-medium whitespace-nowrap">Table Name</label>
                <input type="text" id="table-name" value="my_table" placeholder="table_name"
                    class="bg-fn-bg border border-white/[0.07] text-fn-text2 text-xs font-mono rounded-lg px-3 py-2 w-36 focus:outline-none focus:border-fn-blue/50" />
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <label class="flex items-center gap-2 cursor-pointer text-fn-text3 text-xs font-medium">
                    <input type="checkbox" id="include-create" checked
                        class="accent-fn-blue w-3.5 h-3.5 cursor-pointer" />
                    Include CREATE TABLE
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-fn-text3 text-xs font-medium">
                    <input type="checkbox" id="batch-inserts" checked
                        class="accent-fn-blue w-3.5 h-3.5 cursor-pointer" />
                    Batch INSERTs
                </label>
            </div>

        </div>

        <!-- Two-Panel Editor -->
        <div class="grid lg:grid-cols-2 gap-4">

            <!-- Input Panel -->
            <div class="flex flex-col">
                <div
                    class="flex items-center justify-between px-4 py-2.5 bg-fn-bg border border-white/[0.07] rounded-t-xl border-b-0">
                    <span class="text-fn-text3 text-xs font-mono">INPUT · CSV</span>
                    <div class="flex items-center gap-2">
                        <!-- Upload button -->
                        <label for="csv-file-input"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all cursor-pointer">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Upload CSV
                        </label>
                        <input type="file" id="csv-file-input" accept=".csv" class="hidden" />
                        <button id="clear-btn"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 transition-all">
                            Clear
                        </button>
                    </div>
                </div>
                <textarea id="csv-input"
                    class="flex-1 min-h-[420px] bg-fn-bg border border-white/[0.07] rounded-b-xl px-4 py-4 text-fn-text2 text-xs font-mono leading-relaxed resize-none focus:outline-none focus:border-fn-blue/40 placeholder-fn-text3/50 transition-colors"
                    placeholder="Paste your CSV here, e.g.

id,name,email,age
1,Alice,alice@example.com,30
2,Bob,bob@example.com,25
3,Carol,carol@example.com,35" spellcheck="false"></textarea>
            </div>

            <!-- Output Panel -->
            <div class="flex flex-col">
                <div
                    class="flex items-center justify-between px-4 py-2.5 bg-fn-bg border border-white/[0.07] rounded-t-xl border-b-0">
                    <span class="text-fn-text3 text-xs font-mono">OUTPUT · SQL</span>
                    <div class="flex items-center gap-2">
                        <button id="copy-btn"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                            </svg>
                            Copy SQL
                        </button>
                        <button id="download-btn"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Download .sql
                        </button>
                    </div>
                </div>
                <textarea id="sql-output" readonly
                    class="flex-1 min-h-[420px] bg-fn-bg border border-white/[0.07] rounded-b-xl px-4 py-4 text-fn-green text-xs font-mono leading-relaxed resize-none focus:outline-none placeholder-fn-text3/50 transition-colors"
                    placeholder="-- Your SQL will appear here automatically as you type..."
                    spellcheck="false"></textarea>
            </div>

        </div>

        <!-- Convert Button + Stats -->
        <div class="flex flex-wrap items-center justify-between gap-4 mt-5">
            <div id="stats-bar" class="flex items-center gap-5 text-fn-text3 text-xs font-mono">
                <span id="stat-rows">0 rows</span>
                <span class="text-white/10">|</span>
                <span id="stat-cols">0 columns</span>
                <span class="text-white/10">|</span>
                <span id="stat-statements">0 statements</span>
            </div>
            <button id="convert-btn"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-white bg-fn-blue rounded-xl hover:bg-fn-blue-l btn-glow hover:-translate-y-0.5 transition-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 18 22 12 16 6" />
                    <polyline points="8 6 2 12 8 18" />
                </svg>
                Convert to SQL
            </button>
        </div>

    </div>
</section>

<!-- ══════════════════════ HOW IT WORKS ══════════════════════ -->
<section id="how" class="py-24 bg-fn-bg" aria-labelledby="how-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">Simple Process</p>
            <h2 id="how-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Three steps to clean SQL
            </h2>
            <p class="text-fn-text2 text-lg max-w-lg mx-auto leading-relaxed">No config, no guesswork. Our converter
                handles column detection, type inference, and formatting automatically.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-px border border-white/[0.07] rounded-2xl overflow-hidden">

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">01</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-blue/10 border border-fn-blue/25">
                    📂</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Upload or Paste CSV</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Drag and drop your CSV file, click to browse, or paste
                    data directly into the input panel. Supports any delimiter and encoding.</p>
            </div>

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">02</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-cyan/10 border border-fn-cyan/25">
                    ⚙️</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Configure Options</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Choose your SQL dialect (MySQL, PostgreSQL, SQLite, SQL
                    Server), set the table name, and toggle CREATE TABLE or batch INSERT options.</p>
            </div>

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">03</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-green/10 border border-fn-green/25">
                    ⬇️</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Copy or Download SQL</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Instantly copy the SQL to your clipboard or download a
                    clean <code class="text-fn-text3 font-mono text-xs">.sql</code> file ready to run against your
                    database.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ FEATURES ══════════════════════ -->
<section id="features" class="py-24 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="features-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-16">
            <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">What's Included</p>
            <h2 id="features-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Built for developers
                and data teams</h2>
            <p class="text-fn-text2 text-lg max-w-lg leading-relaxed">Every feature you actually need, none of the
                bloat.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🧠</div>
                <h3 class="font-semibold text-base mb-2">Smart Type Detection</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Automatically infers INTEGER, VARCHAR, FLOAT, DATE, and
                    BOOLEAN types from your column data — no manual annotation needed.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🗄️</div>
                <h3 class="font-semibold text-base mb-2">Multi-Dialect Support</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Generates syntax-correct SQL for MySQL, PostgreSQL,
                    SQLite, and SQL Server. Backticks, quotes, and types handled per dialect.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">📦</div>
                <h3 class="font-semibold text-base mb-2">Batch INSERT Statements</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Groups rows into efficient multi-row INSERT statements
                    for dramatically faster imports on large datasets.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🛡️</div>
                <h3 class="font-semibold text-base mb-2">SQL Injection Safe</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">All string values are properly escaped before
                    insertion. No raw values pass through unescaped — safe for direct use.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">⚡</div>
                <h3 class="font-semibold text-base mb-2">Instant Conversion</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Converts as you type — no button press required for
                    small files. Handles CSVs with thousands of rows in under a second.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🔒</div>
                <h3 class="font-semibold text-base mb-2">Processed Locally</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">All conversion runs in your browser. Your CSV data
                    never leaves your machine — no server upload, total privacy.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ FAQ ══════════════════════ -->
<section id="faq" class="py-24 bg-fn-bg" aria-labelledby="faq-heading">
    <div class="max-w-3xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">FAQ</p>
            <h2 id="faq-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Common questions</h2>
        </div>

        <div class="flex flex-col gap-3" id="faq-list">

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    What CSV formats are supported?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">Standard comma-separated CSV files with a
                    header row are fully supported. The converter also handles files with semicolon or tab delimiters.
                    Files should be UTF-8 encoded for best results.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Is my data sent to your servers?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">No. All CSV-to-SQL conversion happens
                    entirely in your browser using JavaScript. Your data never leaves your device — no upload, no
                    storage, no logging.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    What's the difference between batch and individual INSERTs?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">Batch INSERTs combine multiple rows into a
                    single statement (e.g. <code
                        class="text-fn-text3 font-mono text-xs">INSERT INTO t VALUES (…),(…),(…)</code>), which is
                    significantly faster for large imports. Individual INSERTs generate one statement per row and are
                    useful when you need granular control or are importing into strict environments.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    How large a CSV file can I convert?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">The free tool handles files up to 5 MB
                    (typically tens of thousands of rows). For larger files or automated bulk processing, consider
                    upgrading to a Pro account for server-side processing with no size limits.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Will the CREATE TABLE statement always be accurate?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">The type inference is based on sampling your
                    data and is accurate for most use cases. We recommend reviewing the CREATE TABLE output before
                    running it in production, especially for columns with mixed or nullable values.</p>
            </details>

        </div>
    </div>
</section>

<!-- ══════════════════════ RELATED TOOLS ══════════════════════ -->
<x-tools-section />

<!-- ══════════════════════ CTA ══════════════════════ -->
<section id="cta" class="py-24 bg-fn-surface border-y border-white/[0.07] text-center relative overflow-hidden"
    aria-labelledby="cta-heading">
    <div
        class="absolute top-[-300px] left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-[radial-gradient(ellipse_at_center,rgba(37,99,235,0.14)_0%,transparent_65%)] pointer-events-none">
    </div>

    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">More Power</p>
        <h2 id="cta-heading" class="text-3xl sm:text-4xl font-bold tracking-tight max-w-2xl mx-auto mb-4">Need bulk
            processing or API access?</h2>
        <p class="text-fn-text2 text-lg max-w-md mx-auto leading-relaxed mb-10">
            Upgrade to Pro for unlimited file sizes, automated CSV-to-SQL pipelines, and API access for your dev stack.
            No credit card to start.
        </p>

        <div class="flex flex-wrap justify-center gap-3">
            <a href="/signup"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-white bg-fn-blue rounded-xl hover:bg-fn-blue-l btn-glow hover:-translate-y-0.5 transition-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                </svg>
                Start Free — No Sign-up Needed
            </a>
            <a href="/pricing"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] transition-all">
                View Pro Plans
            </a>
        </div>

        <p class="text-fn-text3 text-xs mt-5">✓ Free to use &nbsp;·&nbsp; ✓ Runs in browser &nbsp;·&nbsp; ✓ No data
            upload</p>
    </div>
</section>

<!-- ══════════════════════ TOOL SCRIPT ══════════════════════ -->
@push('scripts')
<script>
    (function () {

    // ── DOM refs ──────────────────────────────────────────────
    const csvInput      = document.getElementById('csv-input');
    const sqlOutput     = document.getElementById('sql-output');
    const convertBtn    = document.getElementById('convert-btn');
    const copyBtn       = document.getElementById('copy-btn');
    const downloadBtn   = document.getElementById('download-btn');
    const clearBtn      = document.getElementById('clear-btn');
    const fileInput     = document.getElementById('csv-file-input');
    const dialectSel    = document.getElementById('sql-dialect');
    const tableNameInp  = document.getElementById('table-name');
    const includeCreate = document.getElementById('include-create');
    const batchInserts  = document.getElementById('batch-inserts');
    const statRows      = document.getElementById('stat-rows');
    const statCols      = document.getElementById('stat-cols');
    const statStmts     = document.getElementById('stat-statements');

    const BATCH_SIZE = 100;

    // ── CSV parser ────────────────────────────────────────────
    function parseCSV(text) {
        const lines = text.trim().split(/\r?\n/);
        if (lines.length < 2) return null;
        const sep   = lines[0].includes('\t') ? '\t' : lines[0].includes(';') ? ';' : ',';
        const parse = (line) => {
            const cols = []; let cur = ''; let inQ = false;
            for (let i = 0; i < line.length; i++) {
                const c = line[i];
                if (c === '"') { inQ = !inQ; continue; }
                if (c === sep && !inQ) { cols.push(cur.trim()); cur = ''; continue; }
                cur += c;
            }
            cols.push(cur.trim());
            return cols;
        };
        const headers = parse(lines[0]);
        const rows    = lines.slice(1).filter(l => l.trim()).map(parse);
        return { headers, rows };
    }

    // ── Type inference ────────────────────────────────────────
    function inferType(values, dialect) {
        const sample = values.filter(v => v !== '' && v !== null);
        if (!sample.length) return 'TEXT';
        const isInt    = sample.every(v => /^-?\d+$/.test(v));
        const isFloat  = sample.every(v => /^-?\d+(\.\d+)?$/.test(v));
        const isBool   = sample.every(v => /^(true|false|0|1)$/i.test(v));
        const isDate   = sample.every(v => /^\d{4}-\d{2}-\d{2}$/.test(v));
        if (isInt)   return dialect === 'postgresql' ? 'INTEGER' : 'INT';
        if (isFloat) return 'DECIMAL(18,4)';
        if (isBool)  return dialect === 'postgresql' ? 'BOOLEAN' : 'TINYINT(1)';
        if (isDate)  return 'DATE';
        const maxLen = Math.max(...sample.map(v => v.length));
        return maxLen <= 255 ? `VARCHAR(${Math.min(Math.ceil(maxLen / 50) * 50 + 50, 255)})` : 'TEXT';
    }

    // ── Quote identifier ──────────────────────────────────────
    function qi(name, dialect) {
        if (dialect === 'postgresql' || dialect === 'mssql') return `"${name}"`;
        return `\`${name}\``;
    }

    // ── Escape string value ───────────────────────────────────
    function escVal(v) {
        return v.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
    }

    // ── Format value ──────────────────────────────────────────
    function fmtVal(v, type) {
        if (v === '' || v === null) return 'NULL';
        if (/^(INT|DECIMAL|TINYINT|BOOLEAN|BIGINT|FLOAT|DOUBLE|NUMERIC)/i.test(type)) {
            if (/^(true)$/i.test(v))  return '1';
            if (/^(false)$/i.test(v)) return '0';
            return v;
        }
        return `'${escVal(v)}'`;
    }

    // ── Main convert ──────────────────────────────────────────
    function convert() {
        const raw = csvInput.value.trim();
        if (!raw) { sqlOutput.value = ''; updateStats(0, 0, 0); return; }

        const parsed = parseCSV(raw);
        if (!parsed) { sqlOutput.value = '-- Error: Could not parse CSV. Make sure the file has a header row.'; return; }

        const { headers, rows } = parsed;
        const dialect   = dialectSel.value;
        const tableName = tableNameInp.value.trim() || 'my_table';
        const doBatch   = batchInserts.checked;
        const doCreate  = includeCreate.checked;

        const colTypes  = headers.map((_, i) => inferType(rows.map(r => r[i] ?? ''), dialect));
        const parts     = [];

        // CREATE TABLE
        if (doCreate) {
            const colDefs = headers.map((h, i) => `  ${qi(h, dialect)} ${colTypes[i]}`).join(',\n');
            const drop = dialect === 'postgresql'
                ? `DROP TABLE IF EXISTS ${qi(tableName, dialect)};\n`
                : `DROP TABLE IF EXISTS ${qi(tableName, dialect)};\n`;
            parts.push(`${drop}CREATE TABLE ${qi(tableName, dialect)} (\n${colDefs}\n);`);
        }

        if (!rows.length) { sqlOutput.value = parts.join('\n\n'); return; }

        // INSERT statements
        const colList = headers.map(h => qi(h, dialect)).join(', ');
        let stmtCount = 0;

        if (doBatch) {
            for (let i = 0; i < rows.length; i += BATCH_SIZE) {
                const chunk  = rows.slice(i, i + BATCH_SIZE);
                const values = chunk.map(row =>
                    `  (${headers.map((_, ci) => fmtVal(row[ci] ?? '', colTypes[ci])).join(', ')})`
                ).join(',\n');
                parts.push(`INSERT INTO ${qi(tableName, dialect)} (${colList})\nVALUES\n${values};`);
                stmtCount++;
            }
        } else {
            rows.forEach(row => {
                const vals = headers.map((_, ci) => fmtVal(row[ci] ?? '', colTypes[ci])).join(', ');
                parts.push(`INSERT INTO ${qi(tableName, dialect)} (${colList}) VALUES (${vals});`);
                stmtCount++;
            });
        }

        sqlOutput.value = parts.join('\n\n');
        updateStats(rows.length, headers.length, stmtCount);
    }

    function updateStats(rows, cols, stmts) {
        statRows.textContent  = `${rows.toLocaleString()} row${rows !== 1 ? 's' : ''}`;
        statCols.textContent  = `${cols} column${cols !== 1 ? 's' : ''}`;
        statStmts.textContent = `${stmts.toLocaleString()} statement${stmts !== 1 ? 's' : ''}`;
    }

    // ── Event listeners ───────────────────────────────────────
    convertBtn.addEventListener('click', convert);

    // Live convert on input (debounced)
    let debounce;
    csvInput.addEventListener('input', () => { clearTimeout(debounce); debounce = setTimeout(convert, 300); });
    dialectSel.addEventListener('change', convert);
    tableNameInp.addEventListener('input', () => { clearTimeout(debounce); debounce = setTimeout(convert, 200); });
    includeCreate.addEventListener('change', convert);
    batchInserts.addEventListener('change', convert);

    // File upload
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => { csvInput.value = e.target.result; convert(); };
        reader.readAsText(file);
        fileInput.value = '';
    });

    // Drag & drop on textarea
    csvInput.addEventListener('dragover', e => { e.preventDefault(); csvInput.classList.add('border-fn-blue/50'); });
    csvInput.addEventListener('dragleave', () => { csvInput.classList.remove('border-fn-blue/50'); });
    csvInput.addEventListener('drop', e => {
        e.preventDefault();
        csvInput.classList.remove('border-fn-blue/50');
        const file = e.dataTransfer.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => { csvInput.value = ev.target.result; convert(); };
        reader.readAsText(file);
    });

    // Copy
    copyBtn.addEventListener('click', () => {
        if (!sqlOutput.value) return;
        navigator.clipboard.writeText(sqlOutput.value).then(() => {
            const orig = copyBtn.innerHTML;
            copyBtn.innerHTML = '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied!';
            copyBtn.classList.add('text-fn-green', 'border-fn-green/30');
            setTimeout(() => { copyBtn.innerHTML = orig; copyBtn.classList.remove('text-fn-green', 'border-fn-green/30'); }, 2000);
        });
    });

    // Download
    downloadBtn.addEventListener('click', () => {
        if (!sqlOutput.value) return;
        const blob = new Blob([sqlOutput.value], { type: 'text/plain' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = (tableNameInp.value.trim() || 'output') + '.sql';
        a.click();
        URL.revokeObjectURL(a.href);
    });

    // Clear
    clearBtn.addEventListener('click', () => {
        csvInput.value = '';
        sqlOutput.value = '';
        updateStats(0, 0, 0);
    });

})();
</script>
@endpush

@endsection
