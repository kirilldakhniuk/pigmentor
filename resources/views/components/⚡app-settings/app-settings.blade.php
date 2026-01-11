<div>
    <flux:header class="justify-center">
        <flux:heading size="lg">
            {{ __('Settings') }}
        </flux:heading>
    </flux:header>

    <flux:main class="surface-base p-4">
        <div class="card p-4 mb-4">
            <flux:heading size="sm" class="heading-label mb-4">
                {{ __('Startup') }}
            </flux:heading>

            <div class="flex items-center justify-between">
                <flux:text size="sm">
                    {{ __('Open at login') }}
                </flux:text>

                <flux:switch wire:model.live="openAtLogin" />
            </div>
        </div>

        <div class="card p-4">
            <flux:heading size="sm" class="heading-label mb-4">
                {{ __('History') }}
            </flux:heading>

            <flux:slider min="1" max="5" wire:model.live="keepHistory">
                @foreach (range(1, 5) as $i)
                    <flux:slider.tick :value="$i">
                        {{ $this->sliderValueToLabel($i) }}
                    </flux:slider.tick>
                @endforeach
            </flux:slider>

            <flux:separator class="my-3" />

            <flux:button variant="ghost" size="xs" wire:click="eraseHistory" class="text-red-500! hover:text-red-600! dark:text-red-400!">
                {{ __('Erase History...') }}
            </flux:button>
        </div>
    </flux:main>
</div>
