@extends('layouts.app')
@section('content')
    @push('blog-running')
        <section class="lg:px-20 px-5">
            <x-running-blog :blogs="$blogs" />
            <x-chart.mixed-chart
                id="pendudukChart"
                :series1-data="$series1Data"
                :series2-data="$series2Data"
                :categories="$categories"
                series1-name="Laki-Laki"
                series2-name="Perempuan"
                y-axis-title="Jumlah Penduduk"
            />
            {{-- {{ dd($ProfileDesa) }} --}}
            <x-card.data-penduduk class="w-full py-3" id="#" :dataPenduduk="$dataPenduduk" />
            <div class="flex flex-col lg:flex-row gap-15 items-center py-10">
                <div class="lg:flex-8">
                    <x-comment />
                </div>
                <div class="lg:flex-3 lg:w-1/3">
                    <x-latest-blogs :articles="$viralBlogs"/>
                </div>
            </div>
        </section>
    @endpush
@endsection
