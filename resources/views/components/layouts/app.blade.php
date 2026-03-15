<x-layouts.app.sidebar :title="$title ?? null">
   <flux:main class="!px-0 !py-0 dark:bg-zinc-900">
    {{ $slot }}
</flux:main>
</x-layouts.app.sidebar>
