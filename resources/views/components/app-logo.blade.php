@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Holy Spirit School" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center overflow-hidden rounded-md bg-white">
            <img
                src="{{ asset('images/hsstlogo.jpg') }}"
                alt="HSST Logo"
                class="h-full w-full object-contain"
            >
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Holy Spirit School" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center overflow-hidden rounded-md bg-white">
            <img
                src="{{ asset('images/hsstlogo.jpg') }}"
                alt="HSST Logo"
                class="h-full w-full object-contain"
            >
        </x-slot>
    </flux:brand>
@endif
