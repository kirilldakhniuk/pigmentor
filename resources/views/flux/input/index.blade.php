@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'variant' => 'outline',
    'invalid' => null,
    'type' => 'text',
    'size' => null,
    'icon' => null,
])

@php
$invalid ??= ($name && $errors->has($name));
$iconLeading = $icon;
$hasLeadingIcon = (bool) $iconLeading;

$iconClasses = Flux::classes();

$classes = Flux::classes()
    ->add('w-full block appearance-none')
    ->add('transition-all duration-150 ease-out')
    ->add('focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/50 dark:focus:ring-blue-400/30 dark:focus:border-blue-400/50')
    ->add(match ($size) {
        default => 'text-base sm:text-sm py-2 h-9 leading-[1.375rem] rounded-lg',
        'sm' => 'text-sm py-1.5 h-7 leading-[1.125rem] rounded-md',
        'xs' => 'text-xs py-1 h-5 leading-[1.125rem] rounded',
    })
    ->add($hasLeadingIcon ? 'ps-10' : 'ps-3')
    ->add('pe-3')
    ->add(match ($variant) {
        'outline' => 'bg-white/80 dark:bg-white/10 dark:disabled:bg-white/5 backdrop-blur-sm',
        'filled'  => 'bg-zinc-100/80 dark:bg-white/10 dark:disabled:bg-white/5 backdrop-blur-sm',
    })
    ->add(match ($variant) {
        'outline' => 'text-zinc-800 disabled:text-zinc-400 placeholder-zinc-400 dark:text-zinc-100 dark:disabled:text-zinc-500 dark:placeholder-zinc-500',
        'filled'  => 'text-zinc-800 placeholder-zinc-400 dark:text-zinc-100 dark:placeholder-zinc-500',
    })
    ->add(match ($variant) {
        'outline' => $invalid
            ? 'ring-1 ring-inset ring-red-500 border-0'
            : 'ring-1 ring-inset ring-zinc-900/10 dark:ring-white/10 border-0 shadow-sm shadow-zinc-900/5 dark:shadow-none',
        'filled'  => $invalid
            ? 'ring-1 ring-inset ring-red-500 border-0'
            : 'ring-0 border-0',
    })
    ->add($attributes->pluck('class:input'));
@endphp

<flux:with-field :$attributes :$name>
    <div {{ $attributes->only('class')->class('w-full relative block group/input') }} data-flux-input>
        <?php if (is_string($iconLeading)): ?>
            <div class="pointer-events-none absolute top-0 bottom-0 border-s border-transparent flex items-center justify-center text-xs text-zinc-400/75 dark:text-white/60 ps-3 start-0">
                <flux:icon :icon="$iconLeading" variant="mini" :class="$iconClasses" />
            </div>
        <?php endif; ?>

        <input
            type="{{ $type }}"
            {{ $attributes->except('class')->class($classes) }}
            @isset ($name) name="{{ $name }}" @endisset
            @if ($invalid) aria-invalid="true" data-invalid @endif
            @if (is_numeric($size)) size="{{ $size }}" @endif
            data-flux-control
            data-flux-group-target
        >
    </div>
</flux:with-field>
