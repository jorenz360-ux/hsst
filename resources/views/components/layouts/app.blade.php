<x-layouts.app.sidebar :title="$title ?? null">
   <flux:main  class="!px-1 !py-0 sm:!px-1 sm:!py-0 lg:!px-0 lg:!py-0 ">
      {{ $slot }}
   </flux:main>
</x-layouts.app.sidebar>
