<div>
    <flux:header>
        <flux:button href="{{ route('home') }}">
            {{ __('Back') }}
        </flux:button>
    </flux:header>

    <flux:main>
        <form wire:submit="save" class="space-y-6">
            <flux:input label="{{ __('Name') }}" wire:model="form.name" placeholder="Enter palette name"></flux:input>

            <flux:heading>
                {{ __('Colors') }}
            </flux:heading>
            <flux:card size="sm" class="space-y-2 mt-2">
                @forelse($form->colors ?? [] as $color)
                    <flux:context>
                        <flux:button class="cursor-pointer" style="background-color: {{ $color }} !important"/>

                        <flux:menu>
                            <flux:menu.item wire:click="removeFromPalette('{{ $color }}')" icon="trash"
                                            variant="danger">{{ __('Remove') }}</flux:menu.item>
                        </flux:menu>
                    </flux:context>
                @empty
                    {{ __('No picked colors yet') }}
                @endforelse
            </flux:card>

            <flux:field variant="inline" class="!flex">
                <flux:button
                    x-data
                    @click="new EyeDropper().open().then(r => $wire.pipetteColor(r.sRGBHex)).catch(e => {})"
                    class="cursor-pointer min-w-12"
                    icon="pipette"
                />

                <flux:input wire:model.blur="hex" placeholder="Enter Hex Value"></flux:input>
            </flux:field>

            <flux:pillbox wire:model.live.debounce="fromColorHistory"
                          placeholder="{{ __('Select from Color History') }}">
                @foreach(Cache::get('picks-history', []) as $color)
                    <flux:pillbox.option value="{{ $color }}">
                        <div class="flex items-center gap-2">
                            <flux:button class="cursor-pointer"
                                         style="background-color: {{ $color }} !important">
                            </flux:button>
                            <flux:text>{{ $color }}</flux:text>
                        </div>
                    </flux:pillbox.option>
                @endforeach
            </flux:pillbox>

            <flux:pillbox wire:model.live="fromAnotherPalette" searchable
                          placeholder="{{ __('Select from Other Palettes') }}">
                @foreach($existingColors as $color)
                    <flux:pillbox.option value="{{ $color }}">
                        <div class="flex items-center gap-2">
                            <flux:button class="cursor-pointer"
                                         style="background-color: {{ $color }} !important">
                            </flux:button>
                            <flux:text>{{ $color }}</flux:text>
                        </div>
                    </flux:pillbox.option>
                @endforeach
            </flux:pillbox>

            <flux:button type="submit" class="cursor-pointer w-full">
                {{ __('Update Palette') }}
            </flux:button>
        </form>
    </flux:main>
</div>
