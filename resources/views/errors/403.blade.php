@extends('layouts.app')
@section('content')
    @php
        $title = '403';
        $timeData = App\Helpers\TimeHelper::getFormattedTime();
        $headlines = App\Services\ArticleService::getHeadlines();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
    @endphp
    <div class="py-20 px-10">
        <div class="w-1/4 mx-auto">
            <img src="{{ asset('assets/svg/errors/403 Error Forbidden-bro.svg') }}" alt="403 Error" class="">
        </div>
        <h1 class="text-5xl text-center font-bold text-green-700 mt-10">Anda Tidak memiliki akses</h1>
    </div>
@endsection
