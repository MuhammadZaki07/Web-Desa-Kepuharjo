@extends('layouts.app')
@section('content')
    <div class="lg:px-20 px-5">
        <div class="lg:py-16 py-10 flex flex-col lg:flex-row gap-10 items-start">
            <div class="flex-1 lg:flex-7">
                <x-content>
                    <div class="border-b-2 border-green-700 mb-6">
                        <h1 class="text-2xl font-semibold text-black">Kepuh News</h1>
                    </div>

                    <div class="mb-6 space-y-4">
                        <form method="GET" action="{{ route('articles.index') }}" class="flex gap-2">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ $search }}"
                                    placeholder="Cari berita Desa Kepuharjo..."
                                    class="w-full px-4 py-2 border outline-none border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 cursor-pointer text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            @if ($search || $category || $sort !== 'terbaru')
                                <a href="{{ route('articles.index') }}"
                                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                    Reset
                                </a>
                            @endif
                            <input type="hidden" name="category" value="{{ $category }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                        </form>

                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-sm font-medium text-gray-700">Urutkan:</span>
                            @php
                                $sortOptions = [
                                    'terbaru' => 'Terbaru',
                                    'hari-ini' => 'Hari Ini',
                                    'bulan-ini' => 'Bulan Ini',
                                    'tahun-ini' => 'Tahun Ini',
                                    'views-terbanyak' => 'Views Terbanyak',
                                ];
                            @endphp
                            @foreach ($sortOptions as $value => $label)
                                <a href="{{ request()->fullUrlWithQuery(['sort' => $value]) }}"
                                    class="px-3 py-1 text-sm rounded-full border transition-colors {{ $sort === $value ? 'bg-green-600 text-white border-green-600' : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-green-100 hover:border-green-300' }}"
                                    rel="{{ $sort === $value ? 'nofollow' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>

                        @if ($category || $search)
                            <div class="flex flex-wrap gap-2 items-center">
                                <span class="text-sm font-medium text-gray-700">Filter aktif:</span>
                                @if ($category)
                                    @php
                                        $categoryName =
                                            $categories->where('slug', $category)->first()?->name ?? $category;
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                        Kategori: {{ $categoryName }}
                                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                            class="text-green-600 hover:text-green-800">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </span>
                                @endif
                                @if ($search)
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                        Pencarian: "{{ $search }}"
                                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="bi bi-x"></i>
                                        </a>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if ($getHeadlinesInPageArticle->isNotEmpty() && !$search && !$category)
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Berita Viral Desa Kepuharjo</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach ($getHeadlinesInPageArticle as $headline)
                                    <a href="{{ route('articles.show', $headline->slug) }}">
                                        <div class="group cursor-pointer">
                                            <div class="relative rounded-xl overflow-hidden">
                                                <img src="{{ $headline->featured_image ? asset('storage/' . $headline->featured_image) : asset('assets/images/default-berita-kepuharjo.png') }}"
                                                    alt="{{ $headline->title }} - Berita Desa Kepuharjo" loading="lazy"
                                                    class="w-full h-48 md:h-64 object-cover transition-opacity duration-500 group-hover:opacity-80" />
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 group-hover:via-black/20 to-transparent z-10 transition-all duration-500 ease-in-out">
                                                </div>
                                                <div class="absolute inset-0 z-20 overflow-hidden pointer-events-none">
                                                    <div
                                                        class="absolute w-[50px] h-[500%] bg-white/50 transform rotate-45 translate-x-[-100%] translate-y-[-100%] group-hover:translate-x-[150%] group-hover:translate-y-[150%] transition-all duration-[2000ms] ease-in-out">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="py-2 px-1 flex flex-col gap-2">
                                                <h3
                                                    class="font-bold text-gray-800 text-sm md:text-base lg:text-xl hover:text-green-800 hover:underline">
                                                    {{ $headline->title }}
                                                </h3>
                                                <div class="flex flex-wrap gap-3 items-center">
                                                    @if ($headline->category)
                                                        <div
                                                            class="py-1 px-2 text-white bg-green-700 font-semibold text-xs rounded">
                                                            {{ $headline->category->name }}
                                                        </div>
                                                    @endif
                                                    <div class="flex items-center gap-1 text-gray-600 text-xs">
                                                        <i class="bi bi-clock"></i>
                                                        <span
                                                            class="font-semibold">{{ $headline->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1 text-gray-600 text-xs">
                                                        <i class="bi bi-eye"></i>
                                                        <span>{{ number_format($headline->viewers ?? 0) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    <div class="space-y-5">
                        @if ($articles->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($articles as $article)
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        <div
                                            class="flex gap-3 items-start hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                            <div
                                                class="w-28 h-20 md:w-32 md:h-24 flex-shrink-0 rounded-lg overflow-hidden relative">
                                                <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default-berita-kepuharjo.png') }}"
                                                    alt="{{ $article->title }} - Berita Desa Kepuharjo" loading="lazy"
                                                    class="w-full h-full object-cover" />
                                                @if ($article->category)
                                                    <div
                                                        class="absolute bottom-1 left-1 text-white font-semibold px-1.5 py-0.5 bg-green-700 rounded text-xs shadow">
                                                        {{ $article->category->name }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-between flex-grow">
                                                <h2
                                                    class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 hover:text-green-800 hover:underline cursor-pointer">
                                                    {{ $article->title }}
                                                </h2>
                                                @if ($article->excerpt)
                                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                                        {{ $article->excerpt }}
                                                    </p>
                                                @endif
                                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-2 flex-wrap">
                                                    <span>KepuhNews</span>
                                                    <span><i class="bi bi-clock-fill text-slate-500"></i></span>
                                                    <span>{{ $article->created_at->diffForHumans() }}</span>
                                                    <span><i class="bi bi-eye-fill text-slate-500"></i></span>
                                                    <span>{{ number_format($article->viewers ?? 0) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-gray-500 text-lg mb-2">
                                    <i class="bi bi-search text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada berita ditemukan</h3>
                                <p class="text-gray-600">Coba ubah kata kunci pencarian atau filter yang Anda gunakan.</p>
                            </div>
                        @endif
                    </div>

                    @if ($articles->hasPages())
                        <link rel="prev" href="{{ $articles->onFirstPage() ? null : $articles->previousPageUrl() }}" />
                        <link rel="next" href="{{ $articles->hasMorePages() ? $articles->nextPageUrl() : null }}" />
                        <div class="flex justify-between items-center mt-8">
                            <div class="flex lg:justify-start justify-center items-center gap-4">
                                @if ($articles->onFirstPage())
                                    <button disabled
                                        class="w-10 h-10 bg-gray-300 text-gray-500 cursor-not-allowed flex items-center justify-center">
                                        <i class="bi bi-arrow-left"></i>
                                    </button>
                                @else
                                    <a href="{{ $articles->previousPageUrl() }}"
                                        class="w-10 h-10 bg-green-600 text-white hover:bg-green-800 flex items-center justify-center transition-colors">
                                        <i class="bi bi-arrow-left"></i>
                                    </a>
                                @endif

                                <div class="flex gap-2">
                                    @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                                        @if ($page == $articles->currentPage())
                                            <span
                                                class="w-10 h-10 bg-green-600 text-white font-medium flex items-center justify-center">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="w-10 h-10 bg-green-50 text-green-700 font-medium hover:bg-green-200 flex items-center justify-center transition-colors">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>

                                @if ($articles->hasMorePages())
                                    <a href="{{ $articles->nextPageUrl() }}"
                                        class="w-10 h-10 bg-green-600 text-white hover:bg-green-800 flex items-center justify-center transition-colors">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                @else
                                    <button disabled
                                        class="w-10 h-10 bg-gray-300 text-gray-500 cursor-not-allowed flex items-center justify-center">
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                @endif
                            </div>

                            <div class="mt-4 text-sm text-gray-600 text-center lg:text-left">
                                Menampilkan {{ $articles->firstItem() }} sampai {{ $articles->lastItem() }} dari
                                {{ $articles->total() }} berita
                            </div>
                        </div>
                    @endif
                </x-content>
            </div>

            <div class="lg:w-1/4 w-full flex flex-col gap-5 mt-10 lg:mt-0">
                <x-category-blogs :categories="$categories" />
            </div>
        </div>
    </div>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Berita Desa Kepuharjo",
        "description": "Berita terbaru dan informasi penting dari Desa Kepuharjo, Malang.",
        "url": "{{ route('articles.index') }}",
        "mainEntity": [
            @foreach ($articles as $article)
                {
                    "@type": "NewsArticle",
                    "headline": "{{ $article->title }}",
                    "url": "{{ route('articles.show', $article->slug) }}",
                    "image": "{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('assets/images/default-berita-kepuharjo.png') }}",
                    "datePublished": "{{ $article->created_at->toAtomString() }}",
                    "dateModified": "{{ $article->updated_at->toAtomString() }}",
                    "author": {
                        "@type": "Organization",
                        "name": "Kepuharjo News"
                    },
                    "publisher": {
                        "@type": "Organization",
                        "name": "Desa Kepuharjo",
                        "logo": {
                            "@type": "ImageObject",
                            "url": "{{ asset('assets/' . $ProfileDesa->logo) }}"
                        }
                    }
                }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    }
    </script>
@endsection
