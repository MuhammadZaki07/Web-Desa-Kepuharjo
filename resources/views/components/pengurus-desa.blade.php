<section class="lg:px-20 px-5 bg-white py-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 lg:gap-20 gap-10">
        @foreach ($pengurusDesa as $pengurus)
            <div class="w-full max-w-xs p-4 flex flex-col items-center lg:items-start mx-auto">
                <div class="w-40 h-40 lg:w-48 lg:h-48 overflow-hidden mb-4">
                    <img src="{{ $pengurus['foto'] }}" alt="Foto {{ $pengurus['name'] }}"
                        class="w-full h-full object-cover rounded-full lg:rounded-none" />
                </div>
                <div class="text-center lg:text-left">
                    <h1 class="font-semibold text-lg sm:text-xl text-gray-800">{{ $pengurus['name'] }}</h1>
                    <p class="text-sm text-gray-500 font-light">{{ $pengurus['jabatan'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
