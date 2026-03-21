<x-layouts.app.sidebar :title="$title ?? null">
   <flux:main>
    {{ $slot }}
</flux:main>
</x-layouts.app.sidebar>
 {{-- class="!px-2 !py-2 dark:bg-zinc-900" --}}