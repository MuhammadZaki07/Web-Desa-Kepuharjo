@extends('layouts.app')
@section('content')
    <x-hero-banner />
    <section class="w-full lg:px-32 px-4 lg:pb-16">
        <div class="bg-green-600 py-0.5 rounded-full mt-7"></div>

        <nav class="w-full border-b border-slate-200 lg:border-none py-0 lg:py-5">
            <ul class="flex flex-wrap justify-center gap-4 md:gap-8 lg:gap-15 px-4 py-4">
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="sambutan">Sambutan <span class="hidden lg:inline-block">Kades</span></li>
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="data-penduduk">Data Penduduk</li>
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="visi-misi">Visi Misi</li>
                <li class="tab relative font-semibold text-sm md:text-base text-slate-500 hover:text-green-600 hover:border-green-600 pb-2 border-b-2 border-transparent cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105"
                    data-target="sejarah">Sejarah</li>
            </ul>
        </nav>

        <div class="lg:px-20 px-0 py-5">
            <x-sambutan />
            <x-card.data-penduduk class="tab-content hidden w-full py-3" id="data-penduduk" />
            <x-visi-misi />
            <x-sejarah />
        </div>
    </section>
    <x-latest-information :blogs="$blogs" />
    @include('partials.LocationContact')
@endsection
@push('js')
    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        function activateTab(targetId) {
            tabs.forEach(t => {
                t.classList.remove('text-green-600', 'border-b-4', 'border-b-green-600');
                t.classList.add('text-slate-400');
            });

            contents.forEach(c => c.classList.add('hidden'));

            const activeTab = document.querySelector(`.tab[data-target="${targetId}"]`);
            const activeContent = document.getElementById(targetId);

            if (activeTab && activeContent) {
                activeTab.classList.remove('text-slate-400');
                activeTab.classList.add('text-green-600', 'border-b-4', 'border-b-green-600');
                activeContent.classList.remove('hidden');
            }
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetId = tab.getAttribute('data-target');
                activateTab(targetId);
                localStorage.setItem('activeTab', targetId);
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem('activeTab') || 'sambutan';
            activateTab(savedTab);
        });
    </script>
@endpush
