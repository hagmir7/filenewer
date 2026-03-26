<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- SEO Meta -->
    <title>@if (isset($title)) {{ $title }} @else Filenewer – Online File Tools &amp; Converters @endif</title>
    <meta name="description"
        content="Filenewer is your all-in-one platform for online file tools: convert, generate, compress, and process business documents fast and securely. No install needed." />
    <meta name="keywords"
        content="online file tools, file converter online, business document generator, PDF tools online, secure file processing, free file tools" />
    <link rel="canonical" href="https://filenewer.com/" />
    <meta property="og:title" content="Filenewer – Online File Tools &amp; Document Converter" />
    <meta property="og:description" content="Convert, generate, compress, and process files in seconds. Fast, secure, and free online file tools for everyone." />
    <meta property="og:type" content="website" />

    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Filenewer" />
    {{-- <link rel="manifest" href="/site.webmanifest" /> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans bg-fn-bg text-fn-text antialiased overflow-x-hidden">

    <!-- ══════════════════════ NAV ══════════════════════ -->
    <nav class="sticky top-0 z-50 border-b border-white/[0.07] backdrop-blur-xl bg-fn-bg/85">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

            <!-- Logo -->
                <img src="/filenewer-logo.svg" alt="Filenewer" class="h-[54px] md:h-[57px]">
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
                class="inline-flex gap-2 items-center px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-semibold text-white bg-fn-blue rounded-lg hover:bg-fn-blue-l btn-glow transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                </svg>
                <span>My Files</span>
            </a>

            <a href="{{ route('logout') }}"
                class="inline-flex items-center gap-2 px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 hover:bg-fn-red/5 transition-all">
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
                        <img src="/filenewer-logo.svg" alt="Filenewer" class="h-[40px] md:h-[47px]">
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
                                class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Sitemap</a>
                        </li>
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
