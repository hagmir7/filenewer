@php
    $toolUrl = url()->current();
    $category = $tool->category;

    $webApplicationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => $tool->name,
        'url' => $toolUrl,
        'description' => $tool->description ?: $tool->title,
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Any',
        'browserRequirements' => 'Requires JavaScript',
        'isAccessibleForFree' => true,
        'offers' => [
            '@type' => 'Offer',
            'price' => '0',
            'priceCurrency' => 'USD',
        ],
        'provider' => [
            '@type' => 'Organization',
            'name' => 'Filenewer',
            'url' => 'https://filenewer.com',
        ],
    ];

    $breadcrumbItems = [
        ['name' => 'Home', 'item' => url('/')],
        ['name' => 'Tools', 'item' => url('/tools')],
    ];

    if ($category) {
        $breadcrumbItems[] = [
            'name' => $category->title,
            'item' => url('/tools') . '?' . http_build_query(['category' => $category->slug]),
        ];
    }

    $breadcrumbItems[] = ['name' => $tool->name, 'item' => $toolUrl];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($breadcrumbItems)
            ->values()
            ->map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['item'],
            ])
            ->all(),
    ];

    $schemaJsonFlags = JSON_UNESCAPED_SLASHES
        | JSON_UNESCAPED_UNICODE
        | JSON_HEX_TAG
        | JSON_HEX_AMP
        | JSON_INVALID_UTF8_SUBSTITUTE;
@endphp

<script type="application/ld+json">{!! json_encode($webApplicationSchema, $schemaJsonFlags) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbSchema, $schemaJsonFlags) !!}</script>
