@if (count($blogs) >= 3)
<div
    class="group flex items-center bg-white shadow-sm border border-slate-400/[0.2] mt-10 overflow-hidden rounded-lg relative">
    <div class="w-[170px] h-full overflow-hidden">
        <img src="{{ asset('assets/images/shape-trianggle-blogs.png') }}" alt="triangle"
            class="absolute inset-0 h-full object-cover z-10">
        <div class="absolute left-3 top-1/2 -translate-y-1/2 flex gap-2 items-center z-10">
            <i class="bi bi-clock-history text-white font-bold"></i>
            <h1 class="font-semibold text-white text-sm">Berita Terbaru</h1>
        </div>
    </div>
    <div class="overflow-hidden whitespace-nowrap w-full relative">
        <div class="animate-marquee inline-block">
            @forelse ($blogs as $blog)
                <a href="{{ route('articles.show', $blog->slug) }}"
                    class="inline-flex items-center space-x-2 px-4 text-gray-800 hover:underline hover:animate-bounce-stop">
                    <img src="{{ $blog['featured_image'] ? asset('storage/' . $blog['featured_image']) : asset('assets/images/default-thumbnail.jpg') }}"
                        class="w-full h-8 mt-1 object-cover rounded" alt="thumbnail">
                    <div class="flex flex-col text-[10px]">
                        <span class="font-medium text-black text-sm">{{ $blog['title'] }}</span>
                        <span class="text-gray-500">
                         <i class="bi bi-clock text-slate-500"></i> {{ $blog['created_at']->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </a>
            @empty
                <a href="#"
                    class="inline-block px-4 py-2 text-gray-800 hover:underline whitespace-nowrap animate-marquee cursor-default">
                    <span class="font-medium text-black text-sm">Tidak ada berita terbaru untuk saat ini. Silakan
                        kembali lagi nanti.</span>
                </a>
            @endforelse
        </div>
    </div>
</div>
@endif
