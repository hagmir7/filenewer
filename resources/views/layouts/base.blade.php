<!DOCTYPE html>
<html lang="en" dir="ltr" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- SEO Meta -->
    <title>{{ $title ?? 'Filenewer – Online File Tools &amp; Converters' }}</title>
    <meta name="description" content="{{ Str::limit($description ?? 'Filenewer is your all-in-one platform for online file tools: convert, generate, compress, and process business documents fast and securely. No install needed.', 169, '') }}" />
    <meta name="keywords" content="{{ $tags ?? 'online file tools, file converter online, business document generator, PDF tools online, secure file processing, free file tools' }}" />
    <link rel="canonical" href="{{ request()->fullUrl() }}" />
    <meta property="og:title" content="{{ $title ?? 'Filenewer – Online File Tools &amp; Converters' }}" />
    <meta property="og:description" content="{{ Str::limit($description ?? 'Convert, generate, compress, and process files in seconds. Fast, secure, and free online file tools for everyone.', 169, '') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="/favicon/favicon.svg">
    <meta property="og:url" content="{{ request()->fullUrl() }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta property="og:site_name" content="Filenewer" />
    {{-- <meta property="og:image" content="https://www.filenewer.com/images/og-pdf-to-word.png" /> --}}
    {{-- <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" /> --}}
    {{-- <meta property="og:image:alt" content="Filenewer PDF to Word Converter – Convert PDF to DOCX online for free" /> --}}
    <!-- Twitter / X Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $title ?? 'Filenewer – Online File Tools &amp; Converters' }}" />
    <meta name="twitter:description" content="{{ Str::limit($description ?? 'Convert, generate, compress, and process files in seconds. Fast, secure, and free online file tools for everyone.', 169, '') }}" />
    {{-- <meta name="twitter:image" content="https://www.filenewer.com/images/og-pdf-to-word.png" /> --}}
    {{-- <link rel="manifest" href="/site.webmanifest" /> --}}
    <meta name="google-site-verification" content="EQZYRJ21rxnFbPlDE5uDwRL5FIdDfphpwnhPp5h2Yz4" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Preconnect for performance -->
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
</head>
<body class="font-sans bg-fn-bg text-fn-text antialiased overflow-x-hidden">
    <x-nav />
    <main>@yield('content')</main>
    <x-footer />
    @stack('footer')
</body>
</html>
