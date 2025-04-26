<section class="w-full relative bg-white py-32 lg:py-0 hidden lg:block">
    <img src="{{ asset('assets/svg/Vector-green.svg') }}" alt="Vector" class="w-full hidden lg:block">
    <div
        class="absolute top-[27%] lg:left-1/2  w-full transform lg:-translate-x-1/2 -translate-y-1/2 z-10 text-center text-black lg:text-white px-5 lg:px-0">
        <div class="mb-14">
            <x-badge text="text-white" bg="bg-green-50/50" class="mb-4 mx-auto py-1 w-48 hidden lg:flex">
                Desa Maju
            </x-badge>
        </div>
        <h1 class="font-bold lg:text-4xl text-3xl text-green-800 lg:text-white">Mari Ketahui Lebih Banyak Tentang
            Desa Kami</h1>
        <h2 class="mt-4 font-normal text-sm lg:text-base ">Temukan informasi lengkap tentang Desa Kepuharjo dan
            layanan yang
            tersedia</h2>
    </div>
</section>
<section class="w-full bg-white py-20 relative lg:px-20 px-5">
    <div class="absolute top-0 right-0 left-0 flex justify-center flex-col gap-5">
        <x-badge class="py-1 w-56 mx-auto">Lokasi & Kontak</x-badge>
        <h1 class="text-center text-slate-500 lg:font-semibold font-medium lg:text-lg text-sm">Temukan lokasi dan
            informasi
            kontak desa Kepuharjo</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-9 gap-12 items-center">
        <div class="col-span-5">
            <div class="card besar">
                <div class="rounded-xl py-10">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15395.650937236189!2d112.6142691219156!3d-7.91335866500083!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7881fd53f16b63%3A0x94c4d5335cf55ea!2sKepuharjo%2C%20Kec.%20Karang%20Ploso%2C%20Kabupaten%20Malang%2C%20Jawa%20Timur!5e1!3m2!1sid!2sid!4v1745550818313!5m2!1sid!2sid"
                        width="100%" height="0" class="rounded-xl w-full h-[400px] lg:h-[490px]" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 col-span-5 gap-5 flex flex-col">
            <div class="bg-white shadow rounded-xl p-5 w-full">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 rounded-xl bg-sky-400 flex justify-center items-center">
                        <i class="bi bi-telephone-fill text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="font-semibold text-lg">Nomor Telephone</h1>
                        <p class="text-slate-500 text-sm">+62 8123456789</p>
                    </div>
                </div>
                <p class="text-slate-500 text-sm mt-5">Hubungi kami untuk informasi lebih lanjut tentang
                    desa dan pelayanan yang tersedia.
                </p>
            </div>
            <div class="bg-white shadow rounded-xl p-5 w-full">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 rounded-xl bg-purple-400 flex justify-center items-center">
                        <i class="bi bi-envelope-fill text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="font-semibold text-lg">Email</h1>
                        <p class="text-slate-500 text-sm">DesaKepuharjo@gmail.com</p>
                    </div>
                </div>
                <p class="text-slate-500 text-sm mt-5">Kirim email untuk pertaanyaan, saran, atau keperluan
                    administrasi desa.</p>
            </div>
            <div class="bg-white shadow rounded-xl p-5 w-full">
                <div class="flex gap-3 items-center">
                    <div class="w-12 h-12 rounded-xl bg-yellow-400 flex justify-center items-center">
                        <i class="bi bi-geo text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="font-semibold text-lg">Location</h1>
                        <p class="text-slate-500 text-sm">Kec. Karang Ploso Kabupaten Malang</p>
                    </div>
                </div>
                <p class="text-slate-500 text-sm mt-5">Hubungi kami untuk informasi lebih lanjut tentang
                    desa dan pelayanan yang tersedia.
                </p>
            </div>
        </div>
    </div>
</section>
