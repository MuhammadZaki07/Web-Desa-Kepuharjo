@php
    $navItems = [
        ['label' => 'Beranda', 'href' => '/'],
        [
            'label' => 'Profile Desa',
            'dropdown' => [
                ['label' => 'Profile Data Penduduk', 'href' => '/profile-data-penduduk'],
                ['label' => 'Visi & Misi', 'href' => '/visi-misi'],
                ['label' => 'Sejarah Desa', 'href' => '/sejarah'],
                ['label' => 'PKK', 'href' => '/pkk'],
                ['label' => 'Karang Taruna', 'href' => '/karang-taruna'],
            ],
        ],
        ['label' => 'Berita', 'href' => '/berita'],
        ['label' => 'Pemerintahan', 'href' => '/pemerintahan'],
        ['label' => 'Galeri', 'href' => '/gallery'],
        ['label' => 'UMKM', 'href' => '/umkm'],
    ];
    $currentUrl = request()->path();
@endphp

<nav x-data="{ sidebarOpen: false, searchOpen: false }"
    class="px-5 lg:px-20 flex items-center justify-between text-sm font-medium py-5 relative border-b border-b-slate-300">
    <div class="lg:opacity-50 lg:pointer-events-none">
        <button @click="sidebarOpen = true">
            <i class="bi bi-list text-3xl text-slate-700 opacity-70 font-bold"></i>
        </button>
    </div>

    <div class="hidden lg:flex items-center gap-10 justify-center flex-1">
        @foreach ($navItems as $item)
            @if (isset($item['dropdown']))
                <div x-data="{ open: false, selected: '{{ $item['label'] }}' }" class="relative group">
                    <button @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false"
                        class="flex items-center gap-1 hover:text-green-700 transition font-bold cursor-pointer">
                        <span x-text="selected"></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition @mouseenter="open = true" @mouseleave="open = false"
                        class="absolute left-0 mt-2 w-44 bg-white shadow-md rounded-md z-50 overflow-hidden">
                        @foreach ($item['dropdown'] as $subItem)
                            <a href="{{ $subItem['href'] }}" @click="selected = '{{ $subItem['label'] }}'; open = false"
                                class="block px-4 py-2
                                    hover:bg-green-50 hover:text-green-600 text-slate-700
                                    {{ request()->is(ltrim($subItem['href'], '/')) ? 'text-green-600 font-bold border-l-4 border-green-600 bg-green-50' : '' }}">
                                {{ $subItem['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $item['href'] }}"
                    class="transition font-bold
            {{ url()->current() === url($item['href']) ? 'text-green-700 border-b-2 border-green-600 pb-1' : 'hover:text-green-700' }}">
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </div>

    <div class="relative">
        <div class="flex items-center gap-4 text-green-700">
            <i @click="searchOpen = !searchOpen" class="bi bi-search cursor-pointer text-xl"></i>
            <a href="/auth">
                <i class="bi bi-box-arrow-in-right cursor-pointer text-xl"></i>
            </a>
        </div>

        <div x-show="searchOpen" @click.away="searchOpen = false" x-transition
            class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg p-2 z-50">
            <form action="/search" method="GET" class="flex items-center gap-2">
                <input type="text" name="q" placeholder="Cari sesuatu..."
                    class="w-full border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-green-600" />
                <button type="submit"
                    class="bg-green-700 cursor-pointer text-white px-3 py-1 rounded hover:bg-green-800 text-sm"><i
                        class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    <div x-show="sidebarOpen" x-transition:enter="transition duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg p-6 z-50 lg:hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-green-700">Menu</h2>
            <button @click="sidebarOpen = false">
                <i class="bi bi-x-lg text-xl text-slate-700"></i>
            </button>
        </div>
        <nav class="flex flex-col gap-3">
            @foreach ($navItems as $item)
                @if (isset($item['dropdown']))
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex justify-between items-center w-full px-2 py-2 rounded text-left text-green-700 font-semibold hover:bg-gray-100">
                            <span>{{ $item['label'] }}</span>
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="pl-4">
                            @foreach ($item['dropdown'] as $subItem)
                                <a href="{{ $subItem['href'] }}"
                                    class="block py-1 text-slate-700 hover:text-green-700">{{ $subItem['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item['href'] }}"
                        class="px-2 py-2 text-green-700 hover:bg-gray-100 rounded font-semibold">{{ $item['label'] }}</a>
                @endif
            @endforeach
        </nav>
    </div>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition
        class="fixed inset-0 bg-black/40 z-40 lg:hidden"></div>
</nav>
