@extends('layouts.app')
@section('content')
    <x-banner-pemerintahan>
        <section class="w-full h-[500px] relative bg-cover bg-center bg-no-repeat hidden lg:block"
            style="background-image: url('{{ $bannerImagePath }}')">
            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-r from-black to-transparent"></div>
            <div
                class="absolute flex justify-start flex-col gap-4 lg:w-4/5 lg:left-15 left-0 top-1/4 sm:top-40 lg:px-4 px-8">
                <h1 class="font-bold text-white lg:text-6xl text-5xl lg:text-left text-center uppercase">
                    {{ $banner->title[0] }}</h1>
                <p class="lg:text-left text-center lg:text-lg text-sm text-white font-normal lg:w-2/3">
                    {{ $banner->description }}
                </p>
            </div>
        </section>
    </x-banner-pemerintahan>

    <div class="px-5 lg:px-20 lg:py-10 py-5">
        <x-layouts-blogs>
            <x-flex-one>
                <x-content>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Struktur dan Kegiatan Karang Taruna Desa Kepuharjo</h1>
                    <p class="text-sm text-gray-500 mb-6">Diperbarui pada: {{ $data['updated_at'] ?? 'no data' }}</p>

                    <div class="text-gray-700 mb-6 leading-relaxed">
                        {!! $data['content'] !!}
                    </div>

                    @if (!empty($data['structure']))
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Struktur Organisasi Karang Taruna Desa
                            Kepuharjo</h2>
                        <table class="w-full text-left text-sm border-t border-gray-200 mb-8">
                            <thead class="bg-gray-50 text-gray-700">
                                <tr>
                                    <th class="py-3 px-4 border-b">Jabatan</th>
                                    <th class="py-3 px-4 border-b">Nama</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                @foreach ($data['structure'] as $item)
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="py-3 px-4 border-b">{{ $item['jabatan'] }}</td>
                                        <td class="py-3 px-4 border-b">{{ $item['nama'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if (!empty($data['programs']))
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ count($data['programs']) }} Program Kerja Karang Taruna</h2>
                        <ul class="list-decimal pl-6 text-gray-700 space-y-2 mb-8">
                            @foreach ($data['programs'] as $program)
                                <li>{{ $program }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if (!empty($data['activities']))
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ count($data['activities']) }} Kegiatan Rutin Karang Taruna</h2>
                        <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-8">
                            @foreach ($data['activities'] as $activity)
                                <li>{{ $activity }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Hubungi Kami</h2>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data['contact_phone']) }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        <i class="bi bi-whatsapp text-lg"></i>
                        Hubungi via WhatsApp
                    </a>

                </x-content>

                <div class="w-full pt-10">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-5xl font-bold text-green-600">Galeri <span class="text-black">Karang Taruna</span>
                        </h1>
                        <div class="bg-green-600 w-1/9 py-0.5"></div>
                    </div>
                    @if (!empty($data['gallery']))
                        <div class="grid grid-cols-4 gap-5 py-5">
                            @foreach ($data['gallery'] as $image)
                                <img src="{{ asset($image) }}"
                                    class="hover:scale-105 duration-200 transition ease-in-out w-full" alt="">
                            @endforeach
                        </div>
                    @else
                        <div class="text-5xl font-bold text-green-700 my-10">Tidak ada foto Karang Taruna saat ini</div>
                    @endif
                </div>
            </x-flex-one>

             <x-flex-two>
                <x-latest-blogs :articles="$articles"/>
            </x-flex-two>
        </x-layouts-blogs>
    </div>
@endsection
