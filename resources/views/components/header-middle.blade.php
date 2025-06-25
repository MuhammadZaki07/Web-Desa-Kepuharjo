@php
    $dataDesa = \App\Models\ProfileDesa::first();
@endphp

<div class="pt-10 px-6 lg:px-20">
    <div class="flex justify-between items-center flex-wrap gap-y-4">
        <div class="flex gap-3 text-lg text-slate-800 mx-auto lg:m-0">
            @if ($dataDesa?->instagram)
                <a href="https://instagram.com/{{ ltrim($dataDesa->instagram, '@') }}" target="_blank"
                    rel="noopener noreferrer">
                    <i class="bi bi-instagram"></i>
                </a>
            @endif

            @if ($dataDesa?->tiktok)
                <a href="https://tiktok.com/@{{ ltrim($dataDesa - > tiktok, '@') }}" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-tiktok"></i>
                </a>
            @endif

            @if ($dataDesa?->facebook)
                <a href="https://facebook.com/{{ ltrim($dataDesa->facebook, '@') }}" target="_blank"
                    rel="noopener noreferrer">
                    <i class="bi bi-facebook"></i>
                </a>
            @endif

            @if ($dataDesa?->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $dataDesa->whatsapp) }}" target="_blank"
                    rel="noopener noreferrer">
                    <i class="bi bi-whatsapp"></i>
                </a>
            @endif

            @if ($dataDesa?->youtube)
                <a href="https://youtube.com/@{{ ltrim($dataDesa - > youtube, '@') }}" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-youtube"></i>
                </a>
            @endif
        </div>


        <div class="flex flex-col gap-2">
            <h1 class="text-3xl lg:text-3xl font-bold text-center text-green-700 uppercase">
                {{ strtoupper($dataDesa?->kecamatan ?? 'KARANGPLOSO') }}
                <span class="hidden lg:inline">|</span>
                DESA {{ strtoupper($dataDesa?->name ?? ' Nama Desa') }}
            </h1>
            <h1 class="text-sm font-medium text-center text-gray-400 hidden lg:block">
                {{ $dataDesa?->motto_desa ?? 'Website resmi desa kepuharjo kab.Malang' }}
            </h1>
        </div>

        <h1 class="text-sm text-slate-500 hidden lg:block">
            {{ $dataDesa?->email ?? 'Email Desa' }}
        </h1>

        <div class="w-full h-0.5 bg-green-900 mt-3 rounded"></div>
    </div>
</div>
