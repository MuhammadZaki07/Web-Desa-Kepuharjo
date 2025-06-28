<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl">
            <div class="p-6">
                <form wire:submit="updateProfile">
                    {{ $this->profileForm }}

                    <div class="mt-6 flex justify-end">
                        <x-filament::button
                            type="submit"
                            color="primary"
                            icon="heroicon-o-check"
                        >
                            Update Profile
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 rounded-xl">
            <div class="p-6">
                <form wire:submit="updatePassword">
                    {{ $this->passwordForm }}

                    <div class="mt-6 flex justify-end">
                        <x-filament::button
                            type="submit"
                            color="warning"
                            icon="heroicon-o-key"
                        >
                            Change Password
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-filament-panels::page>
