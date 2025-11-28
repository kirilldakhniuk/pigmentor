<div>
    <flux:sidebar class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 min-h-screen">
        <flux:sidebar.header />
        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog" current>{{ __('General') }}</flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    <flux:main>
        <flux:heading size="lg" level="1">{{ __('General') }}</flux:heading>

        <flux:separator variant="subtle" class="my-6" />

        <flux:field variant="inline">
            <flux:label>
                {{ __('Open at login') }}
            </flux:label>

            <flux:switch wire:model.live="isOpenAtLogin" />

            <flux:error name="isOpenAtLogin" />
        </flux:field>
    </flux:main>
</div>
