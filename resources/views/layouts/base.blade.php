<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- SEO Meta -->
    <title>{{ $title ?? 'Filenewer – Online File Tools &amp; Converters' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Filenewer is your all-in-one platform for online file tools: convert, generate, compress, and process business documents fast and securely. No install needed.' }}" />
    <meta name="keywords"
        content="{{ $tags ?? 'online file tools, file converter online, business document generator, PDF tools online, secure file processing, free file tools' }}" />
    <link rel="canonical" href="{{ request()->fullUrl() }}" />
    <meta property="og:title" content="{{ $title ?? 'Filenewer – Online File Tools &amp; Converters' }}" />
    <meta property="og:description"
        content="{{ $description ?? 'Convert, generate, compress, and process files in seconds. Fast, secure, and free online file tools for everyone.' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="/favicon/favicon.svg">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Filenewer" />
    {{--
    <link rel="manifest" href="/site.webmanifest" /> --}}

    <meta name="google-site-verification" content="EQZYRJ21rxnFbPlDE5uDwRL5FIdDfphpwnhPp5h2Yz4" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet" />
</head>

<body class="font-sans bg-fn-bg text-fn-text antialiased overflow-x-hidden">
    <x-nav />
    <main>@yield('content')</main>
    <x-footer />
</body>

</html>
