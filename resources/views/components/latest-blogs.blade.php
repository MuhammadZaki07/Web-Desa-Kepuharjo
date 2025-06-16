<div class="w-full lg:w-full bg-white rounded-xl shadow py-7 px-5 relative border-t border-t-green-600">
    <h2 class="text-green-600 text-xl font-semibold mb-4">Berita Terbaru</h2>

    <div class="space-y-4">
        @foreach ($articles as $index => $article)
            <div class="flex gap-2">
                <span class="text-slate-400">#{{ $index + 1 }}</span>
                <div class="flex gap-1 flex-col">
                    <a href="{{ route('articles.show', $article->slug) }}">
                        <h3 class="font-semibold text-slate-700 hover:text-green-600 cursor-pointer">
                            {{ $article->title }}
                        </h3>
                    </a>
                    <p class="text-slate-400 text-xs">
                        {{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('l | d F Y | H:i') }} WIB
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
