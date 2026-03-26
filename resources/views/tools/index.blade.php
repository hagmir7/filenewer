@extends('layouts.base')

@section('content')

{{-- ══ HERO ══ --}}
<section class="relative pt-10 pb-10 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">

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
                    class="absolute right-4 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1 px-2 py-1 bg-fn-surface2 border border-fn-text/10 rounded-md text-fn-text3 text-xs font-mono">⌘K</kbd>
            </div>
            <p id="search-count" class="text-fn-text3 text-xs text-center mt-2.5 h-4"></p>
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
                    <span class="text-fn-text3 text-xs">Sort:</span>
                    <select id="sort-select"
                        class="bg-fn-surface border border-fn-text/10 text-fn-text2 text-xs font-medium rounded-lg px-3 py-1.5 font-sans focus:outline-none focus:border-fn-blue/50 cursor-pointer">
                        <option value="popular">Most Popular</option>
                        <option value="newest">Newest First</option>
                        <option value="az">A → Z</option>
                    </select>
                </div>
            </div>

            {{-- ── CATEGORIES LOOP ── --}}
            @foreach($categories as $category)
            @if($category->tools->isNotEmpty())
            <div class="tool-section mb-10" data-section="{{ $category->slug }}">

                {{-- Section header --}}
                <div class="flex items-center gap-3 mb-5">
                    <div
                        class="w-8 h-8 rounded-lg bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-base shrink-0">
                        {{ $category->icon }}
                    </div>
                    <h2 class="text-base font-bold tracking-tight">{{ $category->title }}</h2>
                    <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-xs font-mono">
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
                                    class="badge-popular shrink-0 px-1.5 py-0.5 text-xs font-semibold rounded-full border">🔥</span>
                                @elseif(str_contains($tool->tags ?? '', 'new'))
                                <span
                                    class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-xs font-semibold rounded-full">New</span>
                                @endif
                            </div>
                            <p class="text-fn-text3 text-xs leading-relaxed">{{ $tool->description }}</p>
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
