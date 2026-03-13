<x-layouts.app :title="__('Dashboard')">
  @if(app()->environment('local'))
        <div class="mb-2 text-xs text-slate-500">
          You logged in as  {{ auth()->user()->username }} as {{ auth()->user()->getRoleNames()->first() }}
        </div>
    @endif
    {{-- @can('view.upcoming.events')
    <livewire:upcoming-events />
        @endcan --}}
        @can('view.alumni.dashboard')
          <livewire:alumni-dashboard/>
        @endcan
<livewire:dashboard />
</x-layouts.app>
