@props(['categories'])

<div class="w-full rounded-lg bg-white p-5 border-t-2 border-green-600 shadow">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Kategori Berita</h3>

    @if($categories && $categories->count() > 0)
        <ul class="divide-y divide-gray-200">
            <li>
                <a href="{{ route('articles.index') }}"
                   class="group flex justify-between items-center py-3 text-base font-light text-gray-800 hover:text-green-500 hover:border-b hover:border-green-600 {{ !request('category') ? 'text-green-600 font-medium' : '' }}">
                    <span>Semua Kategori</span>
                    <span class="text-gray-500 group-hover:text-green-600 font-medium">
                        ({{ $categories->sum('published_articles_count') }})
                    </span>
                </a>
            </li>

            @foreach($categories as $categoryItem)
                <li>
                    <a href="{{ route('articles.index', ['category' => $categoryItem->slug]) }}"
                       class="group flex justify-between items-center py-3 text-base font-light text-gray-800 hover:text-green-500 hover:border-b hover:border-green-600 {{ request('category') === $categoryItem->slug ? 'text-green-600 font-medium' : '' }}">
                        <span>{{ $categoryItem->name }}</span>
                        <span class="text-gray-500 group-hover:text-green-600 font-medium">
                            ({{ $categoryItem->published_articles_count }})
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-4">
            <p class="text-gray-500 text-sm">Belum ada kategori tersedia</p>
        </div>
    @endif
</div>
