@php
    $bannerData = $banner[0];
@endphp

<section class="w-full h-[500px] relative bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ $banner[1] }}')">
    <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black to-transparent"></div>
    <div
        class="absolute flex justify-center flex-col gap-4 w-2/3 left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <h1 class="font-bold text-white lg:text-6xl text-4xl text-center uppercase">
            {{ $bannerData[0] ?? 'GALERI DESA' }}
        </h1>
        <p class="text-center lg:text-lg text-sm text-white font-normal">
            {{ $bannerData->description ?? 'Deskripsi belum tersedia' }}
        </p>
    </div>
</section>
