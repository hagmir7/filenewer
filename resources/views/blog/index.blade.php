@extends('layouts.base')


@section('content')



<!-- ══ HERO ══ -->
<section class="relative pt-20 pb-14 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">

        <div class="animate-fade-up opacity-0 text-center mb-14">
            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-fn-blue/30 bg-fn-blue/10 text-fn-blue-l text-sm font-semibold tracking-widest uppercase mb-5">
                <span class="w-1.5 h-1.5 rounded-full bg-fn-blue-l animate-pulse"></span>
                The Filenewer Blog
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-[3.6rem] font-normal tracking-tight leading-[1.1] mb-4">
                Guides, tips &amp; insights on<br />
                <span class="text-gradient italic">smarter file processing</span>
            </h1>
            <p class="text-fn-text2 text-lg max-w-xl mx-auto leading-relaxed">
                Tutorials, deep-dives, and product updates from the Filenewer team — helping you work faster with
                files.
            </p>
        </div>


    </div>
</section>



{{-- ══ FEATURED POST (first blog from paginator if on page 1) ══ --}}
@if ($blogs->currentPage() === 1 && $blogs->isNotEmpty())
@php $featured = $blogs->first(); @endphp

<section class="pb-6">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-fn-text3 text-sm font-semibold uppercase tracking-widest mb-5">Featured Article</p>

        <a href="/blog/{{ $featured->slug }}"
            class="blog-card group block bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300 shadow-lg">
            <div class="grid lg:grid-cols-2">
                {{-- Image area --}}
                <div
                    class="feat-img relative h-56 lg:h-auto min-h-[280px] flex items-center justify-center overflow-hidden">
                    @if ($featured->featured_image)
                    <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30"></div>
                    @else
                    <div class="absolute inset-0 opacity-30"
                        style="background-image: radial-gradient(oklch(56% 0.23 264 / 20%) 1px, transparent 1px); background-size: 24px 24px;">
                    </div>
                    <div class="relative z-10 text-center px-8">
                        <div
                            class="w-20 h-20 rounded-2xl bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-4xl mx-auto mb-4">
                            📕
                        </div>
                        <span
                            class="inline-block px-3 py-1 bg-fn-blue/15 border border-fn-blue/30 rounded-full text-fn-blue-l text-sm font-semibold">
                            {{ $featured->category ?? 'Article' }}
                        </span>
                    </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-8 lg:p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <span
                                class="px-2.5 py-1 bg-fn-blue/10 border border-fn-blue/20 rounded-full text-fn-blue-l text-sm font-semibold">
                                Featured
                            </span>
                            @if ($featured->content)
                            <span class="text-fn-text3 text-sm">
                                {{ ceil(str_word_count(strip_tags($featured->content)) / 200) }} min read
                            </span>
                            @endif
                        </div>
                        <h2
                            class="card-title font-serif text-2xl lg:text-3xl font-normal leading-snug tracking-tight mb-4 transition-colors duration-200">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-fn-text2 text-sm leading-relaxed mb-6">
                            {{ $featured->excerpt }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-fn-blue/20 border border-fn-blue/30 flex items-center justify-center text-sm font-bold text-fn-blue-l">
                                {{ strtoupper(substr($featured->user->name ?? 'A', 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold">{{ $featured->user->name ?? 'Author' }}</p>
                                <p class="text-sm text-fn-text3">
                                    {{ $featured->published_at ?
                                    \Carbon\Carbon::parse($featured->published_at)->format('M j, Y') : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-fn-blue-l text-sm font-semibold">
                            Read article
                            <svg class="card-arrow w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7" />
                                <polyline points="7 7 17 7 17 17" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>
@endif

{{-- ══ BLOG GRID ══ --}}
<section class="py-12">
    <div class="max-w-6xl mx-auto px-6">
        <p class="text-fn-text3 text-sm font-semibold uppercase tracking-widest mb-7">Latest Articles</p>

        @php
        // Skip the featured post on page 1 so it doesn't repeat in the grid
        $gridBlogs = $blogs->currentPage() === 1 ? $blogs->skip(1) : $blogs;

        // Category → color mapping
        $categoryColors = [
        'tutorial' => ['bg' => 'bg-fn-green/10', 'border' => 'border-fn-green/20', 'text' => 'text-fn-green'],
        'tips' => ['bg' => 'bg-fn-cyan/10', 'border' => 'border-fn-cyan/20', 'text' => 'text-fn-cyan'],
        'automation' => ['bg' => 'bg-fn-green/10', 'border' => 'border-fn-green/20', 'text' => 'text-fn-green'],
        'security' => ['bg' => 'bg-fn-red/10', 'border' => 'border-fn-red/20', 'text' => 'text-fn-red'],
        'developer' => ['bg' => 'bg-fn-amber/10', 'border' => 'border-fn-amber/20', 'text' => 'text-fn-amber'],
        'updates' => ['bg' => 'bg-fn-blue/10', 'border' => 'border-fn-blue/20', 'text' => 'text-fn-blue-l'],
        ];
        $defaultColor = ['bg' => 'bg-fn-blue/10', 'border' => 'border-fn-blue/20', 'text' => 'text-fn-blue-l'];

        // Dot patterns per card position (cycles)
        $dotColors = [
        'oklch(56% 0.23 264 / 25%)',
        'oklch(68% 0.17 210 / 25%)',
        'oklch(67% 0.18 162 / 25%)',
        'oklch(59% 0.22 27 / 25%)',
        'oklch(73% 0.17 72 / 25%)',
        'oklch(56% 0.23 264 / 25%)',
        ];
        @endphp

        @if ($gridBlogs->isEmpty())
        <p class="text-fn-text3 text-sm">No articles found.</p>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($gridBlogs as $i => $blog)
            @php
            $catKey = strtolower($blog->category ?? '');
            $color = $categoryColors[$catKey] ?? $defaultColor;
            $dotColor = $dotColors[$i % count($dotColors)];
            $initials = strtoupper(substr($blog->user->name ?? 'A', 0, 2));
            $readTime = $blog->content
            ? ceil(str_word_count(strip_tags($blog->content)) / 200)
            : null;
            @endphp

            <a href="/blog/{{ $blog->slug }}"
                class="blog-card group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl overflow-hidden hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">

                {{-- Card image / header --}}
                <div class="h-44 relative flex items-center justify-center overflow-hidden">
                    @if ($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/20"></div>
                    @else
                    <div class="absolute inset-0 opacity-25"
                        style="background-image: radial-gradient({{ $dotColor }} 1px, transparent 1px); background-size: 20px 20px;">
                    </div>
                    <span class="text-4xl relative z-10">
                        @switch($catKey)
                        @case('tutorial') 🟩 @break
                        @case('tips') 🖼️ @break
                        @case('automation') 🧾 @break
                        @case('security') 🔐 @break
                        @case('developer') ⚡ @break
                        @case('updates') 🚀 @break
                        @default 📄
                        @endswitch
                    </span>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        @if ($blog->category)
                        <span
                            class="px-2.5 py-0.5 {{ $color['bg'] }} border {{ $color['border'] }} rounded-full {{ $color['text'] }} text-sm font-semibold">
                            {{ ucfirst($blog->category) }}
                        </span>
                        @endif
                        @if ($readTime)
                        <span class="text-fn-text3 text-sm">{{ $readTime }} min read</span>
                        @endif
                    </div>

                    <h3
                        class="card-title font-serif text-lg font-normal leading-snug tracking-tight mb-2.5 transition-colors duration-200 flex-1">
                        {{ $blog->title }}
                    </h3>

                    <p class="text-fn-text3 text-sm leading-relaxed mb-5">
                        {{ $blog->excerpt }}
                    </p>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-fn-text/7">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full {{ $color['bg'] }} flex items-center justify-center text-sm font-bold {{ $color['text'] }}">
                                {{ $initials }}
                            </div>
                            <span class="text-sm text-fn-text3">
                                {{ $blog->user->name ?? 'Author' }}
                                @if ($blog->published_at)
                                · {{ \Carbon\Carbon::parse($blog->published_at)->format('M j') }}
                                @endif
                            </span>
                        </div>
                        <svg class="card-arrow w-4 h-4 text-fn-text3" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        {{-- ══ PAGINATION ══ --}}
        @if ($blogs->hasPages())
        <div class="flex items-center justify-center gap-2 mt-14">

            {{-- Previous --}}
            @if ($blogs->onFirstPage())
            <span
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 opacity-40 cursor-not-allowed">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </span>
            @else
            <a href="{{ $blogs->previousPageUrl() }}"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
            @if ($page == $blogs->currentPage())
            <span
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-fn-blue text-white text-sm font-semibold">
                {{ $page }}
            </span>
            @elseif ($page == 1 || $page == $blogs->lastPage() || abs($page - $blogs->currentPage()) <= 1) <a
                href="{{ $url }}"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 text-sm font-medium hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">
                {{ $page }}
                </a>
                @elseif (abs($page - $blogs->currentPage()) == 2)
                <span class="text-fn-text3 text-sm px-1">…</span>
                @endif
                @endforeach

                {{-- Next --}}
                @if ($blogs->hasMorePages())
                <a href="{{ $blogs->nextPageUrl() }}"
                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </a>
                @else
                <span
                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-fn-text/10 text-fn-text3 opacity-40 cursor-not-allowed">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </span>
                @endif

        </div>
        @endif

    </div>
</section>

<!-- ══ NEWSLETTER ══ -->
<section class="py-20 mt-8 border-t border-fn-text/7">
    <div class="max-w-6xl mx-auto px-6">
        <div
            class="bg-fn-surface border border-fn-text/7 rounded-2xl p-10 lg:p-14 relative overflow-hidden text-center">
            <!-- Glow -->
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_50%_-20%,oklch(49%_0.24_264_/_12%)_0%,transparent_65%)] pointer-events-none">
            </div>

            <div class="relative z-10 max-w-lg mx-auto">
                <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Stay Updated</p>
                <h2 class="font-serif text-2xl sm:text-3xl font-normal tracking-tight mb-3">
                    Get file tips straight to your inbox
                </h2>
                <p class="text-fn-text2 text-sm leading-relaxed mb-7">
                    Join 12,000+ readers. No spam, just practical guides on file tools, automation, and productivity
                    — every two weeks.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 max-w-sm mx-auto">
                    <input type="email" placeholder="your@email.com"
                        class="nl-input flex-1 px-4 py-2.5 bg-fn-bg border border-fn-text/10 rounded-xl text-fn-text text-sm placeholder:text-fn-text3 font-sans transition-all" />
                    <button
                        class="px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all hover:-translate-y-0.5 whitespace-nowrap">
                        Subscribe Free
                    </button>
                </div>
                <p class="text-fn-text3 text-sm mt-3">Unsubscribe any time · No spam ever</p>
            </div>
        </div>
    </div>
</section>


<script>
    // Category filter pills
    document.querySelectorAll('.cat-pill').forEach(pill => {
      pill.addEventListener('click', () => {
        document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
      });
    });
</script>


@endsection
