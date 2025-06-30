<div id="visi-misi" class="tab-content {{ $class }} w-full py-3" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
    <div class="lg:flex gap-3 items-center hidden">
        <div class="w-[70px] h-[70px] rounded-lg shadow-lg border-4 border-green-600 flex justify-center items-center">
            <i class="bi bi-file-earmark-text text-blue-500 text-3xl"></i>
        </div>
        <div class="w-full bg-white shadow rounded-lg text-left text-xl text-slate-600 px-3 py-1.5 lg:py-5">
            Fungsi dari visi & misi di desa kami yaitu untuk pembangunan desa juga untuk mewujudkan
            kesejahteraan masyarakat
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-white rounded-3xl shadow-2xl p-10 flex flex-col gap-8 mt-0 lg:mt-8">
        <div class="flex flex-col items-start gap-4">
            <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                <i class="bi bi-eye-fill"></i> Visi
            </div>
            <p class="text-slate-700 text-lg font-medium leading-relaxed">
                "{{ $visi ?? "No Data"}}"
            </p>
        </div>

        <div class="border-b border-slate-300"></div>

        <div class="flex flex-col items-start gap-4">
            <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                <i class="bi bi-flag-fill"></i> Misi
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                @foreach ($misi as $m)
                    <div class="flex items-start gap-3">
                        <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                        <p class="text-slate-700 leading-relaxed">{{ $m['poin_misi'] ?? "No Data"}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(isset($progamUnggulan) && $progamUnggulan)
    <div class="mt-12">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-100 to-purple-100 text-blue-700 px-6 py-2 rounded-full text-sm font-semibold mb-4">
                <i class="bi bi-star-fill"></i> Program Unggulan
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-white rounded-3xl shadow-lg p-5 lg:p-10">
            <div class="program-unggulan-content">
                {!! $progamUnggulan !!}
            </div>
        </div>
    </div>
    @endif
</div>
