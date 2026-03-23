<x-layouts.app.sidebar :title="$title ?? null">
   <flux:main class="!px-0 !py-0 sm:!px-0 sm:!py-0 lg:!px-0 lg:!py-0 dark:bg-zinc-900">
      {{ $slot }}
   </flux:main>
</x-layouts.app.sidebar>