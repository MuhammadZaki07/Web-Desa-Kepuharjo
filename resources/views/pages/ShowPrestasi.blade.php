@extends('layouts.app')

@section('title', $prestasi->title . ' - Prestasi Desa')
@section('meta_description',
    'Detail prestasi ' .
    $prestasi->title .
    ' yang diraih oleh ' .
    $prestasi->participant_name .
    ' pada tanggal ' .
    \Carbon\Carbon::parse($prestasi->achievement_date)->format('d F Y')
)

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Achievement",
  "name": "{{ $prestasi->title }}",
  "description": "{{ strip_tags($prestasi->description) }}",
  "dateAchieved": "{{ \Carbon\Carbon::parse($prestasi->achievement_date)->format('Y-m-d') }}",
  "achiever": {
    "@type": "Person",
    "name": "{{ $prestasi->participant_name }}"
  },
  "category": "{{ $prestasi->category }}",
  "award": "{{ $prestasi->rank }}",
  "image": "{{ asset('storage/' . $prestasi->image_path) }}"
}
</script>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <nav class="flex items-center space-x-2 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-gray-700">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('prestasi.index') }}" class="hover:text-gray-700">Prestasi</a>
                    <span>/</span>
                    <span class="text-gray-900">{{ Str::limit($prestasi->title, 30) }}</span>
                </nav>
                <a href="{{ route('prestasi.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Hero Image -->
            <div class="aspect-video bg-gray-200 relative">
                <img src="{{ asset('storage/' . $prestasi->image_path) }}" alt="{{ $prestasi->title }}"
                     class="w-full h-full object-cover">
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if ($prestasi->category === 'Olahraga') bg-yellow-100 text-yellow-800
                        @elseif($prestasi->category === 'Seni & Budaya') bg-green-100 text-green-800
                        @elseif($prestasi->category === 'Pendidikan') bg-purple-100 text-purple-800
                        @elseif($prestasi->category === 'Lingkungan') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $prestasi->category }}
                    </span>
                </div>
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        {{ $prestasi->rank }}
                    </span>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $prestasi->title }}</h1>
                    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($prestasi->achievement_date)->format('d F Y') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $prestasi->participant_name }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            {{ ucfirst($prestasi->level) }}
                        </div>
                    </div>
                </div>

                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Prestasi</h2>
                    <div class="text-gray-700 leading-relaxed">{!! $prestasi->description !!}</div>
                </div>
            </div>
        </div>

        <!-- Prestasi Lainnya -->
        <div class="mt-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Prestasi Lainnya</h2>
                <a href="{{ route('prestasi.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($related as $item)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <div class="aspect-video bg-gray-200">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium px-2 py-1 rounded-full
                                    @if ($item->category === 'Olahraga') bg-yellow-100 text-yellow-800
                                    @elseif($item->category === 'Seni & Budaya') bg-green-100 text-green-800
                                    @elseif($item->category === 'Pendidikan') bg-purple-100 text-purple-800
                                    @elseif($item->category === 'Lingkungan') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $item->category }}
                                </span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->achievement_date)->format('d M Y') }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2 leading-tight">
                                <a href="{{ route('prestasi.show', $item->slug) }}" class="hover:text-blue-600">
                                    {{ Str::limit($item->title, 50) }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $item->participant_name }}</p>
                            <a href="{{ route('prestasi.show', $item->slug) }}"
                               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('prestasi.index') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Halaman Prestasi
            </a>
        </div>
    </div>
</div>
@endsection
