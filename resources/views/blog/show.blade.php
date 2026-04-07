@extends('layouts.base')

@section('content')
<!-- ══ ARTICLE HEADER ══ -->
<header class="pt-14 pb-0">
    <div class="max-w-6xl mx-auto px-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-fn-text3 mb-8" aria-label="Breadcrumb">
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
            <span class="text-fn-text2 truncate max-w-xs">{{ $blog->title }}</span>
        </nav>

        <div class="max-w-3xl">
            <!-- Category + meta -->
            <div class="flex items-center gap-3 mb-5 flex-wrap">
                @if($blog->category)
                <a href="/blog?cat={{ Str::slug($blog->category) }}"
                    class="px-3 py-1 bg-fn-blue/10 border border-fn-blue/25 rounded-full text-fn-blue-l text-sm font-semibold hover:bg-fn-blue/15 transition-colors">
                    {{ $blog->category }}
                </a>
                <span class="text-fn-text3 text-sm">·</span>
                @endif
                <span class="text-fn-text3 text-sm">{{ $blog->read_time ?? '5' }} min read</span>
                @if($blog->published_at)
                <span class="text-fn-text3 text-sm">·</span>
                <span class="text-fn-text3 text-sm">{{ \Carbon\Carbon::parse($blog->published_at)->format('F j, Y')
                    }}</span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-[2.8rem] font-normal tracking-tight leading-[1.15] mb-5">
                {{ $blog->title }}
            </h1>

            <!-- Subtitle / Excerpt -->
            @if($blog->excerpt)
            <p class="text-fn-text2 text-lg leading-relaxed mb-8 max-w-2xl">
                {{ $blog->excerpt }}
            </p>
            @endif

            <!-- Author row + share -->
            <div class="flex items-center justify-between flex-wrap gap-4 pb-8 border-b border-fn-text/7">
                <div class="flex items-center gap-3">
                    @if($blog->user)
                    <div
                        class="w-10 h-10 rounded-full bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-sm font-bold text-fn-blue-l">
                        {{ strtoupper(substr($blog->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ $blog->user->name }}</p>
                        <p class="text-sm text-fn-text3">Author at Filenewer</p>
                    </div>
                    @endif
                </div>
                <!-- Share buttons -->
                <div class="flex items-center gap-2">
                    <span class="text-fn-text3 text-sm font-medium mr-1">Share:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}"
                        target="_blank" rel="noopener"
                        class="share-btn flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text3 text-sm font-medium transition-all hover:text-fn-text">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                        Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                        target="_blank" rel="noopener"
                        class="share-btn flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text3 text-sm font-medium transition-all hover:text-fn-text">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                        LinkedIn
                    </a>
                    <button onclick="copyLink()"
                        class="share-btn flex items-center gap-1.5 px-3 py-1.5 bg-fn-surface border border-fn-text/10 rounded-lg text-fn-text3 text-sm font-medium transition-all hover:text-fn-text"
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



<!-- ══ CONTENT AREA ══ -->
<div class="max-w-6xl mx-auto px-6 pb-20">
    <div class="flex gap-12 relative">


        <!-- ── MAIN ARTICLE ── -->
        <article class="flex-1 min-w-0 max-w-3xl" id="article-content">
            <!-- ══ HERO IMAGE ══ -->
            <div class="max-w-6xl mx-auto mb-2">
                @if($blog->featured_image)
                <div class="rounded-2xl h-64 sm:h-80 relative overflow-hidden border border-fn-text/7">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                        class="w-full h-full object-cover" />
                </div>
                @else
                <div
                    class="article-hero-img rounded-2xl h-64 sm:h-80 relative overflow-hidden flex items-center justify-center border border-fn-text/7">
                    <div class="absolute inset-0 opacity-20"
                        style="background-image: radial-gradient(oklch(56% 0.23 264 / 25%) 1px, transparent 1px); background-size: 28px 28px;">
                    </div>
                    <div class="relative z-10 text-center">
                        <div class="text-7xl mb-4">📄</div>
                        <p class="text-fn-text3 text-sm font-mono">{{ $blog->category ?? 'Article' }}</p>
                    </div>
                </div>
                @endif
            </div>

            <div class="prose prose-lg max-w-4xl mx-auto
                prose-p:text-gray-300 prose-p:leading-8 prose-hr:m-0
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

                {!! $blog->content !!}

            </div>

            <!-- Tags -->
            @if($blog->category)
            <div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-fn-text/7">
                <span class="text-fn-text3 text-sm font-medium mr-1">Tags:</span>
                <a href="/blog?cat={{ Str::slug($blog->category) }}"
                    class="px-3 py-1 bg-fn-surface border border-fn-text/10 rounded-full text-fn-text3 text-sm hover:border-fn-blue/30 hover:text-fn-blue-l transition-all">
                    #{{ Str::slug($blog->category) }}
                </a>
            </div>
            @endif

            <!-- Author bio -->
            @if($blog->user)
            <div class="mt-10 p-6 bg-fn-surface border border-fn-text/7 rounded-2xl flex items-start gap-5">
                <div
                    class="w-14 h-14 rounded-2xl bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-lg font-bold text-fn-blue-l shrink-0">
                    {{ strtoupper(substr($blog->user->name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-semibold text-sm mb-0.5">{{ $blog->user->name }}</p>
                    <p class="text-fn-text3 text-sm mb-3">Author · Filenewer</p>
                    @if($blog->user->bio)
                    <p class="text-fn-text2 text-sm leading-relaxed">{{ $blog->user->bio }}</p>
                    @else
                    <p class="text-fn-text2 text-sm leading-relaxed">Writing about file tools and automation at
                        Filenewer.</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- CTA Banner -->
            <div
                class="mt-10 p-8 bg-fn-surface border border-fn-blue/20 rounded-2xl text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-[radial-gradient(ellipse_at_50%_0%,oklch(49%_0.24_264_/_10%)_0%,transparent_65%)] pointer-events-none">
                </div>
                <div class="relative z-10">
                    <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-2">Try It Free</p>
                    <h3 class="font-serif text-xl font-normal mb-2">Process your files right now</h3>
                    <p class="text-fn-text3 text-sm mb-5">No account needed · Fast &amp; secure · 100% free</p>
                    <a href="/tools"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all hover:-translate-y-0.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                        Browse All Tools
                    </a>
                </div>
            </div>

        </article>

        <!-- ── SIDEBAR ── -->
        <aside class="hidden xl:flex flex-col gap-6 w-64 shrink-0">
            <div class="sticky top-24 flex flex-col gap-6">

                <!-- Table of Contents — auto-generated from headings via JS -->
                <div class="bg-fn-surface border border-fn-text/7 rounded-2xl p-5">
                    <p class="text-sm font-semibold uppercase tracking-widest text-fn-text3 mb-4">Table of Contents</p>
                    <nav class="flex flex-col gap-0.5" id="toc-nav">
                        {{-- Populated by JS below --}}
                    </nav>
                </div>

                <!-- Reading progress -->
                <div class="bg-fn-surface border border-fn-text/7 rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-semibold text-fn-text3 uppercase tracking-widest">Reading</p>
                        <p class="text-sm font-mono text-fn-text3" id="progress-pct">0%</p>
                    </div>
                    <div class="h-1.5 bg-fn-surface2 rounded-full overflow-hidden">
                        <div id="sidebar-progress" class="h-full rounded-full transition-all duration-200"
                            style="width: 0%; background: linear-gradient(90deg, oklch(49% 0.24 264), oklch(68% 0.17 210));">
                        </div>
                    </div>
                    <p class="text-sm text-fn-text3 mt-2" id="reading-time-left">
                        ~{{ $blog->read_time ?? '5' }} min remaining
                    </p>
                </div>

                <!-- Related tool (linked tools via pivot) -->
                @if($blog->tools->isNotEmpty())
                @foreach($blog->tools->take(1) as $tool)
                <div class="bg-fn-blue/8 border border-fn-blue/20 rounded-2xl p-5">
                    <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Featured Tool</p>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-fn-blue/15 flex items-center justify-center text-lg shrink-0">
                            🛠️
                        </div>
                        <p class="font-semibold text-sm">{{ $tool->name }}</p>
                    </div>
                    @if($tool->description)
                    <p class="text-fn-text3 text-sm leading-relaxed mb-4">{{ Str::limit($tool->description, 80) }}</p>
                    @endif
                    <a href="/tools/{{ $tool->slug }}"
                        class="block text-center py-2 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-lg transition-all">
                        Try for Free →
                    </a>
                </div>
                @endforeach
                @endif

            </div>
        </aside>

    </div>
</div>

<!-- ══ RELATED POSTS ══ -->
@if($recommended->isNotEmpty())
<section class="border-t border-fn-text/7 py-16 bg-fn-surface">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-fn-text3 text-sm font-semibold uppercase tracking-widest mb-7">Related Articles</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach($recommended as $post)
            <a href="/blog/{{ $post->slug }}"
                class="related-card group flex flex-col bg-fn-bg border border-fn-text/7 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-fn-blue/20 cursor-pointer">

                @if($post->featured_image)
                <div class="h-36 overflow-hidden">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                @else
                <div class="h-36 flex items-center justify-center"
                    style="background: linear-gradient(135deg, oklch(20% 0.04 210), oklch(24% 0.07 200));">
                    <span class="text-4xl">📄</span>
                </div>
                @endif

                <div class="p-5 flex flex-col flex-1">
                    @if($post->category)
                    <span class="text-fn-blue-l text-sm font-semibold mb-2">{{ $post->category }}</span>
                    @endif
                    <h3
                        class="font-serif text-base font-normal leading-snug tracking-tight mb-2 group-hover:text-fn-blue-l transition-colors duration-200">
                        {{ $post->title }}
                    </h3>
                    @if($post->excerpt)
                    <p class="text-fn-text3 text-sm leading-relaxed mb-3 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                    <p class="text-fn-text3 text-sm mt-auto">
                        @if($post->read_time){{ $post->read_time }} min read · @endif
                        @if($post->published_at){{ \Carbon\Carbon::parse($post->published_at)->format('M j') }}@endif
                    </p>
                </div>
            </a>
            @endforeach

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
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tocNav        = document.getElementById('toc-nav');
        const articleHeadings = Array.from(document.querySelectorAll('#article-content h2, #article-content h3'));

        if (tocNav && articleHeadings.length > 0) {
            articleHeadings.forEach((heading, i) => {
                // Assign id if missing
                if (!heading.id) {
                    heading.id = 'heading-' + i;
                }

                const a    = document.createElement('a');
                a.href     = '#' + heading.id;

                // Clone heading, strip icons/images, extract clean text only
                const clone = heading.cloneNode(true);
                clone.querySelectorAll('img, svg, figure, .icon, [aria-hidden]').forEach(el => el.remove());
                const label = clone.textContent
                    .replace(/[\u200B\u200C\u200D\uFEFF\u00AD]/g, '') // strip zero-width chars
                    .trim();
                a.textContent = label || 'Section ' + (i + 1);
                const isH3 = heading.tagName === 'H3';
                a.className = `toc-link ${isH3 ? 'pl-6' : 'pl-3'} py-1.5 text-sm text-fn-text2 hover:text-fn-text transition-colors rounded-r-md block truncate`;
                tocNav.appendChild(a);
            });
        } else if (tocNav) {
            // Hide the TOC card entirely if no headings found
            tocNav.closest('.bg-fn-surface')?.classList.add('hidden');
        }

        // ── Reading progress bar ──
        const sidebarProgress = document.getElementById('sidebar-progress');
        const progressPct     = document.getElementById('progress-pct');
        const readingLeft     = document.getElementById('reading-time-left');
        const totalMinutes    = {{ $blog->read_time ?? 5 }};

        window.addEventListener('scroll', () => {
            const article       = document.getElementById('article-content');
            if (!article) return;
            const articleTop    = article.getBoundingClientRect().top + window.scrollY;
            const articleHeight = article.offsetHeight;
            const scrolled      = window.scrollY - articleTop;
            const pct           = Math.min(100, Math.max(0, Math.round((scrolled / articleHeight) * 100)));

            if (sidebarProgress) sidebarProgress.style.width = pct + '%';
            if (progressPct)     progressPct.textContent = pct + '%';
            if (readingLeft) {
                const minsLeft = Math.ceil(totalMinutes * (1 - pct / 100));
                readingLeft.textContent = minsLeft > 0 ? `~${minsLeft} min remaining` : 'Finished!';
            }
        });

        // ── TOC active section highlight ──
        if (articleHeadings.length > 0) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        document.querySelectorAll('.toc-link').forEach(l => {
                            l.classList.remove('text-fn-blue-l', 'border-l-2', 'border-fn-blue', 'font-semibold');
                        });
                        const active = document.querySelector(`.toc-link[href="#${entry.target.id}"]`);
                        if (active) active.classList.add('text-fn-blue-l', 'border-l-2', 'border-fn-blue', 'font-semibold');
                    }
                });
            }, { rootMargin: '-20% 0px -75% 0px' });

            articleHeadings.forEach(h => observer.observe(h));
        }

    }); // end DOMContentLoaded

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
