@extends('layouts.base')

@php
$isHome = request()->is('/');
$activeCategory = request('category') && $categories->isNotEmpty() ? $categories->first() : null;
$totalTools = $categories->sum(fn ($category) => $category->tools->count());

// Unique <title> and meta description for "/" and "/tools".
    // Category pages keep whatever the controller passes.
    if ($isHome) {
    $title = 'Filenewer – Free Online File Converter, PDF & Image Tools';
    $description = 'Convert, compress, merge and edit PDF, Word, Excel and image files online for free. '
    . (intdiv($totalTools, 10) * 10) . '+ browser-based tools, no software to install.';
    } elseif (! $activeCategory) {
    $title = 'All Online File Tools – PDF, Word, Excel & Image | Filenewer';
    $description = 'Browse every Filenewer tool: convert, compress, merge and split PDF, Word, Excel, CSV, JSON and
    image files online for free.';
    }

    // Homepage shows a curated list instead of repeating the whole /tools directory.
    $featuredSlugs = [
    'pdf-to-word', 'merge-pdf', 'compress-pdf', 'word-to-pdf', 'pdf-to-jpg', 'split-pdf',
    'ocr-pdf', 'compress-image', 'image-to-jpg', 'csv-to-excel', 'json-formatter', 'invoice-generator',
    ];

    $featuredTools = $categories
    ->flatMap(fn ($category) => $category->tools)
    ->whereIn('slug', $featuredSlugs)
    ->sortBy(fn ($tool) => array_search($tool->slug, $featuredSlugs))
    ->values();

    // One list that the single grid below renders: curated tools on "/", real categories elsewhere.
    $sections = $isHome
    ? collect([(object) ['slug' => 'popular-tools', 'title' => 'Most-used tools', 'icon' => null, 'tools' =>
    $featuredTools]])
    : $categories;
    @endphp

    @if ($isHome)
    @php
    $faqs = [
    ['q' => 'Is Filenewer free to use?', 'a' => 'Yes. All Filenewer tools are free to use, and you do not need to create
    an account to convert, compress, merge or split your files.'],
    ['q' => 'Do I need to install any software?', 'a' => 'No. Everything runs in your web browser on desktop, tablet or
    phone. You upload a file, we process it, and you download the result.'],
    ['q' => 'What happens to my files after conversion?', 'a' => 'Uploaded files and the converted results are deleted
    automatically after processing, within one hour at the latest. Read our Privacy Policy for the full details.'],
    ['q' => 'Which file types does Filenewer support?', 'a' => 'PDF, Word (DOC and DOCX), Excel (XLSX), CSV, JSON, YAML,
    XML, Markdown, EPUB, MOBI, HTML and common image formats such as JPG, PNG and WEBP. Browse the full list on the
    tools page.'],
    ['q' => 'Will the formatting stay the same when I convert a PDF to Word?', 'a' => 'For text-based PDFs the layout is
    usually preserved well. Very complex layouts can shift slightly, and scanned PDFs need to go through the OCR PDF
    tool first so the text can be recognised.'],
    ['q' => 'Can I use Filenewer on my phone?', 'a' => 'Yes. The site works in any modern mobile browser, so you can
    convert and compress files straight from your phone.'],
    ];

    $faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqs)->map(fn ($faq) => [
    '@type' => 'Question',
    'name' => $faq['q'],
    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
    ])->all(),
    ];
    @endphp

    @push('schema')
    <script type="application/ld+json">
        {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}
    </script>
    @endpush
    @endif

    @section('content')

    {{-- ══ HERO ══ --}}
    <section class="relative pt-10 pb-10 overflow-hidden hero-glow">
        <div class="absolute inset-0 grid-lines pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">

            <div class="animate-fade-up opacity-0 delay-1 text-center mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-fn-text tracking-tight leading-tight">
                    @if ($activeCategory)
                    {{ str_contains($activeCategory->title, 'Tools') ? $activeCategory->title : $activeCategory->title .
                    ' Tools' }}
                    @elseif (request()->is('tools') || request()->is('tools/*'))
                    Free Online File Tools for <br> PDF, Images, Documents &amp; More
                    @else
                    Free Online File Tools – PDF, Word, Excel &amp; Image,<br>
                    For Modern Work
                    @endif
                </h1>

                @if ($activeCategory && ! empty($description))
                <p class="mt-4 max-w-2xl mx-auto text-fn-text3 text-base sm:text-lg leading-relaxed">
                    {{ $description }}
                </p>
                @elseif ($isHome)
                <p class="mt-4 max-w-2xl mx-auto text-fn-text3 text-base sm:text-lg leading-relaxed">
                    Convert, compress, merge and edit PDF, Word, Excel and image files right in your browser.
                    No software to install and no account needed.
                </p>
                @elseif (! $activeCategory)
                <p class="mt-4 max-w-2xl mx-auto text-fn-text3 text-base sm:text-lg leading-relaxed">
                    Every Filenewer tool in one place. Convert, compress, merge and split PDF, Word, Excel, CSV, JSON
                    and
                    image files, generate invoices and contracts, or use quick developer utilities.
                </p>
                @endif
            </div>

            {{-- Search bar --}}
            <div class="animate-fade-up opacity-0 delay-2 max-w-2xl mx-auto mb-6">
                @if ($isHome)
                {{-- Homepage search sends visitors to the full directory --}}
                <form action="/tools" method="GET" role="search" class="flex gap-3">
                    <label for="home-search" class="sr-only">Search tools</label>
                    <input id="home-search" name="q" type="search" required
                        placeholder="What do you want to do? e.g. merge PDF, CSV to Excel"
                        class="search-input flex-1 min-w-0 px-5 py-3.5 bg-fn-surface border border-fn-text/10 rounded-2xl text-fn-text text-base placeholder:text-fn-text3 font-sans transition-all" />
                    <button type="submit"
                        class="px-6 py-3.5 rounded-2xl bg-fn-blue text-white text-base font-semibold hover:opacity-90 transition-opacity">
                        Search
                    </button>
                </form>
                @else
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-fn-text3 w-5 h-5 pointer-events-none"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input id="global-search" type="search" value="{{ request('q') }}" aria-label="Search tools"
                        placeholder="Search tools… e.g. PDF, compress, invoice, CSV"
                        class="search-input w-full pl-12 pr-14 py-3.5 bg-fn-surface border border-fn-text/10 rounded-2xl text-fn-text text-base placeholder:text-fn-text3 font-sans transition-all" />
                    <kbd
                        class="absolute right-4 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1 px-2 py-1 bg-fn-surface2 border border-fn-text/10 rounded-md text-fn-text3 text-sm font-mono"><svg
                            xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-command" width="1em"
                            height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            style="vertical-align:-0.125em">
                            <path d="M7 9a2 2 0 1 1 2 -2v10a2 2 0 1 1 -2 -2h10a2 2 0 1 1 -2 2v-10a2 2 0 1 1 2 2h-10" />
                        </svg>K</kbd>
                </div>
                <p id="search-count" class="text-fn-text3 text-sm text-center mt-2.5 h-4" aria-live="polite"></p>
                @endif
            </div>

            {{-- Stats bar --}}
            <div class="animate-fade-up opacity-0 delay-3 flex items-center justify-center gap-8 flex-wrap">
                <div class="flex items-center gap-2 text-fn-text3 text-sm">
                    <span class="w-2 h-2 rounded-full bg-fn-green"></span>
                    <span><strong class="text-fn-text font-semibold">{{ $totalTools }}</strong> tools available</span>
                </div>
                <div class="flex items-center gap-2 text-fn-text3 text-sm">
                    <span class="w-2 h-2 rounded-full bg-fn-blue-l"></span>
                    <span><strong class="text-fn-text font-semibold">{{ $categories->count() }}</strong>
                        {{ Str::plural('category', $categories->count()) }}</span>
                </div>
                <div class="flex items-center gap-2 text-fn-text3 text-sm">
                    <span class="w-2 h-2 rounded-full bg-fn-amber"></span>
                    <span><strong class="text-fn-text font-semibold">100%</strong> free tools</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ══ TOOL GRID (curated on "/", full directory on /tools) ══ --}}
    <div class="max-w-7xl mx-auto px-6 {{ $isHome ? 'pb-16' : 'pb-24' }}">
        <div class="pt-2">

            @foreach ($sections as $section)
            @if ($section->tools->isNotEmpty())
            <div class="tool-section mb-10" id="{{ $section->slug }}" data-section="{{ $section->slug }}">

                {{-- Section header --}}
                <div class="flex items-center gap-3 mb-5">
                    @if ($section->icon)
                    <div
                        class="w-8 h-8 rounded-lg bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-base shrink-0">
                        {!! $section->icon !!}
                    </div>
                    @endif
                    <h2 class="text-base font-bold tracking-tight">{{ $section->title }}</h2>
                    @unless ($isHome)
                    <span class="px-2 py-0.5 bg-fn-surface2 rounded-full text-fn-text3 text-sm font-mono">
                        {{ $section->tools->count() }}
                    </span>
                    @endunless
                    <div class="flex-1 h-px bg-fn-text/7"></div>
                    @if ($isHome)
                    <a href="/tools" class="text-fn-blue-l text-sm font-semibold hover:underline shrink-0">
                        View all {{ $totalTools }} tools &rarr;
                    </a>
                    @endif
                </div>

                {{-- Tools grid --}}
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 section-tools">
                    @foreach ($section->tools as $tool)
                    @php
                    // Compare whole tags: "filenewer tools" contains "new" and was triggering the New badge.
                    $tagList = collect(explode(',', $tool->tags ?? ''))->map(fn ($tag) => strtolower(trim($tag)));
                    @endphp
                    <a href="/tools/{{ $tool->slug }}"
                        class="tool-card bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-start gap-3.5"
                        data-cat="{{ $section->slug }}" data-tags="{{ $tool->tags ?? '' }}"
                        data-name="{{ strtolower(trim($tool->name)) }}">

                        {{-- Icon --}}
                        <div
                            class="w-10 h-10 rounded-xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-lg shrink-0">
                            {!! $tool->icon !!}
                        </div>

                        {{-- Body --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-semibold text-sm leading-snug">{{ trim($tool->name) }}</h3>

                                {{-- Badges --}}
                                @if ($tagList->contains('popular'))
                                <span
                                    class="badge-popular shrink-0 px-1.5 py-0.5 text-sm font-semibold rounded-full border"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-flame">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 12c2 -2.96 0 -7 -1 -8c0 3.038 -1.773 4.741 -3 6c-1.226 1.26 -2 3.24 -2 5a6 6 0 1 0 12 0c0 -1.532 -1.056 -3.94 -2 -5c-1.786 3 -2.791 3 -4 2z" />
                                    </svg></span>
                                @elseif ($tagList->contains('new'))
                                <span
                                    class="badge-new shrink-0 px-1.5 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-sm font-semibold rounded-full">New</span>
                                @endif
                            </div>
                            {{-- Full description, clamped visually (no "..." baked into the HTML) --}}
                            <p class="text-fn-text3 text-sm leading-relaxed line-clamp-2">{{ $tool->description }}</p>
                        </div>

                        {{-- Arrow --}}
                        <svg class="tool-arrow w-4 h-4 text-fn-text3 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <line x1="7" y1="17" x2="17" y2="7" />
                            <polyline points="7 7 17 7 17 17" />
                        </svg>
                    </a>
                    @endforeach
                </div>

            </div>
            @endif
            @endforeach

            @unless ($isHome)
            <p id="no-results" class="hidden text-center text-fn-text3 text-base py-16">
                No tools match your search. Try a file format such as “pdf”, “csv” or “image”.
            </p>
            @endunless

        </div>
    </div>

    @if ($isHome)

    {{-- ══ CATEGORIES ══ --}}
    <section class="py-16 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="categories-heading">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-8">
                <h2 id="categories-heading" class="text-2xl sm:text-3xl font-bold tracking-tight">Browse tools by
                    category</h2>
                <p class="text-fn-text2 text-base mt-2 max-w-2xl">
                    Filenewer is a collection of free online tools for everyday file work: converting between PDF, Word,
                    Excel, CSV, JSON and image formats, compressing, merging and splitting documents, generating
                    invoices
                    and contracts, and quick developer utilities.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($categories as $category)
                @if ($category->tools->isNotEmpty())
                <a href="/tools?category={{ $category->slug }}"
                    class="bg-fn-bg border border-fn-text/8 rounded-xl p-5 flex items-center gap-4 hover:border-white/[0.15] transition-all">
                    <div
                        class="w-10 h-10 rounded-xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center shrink-0">
                        {!! $category->icon !!}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm leading-snug">{{ $category->title }}</h3>
                        <p class="text-fn-text3 text-sm mt-0.5">
                            {{ $category->tools->count() }} {{ Str::plural('tool', $category->tools->count()) }}
                        </p>
                    </div>
                    <svg class="w-4 h-4 text-fn-text3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="7" y1="17" x2="17" y2="7" />
                        <polyline points="7 7 17 7 17 17" />
                    </svg>
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══ HOW IT WORKS ══ --}}
    <section class="py-20" aria-labelledby="how-heading">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 id="how-heading" class="text-2xl sm:text-3xl font-bold tracking-tight">How Filenewer works</h2>
                <p class="text-fn-text2 text-base mt-3 max-w-xl mx-auto">Three steps, no sign-up and nothing to install.
                </p>
            </div>

            <ol class="grid md:grid-cols-3 gap-6 list-none">
                <li class="bg-fn-surface border border-fn-text/8 rounded-2xl p-8">
                    <span
                        class="inline-flex w-9 h-9 items-center justify-center rounded-full bg-fn-blue/10 border border-fn-blue/25 text-fn-blue-l text-sm font-bold mb-4">1</span>
                    <h3 class="text-lg font-semibold tracking-tight mb-2">Choose a tool</h3>
                    <p class="text-fn-text2 text-sm leading-relaxed">Pick a converter or editor from the list, or search
                        for the format you need, such as PDF to Word or Compress image.</p>
                </li>
                <li class="bg-fn-surface border border-fn-text/8 rounded-2xl p-8">
                    <span
                        class="inline-flex w-9 h-9 items-center justify-center rounded-full bg-fn-blue/10 border border-fn-blue/25 text-fn-blue-l text-sm font-bold mb-4">2</span>
                    <h3 class="text-lg font-semibold tracking-tight mb-2">Upload your file</h3>
                    <p class="text-fn-text2 text-sm leading-relaxed">Drag and drop a file or select one from your
                        device. Processing starts right away and takes just a few seconds for most files.</p>
                </li>
                <li class="bg-fn-surface border border-fn-text/8 rounded-2xl p-8">
                    <span
                        class="inline-flex w-9 h-9 items-center justify-center rounded-full bg-fn-blue/10 border border-fn-blue/25 text-fn-blue-l text-sm font-bold mb-4">3</span>
                    <h3 class="text-lg font-semibold tracking-tight mb-2">Download the result</h3>
                    <p class="text-fn-text2 text-sm leading-relaxed">Download your converted file as soon as it is
                        ready. Your files are deleted automatically after processing.</p>
                </li>
            </ol>
        </div>
    </section>

    <!-- ══════════════════════ FEATURES ══════════════════════ -->
    <section id="features" class="py-20 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="features-heading">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-12">
                <h2 id="features-heading" class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">Everything you need
                    to manage files</h2>
                <p class="text-fn-text2 text-base max-w-lg mx-auto leading-relaxed">Three toolsets built for individuals
                    and teams who want results without the complexity.</p>
            </div>

            <!-- Grid -->
            <div class="grid md:grid-cols-3 gap-px border border-white/[0.07] rounded-2xl overflow-hidden">

                <!-- Card 1 -->
                <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group">
                    <div
                        class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-blue/10 border border-fn-blue/25">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-refresh" aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold tracking-tight mb-2.5">File conversion tools</h3>
                    <p class="text-fn-text2 text-sm leading-relaxed mb-4">Transform file formats in seconds. Our online
                        file converter supports PDF, Word, Excel, CSV, JSON, Markdown, images and more, with
                        high-fidelity output for most documents.</p>
                    <span class="inline-block px-2.5 py-1 bg-fn-bg rounded-md text-sm font-mono text-fn-text3">PDF ·
                        DOCX · CSV · JPG</span>
                </div>

                <!-- Card 2 -->
                <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group">
                    <div
                        class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-cyan/10 border border-fn-cyan/25">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-certificate"
                            aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5" />
                            <path d="M3 14a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold tracking-tight mb-2.5">Business document generators</h3>
                    <p class="text-fn-text2 text-sm leading-relaxed mb-4">Create professional invoices and contracts.
                        Fill in your details and Filenewer produces a clean, print-ready PDF instantly.</p>
                    <span class="inline-block px-2.5 py-1 bg-fn-bg rounded-md text-sm font-mono text-fn-text3">Invoices
                        · Contracts</span>
                </div>

                <!-- Card 3 -->
                <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors group">
                    <div
                        class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-green/10 border border-fn-green/25">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-sparkles-2" aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M13 7a9.3 9.3 0 0 0 1.516 -.546c.911 -.438 1.494 -1.015 1.937 -1.932c.207 -.428 .382 -.928 .547 -1.522c.165 .595 .34 1.095 .547 1.521c.443 .918 1.026 1.495 1.937 1.933c.426 .205 .925 .38 1.516 .546a9.3 9.3 0 0 0 -1.516 .547c-.911 .438 -1.494 1.015 -1.937 1.932a9 9 0 0 0 -.547 1.521c-.165 -.594 -.34 -1.095 -.547 -1.521c-.443 -.918 -1.026 -1.494 -1.937 -1.932a9 9 0 0 0 -1.516 -.547" />
                            <path
                                d="M3 14a21 21 0 0 0 1.652 -.532c2.542 -.953 3.853 -2.238 4.816 -4.806a20 20 0 0 0 .532 -1.662a20 20 0 0 0 .532 1.662c.963 2.567 2.275 3.853 4.816 4.806q .75 .28 1.652 .532a21 21 0 0 0 -1.652 .532c-2.542 .953 -3.854 2.238 -4.816 4.806a20 20 0 0 0 -.532 1.662a20 20 0 0 0 -.532 -1.662c-.963 -2.568 -2.275 -3.853 -4.816 -4.806a21 21 0 0 0 -1.652 -.532" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold tracking-tight mb-2.5">Smart file processing</h3>
                    <p class="text-fn-text2 text-sm leading-relaxed mb-4">Compress, merge, split, encrypt and extract
                        text from PDF, Word, Excel and image files. Combine several files into one or split a large file
                        into parts.</p>
                    <span class="inline-block px-2.5 py-1 bg-fn-bg rounded-md text-sm font-mono text-fn-text3">Compress
                        · Merge · Split · OCR</span>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════════ PRIVACY ══════════════════════ -->
    <section id="security" class="py-20 bg-fn-bg relative overflow-hidden cyan-glow" aria-labelledby="security-heading">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 id="security-heading" class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">Your files stay
                    private</h2>
                <p class="text-fn-text2 text-base max-w-xl mx-auto leading-relaxed">Here is exactly how we handle the
                    files you upload.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">

                <div class="flex gap-4">
                    <div
                        class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-lock" aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" />
                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                            <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">Encrypted in transit</h3>
                        <p class="text-fn-text3 text-sm leading-relaxed">Files travel between your browser and our
                            servers over HTTPS (TLS), so nobody on the network can read them.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div
                        class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash" aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">Automatic file deletion</h3>
                        <p class="text-fn-text3 text-sm leading-relaxed">Uploaded files and conversion results are
                            deleted automatically after processing, within one hour at the latest.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div
                        class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-ban" aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M5.7 5.7l12.6 12.6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">We don't sell your files</h3>
                        <p class="text-fn-text3 text-sm leading-relaxed">We never sell your files or use them for
                            advertising. Tools marked as AI-powered send your input to an AI provider to generate the
                            result; see our <a href="/pages/privacy-policy" class="underline hover:text-fn-text">Privacy
                                Policy</a> for details.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div
                        class="w-9 h-9 flex-shrink-0 rounded-lg flex items-center justify-center bg-fn-cyan/10 border border-fn-cyan/20 text-sm mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-world" aria-hidden="true">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M3.6 9h16.8" />
                            <path d="M3.6 15h16.8" />
                            <path d="M11.5 3a17 17 0 0 0 0 18" />
                            <path d="M12.5 3a17 17 0 0 1 0 18" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm mb-1">Your data rights</h3>
                        <p class="text-fn-text3 text-sm leading-relaxed">You can contact us at any time about the
                            personal data we hold. Read our <a href="/pages/gdpr-compliance-policy"
                                class="underline hover:text-fn-text">GDPR policy</a> to see how requests are handled.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══ FAQ ══ --}}
    <section id="faq" class="py-20 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="faq-heading">
        <div class="max-w-3xl mx-auto px-6">
            <h2 id="faq-heading" class="text-2xl sm:text-3xl font-bold tracking-tight text-center mb-10">Frequently
                asked questions</h2>

            <div class="flex flex-col gap-3">
                @foreach ($faqs as $faq)
                <details class="group bg-fn-bg border border-fn-text/8 rounded-xl px-6 py-4">
                    <summary
                        class="cursor-pointer list-none flex items-center justify-between gap-4 font-semibold text-base">
                        <span>{{ $faq['q'] }}</span>
                        <span class="text-fn-text3 transition-transform group-open:rotate-45 text-xl leading-none"
                            aria-hidden="true">+</span>
                    </summary>
                    <p class="mt-3 text-fn-text2 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ══════════════════════ CTA ══════════════════════ -->
    <section id="cta" class="py-20 text-center relative overflow-hidden" aria-labelledby="cta-heading">
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <h2 id="cta-heading" class="text-2xl sm:text-3xl font-bold tracking-tight max-w-2xl mx-auto mb-4">Start
                processing files smarter, right now</h2>
            <p class="text-fn-text2 text-base max-w-md mx-auto leading-relaxed mb-8">
                Convert, compress, merge and generate files in your browser. Free to use, no account required.
            </p>
            <a href="/tools"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] transition-all">
                Browse all tools
            </a>
        </div>
    </section>

    @endif

    @endsection

    @unless ($isHome)
    @push('footer')
    <script>
        (function () {
            const cards = document.querySelectorAll('.tool-card');
            const sections = document.querySelectorAll('.tool-section');
            const input = document.getElementById('global-search');
            const count = document.getElementById('search-count');
            const empty = document.getElementById('no-results');
            if (!input) return;

            function filterTools() {
                const query = input.value.toLowerCase().trim();
                let visible = 0;

                cards.forEach(function (card) {
                    const haystack = ((card.dataset.name || '') + ' ' + (card.dataset.tags || '')).toLowerCase();
                    const show = !query || haystack.includes(query);
                    card.classList.toggle('hidden-card', !show);
                    if (show) visible++;
                });

                sections.forEach(function (section) {
                    const hasVisible = section.querySelector('.tool-card:not(.hidden-card)') !== null;
                    section.style.display = hasVisible ? '' : 'none';
                });

                count.textContent = query
                    ? visible + (visible === 1 ? ' result for “' : ' results for “') + input.value.trim() + '”'
                    : '';
                empty.classList.toggle('hidden', visible !== 0);
            }

            input.addEventListener('input', filterTools);

            document.addEventListener('keydown', function (e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    input.focus();
                    input.select();
                }
            });

            filterTools(); // applies ?q= coming from the homepage search
        })();
    </script>
    @endpush
    @endunless
