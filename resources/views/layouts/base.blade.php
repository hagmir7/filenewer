@php
    $baseUrl = rtrim(config('app.url'), '/');
    $canonical = $baseUrl . request()->getPathInfo();
    $pageTitle = $title ?? 'Filenewer – Online File Tools & Converters';
    $rawDescription = $description ?? 'Filenewer is your all-in-one platform for online file tools: convert, generate, compress, and process business documents fast and securely. No install needed.';
    // Strip tags, collapse newlines/spaces, cut at a word boundary
    $pageDescription = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($rawDescription))), 160, '…', preserveWords: true);
    $homeSchema = null;
    if (request()->is('/')) {
        $homeSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => $baseUrl . '/#website',
                    'url' => $baseUrl . '/',
                    'name' => 'Filenewer',
                    'alternateName' => ['Filenewer.com'],
                    'publisher' => ['@id' => $baseUrl . '/#organization'],
                ],
                [
                    '@type' => 'Organization',
                    '@id' => $baseUrl . '/#organization',
                    'name' => 'Filenewer',
                    'url' => $baseUrl . '/',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $baseUrl . '/filenewer-logo.svg',
                    ],
                ],
            ],
        ];
    }
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}" />
    <link rel="canonical" href="{{ $canonical }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta property="og:title" content="{{ $pageTitle }}" />
    <meta property="og:description" content="{{ $pageDescription }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:site_name" content="Filenewer" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:image" content="{{ $baseUrl }}/filenewer-thumbnail.png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $pageTitle }}" />
    <meta name="twitter:description" content="{{ $pageDescription }}" />
    <meta name="twitter:image" content="{{ $baseUrl }}/filenewer-thumbnail.png" />
    @if ($homeSchema)
        <script type="application/ld+json">{!! json_encode($homeSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5306320936731470" crossorigin="anonymous"></script>
    <meta name="google-site-verification" content="Pyz_dZTtqYYTpgqR_U-mRi67lCHeqOvFSNgA-Pmztpk" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://api.filenewer.com" />
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Filenewer" />
    <meta name="theme-color" content="#0f1117" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
    @stack('scripts')
    @stack('styles')
    <script src="https://analytics.ahrefs.com/analytics.js" data-key="MVOHoGZmMjs1xCZHU4fAjg" async></script>
</head>
<body class="font-sans bg-fn-bg text-fn-text antialiased overflow-x-hidden">
    <x-nav />
    <main>@yield('content')</main>
    <x-footer />
    @stack('footer')
</body>
</html>
