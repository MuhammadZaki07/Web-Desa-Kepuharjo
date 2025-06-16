@extends('layouts.app')
@section('content')
<section class="px-5 lg:px-20">
    <div class="hidden lg:block my-10">
        <x-running-blog :blogs="$blogs" />
    </div>
    {{-- {{ $ProfileDesa->program_unggulan }} --}}
    <x-visi-misi class="block" :progamUnggulan="$ProfileDesa->program_unggulan" :misi="$ProfileDesa->misi" :visi="$ProfileDesa->visi"/>
</section>
@endsection
