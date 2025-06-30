@extends('layouts.app')
@section('content')
<section class="px-5 lg:px-20">
    <x-visi-misi class="block lg:my-10 my-5" :progamUnggulan="$ProfileDesa->program_unggulan ?? ''" :misi="$ProfileDesa->misi ?? ['tidak ada data']" :visi="$ProfileDesa->visi ?? '-' "/>
</section>
@endsection
