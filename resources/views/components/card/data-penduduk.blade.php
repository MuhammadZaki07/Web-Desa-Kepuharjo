@php
    $warnaClasses = [
        'green' => [
            'base' => 'green',
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'border' => 'bg-green-800',
            'line' => 'bg-green-800',
            'faint' => 'text-green-200',
        ],
        'red' => [
            'base' => 'red',
            'bg' => 'bg-red-100',
            'text' => 'text-red-600',
            'border' => 'bg-red-500',
            'line' => 'bg-red-400',
            'faint' => 'text-red-200',
        ],
        'blue' => [
            'base' => 'blue',
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-600',
            'border' => 'bg-blue-400',
            'line' => 'bg-blue-400',
            'faint' => 'text-blue-200',
        ],
    ];
@endphp

<div id="{{ $id }}" class="{{ $class }}">
    <x-badge class="py-2 lg:flex mx-auto hidden">Data Penduduk</x-badge>
    <p class="text-center text-slate-500 font-semibold mt-5 hidden lg:block">
        Data Penduduk Desa Kepuharjo Karangploso Kabupaten Malang
    </p>

    <div class="grid lg:grid-cols-3 grid-cols-1 lg:gap-10 gap-5 lg:py-10 py-5">
        @foreach ($dataPenduduk as $item)
            @php
                $warna = $warnaClasses[$item['warna']] ?? $warnaClasses['blue'];
            @endphp
            <div class="relative bg-white rounded-xl shadow-md p-5 w-full">
                <div class="absolute top-0 left-0 w-full h-2 {{ $warna['border'] }} rounded-t-xl"></div>
                <div class="flex items-center gap-2 {{ $warna['bg'] }} {{ $warna['text'] }} px-2 py-1 rounded-md w-max mt-5">
                    <i class="{{ $item['icon'] }} {{ $warna['text'] }}"></i>
                    <span class="text-sm font-medium {{ $warna['text'] }}">Penduduk</span>
                </div>
                <div class="mt-6">
                    <div class="flex items-end gap-2">
                        <h2 class="text-5xl sm:text-4xl font-bold text-black">{{ $item['jumlah'] ?? "No data"}}</h2>
                        <span class="{{ $warna['text'] }} font-medium lg:text-sm text-lg">Jiwa</span>
                    </div>
                    <p class="text-slate-400 font-semibold mt-2 text-sm sm:text-base">{{ $item['label'] ?? "Noo Data"}}</p>
                    <div class="h-1 {{ $warna['line'] }} w-20 mt-2 rounded-full"></div>
                </div>
                <div class="absolute right-5 bottom-5 opacity-20 text-8xl sm:text-7xl {{ $warna['faint'] }}">
                    <i class="{{ $item['icon'] }}"></i>
                </div>
            </div>
        @endforeach
    </div>
</div>
