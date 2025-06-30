@extends('layouts.app')
@section('content')
    <x-banner-gallery :banner="[$banner, $imagesPathBanner]" />

    <div class="lg:px-20 lg:py-16 px-5 py-2 flex flex-col lg:flex-row gap-10 items-start">
        <div class="lg:flex-1 w-full">
            <div class="mb-8 border-b border-b-slate-300 p-3">
                <form id="filterForm" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="searchInput" name="search" placeholder="Cari gallery..."
                            class="w-full px-4 py-2 border outline-none cursor-pointer border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ request('search') }}">
                    </div>
                    <div class="flex gap-3">
                        <select id="typeFilter" name="type"
                            class="px-4 py-2 w-full border cursor-pointer border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tipe</option>
                            @foreach ($types as $type)
                                <option class="uppercase" value="{{ $type }}"
                                    {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $type) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors cursor-pointer">
                            Cari
                        </button>
                        <button type="button" onclick="resetFilters()"
                            class="bg-gray-100 hover:bg-gray-200 cursor-pointer text-gray-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </form>
            </div>

            @if ($galleries->count() > 0)
                <div class="mb-6 text-sm text-gray-600">
                    Menampilkan {{ $galleries->firstItem() }} - {{ $galleries->lastItem() }} dari {{ $galleries->total() }}
                    gallery
                    @if (request('search'))
                        untuk pencarian "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if (request('type'))
                        dengan tipe "<strong>{{ str_replace('_', ' ', request('type')) }}</strong>"
                    @endif
                </div>

                <div id="bento-grid" class="grid grid-cols-2 md:grid-cols-3 gap-4 auto-rows-[150px]">
                    @foreach ($galleries as $index => $gallery)
                        @php
                            $gridClasses = [
                                'row-span-2',
                                '',
                                'row-span-2',
                                '',
                                'row-span-2',
                                '',
                                '',
                                'row-span-2 col-span-2',
                                '',
                            ];
                            $class = $gridClasses[$index % count($gridClasses)];
                        @endphp
                        <div class="relative group cursor-pointer overflow-hidden {{ $class }}"
                            onclick="openModal({{ $gallery->id }})">
                            <img src="{{ $gallery->path ? asset('storage/' . $gallery->path) : asset('assets/images/profile.jpg') }}"
                                alt="{{ $gallery->title }}"
                                class="w-full h-full object-cover rounded-xl grayscale group-hover:grayscale-0 transition-all duration-500 ease-in-out" />

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-500">
                            </div>

                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out">
                                <div class="text-white">
                                    <h3 class="font-bold text-sm md:text-base mb-1 line-clamp-1">{{ $gallery->title }}</h3>
                                    <p class="text-xs md:text-sm opacity-90 line-clamp-2 mb-2">
                                        {{ Str::limit($gallery->description, 80) }}</p>
                                    <div class="flex items-center gap-2 text-xs">
                                        <span
                                            class="bg-white/20 px-2 py-1 rounded-full">{{ str_replace('_', ' ', $gallery->type) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($galleries->hasPages())
                    <div class="mt-12 flex justify-start">
                        {{ $galleries->links('custom.pagination') }}
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-20 text-gray-500">
                    <div class="w-24 h-24 mb-6">
                        <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @if (request()->hasAny(['search', 'type']))
                        <h3 class="text-xl font-semibold mb-2">Tidak ada galeri ditemukan</h3>
                        <p class="text-gray-400 text-center max-w-md mb-4">
                            Tidak ada galeri yang sesuai dengan pencarian
                            @if (request('search'))
                                "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('type'))
                                dengan tipe "<strong>{{ str_replace('_', ' ', request('type')) }}</strong>"
                            @endif
                        </p>
                        <button onclick="resetFilters()"
                            class="px-6 py-2 cursor-pointer bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Reset Filter
                        </button>
                    @else
                        <h3 class="text-xl font-semibold mb-2">Belum ada galeri</h3>
                        <p class="text-gray-400 text-center max-w-md">
                            Belum ada galeri yang ditambahkan. Silakan kembali lagi nanti.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="lg:w-1/4 w-full flex flex-col gap-5 mt-10 lg:mt-0">
            <x-latest-blogs :articles="$articles" />
        </div>
    </div>

    <div id="imageModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[9999] hidden">
        <div class="relative max-w-2xl w-full mx-4">
            <button onclick="closeModal()"
                class="absolute -top-4 -right-4 z-10 cursor-pointer bg-white rounded-full p-2 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
                <div class="w-full h-80 bg-gray-100 rounded">
                    <img id="modalImage" loading="lazy" src="" alt="" class="w-full h-full object-cover" />
                </div>

                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 mb-2"></h2>
                            <div id="modalMeta" class="flex items-center gap-3 text-sm text-gray-600"></div>
                        </div>
                    </div>

                    <div id="modalDescription" class="text-gray-700 leading-relaxed"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
       const galleries = @json($galleries->items());
        const APP_URL = @json(config('app.url'));

        function openModal(galleryId) {
            const gallery = galleries.find(g => g.id === galleryId);
            if (!gallery) return;

            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const modalMeta = document.getElementById('modalMeta');
            const modalDescription = document.getElementById('modalDescription');

            modalImage.src = gallery.path ? `${APP_URL}/storage/${gallery.path}` :
                `${APP_URL}/assets/images/profile.jpg`;
            modalImage.alt = gallery.title;
            modalTitle.textContent = gallery.title;
            modalDescription.textContent = gallery.description;

            const metaHtml = `
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    ${gallery.type.charAt(0).toUpperCase() + gallery.type.slice(1)}
                </span>
                ${gallery.event_date ? `<span class="text-gray-500">${new Date(gallery.event_date).toLocaleDateString('id-ID', {
                              weekday: 'long',
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            })}</span>` : ''}
            `;
            modalMeta.innerHTML = metaHtml;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('typeFilter').value = '';
            window.location.href = window.location.pathname;
        }

        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const url = new URL(window.location);

            // Clear existing params
            url.searchParams.delete('search');
            url.searchParams.delete('type');

            // Add new params
            const search = formData.get('search');
            const type = formData.get('type');

            if (search && search.trim()) {
                url.searchParams.set('search', search.trim());
            }
            if (type) {
                url.searchParams.set('type', type);
            }

            window.location.href = url.toString();
        });

        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').dispatchEvent(new Event('submit'));
            }
        });

        document.addEventListener('click', function(e) {
            const modal = document.getElementById('imageModal');
            if (e.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endpush
