    <script type="application/ld+json">
        {
                "@@context": "https://schema.org",
                "@@type": "WebApplication",
                "name": "{{ $tool->name }}",
                "url": "{{ request()->fullUrl() }}",
                "description": "{{ $tool->title }}",
                "applicationCategory": "UtilitiesApplication",
                "operatingSystem": "Any",
                    "provider": {
                        "@@type": "Organization",
                        "name": "Filenewer",
                        "url": "https://www.filenewer.com"
                    }
                }
    </script>

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "BreadcrumbList",
            "itemListElement": [
                { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://www.filenewer.com/" },
                { "@type": "ListItem", "position": 2, "name": "Tools", "item": "https://www.filenewer.com/tools" },
                { "@type": "ListItem", "position": 3, "name": "{{ $tool->category->title }}", "item": "https://www.filenewer.com/tools?category={{ $tool->category->slug }}" },
                { "@type": "ListItem", "position": 4, "name": "{{ $tool->name }}" }
            ]
            }
    </script>
