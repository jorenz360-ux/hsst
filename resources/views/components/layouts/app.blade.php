<x-layouts.app.sidebar :title="$title ?? null">
   <flux:main class="!px-2 !py-2 sm:!px-4 sm:!py-4 lg:!px-6 lg:!py-6 dark:bg-zinc-900">
      {{ $slot }}
   </flux:main>
</x-layouts.app.sidebar>