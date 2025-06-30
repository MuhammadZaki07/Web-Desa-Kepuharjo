<section class="lg:px-20 px-5 bg-white py-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 lg:gap-20 gap-10">
        @forelse ($pengurusDesa as $index => $pengurus)
            <div class="w-full max-w-xs p-4 flex flex-col items-center lg:items-start mx-auto"
                 data-aos="fade-up"
                 data-aos-duration="800"
                 data-aos-delay="{{ ($index % 4) * 100 + 200 }}">
                <div class="w-40 h-40 lg:w-48 lg:h-48 overflow-hidden mb-4">
                    <img src="{{ $pengurus['foto'] ?? asset('assets/images/user-unknown.png') }}"
                        alt="Foto {{ $pengurus['name'] ?? 'Tidak diketahui' }}"
                        class="w-full h-full object-cover rounded-full lg:rounded-none" />
                </div>
                <div class="text-center lg:text-left">
                    <h1 class="font-semibold text-lg sm:text-xl text-gray-800">
                        {{ $pengurus['name'] ?? 'Tidak diketahui' }}</h1>
                    <p class="text-sm text-gray-500 font-light">{{ $pengurus['jabatan'] ?? 'Tidak diketahui' }}</p>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-400 italic py-10" data-aos="fade-in" data-aos-duration="800">
                Belum ada data pengurus desa.
            </div>
        @endforelse
    </div>
</section>
