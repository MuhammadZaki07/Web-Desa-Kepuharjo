<div x-data="headlineSlider" x-init="init">
    <div class="bg-green-700 py-2.5 flex flex-col lg:flex-row justify-between px-4 sm:px-6 lg:px-20">
        <div class="lg:flex gap-3 text-white text-xs font-medium hidden">
            <h1>{{ $tanggal }}</h1>
            <h1>{{ $jam }} <span>{{ $format }}</span></h1>
        </div>

        <div class="flex gap-5 items-center justify-center lg:justify-normal mt-2 lg:mt-0">
            <div class="relative overflow-hidden">
                <a href="#">
                    <h1
                        x-text="currentHeadline"
                        class="text-[10px] lg:text-xs text-white font-medium whitespace-nowrap transition-all ease-out duration-300"
                        x-transition:enter="transform transition ease-out duration-300"
                        x-transition:enter-start="translate-y-5 opacity-0"
                        x-transition:enter-end="translate-y-0 opacity-100"
                        x-transition:leave="transform transition ease-in duration-300"
                        x-transition:leave-start="translate-y-0 opacity-100"
                        x-transition:leave-end="translate-y-[-20px] opacity-0">
                    </h1>
                </a>
            </div>
            <div class="flex gap-1 text-white">
                <button @click="prev" class="hover:text-green-300 cursor-pointer text-xs sm:text-sm" aria-label="Sebelumnya">&lt;</button>
                <span class="text-white text-xs sm:text-sm">|</span>
                <button @click="next" class="hover:text-green-300 cursor-pointer text-xs sm:text-sm" aria-label="Berikutnya">&gt;</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('headlineSlider', () => ({
            headlines: @json($headline),
            currentIndex: 0,
            init() {
                setInterval(() => {
                    this.next();
                }, 3000);
            },
            get currentHeadline() {
                return this.headlines.length > 0 ? this.headlines[this.currentIndex] : '';
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.headlines.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.headlines.length) % this.headlines.length;
            }
        }));
    });
</script>
