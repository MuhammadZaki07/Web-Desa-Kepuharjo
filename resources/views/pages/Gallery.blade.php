@extends('layouts.app')
@section('content')
    <x-banner-gallery :banner="[$banner,$imagesPathBanner]"/>
    <div class="lg:px-20 lg:py-16 px-5 py-10 flex flex-col lg:flex-row gap-10 items-start">
        <div class="lg:flex-1 w-full">
            <div id="bento-grid" class="grid grid-cols-3 gap-4 auto-rows-[150px]">
                <div class="row-span-2">
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div>
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div class="row-span-2">
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div>
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div class="row-span-2">
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div>
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div>
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
                <div class="row-span-2 col-span-2">
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-102 transition duration-400 ease-in-out" />
                </div>
                <div>
                    <img src="{{ asset('assets/banners/gellery/sawah.jpg') }}" onclick="openModal(this.src)"
                        class="w-full h-full object-cover rounded-xl cursor-pointer hover:scale-105 transition duration-400 ease-in-out" />
                </div>
            </div>
        </div>

        <div class="lg:w-1/4 w-full flex flex-col gap-5 mt-10 lg:mt-0">
            <x-category-blogs :categories="$categories"/>
            <x-latest-blogs :articles="$articles"/>
        </div>
    </div>
    <div id="imageModal" class="fixed inset-0 bg-black/50 bg-opacity-70 flex items-center justify-center z-[9999] hidden">
        <div class="relative max-w-4xl w-full p-4">
            <img id="modalImage" src="" alt="Preview" class="w-full h-auto rounded-xl shadow-lg" />
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        document.addEventListener('click', function(e) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            if (e.target === modal && !img.contains(e.target)) {
                closeModal();
            }
        });
    </script>
@endpush
