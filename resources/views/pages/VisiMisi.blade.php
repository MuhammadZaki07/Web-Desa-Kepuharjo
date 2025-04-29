@extends('layouts.app')
@section('content')
<section class="px-5 lg:px-20">
    <div class="hidden lg:block my-10">
        <x-running-blog :blogs="$blogs" />
    </div>
    <x-visi-misi class="block"/>
</section>
@endsection
