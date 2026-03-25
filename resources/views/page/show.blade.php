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
            <a href="/blog" class="hover:text-fn-text2 transition-colors">Bages</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <span class="text-fn-text2 truncate max-w-xs">{{ $page->title }}</span>
        </nav>

        <div class="max-w-3xl">
            <!-- Category + meta -->
            {{-- <div class="flex items-center gap-3 mb-5 flex-wrap">
                <a href="/blog?cat=pdf-tools"
                    class="px-3 py-1 bg-fn-blue/10 border border-fn-blue/25 rounded-full text-fn-blue-l text-xs font-semibold hover:bg-fn-blue/15 transition-colors">PDF
                    Tools</a>
                <span class="text-fn-text3 text-sm">·</span>
                <span class="text-fn-text3 text-sm">8 min read</span>
                <span class="text-fn-text3 text-sm">·</span>
                <span class="text-fn-text3 text-sm">{{ $page->created_at }}</span>
            </div> --}}

            <!-- Title -->
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-[2.8rem] font-normal tracking-tight leading-[1.15] mb-5">
                {{ $page->title }}
            </h1>
        </div>
    </div>
</header>


<!-- ══ CONTENT AREA ══ -->
<div class="max-w-6xl mx-auto px-6 pb-20">
    <div class="flex gap-12 relative">

        <!-- ── MAIN ARTICLE ── -->
        <article class="flex-1 min-w-0 max-w-3xl" id="article-content">
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
                dark:prose-invert"> {!! $page->content !!}</div>




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



            </div>
        </aside>

    </div>
</div>

<x-tools-section />

@endsection
