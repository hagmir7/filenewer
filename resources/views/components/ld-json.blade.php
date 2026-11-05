@php
    $webApplicationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => $tool->name,
        'url' => url()->current(),
        'description' => $tool->description ?: $tool->title,
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Any',
        'provider' => [
            '@type' => 'Organization',
            'name' => 'Filenewer',
            'url' => 'https://filenewer.com',
        ],
    ];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Tools',
                'item' => url('/tools'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $tool->category->title,
                'item' => url('/tools') . '?' . http_build_query([
                    'category' => $tool->category->slug,
                ]),
            ],
            [
                '@type' => 'ListItem',
                'position' => 4,
                'name' => $tool->name,
                'item' => url()->current(),
            ],
        ],
    ];

    $schemaJsonFlags = JSON_UNESCAPED_SLASHES
        | JSON_UNESCAPED_UNICODE
        | JSON_HEX_TAG
        | JSON_HEX_AMP
        | JSON_HEX_APOS
        | JSON_HEX_QUOT
        | JSON_THROW_ON_ERROR;
@endphp

<script type="application/ld+json">
{!! json_encode($webApplicationSchema, $schemaJsonFlags) !!}
</script>

<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, $schemaJsonFlags) !!}
</script>
