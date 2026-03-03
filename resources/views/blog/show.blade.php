@extends('layouts.base')



@section('content')
<!-- ══ ARTICLE HEADER ══ -->
<header class="pt-14 pb-0">
    <div class="max-w-6xl mx-auto px-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-fn-text3 mb-8" aria-label="Breadcrumb">
            <a href="/" class="hover:text-fn-text2 transition-colors">Home</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <a href="/blog" class="hover:text-fn-text2 transition-colors">Blog</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <span class="text-fn-text2 truncate max-w-xs">PDF to Word Guide</span>
        </nav>

        <div class="max-w-3xl">
            <!-- Category + meta -->
            <div class="flex items-center gap-3 mb-5 flex-wrap">
                <a href="/blog?cat=pdf-tools"
                    class="px-3 py-1 bg-fn-blue/10 border border-fn-blue/25 rounded-full text-fn-blue-l text-xs font-semibold hover:bg-fn-blue/15 transition-colors">PDF
                    Tools</a>
                <span class="text-fn-text3 text-sm">·</span>
                <span class="text-fn-text3 text-sm">8 min read</span>
                <span class="text-fn-text3 text-sm">·</span>
                <span class="text-fn-text3 text-sm">February 20, 2026</span>
            </div>

            <!-- Title -->
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-[2.8rem] font-normal tracking-tight leading-[1.15] mb-5">
                How to Convert PDF to Word Online<br class="hidden sm:block" />
                <span class="italic text-gradient">Without Losing Formatting</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-fn-text2 text-lg leading-relaxed mb-8 max-w-2xl">
                PDF to Word conversion sounds simple — until you lose all your tables, headers, and fonts. In this
                guide, we explain how Filenewer preserves every element and how you can convert files in under 10
                seconds.
            </p>

            <!-- Author row + share -->
            <div class="flex items-center justify-between flex-wrap gap-4 pb-8 border-b border-fn-text/7">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-sm font-bold text-fn-blue-l">
                        AL</div>
                    <div>
                        <p class="text-sm font-semibold">Alex Liu</p>
                        <p class="text-xs text-fn-text3">Senior Technical Writer at Filenewer</p>
                    </div>
                </div>
                <!-- Share buttons -->
                <div class="flex items-center gap-2">
                    <span class="text-fn-text3 text-xs font-medium mr-1">Share:</span>
                    <button
                        class="share-btn flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text3 text-xs font-medium transition-all">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                        Twitter
                    </button>
                    <button
                        class="share-btn flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text3 text-xs font-medium transition-all">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                        LinkedIn
                    </button>
                    <button onclick="copyLink()"
                        class="share-btn flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text3 text-xs font-medium transition-all"
                        id="copy-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                        </svg>
                        Copy link
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ══ HERO IMAGE ══ -->
<div class="max-w-6xl mx-auto px-6 my-8">
    <div
        class="article-hero-img rounded-2xl h-64 sm:h-80 relative overflow-hidden flex items-center justify-center border border-fn-text/7">
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(oklch(56% 0.23 264 / 25%) 1px, transparent 1px); background-size: 28px 28px;">
        </div>
        <div class="relative z-10 text-center">
            <div class="text-7xl mb-4">📕 → 📝</div>
            <p class="text-fn-text3 text-sm font-mono">PDF → DOCX</p>
        </div>
    </div>
</div>

<!-- ══ CONTENT AREA ══ -->
<div class="max-w-6xl mx-auto px-6 pb-20">
    <div class="flex gap-12 relative">

        <!-- ── MAIN ARTICLE ── -->
        <article class="flex-1 min-w-0 max-w-3xl" id="article-content">

            <!-- Inline CTA box (before article) -->
            <div class="callout info mb-8 relative inline-cta">
                <p class="callout-title">🔧 Try it now</p>
                <p class="text-fn-text2 text-sm">Want to follow along? <a href="/tools/pdf-to-word"
                        class="text-fn-blue-l font-semibold hover:underline">Open the PDF to Word converter</a> in a new
                    tab and convert your first file for free.</p>
            </div>

            <div class="prose prose-lg max-w-4xl mx-auto
                prose-p:text-gray-300 prose-p:leading-8
                prose-headings:font-semibold prose-headings:tracking-tight
                prose-h2:text-white prose-h2:mt-16 prose-h2:mb-6 prose-h2:border-b prose-h2:border-gray-800 prose-h2:pb-3
                prose-h3:text-gray-100 prose-h3:mt-10 prose-h3:mb-4
                prose-strong:text-white
                prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                prose-blockquote:border-l-blue-500 prose-blockquote:text-gray-300 prose-blockquote:bg-gray-900/40 prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:rounded-r-lg
                prose-code:text-blue-300 prose-code:bg-gray-800 prose-code:px-1.5 prose-code:py-1 prose-code:rounded
                prose-pre:bg-gray-900 prose-pre:border prose-pre:border-gray-800 prose-pre:rounded-xl prose-pre:p-6
                prose-ol:text-gray-300 prose-ul:text-gray-300
                prose-li:marker:text-blue-400
                prose-img:rounded-xl
                dark:prose-invert">

                <h2 id="why-formatting-breaks">Why PDF Formatting Breaks During Conversion</h2>
                <p>
                    PDFs aren't documents in the traditional sense — they're a fixed-layout format designed to look
                    identical on every device and printer. Unlike Word documents, PDFs don't store information about
                    text flow, paragraphs, or columns. They store instructions like "draw this character at position (x,
                    y)."
                </p>
                <p>
                    When a basic converter tries to extract that, it reads each character's position and reconstructs
                    text line-by-line. This approach works for simple text — but the moment you have multi-column
                    layouts, embedded fonts, merged table cells, or rotated text boxes, everything falls apart.
                </p>

                <blockquote>
                    <p>Most free converters treat every line of text as a separate paragraph. That's why your neatly
                        formatted report becomes a wall of disconnected lines in Word.</p>
                </blockquote>

                <h2 id="how-filenewer-works">How Filenewer's Conversion Engine Works</h2>
                <p>
                    Filenewer uses a multi-pass PDF analysis engine that works in three stages before writing a single
                    character to the output file:
                </p>

                <h3>Stage 1: Layout Detection</h3>
                <p>
                    The engine first maps the entire structural hierarchy of the PDF — identifying columns, headers,
                    footers, sidebars, figures, and tables as distinct regions. This prevents text from different
                    columns from being merged together.
                </p>

                <h3>Stage 2: Font & Style Mapping</h3>
                <p>
                    Every font used in the PDF is identified and mapped to the closest available Word font. If the exact
                    font is embedded in the PDF, Filenewer preserves it directly. Font sizes, weights, colors, and
                    tracking are all preserved as native Word styles.
                </p>

                <h3>Stage 3: Table Reconstruction</h3>
                <p>
                    Tables are the hardest part of any PDF conversion. Filenewer detects both explicit table markup and
                    visually-implied tables (created with spacing and lines), then reconstructs them as proper Word
                    table objects — including merged cells and headers.
                </p>

                <div class="callout tip">
                    <p class="callout-title">💡 Pro Tip</p>
                    <p>For best results, upload PDFs that were originally created digitally (not scanned). Scanned PDFs
                        require OCR processing, which adds a step but is handled automatically by Filenewer.</p>
                </div>

                <h2 id="step-by-step">Step-by-Step: Convert PDF to Word</h2>
                <p>Here's exactly how to do it using Filenewer — no account required for the first conversion:</p>
                <ol>
                    <li>Go to <a href="/tools/pdf-to-word">filenewer.com/tools/pdf-to-word</a></li>
                    <li>Click <strong>Upload PDF</strong> or drag your file directly onto the page</li>
                    <li>Select your output options (preserve images, page range, etc.)</li>
                    <li>Click <strong>Convert to Word</strong></li>
                    <li>Download your <code>.docx</code> file — usually ready in under 10 seconds</li>
                </ol>

                <p>Your file is automatically deleted from our servers within 1 hour. Nothing is stored or shared.</p>

                <h2 id="common-issues">Fixing Common Conversion Issues</h2>

                <h3>Problem: Text appears as images</h3>
                <p>
                    This happens when the PDF was scanned — the content is a photograph, not selectable text.
                    <strong>Solution:</strong> Enable OCR mode in Filenewer's converter options. It will read the text
                    from the image and make it fully editable.
                </p>

                <h3>Problem: Tables are merging or splitting incorrectly</h3>
                <p>
                    Complex tables with irregular merged cells can sometimes lose structure. <strong>Solution:</strong>
                    Try the "Advanced table reconstruction" option, which uses a slower but more accurate algorithm for
                    complex layouts.
                </p>

                <h3>Problem: Special characters show as boxes</h3>
                <p>
                    This usually means the original PDF used a proprietary or uncommon font that couldn't be mapped.
                    <strong>Solution:</strong> Enable font substitution in the conversion settings — Filenewer will
                    replace unrecognized fonts with the closest system alternative.
                </p>

                <div class="callout warning">
                    <p class="callout-title">⚠️ Note on Scanned PDFs</p>
                    <p>OCR accuracy depends on the quality of the scan. Documents scanned at 300 DPI or higher will
                        produce near-perfect results. Lower-quality scans may require manual correction.</p>
                </div>

                <h2 id="api-usage">Using the API for Bulk Conversion</h2>
                <p>
                    Need to convert hundreds of PDFs programmatically? The Filenewer API makes batch processing simple.
                    Here's a quick example in Node.js:
                </p>

                <pre><code>import FormData from 'form-data';
        import fetch from 'node-fetch';
        import fs from 'fs';

        const form = new FormData();
        form.append('file', fs.createReadStream('./report.pdf'));
        form.append('output_format', 'docx');
        form.append('preserve_images', 'true');

        const response = await fetch('https://api.filenewer.com/v1/convert', {
          method: 'POST',
          headers: {
            'Authorization': 'Bearer YOUR_API_KEY',
            ...form.getHeaders()
          },
          body: form
        });

        const { download_url } = await response.json();
        console.log('Download your file:', download_url);</code></pre>

                <p>
                    The API supports up to 100 concurrent file conversions per request on Pro plans. Full documentation
                    is available at <a href="/docs/api">filenewer.com/docs/api</a>.
                </p>

                <h2 id="conclusion">Conclusion</h2>
                <p>
                    PDF to Word conversion is only as good as the engine behind it. By using Filenewer's multi-pass
                    layout analysis, font mapping, and table reconstruction, you get output that's clean, accurate, and
                    ready to edit — not a mess of disconnected lines and broken tables.
                </p>
                <p>
                    Try it now for free. No account needed for your first conversion — just upload and download.
                </p>

            </div>

            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-fn-text/7">
                <span class="text-fn-text3 text-xs font-medium mr-1">Tags:</span>
                <a href="/blog?tag=pdf"
                    class="px-3 py-1 bg-fn-surface border border-fn-text/10 rounded-full text-fn-text3 text-xs hover:border-fn-blue/30 hover:text-fn-blue-l transition-all">#pdf-tools</a>
                <a href="/blog?tag=conversion"
                    class="px-3 py-1 bg-fn-surface border border-fn-text/10 rounded-full text-fn-text3 text-xs hover:border-fn-blue/30 hover:text-fn-blue-l transition-all">#file-conversion</a>
                <a href="/blog?tag=word"
                    class="px-3 py-1 bg-fn-surface border border-fn-text/10 rounded-full text-fn-text3 text-xs hover:border-fn-blue/30 hover:text-fn-blue-l transition-all">#word-docs</a>
                <a href="/blog?tag=tutorial"
                    class="px-3 py-1 bg-fn-surface border border-fn-text/10 rounded-full text-fn-text3 text-xs hover:border-fn-blue/30 hover:text-fn-blue-l transition-all">#tutorial</a>
            </div>

            <!-- Author bio -->
            <div class="mt-10 p-6 bg-fn-surface border border-fn-text/7 rounded-2xl flex items-start gap-5">
                <div
                    class="w-14 h-14 rounded-2xl bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-lg font-bold text-fn-blue-l shrink-0">
                    AL</div>
                <div>
                    <p class="font-semibold text-sm mb-0.5">Alex Liu</p>
                    <p class="text-fn-text3 text-xs mb-3">Senior Technical Writer · Filenewer</p>
                    <p class="text-fn-text2 text-sm leading-relaxed">Alex writes about file automation, developer tools,
                        and productivity. He's been helping people work smarter with documents for over 8 years.</p>
                </div>
            </div>

            <!-- CTA Banner -->
            <div
                class="mt-10 p-8 bg-fn-surface border border-fn-blue/20 rounded-2xl text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-[radial-gradient(ellipse_at_50%_0%,oklch(49%_0.24_264_/_10%)_0%,transparent_65%)] pointer-events-none">
                </div>
                <div class="relative z-10">
                    <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-2">Try It Free</p>
                    <h3 class="font-serif text-xl font-normal mb-2">Convert your first PDF to Word right now</h3>
                    <p class="text-fn-text3 text-sm mb-5">No account needed · Results in under 10 seconds · 100% free
                    </p>
                    <a href="/tools/pdf-to-word"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all hover:-translate-y-0.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Open PDF to Word Converter
                    </a>
                </div>
            </div>

        </article>

        <!-- ── SIDEBAR ── -->
        <aside class="hidden xl:flex flex-col gap-6 w-64 shrink-0">
            <div class="sticky top-24 flex flex-col gap-6">

                <!-- Table of Contents -->
                <div class="bg-fn-surface border border-fn-text/7 rounded-2xl p-5">
                    <p class="text-xs font-semibold uppercase tracking-widest text-fn-text3 mb-4">Table of Contents</p>
                    <nav class="flex flex-col gap-0.5">
                        <a href="#why-formatting-breaks"
                            class="toc-link pl-3 py-1.5 text-xs text-fn-text2 hover:text-fn-text transition-colors rounded-r-md">Why
                            formatting breaks</a>
                        <a href="#how-filenewer-works"
                            class="toc-link pl-3 py-1.5 text-xs text-fn-text2 hover:text-fn-text transition-colors rounded-r-md">How
                            Filenewer works</a>
                        <a href="#step-by-step"
                            class="toc-link pl-3 py-1.5 text-xs text-fn-text2 hover:text-fn-text transition-colors rounded-r-md">Step-by-step
                            guide</a>
                        <a href="#common-issues"
                            class="toc-link pl-3 py-1.5 text-xs text-fn-text2 hover:text-fn-text transition-colors rounded-r-md">Common
                            issues &amp; fixes</a>
                        <a href="#api-usage"
                            class="toc-link pl-3 py-1.5 text-xs text-fn-text2 hover:text-fn-text transition-colors rounded-r-md">API
                            &amp; bulk conversion</a>
                        <a href="#conclusion"
                            class="toc-link pl-3 py-1.5 text-xs text-fn-text2 hover:text-fn-text transition-colors rounded-r-md">Conclusion</a>
                    </nav>
                </div>

                <!-- Related tool -->
                <div class="bg-fn-blue/8 border border-fn-blue/20 rounded-2xl p-5">
                    <p class="text-fn-blue-l text-xs font-semibold uppercase tracking-widest mb-3">Featured Tool</p>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-fn-red/15 flex items-center justify-center text-lg shrink-0">
                            📕</div>
                        <p class="font-semibold text-sm">PDF to Word Converter</p>
                    </div>
                    <p class="text-fn-text3 text-xs leading-relaxed mb-4">Convert any PDF to editable Word. Preserves
                        all formatting, tables, and fonts.</p>
                    <a href="/tools/pdf-to-word"
                        class="block text-center py-2 bg-fn-blue hover:bg-fn-blue-l text-white text-xs font-semibold rounded-lg transition-all">
                        Try for Free →
                    </a>
                </div>

                <!-- Reading progress -->
                <div class="bg-fn-surface border border-fn-text/7 rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-semibold text-fn-text3 uppercase tracking-widest">Reading</p>
                        <p class="text-xs font-mono text-fn-text3" id="progress-pct">0%</p>
                    </div>
                    <div class="h-1.5 bg-fn-surface2 rounded-full overflow-hidden">
                        <div id="sidebar-progress" class="h-full rounded-full transition-all duration-200"
                            style="width: 0%; background: linear-gradient(90deg, oklch(49% 0.24 264), oklch(68% 0.17 210));">
                        </div>
                    </div>
                    <p class="text-xs text-fn-text3 mt-2" id="reading-time-left">~8 min remaining</p>
                </div>

            </div>
        </aside>

    </div>
</div>

<!-- ══ RELATED POSTS ══ -->
<section class="border-t border-fn-text/7 py-16 bg-fn-surface">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-7">Related Articles</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

            <a href="/blog/compress-images-without-quality-loss"
                class="related-card group flex flex-col bg-fn-bg border border-fn-text/7 rounded-2xl overflow-hidden transition-all duration-300 cursor-pointer">
                <div class="h-36 flex items-center justify-center"
                    style="background: linear-gradient(135deg, oklch(20% 0.04 210), oklch(24% 0.07 200));">
                    <span class="text-4xl">🖼️</span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-fn-cyan text-xs font-semibold mb-2">Tips</span>
                    <h3
                        class="font-serif text-base font-normal leading-snug tracking-tight mb-2 transition-colors duration-200">
                        Compress Images Without Losing Quality: A Visual Guide</h3>
                    <p class="text-fn-text3 text-xs mt-auto">5 min read · Feb 15</p>
                </div>
            </a>

            <a href="/blog/automate-invoice-generation"
                class="related-card group flex flex-col bg-fn-bg border border-fn-text/7 rounded-2xl overflow-hidden transition-all duration-300 cursor-pointer">
                <div class="h-36 flex items-center justify-center"
                    style="background: linear-gradient(135deg, oklch(20% 0.04 162), oklch(24% 0.07 160));">
                    <span class="text-4xl">🧾</span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-fn-green text-xs font-semibold mb-2">Automation</span>
                    <h3
                        class="font-serif text-base font-normal leading-snug tracking-tight mb-2 transition-colors duration-200">
                        How to Automate Invoice Generation for Your Business</h3>
                    <p class="text-fn-text3 text-xs mt-auto">7 min read · Feb 12</p>
                </div>
            </a>

            <a href="/blog/pdf-security-encryption-guide"
                class="related-card group flex flex-col bg-fn-bg border border-fn-text/7 rounded-2xl overflow-hidden transition-all duration-300 cursor-pointer">
                <div class="h-36 flex items-center justify-center"
                    style="background: linear-gradient(135deg, oklch(20% 0.05 27), oklch(24% 0.07 30));">
                    <span class="text-4xl">🔐</span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-fn-red text-xs font-semibold mb-2">Security</span>
                    <h3
                        class="font-serif text-base font-normal leading-snug tracking-tight mb-2 transition-colors duration-200">
                        PDF Security & Encryption: Everything You Need to Know</h3>
                    <p class="text-fn-text3 text-xs mt-auto">9 min read · Feb 8</p>
                </div>
            </a>

        </div>

        <div class="text-center mt-10">
            <a href="/blog"
                class="inline-flex items-center gap-2 px-6 py-2.5 border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                View all articles
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- ══ FOOTER ══ -->
<footer class="bg-fn-bg border-t border-fn-text/7 pt-14 pb-8">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">
            <div>
                <a href="/" class="flex items-center gap-2 font-bold text-lg tracking-tight mb-3">
                    <div class="w-7 h-7 bg-fn-blue rounded-lg flex items-center justify-center shrink-0">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    Filenewer
                </a>
                <p class="text-fn-text3 text-sm leading-relaxed">Smarter File Processing. Fast, free, and secure.</p>
            </div>
            <div>
                <h4 class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-4">Product</h4>
                <ul class="flex flex-col gap-2.5 list-none">
                    <li><a href="/tools" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">All
                            Tools</a></li>
                    <li><a href="/pricing"
                            class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Pricing</a></li>
                    <li><a href="/api" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">API</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-4">Company</h4>
                <ul class="flex flex-col gap-2.5 list-none">
                    <li><a href="/about" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">About</a>
                    </li>
                    <li><a href="/blog" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Blog</a></li>
                    <li><a href="/contact"
                            class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-fn-text3 text-xs font-semibold uppercase tracking-widest mb-4">Legal</h4>
                <ul class="flex flex-col gap-2.5 list-none">
                    <li><a href="/privacy" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Privacy
                            Policy</a></li>
                    <li><a href="/terms" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">Terms of
                            Service</a></li>
                    <li><a href="/gdpr" class="text-fn-text2 text-sm hover:text-fn-text transition-colors">GDPR</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-7 border-t border-fn-text/7 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-fn-text3 text-xs">© 2026 Filenewer. All rights reserved.</p>
            <ul class="flex items-center gap-5 list-none">
                <li><a href="/privacy" class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Privacy</a>
                </li>
                <li><a href="/terms" class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Terms</a></li>
                <li><a href="/sitemap.xml"
                        class="text-fn-text3 text-xs hover:text-fn-text2 transition-colors">Sitemap</a></li>
            </ul>
        </div>
    </div>
</footer>

<script>
    // ── Reading progress bar ──
                const progressBar = document.getElementById('progress-bar');
                const sidebarProgress = document.getElementById('sidebar-progress');
                const progressPct = document.getElementById('progress-pct');
                const readingLeft = document.getElementById('reading-time-left');
                const totalMinutes = 8;

                window.addEventListener('scroll', () => {
                    const article = document.getElementById('article-content');
                    const articleTop = article.getBoundingClientRect().top + window.scrollY;
                    const articleHeight = article.offsetHeight;
                    const scrolled = window.scrollY - articleTop;
                    const pct = Math.min(100, Math.max(0, Math.round((scrolled / articleHeight) * 100)));

                    progressBar.style.width = pct + '%';
                    if (sidebarProgress) sidebarProgress.style.width = pct + '%';
                    if (progressPct) progressPct.textContent = pct + '%';
                    if (readingLeft) {
                        const minsLeft = Math.ceil(totalMinutes * (1 - pct / 100));
                        readingLeft.textContent = minsLeft > 0 ? `~${minsLeft} min remaining` : 'Finished!';
                    }
                });

                // ── TOC active section highlight ──
                const headings = document.querySelectorAll('#article-content h2[id]');
                const tocLinks = document.querySelectorAll('.toc-link');

                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            tocLinks.forEach(l => l.classList.remove('active'));
                            const active = document.querySelector(`.toc-link[href="#${entry.target.id}"]`);
                            if (active) active.classList.add('active');
                        }
                    });
                }, {
                    rootMargin: '-20% 0px -75% 0px'
                });

                headings.forEach(h => observer.observe(h));

                // ── Copy link ──
                function copyLink() {
                    navigator.clipboard.writeText(window.location.href);
                    const btn = document.getElementById('copy-btn');
                    btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied!`;
                    setTimeout(() => {
                        btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg> Copy link`;
                    }, 2000);
                }
</script>
@endsection
