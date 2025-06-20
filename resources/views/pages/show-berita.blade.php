@extends('layouts.app')

@section('title', $article->title . ' - Berita Desa Kepuharjo')

@push('meta-tags')
    <meta name="description" content="{{ Str::limit(strip_tags($article->excerpt), 160) }}">
    <meta name="keywords"
        content="berita desa, desa kepuharjo, malang, jawa timur, indonesia, {{ $article->category->name }}, {{ Str::slug($article->title) }}">
    <meta name="author" content="{{ $article->user->name ?? 'Kepuharjo News' }}">
    <meta name="article:published_time" content="{{ $article->published_at ?? $article->created_at }}">
    <meta name="article:modified_time" content="{{ $article->updated_at }}">
    <meta name="article:section" content="{{ $article->category->name }}">
    <meta name="article:tag" content="{{ $article->category->name }}">

    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->excerpt), 160) }}">
    <meta property="og:image"
        content="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/foto_brawijaya 1.png') }}">
    <meta property="og:url" content="{{ route('articles.show', $article->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="Berita Desa Kepuharjo">
    <meta property="og:locale" content="id_ID">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($article->excerpt), 160) }}">
    <meta name="twitter:image"
        content="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/foto_brawijaya 1.png') }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "{{ $article->title }}",
        "description": "{{ Str::limit(strip_tags($article->excerpt), 160) }}",
        "image": "{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/foto_brawijaya 1.png') }}",
        "author": {
            "@type": "Person",
            "name": "{{ $article->user->name ?? 'Kepuharjo News' }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Berita Desa Kepuharjo",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('assets/' . $ProfileDesa->logo) }}"
            }
        },
        "datePublished": "{{ ($article->published_at ?? $article->created_at)->toISOString() }}",
        "dateModified": "{{ $article->updated_at->toISOString() }}",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ route('articles.show', $article->slug) }}"
        },
        "articleSection": "{{ $article->category->name }}",
        "keywords": "berita desa, desa kepuharjo, malang, {{ $article->category->name }}"
    }
    </script>
@endpush

@section('content')
    <div class="lg:px-20 px-5">
        <nav class="flex py-5 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600">
                        <i class="bi bi-house-door"></i> Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400"></i>
                        <a href="{{ route('articles.index') }}" class="ml-1 text-gray-700 hover:text-green-600">Berita</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400"></i>
                        <a href="{{ route('articles.index', ['category' => $article->category->slug]) }}"
                            class="ml-1 text-gray-700 hover:text-green-600">{{ $article->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bi bi-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-gray-500 truncate">{{ Str::limit($article->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="py-5 flex flex-col lg:flex-row gap-10 items-start">
            <div class="flex-1 lg:flex-[3]">
                <article class="bg-white rounded-xl overflow-hidden" itemscope itemtype="https://schema.org/NewsArticle">
                    <div class="relative">
                        <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/foto_brawijaya 1.png') }}"
                            alt="{{ $article->title }}" class="w-full h-64 lg:h-96 object-cover rounded-xl overflow-hidden"
                            loading="lazy" itemprop="image">

                        @if ($article->category->name)
                            <div class="absolute top-4 left-4">
                                <span style="background-color: {{ $article->category->color }}"
                                    class="text-white px-3 py-1 rounded-full text-sm font-medium" itemprop="articleSection">
                                    {{ $article->category->name }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 lg:p-8">
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <time datetime="{{ ($article->published_at ?? $article->created_at)->toISOString() }}"
                                    itemprop="datePublished">
                                    {{ \Carbon\Carbon::parse($article->published_at ?? $article->created_at)->format('d M Y, H:i') }}
                                </time>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ number_format($article->viewers) }} views</span>
                            </div>
                            @if ($article->user)
                                <div class="flex items-center gap-1">
                                    <i class="bi bi-person"></i>
                                    <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                                        <span itemprop="name">{{ $article->user->name }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>

                        <h1 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight" itemprop="headline">
                            {{ $article->title }}
                        </h1>

                        @if ($article->excerpt)
                            <p class="text-lg text-gray-600 mb-6 leading-relaxed" itemprop="description">
                                {{ $article->excerpt }}
                            </p>
                        @endif

                        <div class="prose prose-lg max-w-none" itemprop="articleBody">
                            {!! $article->content !!}
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center gap-4">
                                <span class="text-gray-600 font-medium">Bagikan:</span>
                                <div class="flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article->slug)) }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors"
                                        aria-label="Bagikan ke Facebook">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M18.77 7.46H15.5v-1.9c0-.9.6-1.1 1-1.1h2.2V.5h-3.4C13.2.5 11.5 2.4 11.5 5v2.46H9.5v3.6h2v10.94h3.5V11.06h2.6l.77-3.6Z" />
                                        </svg>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(route('articles.show', $article->slug)) }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="bg-sky-500 text-white p-2 rounded-full hover:bg-sky-600 transition-colors"
                                        aria-label="Bagikan ke Twitter">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z" />
                                        </svg>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . route('articles.show', $article->slug)) }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="bg-green-600 text-white p-2 rounded-full hover:bg-green-700 transition-colors"
                                        aria-label="Bagikan ke WhatsApp">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.570-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if ($article->author)
                            <div class="mt-8 p-7 bg-gray-50 rounded-lg" itemprop="author" itemscope
                                itemtype="https://schema.org/Person">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $article->author->photo ? asset('storage/' . $article->author->photo) : asset('assets/images/profile.jpg') }}"
                                        alt="{{ $article->author->name }}" class="w-16 h-16 rounded-full object-cover"
                                        loading="lazy" itemprop="image">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-900" itemprop="name">
                                            {{ $article->author->name }}</h3>
                                        @if ($article->author->role)
                                            <p class="text-gray-600 mt-1" itemprop="description">
                                                {{ $article->author->role }} | {{ $article->author->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <meta itemprop="dateModified" content="{{ $article->updated_at->toISOString() }}">
                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization"
                        style="display: none;">
                        <span itemprop="name">Berita Desa Kepuharjo</span>
                        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                            <meta itemprop="url" content="{{ asset('assets/logo/Logo_Kabupaten_Malang.png') }}">
                        </div>
                    </div>
                </article>

                @if ($relatedArticles->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($relatedArticles as $related)
                                <a href="{{ route('articles.show', $related->slug) }}" class="group">
                                    <div
                                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="relative">
                                            <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : asset('assets/images/default-berita-kepuharjo.png') }}"
                                                alt="{{ $related->title }} - Berita Desa Kepuharjo"
                                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                                loading="lazy">
                                            @if ($related->category)
                                                <span
                                                    class="absolute top-2 left-2 bg-green-700 text-white text-xs font-semibold px-2 py-1 rounded">
                                                    {{ $related->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3
                                                class="font-semibold text-gray-900 line-clamp-2 group-hover:text-green-600 transition-colors">
                                                {{ $related->title }}
                                            </h3>
                                            @if ($related->excerpt)
                                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $related->excerpt }}
                                                </p>
                                            @endif
                                            <div class="flex items-center justify-between mt-3 text-xs text-gray-500">
                                                <span>{{ \Carbon\Carbon::parse($related->created_at ?? $related->published_at)->diffForHumans() }}</span>
                                                <span>{{ number_format($related->viewers) }} views</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <x-comment />
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4 w-full flex flex-col gap-6 mt-10 lg:mt-0">
                <x-latest-blogs :articles="$latestArticles" />
                <x-category-blogs :categories="$categories" />
            </div>
        </div>
    </div>
@endsection
