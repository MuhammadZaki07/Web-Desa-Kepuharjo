<x-filament-widgets::widget>
    <x-filament::section>
        <div class="rounded-lg p-4 sm:p-6 text-white">
            <div class="flex flex-col space-y-4 lg:flex-row lg:justify-between lg:items-center lg:space-y-0 lg:space-x-6">
                <div class="flex-1 lg:flex-none text-center lg:text-left">
                    <h1 class="text-xl sm:text-2xl lg:text-5xl font-bold mb-2">
                        {{ $this->getGreeting() }}, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-blue-100 text-xs sm:text-sm lg:text-base">
                        Selamat datang di Dashboard Desa. Semoga hari Anda menyenangkan!
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 sm:p-4 mx-auto lg:mx-0 w-full max-w-xs lg:max-w-none lg:min-w-fit">
                    <div class="text-center">
                        <div class="text-lg sm:text-xl lg:text-2xl font-mono font-bold mb-1" id="current-time">
                            {{ $this->getCurrentDateTime()['time'] }}
                        </div>
                        <div class="text-xs sm:text-sm text-blue-100">
                            {{ $this->getCurrentDateTime()['timezone'] }}
                        </div>
                        <div class="text-xs text-blue-200 mt-1 sm:mt-2">
                            {{ $this->getCurrentDateTime()['date'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        setInterval(function() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }, 1000);
    </script>
</x-filament-widgets::widget>
