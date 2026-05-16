@extends('layouts.base')

@section('content')

{{-- ══ HERO ══ --}}
<section class="relative pt-10 pb-10 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">

        <div class="animate-fade-up opacity-0 delay-1 text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-fn-text tracking-tight leading-tight">
                @if(request('category') && $categories->isNotEmpty())
                @php $categoryTitle = $categories->first()->title; @endphp
                {{ str_contains($categoryTitle, 'Tools') ? $categoryTitle : $categoryTitle . ' Tools' }}
                @else
                The Fastest Online File Tools,<br> For Modern Work
                @endif
            </h1>
        </div>
        {{-- Search bar --}}
        <div class="animate-fade-up opacity-0 delay-2 max-w-2xl mx-auto mb-6">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-fn-text3 w-5 h-5 pointer-events-none"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input id="global-search" type="text" placeholder="Search tools… e.g. PDF, compress, invoice, CSV"
                    class="search-input w-full pl-12 pr-14 py-3.5 bg-fn-surface border border-fn-text/10 rounded-2xl text-fn-text text-base placeholder:text-fn-text3 font-sans transition-all" />
                <kbd
                    class="absolute right-4 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1 px-2 py-1 bg-fn-surface2 border border-fn-text/10 rounded-md text-fn-text3 text-sm font-mono">⌘K</kbd>
            </div>
            <p id="search-count" class="text-fn-text3 text-sm text-center mt-2.5 h-4"></p>
        </div>

        {{-- Stats bar --}}
        <div class="animate-fade-up opacity-0 delay-3 flex items-center justify-center gap-8 flex-wrap">
            @php $totalTools = $categories->sum(fn($c) => $c->tools->count()) @endphp
            <div class="flex items-center gap-2 text-fn-text3 text-sm">
                <span class="w-2 h-2 rounded-full bg-fn-green"></span>
                <span><strong class="text-fn-text font-semibold">{{ $totalTools }}</strong> tools available</span>
            </div>
            <div class="flex items-center gap-2 text-fn-text3 text-sm">
                <span class="w-2 h-2 rounded-full bg-fn-blue-l"></span>
                <span><strong class="text-fn-text font-semibold">{{ $categories->count() }}</strong> categories</span>
            </div>
            <div class="flex items-center gap-2 text-fn-text3 text-sm">
                <span class="w-2 h-2 rounded-full bg-fn-cyan"></span>
                <span><strong class="text-fn-text font-semibold">2M+</strong> files processed</span>
            </div>
            <div class="flex items-center gap-2 text-fn-text3 text-sm">
                <span class="w-2 h-2 rounded-full bg-fn-amber"></span>
                <span><strong class="text-fn-text font-semibold">100%</strong> free to start</span>
            </div>
        </div>

    </div>
</section>

{{-- ══ MAIN LAYOUT ══ --}}
<div class="max-w-7xl mx-auto px-6 pb-24">
    <div class="flex gap-8">

        {{-- ── TOOL GRID ── --}}
        <main class="flex-1 min-w-0 pt-2">

            {{-- Mobile filter button --}}
            <div class="flex items-center justify-between mb-5 lg:hidden">
                <p class="text-fn-text3 text-sm" id="mobile-count">Showing {{ $totalTools }} tools</p>
                <button id="mobile-filter-btn"
                    class="flex items-center gap-2 px-3 py-2 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text2 text-sm font-medium">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                    </svg>
                    Filters
                </button>
            </div>

            {{-- Sort row --}}
            <div class="hidden lg:flex items-center justify-between mb-7">
                <p class="text-fn-text3 text-sm" id="result-count">
                    Showing <strong class="text-fn-text font-semibold">{{ $totalTools }}</strong> tools
                </p>
                <div class="flex items-center gap-2">
                    <span class="text-fn-text3 text-sm">Sort:</span>
                    <select id="sort-select"
                        class="bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-medium rounded-lg px-3 py-1.5 font-sans focus:outline-none focus:border-fn-blue/50 cursor-pointer">
                        <option value="popular">Most Popular</option>
                        <option value="newest">Newest First</option>
                        <option value="az">A → Z</option>
                    </select>
                </div>
            </div>

            {{-- ── CATEGORIES LOOP ── --}}
            @foreach($categories as $category)
            @if($category->tools->isNotEmpty())
            <div class="tool-section mb-10" id="{{ $category->slug }}" data-section="{{ $category->slug }}">

                {{-- Section header --}}
                <div class="flex items-center gap-3 mb-5">
                    <div
                        class="w-8 h-8 rounded-lg bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-base shrink-0">
                        {{ $category->icon }}
                    </div>
                    <h2 class="text-base font-bold tracking-tight">{{ $category->title }}</h2>
                    <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-sm font-mono">
                        {{ $category->tools->count() }}
                    </span>
                    <div class="flex-1 h-px bg-fn-text/7"></div>
                </div>

                {{-- Tools grid --}}
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">
                    @foreach($category->tools as $tool)
                    <a href="/tools/{{ $tool->slug }}"
                        class="tool-card bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                        data-cat="{{ $category->slug }}" data-tags="{{ $tool->tags ?? '' }}"
                        data-name="{{ strtolower($tool->name) }}">

                        {{-- Icon --}}
                        <div
                            class="w-10 h-10 rounded-xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-lg shrink-0">
                            {{ $tool->icon }}
                        </div>

                        {{-- Body --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-semibold text-sm leading-snug">{{ $tool->name }}</h3>

                                {{-- Badges --}}
                                @if(str_contains($tool->tags ?? '', 'popular'))
                                <span
                                    class="badge-popular shrink-0 px-1.5 py-0.5 text-sm font-semibold rounded-full border">🔥</span>
                                @elseif(str_contains($tool->tags ?? '', 'new'))
                                <span
                                    class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-sm font-semibold rounded-full">New</span>
                                @endif
                            </div>
                            <p class="text-fn-text3 text-sm leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($tool->description, 50, '...') }}
                            </p>
                        </div>

                        {{-- Arrow --}}
                        <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </a>
                    @endforeach
                </div>

            </div>
            @endif
            @endforeach

        </main>
    </div>
</div>


<!-- ══════════════════════ FEATURES ══════════════════════ -->
<section id="features" class="py-24 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="features-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Core Product</p>
            <h2 id="features-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Everything you need
                to manage files</h2>
            <p class="text-fn-text2 text-lg max-w-lg mx-auto leading-relaxed">Three powerful toolsets, built for
                teams and individuals who need results without the complexity.</p>
        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-3 gap-px border border-white/[0.07] rounded-2xl overflow-hidden">

            <!-- Card 1 -->
            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group">
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-blue/10 border border-fn-blue/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">File Conversion Tools</h3>
                <p class="text-fn-text2 text-sm leading-relaxed mb-4">Transform any file format in seconds. Our
                    online file converter supports PDF, Word, Excel, CSV, images, and dozens more — with
                    pixel-perfect output every time.</p>
                <span class="inline-block px-2.5 py-1 bg-fn-bg rounded-md text-sm font-mono text-fn-text3">PDF ·
                    DOCX · CSV · JPG · SVG</span>
            </div>

            <!-- Card 2 -->
            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group">
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-cyan/10 border border-fn-cyan/25">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-certificate">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5" />
                        <path d="M3 14a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Business Document Generators</h3>
                <p class="text-fn-text2 text-sm leading-relaxed mb-4">Generate professional invoices, contracts, and
                    reports automatically. Fill in your data and Filenewer produces a clean, print-ready PDF
                    instantly.</p>
                <span class="inline-block px-2.5 py-1 bg-fn-bg rounded-md text-sm font-mono text-fn-text3">Invoices
                    · Contracts · Reports</span>
            </div>

            <!-- Card 3 -->
            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group">
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-green/10 border border-fn-green/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-sparkles-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M13 7a9.3 9.3 0 0 0 1.516 -.546c.911 -.438 1.494 -1.015 1.937 -1.932c.207 -.428 .382 -.928 .547 -1.522c.165 .595 .34 1.095 .547 1.521c.443 .918 1.026 1.495 1.937 1.933c.426 .205 .925 .38 1.516 .546a9.3 9.3 0 0 0 -1.516 .547c-.911 .438 -1.494 1.015 -1.937 1.932a9 9 0 0 0 -.547 1.521c-.165 -.594 -.34 -1.095 -.547 -1.521c-.443 -.918 -1.026 -1.494 -1.937 -1.932a9 9 0 0 0 -1.516 -.547" />
                        <path
                            d="M3 14a21 21 0 0 0 1.652 -.532c2.542 -.953 3.853 -2.238 4.816 -4.806a20 20 0 0 0 .532 -1.662a20 20 0 0 0 .532 1.662c.963 2.567 2.275 3.853 4.816 4.806q .75 .28 1.652 .532a21 21 0 0 0 -1.652 .532c-2.542 .953 -3.854 2.238 -4.816 4.806a20 20 0 0 0 -.532 1.662a20 20 0 0 0 -.532 -1.662c-.963 -2.568 -2.275 -3.853 -4.816 -4.806a21 21 0 0 0 -1.652 -.532" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Smart File Processing</h3>
                <p class="text-fn-text2 text-sm leading-relaxed mb-4">Compress, merge, split, encrypt, and extract
                    content from files with intelligent automation. Handle bulk operations without writing a single
                    line of code.</p>
                <span class="inline-block px-2.5 py-1 bg-fn-bg rounded-md text-sm font-mono text-fn-text3">Compress
                    · Merge · Extract · OCR</span>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ SECURITY ══════════════════════ -->
<section id="security" class="py-24 bg-fn-bg relative overflow-hidden cyan-glow" aria-labelledby="security-heading">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- Left: Copy -->
            <div>
                <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Privacy &amp;
                    Security</p>
                <h2 id="security-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Your files stay
                    private. Always.</h2>
                <p class="text-fn-text2 text-lg leading-relaxed">We built secure file processing into every layer of
                    Filenewer — from upload to deletion, your data is fully protected.</p>

                <div class="flex flex-col gap-5 mt-9">

                    <div class="flex gap-4">
                        <div
                            class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                            🔒</div>
                        <div>
                            <h3 class="font-semibold text-sm mb-1">AES-256 Encryption in Transit</h3>
                            <p class="text-fn-text3 text-sm leading-relaxed">Every file you upload is encrypted over
                                HTTPS using AES-256 — the same standard used by financial institutions worldwide.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                            🗑️</div>
                        <div>
                            <h3 class="font-semibold text-sm mb-1">Automatic File Deletion</h3>
                            <p class="text-fn-text3 text-sm leading-relaxed">Uploaded files are permanently deleted
                                from our servers within 1 hour of processing. No manual action needed.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                            🚫</div>
                        <div>
                            <h3 class="font-semibold text-sm mb-1">Zero Data Sharing</h3>
                            <p class="text-fn-text3 text-sm leading-relaxed">We never share, sell, train on, or
                                access your file contents. Your documents are processed and gone — full stop.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                            🌐</div>
                        <div>
                            <h3 class="font-semibold text-sm mb-1">GDPR-Compliant Infrastructure</h3>
                            <p class="text-fn-text3 text-sm leading-relaxed">Hosted on GDPR-compliant cloud
                                infrastructure. Your data rights are respected regardless of where you are.</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: Status Panel -->
            <div class="security-panel relative bg-fn-surface border border-white/[0.07] rounded-2xl p-8">
                <!-- Terminal chrome -->
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-3 h-3 rounded-full bg-fn-red"></span>
                    <span class="w-3 h-3 rounded-full bg-fn-amber"></span>
                    <span class="w-3 h-3 rounded-full bg-fn-green"></span>
                    <span class="text-fn-text3 text-sm font-mono ml-auto">security-status.log</span>
                </div>

                <!-- Status rows -->
                <div class="flex flex-col gap-3">

                    <div
                        class="flex items-center justify-between px-4 py-3 bg-fn-surface2 rounded-xl border border-white/[0.07]">
                        <span class="flex items-center gap-2.5 text-fn-text2 text-sm">🔒 TLS 1.3 Encryption</span>
                        <span
                            class="flex items-center gap-1.5 text-fn-green text-sm font-mono font-medium before:content-['●'] before:text-[0.5rem]">ACTIVE</span>
                    </div>

                    <div
                        class="flex items-center justify-between px-4 py-3 bg-fn-surface2 rounded-xl border border-white/[0.07]">
                        <span class="flex items-center gap-2.5 text-fn-text2 text-sm">🛡️ AES-256 Storage
                            Enc.</span>
                        <span
                            class="flex items-center gap-1.5 text-fn-green text-sm font-mono font-medium before:content-['●'] before:text-[0.5rem]">ACTIVE</span>
                    </div>

                    <div
                        class="flex items-center justify-between px-4 py-3 bg-fn-surface2 rounded-xl border border-white/[0.07]">
                        <span class="flex items-center gap-2.5 text-fn-text2 text-sm">🗑️ Auto-deletion (1hr)</span>
                        <span
                            class="flex items-center gap-1.5 text-fn-green text-sm font-mono font-medium before:content-['●'] before:text-[0.5rem]">ENABLED</span>
                    </div>

                    <div
                        class="flex items-center justify-between px-4 py-3 bg-fn-surface2 rounded-xl border border-white/[0.07]">
                        <span class="flex items-center gap-2.5 text-fn-text2 text-sm">🚫 Third-party Data
                            Share</span>
                        <span class="text-fn-red text-sm font-mono font-medium">BLOCKED</span>
                    </div>

                    <div
                        class="flex items-center justify-between px-4 py-3 bg-fn-surface2 rounded-xl border border-white/[0.07]">
                        <span class="flex items-center gap-2.5 text-fn-text2 text-sm">🌍 GDPR Compliance</span>
                        <span
                            class="flex items-center gap-1.5 text-fn-green text-sm font-mono font-medium before:content-['●'] before:text-[0.5rem]">VERIFIED</span>
                    </div>

                    <div
                        class="flex items-center justify-between px-4 py-3 bg-fn-surface2 rounded-xl border border-white/[0.07]">
                        <span class="flex items-center gap-2.5 text-fn-text2 text-sm">📊 SOC 2 Audit Trail</span>
                        <span
                            class="flex items-center gap-1.5 text-fn-green text-sm font-mono font-medium before:content-['●'] before:text-[0.5rem]">LOGGING</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ CTA ══════════════════════ -->
<section id="cta" class="py-24 bg-fn-surface border-y border-white/[0.07] text-center relative overflow-hidden"
    aria-labelledby="cta-heading">
    <!-- Glow -->
    <div
        class="absolute top-[-300px] left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-[radial-gradient(ellipse_at_center,rgba(37,99,235,0.14)_0%,transparent_65%)] pointer-events-none">
    </div>

    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Get Started Today</p>
        <h2 id="cta-heading" class="text-3xl sm:text-4xl font-bold tracking-tight max-w-2xl mx-auto mb-4">Start
            processing files smarter — right now</h2>
        <p class="text-fn-text2 text-lg max-w-md mx-auto leading-relaxed mb-10">
            Join thousands of freelancers, developers, and small businesses who rely on Filenewer's online file
            tools every day. No credit card required.
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
            <a href="/tools"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] transition-all">
                Browse All Tools
            </a>
        </div>

        <p class="text-fn-text3 text-sm mt-5">✓ Free to use &nbsp;·&nbsp; ✓ Secure &amp; private &nbsp;·&nbsp; ✓ No
            software to install</p>
    </div>
</section>

<script>
    const allCards   = document.querySelectorAll('.tool-card');
        const sections   = document.querySelectorAll('.tool-section');
        const resultCount = document.getElementById('result-count');
        const mobileCount = document.getElementById('mobile-count');
        const searchInput = document.getElementById('global-search');
        const searchCount = document.getElementById('search-count');

        document.querySelectorAll('.cat-item').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.cat-item').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterTools();
            });
        });

        searchInput.addEventListener('input', filterTools);

        document.addEventListener('keydown', e => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });

        function filterTools() {
            const query     = searchInput.value.toLowerCase().trim();
            const activeCat = document.querySelector('.cat-item.active')?.dataset.cat || 'all';
            const showNew   = document.getElementById('filter-new')?.checked;
            const showPop   = document.getElementById('filter-popular')?.checked;
            const showApi   = document.getElementById('filter-api')?.checked;

            let visible = 0;

            allCards.forEach(card => {
                const cat   = card.dataset.cat   || '';
                const tags  = card.dataset.tags  || '';
                const name  = card.dataset.name  || '';

                const catMatch   = activeCat === 'all' || cat === activeCat;
                const queryMatch = !query || name.includes(query);
                const newMatch   = !showNew  || tags.includes('new');
                const popMatch   = !showPop  || tags.includes('popular');
                const apiMatch   = !showApi  || tags.includes('api');

                const show = catMatch && queryMatch && newMatch && popMatch && apiMatch;
                card.classList.toggle('hidden-card', !show);
                if (show) visible++;
            });

            sections.forEach(sec => {
                const hasVis = [...sec.querySelectorAll('.tool-card')].some(c => !c.classList.contains('hidden-card'));
                sec.style.display = hasVis ? '' : 'none';
            });

            const countText = `Showing <strong class="text-fn-text font-semibold">${visible}</strong> tool${visible !== 1 ? 's' : ''}`;
            if (resultCount) resultCount.innerHTML = countText;
            if (mobileCount) mobileCount.textContent = `Showing ${visible} tools`;
            if (searchCount) searchCount.textContent = query ? `${visible} result${visible !== 1 ? 's' : ''} for "${query}"` : '';
        }

        ['filter-new','filter-popular','filter-api','filter-free'].forEach(id => {
            document.getElementById(id)?.addEventListener('change', filterTools);
        });
</script>

@endsection
