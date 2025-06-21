@extends('layouts.app')
@section('content')
    <x-banner-pemerintahan>
        <section class="w-full h-[500px] relative bg-cover bg-center bg-no-repeat hidden lg:block"
            style="background-image: url('{{ $imagesPathBanner }}')">
            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-r from-black to-transparent"></div>
            <div
                class="absolute flex justify-start flex-col gap-4 lg:w-4/5 lg:left-15 left-0 top-1/4 sm:top-40 lg:px-4 px-8">
                <h1 class="font-bold text-white lg:text-6xl text-5xl lg:text-left text-center">{{ $banner->title[0] ?? '-' }}
                </h1>
                <p class="lg:text-left text-center lg:text-lg text-sm text-white font-normal lg:w-2/3">
                    {{ $banner->description ?? '-' }}
                </p>
            </div>
        </section>
        @if ($ProfileDesa && $ProfileDesa->sambutan_pemerintah)
            <div class="lg:px-20 px-5">
                <div class="flex flex-col gap-5 py-20">
                    <h1 class="font-semibold text-4xl text-center lg:text-left">Pemerintahan Desa</h1>
                    <p class="lg:text-xl font-light text-lg lg:text-left text-center">
                        {{ $ProfileDesa->sambutan_pemerintah }}
                    </p>
                </div>
            </div>
        @else
            <div class="lg:px-20 px-5">
                <div class="flex flex-col gap-5 py-20">
                    <h1 class="font-semibold text-4xl text-center lg:text-left">Pemerintahan Desa</h1>
                    <p class="lg:text-xl font-light text-lg lg:text-left text-center">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore, voluptatum!
                    </p>
                </div>
            </div>
        @endif

    </x-banner-pemerintahan>
    <x-sambutan class="bg-slate-50 w-full py-24 px-5 lg:px-20" id="">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-12 py-10">
            <div class="w-48 h-48 lg:w-64 lg:h-64 overflow-hidden mx-auto">
                @if ($ProfileDesa && $ProfileDesa->user && $ProfileDesa->user->photo)
                    <img src="{{ asset('storage/' . $ProfileDesa->user->photo) }}" alt="Foto Kepala Desa"
                        class="w-full h-full object-cover" />
                @else
                    <img src="{{ asset('assets/images/user-unkown.png') }}" alt="Foto Kepala Desa (Default)"
                        class="w-full h-full object-cover" />
                @endif
            </div>

            <div class="flex-1 text-gray-800 relative">
                <div
                    class="absolute top-0 left-0 -translate-x-6 -translate-y-6 text-6xl text-black select-none hidden lg:block">
                    “</div>
                <h2 class="text-2xl lg:text-5xl font-bold mb-4 text-black text-center lg:text-left">Sambutan <span
                        class="text-green-700">Kepala Desa</span>
                </h2>
                <p class="text-lg leading-relaxed font-light text-center lg:text-left">
                    {{ $ProfileDesa->sambutan_kepala_desa ?? '-' }}
                </p>
                <div class="mt-6 text-center lg:text-left">
                    <p class="font-semibold text-black text-xl">{{ $kepalaDesa ?? '-' }}</p>
                    <p class="text-sm text-gray-500 font-light">Kepala Desa Kepuharjo</p>
                </div>
            </div>
        </div>
    </x-sambutan>
    <x-pengurus-desa :pengurusDesa="$pengurus" />
@endsection
