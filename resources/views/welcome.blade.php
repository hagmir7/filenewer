@extends('layouts.base')



@section('content')

<!-- ══════════════════════ HERO ══════════════════════ -->
    <section id="hero" class="relative pt-10 md:pt-28 pb-24 text-center overflow-hidden hero-glow hero-grid">
        <div class="max-w-6xl mx-auto px-6 relative z-10">

            <!-- Badge -->
            <div
                class="animate-fade-up opacity-0 delay-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-blue-600 bg-fn-blue/10 text-fn-blue-l text-sm font-semibold tracking-wide uppercase mb-7">
                <span class="w-1.5 h-1.5 rounded-full bg-fn-blue-l animate-pulse-dot"></span>
                Smarter File Processing
            </div>

            <!-- H1 -->
            <h1
                class="animate-fade-up opacity-0 delay-1 text-4xl sm:text-5xl lg:text-[4rem] font-bold tracking-[-0.035em] leading-[1.1] max-w-3xl mx-auto mb-5">
                The Fastest <span class="text-gradient">Online File Tools</span><br />for Modern Work
            </h1>

            <!-- Sub -->
            <p class="animate-fade-up opacity-0 delay-2 text-fn-text2 text-lg max-w-xl mx-auto mb-10 leading-relaxed">
                Convert, generate, compress, and process your business documents in seconds — all in one place. No
                software to install, no hassle.
            </p>

            <!-- CTAs -->
           <div class="animate-fade-up opacity-0 delay-3 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 mb-10 sm:mb-14 px-4">

            <a href="/signup"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 text-sm sm:text-base font-semibold text-white bg-fn-blue rounded-xl hover:bg-fn-blue-l btn-glow hover:-translate-y-0.5 transition-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                </svg>
                Start Free
            </a>

            <a href="#tools"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 sm:px-7 py-3 text-sm sm:text-base font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                Explore Tools
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </a>


            </div>

            <!-- Benefit pills -->
            <div class="animate-fade-up opacity-0 delay-4 flex flex-wrap justify-center gap-x-7 gap-y-3">
                <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Processes files in seconds
                </div>
                <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    End-to-end encrypted
                </div>
                <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    No installation required
                </div>
                <div class="flex items-center gap-2 text-fn-text3 text-sm font-medium">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Works on any device
                </div>
            </div>

        </div>
    </section>

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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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

    <!-- ══════════════════════ WHY ══════════════════════ -->
    <section id="why" class="py-24 bg-fn-bg" aria-labelledby="why-heading">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-16">
                <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Why Filenewer</p>
                <h2 id="why-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Built for speed, trust,
                    and simplicity</h2>
                <p class="text-fn-text2 text-lg max-w-lg leading-relaxed">We stripped away everything that slows you
                    down and left only what matters: fast, reliable, secure file tools.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                <div
                    class="p-7 bg-fn-surface border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                    <div class="text-3xl mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-bolt">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M13 3l0 7l6 0l-8 11l0 -7l-6 0l8 -11" />
                    </svg></div>
                    <h3 class="font-semibold text-base mb-2">Lightning-Fast Processing</h3>
                    <p class="text-fn-text3 text-sm leading-relaxed">Server-side processing powered by optimized
                        infrastructure. Files ready in seconds, not minutes.</p>
                </div>

                <div
                    class="p-7 bg-fn-surface border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                    <div class="text-3xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" />
                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                            <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-base mb-2">Bank-Grade Security</h3>
                    <p class="text-fn-text3 text-sm leading-relaxed">AES-256 encryption on all uploads. Your files are
                        never shared, sold, or stored beyond your session.</p>
                </div>

                <div
                    class="p-7 bg-fn-surface border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                    <div class="text-3xl mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-rocket">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3" />
                        <path d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3" />
                        <path d="M14 9a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    </svg></div>
                    <h3 class="font-semibold text-base mb-2">No Account Required</h3>
                    <p class="text-fn-text3 text-sm leading-relaxed">Access core free file tools instantly. No sign-up,
                        no friction — just drag, drop, and download.</p>
                </div>

                <div
                    class="p-7 bg-fn-surface border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                    <div class="text-3xl mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-sparkles-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M13 7a9.3 9.3 0 0 0 1.516 -.546c.911 -.438 1.494 -1.015 1.937 -1.932c.207 -.428 .382 -.928 .547 -1.522c.165 .595 .34 1.095 .547 1.521c.443 .918 1.026 1.495 1.937 1.933c.426 .205 .925 .38 1.516 .546a9.3 9.3 0 0 0 -1.516 .547c-.911 .438 -1.494 1.015 -1.937 1.932a9 9 0 0 0 -.547 1.521c-.165 -.594 -.34 -1.095 -.547 -1.521c-.443 -.918 -1.026 -1.494 -1.937 -1.932a9 9 0 0 0 -1.516 -.547" />
                        <path
                            d="M3 14a21 21 0 0 0 1.652 -.532c2.542 -.953 3.853 -2.238 4.816 -4.806a20 20 0 0 0 .532 -1.662a20 20 0 0 0 .532 1.662c.963 2.567 2.275 3.853 4.816 4.806q .75 .28 1.652 .532a21 21 0 0 0 -1.652 .532c-2.542 .953 -3.854 2.238 -4.816 4.806a20 20 0 0 0 -.532 1.662a20 20 0 0 0 -.532 -1.662c-.963 -2.568 -2.275 -3.853 -4.816 -4.806a21 21 0 0 0 -1.652 -.532" />
                    </svg></div>
                    <h3 class="font-semibold text-base mb-2">Clean, Focused Interface</h3>
                    <p class="text-fn-text3 text-sm leading-relaxed">A tool you'll actually enjoy using. No bloated
                        menus, no distracting ads — just the task at hand.</p>
                </div>

                <div
                    class="p-7 bg-fn-surface border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                    <div class="text-3xl mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14" />
                        <path d="M11 4h2" />
                        <path d="M12 17v.01" />
                    </svg></div>
                    <h3 class="font-semibold text-base mb-2">Cross-Device Compatible</h3>
                    <p class="text-fn-text3 text-sm leading-relaxed">Works flawlessly on desktop, tablet, and mobile.
                        Process files wherever you are, from any browser.</p>
                </div>

                <div
                    class="p-7 bg-fn-surface border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                    <div class="text-3xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-rotate-rectangle">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.09 4.01l.496 -.495a2 2 0 0 1 2.828 0l7.071 7.07a2 2 0 0 1 0 2.83l-7.07 7.07a2 2 0 0 1 -2.83 0l-7.07 -7.07a2 2 0 0 1 0 -2.83l3.535 -3.535h-3.988" />
                        <path d="M7.05 11.038v-3.988" />
                    </svg></div>
                    <h3 class="font-semibold text-base mb-2">Bulk Processing</h3>
                    <p class="text-fn-text3 text-sm leading-relaxed">Handle tens or hundreds of files at once. Ideal for
                        developers, agencies, and data teams with volume needs.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════════ TOOLS ══════════════════════ -->
    <x-tools-section />

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


@endsection
