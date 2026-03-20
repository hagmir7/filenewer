<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- SEO Meta -->
    <title>Filenewer – Online File Tools &amp; Converters</title>
    <meta name="description"
        content="Filenewer is your all-in-one platform for online file tools: convert, generate, compress, and process business documents fast and securely. No install needed." />
    <meta name="keywords"
        content="online file tools, file converter online, business document generator, PDF tools online, secure file processing, free file tools" />
    <link rel="canonical" href="https://filenewer.com/" />
    <meta property="og:title" content="Filenewer – Online File Tools &amp; Document Converter" />
    <meta property="og:description"
        content="Convert, generate, compress, and process files in seconds. Fast, secure, and free online file tools for everyone." />
    <meta property="og:type" content="website" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Schema Markup -->
    {{-- <script type="application/ld+json">
        {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Filenewer",
    "url": "https://filenewer.com",
    "description": "Smart online file tools for converting, generating, compressing, and processing business documents securely.",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }
  }
    </script> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    <!-- Tailwind CDN with custom config -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script>
        /*
    ╔══════════════════════════════════════════════════════════════╗
    ║           FILENEWER — TAILWIND COLOR SYSTEM v1.0            ║
    ║                                                              ║
    ║  Save this config block to reuse these colors anywhere.     ║
    ║  Import into tailwind.config.js in your build setup.        ║
    ╚══════════════════════════════════════════════════════════════╝

    BRAND COLORS:
    ─────────────────────────────────────────────────────────────
    fn-bg          #0b0f1a   Main page background (darkest)
    fn-surface     #111827   Card / nav surface
    fn-surface2    #1a2235   Elevated card / inner panels
    fn-surface3    #1f2d45   Hover state for cards
    fn-border      rgba(255,255,255,0.07)  Subtle dividers

    fn-blue        #2563eb   Primary action / brand blue
    fn-blue-light  #3b82f6   Hover / lighter blue
    fn-blue-glow   rgba(37,99,235,0.25)   Focus ring / glow

    fn-cyan        #06b6d4   Accent / secondary
    fn-green       #10b981   Success / active states
    fn-red         #ef4444   Danger / blocked states
    fn-amber       #f59e0b   Warning states

    TEXT COLORS:
    fn-text        #f1f5f9   Primary text
    fn-text2       #94a3b8   Secondary / body text
    fn-text3       #64748b   Muted / placeholder text
    ─────────────────────────────────────────────────────────────
    */
    // tailwind.config = {
    //   theme: {
    //     extend: {
    //       fontFamily: {
    //         sans: ['DM Sans', 'sans-serif'],
    //         mono: ['DM Mono', 'monospace'],
    //       },
    //       colors: {
    //         fn: {
    //           bg:         '#0b0f1a',
    //           surface:    '#111827',
    //           surface2:   '#1a2235',
    //           surface3:   '#1f2d45',
    //           blue:       '#2563eb',
    //           'blue-l':   '#3b82f6',
    //           cyan:       '#06b6d4',
    //           green:      '#10b981',
    //           red:        '#ef4444',
    //           amber:      '#f59e0b',
    //           text:       '#f1f5f9',
    //           text2:      '#94a3b8',
    //           text3:      '#64748b',
    //         }
    //       },
    //       backgroundImage: {
    //         'gradient-brand': 'linear-gradient(135deg, #3b82f6, #06b6d4)',
    //         'grid-lines': `
    //           linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    //           linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px)
    //         `,
    //       },
    //       backgroundSize: {
    //         'grid': '60px 60px',
    //       },
    //       animation: {
    //         'pulse-dot': 'pulseDot 2s ease-in-out infinite',
    //         'fade-up':   'fadeUp 0.7s ease forwards',
    //       },
    //       keyframes: {
    //         pulseDot: {
    //           '0%, 100%': { opacity: '1', transform: 'scale(1)' },
    //           '50%':      { opacity: '0.5', transform: 'scale(1.4)' },
    //         },
    //         fadeUp: {
    //           from: { opacity: '0', transform: 'translateY(24px)' },
    //           to:   { opacity: '1', transform: 'translateY(0)' },
    //         }
    //       },
    //       boxShadow: {
    //         'blue-glow':  '0 0 0 6px rgba(37,99,235,0.25)',
    //         'card-hover': '0 8px 32px rgba(0,0,0,0.35)',
    //       },
    //     }
    //   }
    // }
    </script>


</head>

<body class="font-sans bg-fn-bg text-fn-text antialiased overflow-x-hidden">

    <!-- ══════════════════════ NAV ══════════════════════ -->
    <nav class="sticky top-0 z-50 border-b border-white/[0.07] backdrop-blur-xl bg-fn-bg/85">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 font-bold text-xl tracking-tight text-fn-text">
                <div class="w-8 h-8 bg-fn-blue rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="9" y1="13" x2="15" y2="13" />
                        <line x1="9" y1="17" x2="13" y2="17" />
                    </svg>
                </div>
                Filenewer
            </a>

            <!-- Links -->
            <ul class="hidden md:flex items-center gap-8 list-none">
                <li><a href="#features"
                        class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Features</a></li>
                <li><a href="#tools"
                        class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Tools</a></li>
                <li><a href="#security"
                        class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Security</a></li>
                <li><a href="/blog"
                        class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Blog</a></li>
            </ul>

            <!-- CTAs -->
           <div class="flex items-center gap-3">
            @if (auth()->user())

            <a href="/my-files"
                class="inline-flex gap-2 items-center px-4 py-2 text-sm font-semibold text-white bg-fn-blue rounded-lg hover:bg-fn-blue-l btn-glow transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                </svg>
                <span>My Files</span>
            </a>

            <a href="{{ route('logout') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 hover:bg-fn-red/5 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Logout</span>
            </a>

            @else

            <a href="/login"
                class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                Sign In
            </a>

            <a href="/signup"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-fn-blue rounded-lg hover:bg-fn-blue-l btn-glow transition-all">
                Start Free
            </a>

            @endif
        </div>
        </div>
    </nav>

    @yield('content')

    <!-- ══════════════════════ FOOTER ══════════════════════ -->
    <footer class="bg-fn-bg border-t border-white/[0.07] pt-14 pb-8" role="contentinfo">
        <div class="max-w-6xl mx-auto px-6">

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

                <!-- Brand -->
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center gap-2 font-bold text-lg tracking-tight text-fn-text mb-3">
                        <div class="w-7 h-7 bg-fn-blue rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        Filenewer
                    </a>
                    <p class="text-fn-text3 text-sm leading-relaxed max-w-[220px]">Smarter File Processing. Convert,
                        generate, and manage your business files fast, free, and securely.</p>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-4">Product</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="/tools" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">All
                                Tools</a></li>
                        <li><a href="/tools/pdf" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">PDF
                                Tools Online</a></li>
                        <li><a href="/tools/converters"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">File Converter
                                Online</a></li>
                        <li><a href="/tools/generators"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Document
                                Generators</a></li>

                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-4">Company</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="/about"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">About</a></li>
                        <li><a href="/blog" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Blog</a>
                        </li>
                        <li><a href="/contact"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Contact</a></li>
                        <li><a href="/sitemap.xml"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Sitemap</a></li>
                        <li><a href="/changelog"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Changelog</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-4">Legal</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="/privacy"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Privacy Policy</a>
                        </li>
                        <li><a href="/terms" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Terms of
                                Service</a></li>
                        <li><a href="/gdpr" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">GDPR</a>
                        </li>
                        <li><a href="/security"
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Security</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom bar -->
            <div class="pt-7 border-t border-white/[0.07] flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-fn-text3 text-xs">© 2025 Filenewer. All rights reserved.</p>
                <ul class="flex items-center gap-5 list-none">
                    <li><a href="/privacy"
                            class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Privacy</a></li>
                    <li><a href="/terms" class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Terms</a>
                    </li>
                    <li><a href="/sitemap.xml"
                            class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Sitemap</a></li>
                    <li><a href="/contact"
                            class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Contact</a></li>
                </ul>
            </div>

        </div>
    </footer>

</body>

</html>
