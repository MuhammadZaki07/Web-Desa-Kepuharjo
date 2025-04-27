@extends('layouts.app')
@section('content')
    @push('blog-running')
        <section class="lg:px-20 px-5">
            <x-running-blog :blogs="$blogs" />
            <x-chart.mixed-chart id="pendudukChart" :series1-data="[2, 3, 1, 1, 2, 3, 3, 2, 2, 1, 1, 3]" :series2-data="[30, 35, 20, 25, 40, 55, 60, 40, 30, 20, 25, 50]" :categories="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']" series1-name="Usage"
                series2-name="Banyak Jiwa" y-axis-title="Jumlah" />
            <x-card.data-penduduk class="w-full py-3" id="#" />
            <div class="flex flex-col lg:flex-row gap-15 items-center py-10">
                <div class="lg:flex-7 bg-white rounded-xl shadow p-6  border-t border-t-green-600">
                    <h2 class="text-xl font-semibold text-slate-700 mb-4">Tinggalkan Komentar</h2>
                    <p class="text-slate-500 text-sm mb-6">
                        Identitas anda tidak akan dipublikasikan. Ruas yang wajib ditandai
                    </p>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-slate-600 mb-1">Komentar</label>
                            <textarea
                                class="w-full border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600"
                                rows="5" required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" placeholder="Nama"
                                class="border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600" required>
                            <input type="email" placeholder="Email"
                                class="border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600" required>
                            <input type="text" placeholder="Situs Web"
                                class="border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600">
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="saveInfo" class="border-slate-300">
                            <label for="saveInfo" class="text-slate-600 text-sm">
                                Simpan nama, email, dan situs web saya pada peramban ini untuk komentar saya berikutnya.
                            </label>
                        </div>

                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 cursor-pointer">
                            Kirimkan Komentar
                        </button>
                    </form>

                </div>

                <div class="w-full lg:flex-3 lg:w-1/3 bg-white rounded-xl shadow py-7 px-5 relative border-t border-t-green-600">
                    <h2 class="text-green-600 text-xl font-semibold mb-4">Suara Pembaca</h2>
                    <div class="bg-green-50 p-4 rounded-lg mb-6">
                        <p class="text-slate-600 text-sm mb-3">
                            Kirimkan tanggapan anda yang berkaitan dengan pelayanan publik dan keluhan konsumen.
                        </p>
                        <button class="bg-green-600 text-white text-sm px-4 py-1 rounded hover:bg-green-700 cursor-pointer">
                            Kirim Komentar
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex gap-2">
                            <span class="text-slate-400">#1</span>
                            <div class="flex gap-1 flex-col">
                                <h3 class="font-semibold text-slate-700 hover:text-green-600 cursor-pointer">Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                </h3>
                                <p class="text-slate-400 text-xs">Kamis | 17 April 2025 | 23:00 WIB</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-slate-400">#1</span>
                            <div class="flex gap-1 flex-col">
                                <h3 class="font-semibold text-slate-700 hover:text-green-600 cursor-pointer">Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                </h3>
                                <p class="text-slate-400 text-xs">Kamis | 17 April 2025 | 23:00 WIB</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-slate-400">#1</span>
                            <div class="flex gap-1 flex-col">
                                <h3 class="font-semibold text-slate-700 hover:text-green-600 cursor-pointer">Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                </h3>
                                <p class="text-slate-400 text-xs">Kamis | 17 April 2025 | 23:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endpush
@endsection
