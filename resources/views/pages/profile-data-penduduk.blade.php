@extends('layouts.app')
@section('content')
    @push('blog-running')
        <section class="lg:px-20 px-5">
            <x-running-blog :blogs="$blogs" />
            <x-chart.mixed-chart id="pendudukChart" :series1-data="[2, 3, 1, 1, 2, 3, 3, 2, 2, 1, 1, 3]" :series2-data="[30, 35, 20, 25, 40, 55, 60, 40, 30, 20, 25, 50]" :categories="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']" series1-name="Usage"
                series2-name="Banyak Jiwa" y-axis-title="Jumlah" />
            <x-card.data-penduduk class="w-full py-3" id="#" />
            <div class="flex flex-col lg:flex-row gap-15 items-center py-10">
                <div class="lg:flex-8">
                    <x-comment />
                </div>
                <div class="lg:flex-3 lg:w-1/3">
                    <x-suara-pembaca />
                </div>
            </div>
        </section>
    @endpush
@endsection
