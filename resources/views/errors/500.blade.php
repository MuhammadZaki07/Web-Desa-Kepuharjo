@extends('layouts.app')
@section('content')
    @php
        $title = '500';
        $timeData = App\Helpers\TimeHelper::getFormattedTime();
        $headlines = App\Services\ArticleService::getHeadlines();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];
    @endphp
    <div class="py-20 px-10">
        <div class="w-1/4 mx-auto">
            <img src="{{ asset('assets/svg/errors/500 Internal Server Error-amico.svg') }}" alt="500 Error" class="">
        </div>
        <h1 class="text-5xl text-center font-bold text-green-700 mt-10">500 Internal Server Error</h1>
    </div>
@endsection
