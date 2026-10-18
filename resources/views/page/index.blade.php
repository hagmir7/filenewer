@extends('layouts.base')

@section('content')

<!-- ══ HERO ══ -->
<section class="relative pt-20 pb-14 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="animate-fade-up opacity-0 text-center">
            <h1 class="font-serif text-4xl sm:text-5xl font-normal tracking-tight leading-[1.1] mb-4">
                <span class="text-gradient italic">Pages</span>
            </h1>
            @if ($description)
            <p class="text-fn-text2 text-lg max-w-xl mx-auto leading-relaxed">
                {{ $description }}
            </p>
            @endif
        </div>
    </div>
</section>

<!-- ══ PAGES LIST ══ -->
<section class="pb-20">
    <div class="max-w-6xl mx-auto px-6">

        @if ($pages->isEmpty())
        <p class="text-fn-text3 text-sm text-center">No pages found.</p>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pages as $page)
            <a href="/pages/{{ $page->slug }}"
                class="group flex flex-col bg-fn-surface border border-fn-text/7 rounded-2xl p-6 hover:border-fn-blue/30 hover:-translate-y-1 transition-all duration-300">

                <h2 class="font-serif text-lg font-normal leading-snug tracking-tight mb-2.5">
                    {{ $page->title }}
                </h2>

                @if ($page->excerpt)
                <p class="text-fn-text3 text-sm leading-relaxed mb-5">
                    {{ $page->excerpt }}
                </p>
                @endif

                <div
                    class="flex items-center gap-1.5 text-fn-blue-l text-sm font-semibold mt-auto pt-4 border-t border-fn-text/7">
                    Read page
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7" />
                        <polyline points="7 7 17 7 17 17" />
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</section>

@endsection
