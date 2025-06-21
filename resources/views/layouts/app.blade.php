<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if ($ProfileDesa && $ProfileDesa->logo_desa)
        <link rel="icon" type="image/png" sizes="32x32"
            href="{{ asset('storage/' . $ProfileDesa->logo_desa) }}?v={{ time() }}">
        <link rel="shortcut icon" sizes="32x32" href="{{ asset('storage/' . $ProfileDesa->logo_desa) }}"
            type="image/png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $ProfileDesa->logo_desa) }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . $ProfileDesa->logo_desa) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $ProfileDesa->logo_desa) }}">
    @else
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}">
    @endif

    <title>
        {{ isset($article) ? $article->title . ' - Berita Desa Kepuharjo' : $title ?? 'Desa Kepuharjo - Informasi Terkini Desa Kepuharjo Malang' }}
    </title>
    <meta name="title"
        content="{{ isset($article) ? $article->title . ' - Berita Desa Kepuharjo' : $title ?? 'Desa Kepuharjo - Informasi Terkini Desa Kepuharjo Malang' }}">
    <meta name="description"
        content="{{ isset($article) ? Str::limit(strip_tags($article->excerpt), 155) : 'terbaru dan informasi penting dari Desa Kepuharjo, Malang, Jawa Timur. Dapatkan update kegiatan desa, pengumuman, dan berita viral terkini.' }}">
    <meta name="keywords"
        content="Desa kepuharjo,web desa, kepuh, desa kepuharjo malang, berita malang, jawa timur, indonesia, viral, news, kegiatan desa{{ isset($article) ? ', ' . $article->category->name : '' }}{{ isset($article->tags) ? ', ' . implode(', ', $article->tags->pluck('name')->toArray()) : '' }}">
    <meta name="author" content="Kepuharjo News">
    <meta name="robots"
        content="{{ request()->has('search') || request()->has('category') ? 'noindex, follow' : 'index, follow' }}">

    <link rel="canonical"
        href="{{ request()->fullUrlWithoutQuery(['page', 'utm_source', 'utm_medium', 'utm_campaign']) }}">
    <meta property="og:type" content="{{ isset($article) ? 'article' : 'website' }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title"
        content="{{ isset($article) ? $article->title : $title ?? 'Desa Kepuharjo - Informasi Terkini' }}">
    <meta property="og:description"
        content="{{ isset($article) ? Str::limit(strip_tags($article->excerpt), 155) : 'Berita terbaru dan informasi penting dari Desa Kepuharjo, Malang, Jawa Timur.' }}">
    <meta property="og:image"
        content="{{ isset($article) && $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/logo/Logo_Kabupaten_Malang.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Desa Kepuharjo">
    <meta property="og:locale" content="id_ID">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="{{ isset($article) ? $article->title : $title ?? 'Desa Kepuharjo' }}">
    <meta property="twitter:description"
        content="{{ isset($article) ? Str::limit(strip_tags($article->excerpt), 155) : 'Desa Kepuharjo, Malang' }}">
    <meta property="twitter:image"
        content="{{ isset($article) && $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/logo/Logo_Kabupaten_Malang.png') }}">
    @stack('meta')
    @stack('structured_data')
    @stack('head')
    @if (isset($article))
        <meta property="article:published_time" content="{{ $article->created_at->toISOString() }}">
        <meta property="article:modified_time" content="{{ $article->updated_at->toISOString() }}">
        <meta property="article:author" content="{{ $article->author->name ?? 'Kepuharjo News' }}">
        <meta property="article:section" content="{{ $article->category->name }}">
        @if ($article->tags)
            @foreach ($article->tags as $tag)
                <meta property="article:tag" content="{{ $tag->name }}">
            @endforeach
        @endif
    @endif
    @if (isset($article))
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "{{ $article->title }}",
        "description": "{{ strip_tags($article->excerpt) }}",
        "image": "{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/logo/Logo_Kabupaten_Malang.png') }}",
        "datePublished": "{{ ($article->published_at ?? $article->created_at)->toISOString() }}",
        "dateModified": "{{ $article->updated_at->toISOString() }}",
        "author": {
            "@type": "Person",
            "name": "{{ $article->author->name ?? 'Kepuharjo News' }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Berita Desa Kepuharjo",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ request()->url() }}"
        }
    }
    </script>
    @else
        <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Berita Desa Kepuharjo",
        "description": "Berita terbaru dan informasi penting dari Desa Kepuharjo, Malang, Jawa Timur",
        "url": "{{ request()->url() }}",
        "publisher": {
            "@type": "Organization",
            "name": "Berita Desa Kepuharjo",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}"
            }
        },
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/') }}?search={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    @endif
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//unpkg.com">

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://unpkg.com" crossorigin>

    @vite('resources/css/app.css')
    <style>
        body {
            font-display: swap;
        }
    </style>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" media="print"
        onload="this.media='all'; this.onload=null;">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        media="print" onload="this.media='all'; this.onload=null;">

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" as="script">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body>
    @include('partials.navbar')
    @stack('blog-running')
    <main role="main">
        @yield('content')
    </main>

    @include('partials.footer')
    <x-pengajuan />

    @stack('js')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    once: true,
                    duration: 1000,
                    easing: 'ease-in-out',
                    disable: window.innerWidth < 768
                });
            }
        });
    </script>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register("{{ asset('sw.js') }}")
                    .then(function(registration) {
                        // console.log('SW registered:', registration);
                    })
                    .catch(function(registrationError) {
                        // console.log('SW registration failed:', registrationError);
                    });
            });
        }
    </script>

</body>

</html>
