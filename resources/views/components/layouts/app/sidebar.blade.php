<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <style>
        @keyframes toast-shrink {
    from {
        transform: scaleX(1);
    }
    to {
        transform: scaleX(0);
    }
}
    </style>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

           @php($user = auth()->user())

            <flux:sidebar.nav>

                <flux:sidebar.group :heading="__('Platform')" class="grid">

                    {{-- Everyone logged-in can see dashboard --}}
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    
                </flux:sidebar.group>

                @can('users.view')
                   <flux:sidebar.item icon="user" :href="route('manage-users')" wire:navigate>
                        {{ __('Users') }}
                    </flux:sidebar.item>
                @endcan
                @can('announcement.manage')
                       <flux:sidebar.item icon="calendar" :href="route('manage-announcement')" wire:navigate>
                        {{ __('Announcement') }}
                    </flux:sidebar.item>
                @endcan
             {{-- @can('create.event')
                   <flux:sidebar.item icon="calendar" :href="route('create-event')" wire:navigate>
                        {{ __('Add Event') }}
                    </flux:sidebar.item>
             @endcan --}}
               @can('event.view')
                   <flux:sidebar.item icon="calendar" :href="route('event-view')" wire:navigate>
                        {{ __('Event') }}
                    </flux:sidebar.item>
             @endcan
                 @can('donation.manage')
                        <flux:sidebar.item icon="credit-card" :href="route('donations')" wire:navigate>
                        {{ __('Donations') }}
                    </flux:sidebar.item>
                 @endcan   
                  @can('donations.create')
                        <flux:sidebar.item icon="banknotes" :href="route('make-donations')" wire:navigate>
                        {{ __('Payment') }}
                    </flux:sidebar.item>
                 @endcan  
                 @can('batches.view')
                       <flux:sidebar.item icon="users" :href="route('view-batch')" wire:navigate>
                        {{ __('Batch') }}
                    </flux:sidebar.item>
                 @endcan 
                 @can('donations.view')
                       <flux:sidebar.item icon="banknotes" :href="route('view-donations')" wire:navigate>
                        {{ __('Donation') }}
                    </flux:sidebar.item>
                 @endcan
                @can('generate.report')
                     <flux:sidebar.item icon="chart-pie" :href="route('reports')" wire:navigate>
                        {{ __('Reports') }}
                    </flux:sidebar.item>
                @endcan
            </flux:sidebar.nav>


            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->username" />
        </flux:sidebar>


        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top"  allign="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts

        
    </body>
</html>
