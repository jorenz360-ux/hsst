<x-layouts.app.sidebar :title="$title ?? null">
   <flux:main class="!px-1 !py-1 dark:bg-zinc-900">
    {{ $slot }}
</flux:main>
</x-layouts.app.sidebar>
