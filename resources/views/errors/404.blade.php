@extends('layouts.app')
@section('content')
    @php
        $title = '404';
        $timeData = App\Helpers\TimeHelper::getFormattedTime();
        $headlines = App\Services\ArticleService::getHeadlines();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
    @endphp
    <div class="py-20 px-10">
        <div class="w-1/4 mx-auto">
            <img src="{{ asset('assets/svg/errors/404 error with a tired person-pana.svg') }}" alt="404 Error" class="">
        </div>
        <h1 class="text-5xl text-center font-bold text-green-700 mt-10">Halaman Tidak ditemukan</h1>
    </div>
@endsection
