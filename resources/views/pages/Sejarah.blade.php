@extends('layouts.app')
@section('content')
    <section class="lg:px-20 px-5 py-3">
        <div class="hidden lg:block">
            <x-running-blog :blogs="$blogs" />
            <x-banner-sejarah :menus="$menus" />
        </div>
        <x-layouts-blogs>
            <x-flex-one>
                <x-content>
                    <div class="overflow-hidden rounded-xl w-full">
                        @if ($ProfileDesa->image_sejarah)
                            <img src="{{ asset('storage/' . $ProfileDesa->image_sejarah) }}" alt="Kantor Desa Kepuharjo | {{ $ProfileDesa->name }}"
                                class="w-full h-[350px] object-cover">
                        @endif
                    </div>
                    <div class="flex flex-col gap-3 py-3 mt-5">
                        <h1 class="font-bold text-4xl text-gray-800">Sejarah Desa Kepuharjo</h1>
                    </div>
                    <div id="content" class="space-y-8 text-gray-800">
                        <p class="text-lg font-normal leading-relaxed text-gray-800">
                            {!! $ProfileDesa->sejarah_desa ?? 'tidak ada sejarah yang tersedia' !!}
                        </p>
                    </div>
                </x-content>
                <x-comment />
            </x-flex-one>
            <x-flex-two>
                <x-latest-blogs :articles="$viralBlogs"/>
                <x-category-blogs :categories="$categories"/>
            </x-flex-two>
        </x-layouts-blogs>
    </section>
@endsection
