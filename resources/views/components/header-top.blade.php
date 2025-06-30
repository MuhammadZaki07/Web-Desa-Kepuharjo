<div x-data="headlineSlider" x-init="init">
    <div class="bg-green-700 py-2.5 flex flex-col lg:flex-row justify-between px-4 sm:px-6 lg:px-20">
        <div class="lg:flex gap-3 text-white text-xs font-medium hidden">
            <h1 id="current-date">-</h1>
            <h1 id="current-time">-</h1>
        </div>

        <div class="flex gap-5 items-center justify-center lg:justify-normal mt-2 lg:mt-0">
            <div class="relative overflow-hidden h-5 sm:h-auto">
                <template x-if="currentHeadline">
                    <a class="hover:text-green-200" :href="`/berita/${currentHeadline.id}`">
                        <h1 x-text="currentHeadline.title"
                            class="text-[10px] lg:text-xs text-white font-medium whitespace-nowrap transition-all ease-out duration-300"
                            x-transition:enter="transform transition ease-out duration-300"
                            x-transition:enter-start="translate-y-3 opacity-0"
                            x-transition:enter-end="translate-y-0 opacity-100"
                            x-transition:leave="transform transition ease-in duration-300"
                            x-transition:leave-start="translate-y-0 opacity-100"
                            x-transition:leave-end="translate-y-[-10px] opacity-0">
                        </h1>
                    </a>
                </template>
            </div>

            <div class="flex gap-1 text-white">
                <button @click="prev" class="hover:text-green-300 cursor-pointer text-xs sm:text-sm"
                    aria-label="Sebelumnya">&lt;</button>
                <span class="text-white text-xs sm:text-sm">|</span>
                <button @click="next" class="hover:text-green-300 cursor-pointer text-xs sm:text-sm"
                    aria-label="Berikutnya">&gt;</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('headlineSlider', () => ({
            headlines: @json($headlines->map(fn($item) => ['id' => $item->id, 'title' => $item->title])),
            currentIndex: 0,
            intervalId: null,
            init() {
                this.startRotation();
            },
            get currentHeadline() {
                return this.headlines.length > 0 ? this.headlines[this.currentIndex] : null;
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.headlines.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.headlines.length) % this.headlines.length;
            },
            startRotation() {
                if (this.intervalId) clearInterval(this.intervalId);
                this.intervalId = setInterval(() => {
                    requestAnimationFrame(() => this.next());
                }, 4000);
            }
        }));
    });

    function updateDateTime() {
        requestAnimationFrame(() => {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const dateStr = `${days[now.getDay()]}, ${now.getDate()}-${now.getMonth() + 1}-${now.getFullYear()}`;
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');

            const dateEl = document.getElementById('current-date');
            const timeEl = document.getElementById('current-time');
            if (dateEl && timeEl) {
                dateEl.textContent = dateStr;
                timeEl.textContent = `${hours}:${minutes}`;
            }
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 10000);
</script>
@endpush
