<div>
    @can('payments.view')
     {{-- Alumni Dashboard UI ONLY (no real variables yet) --}}

  

    @else
        {{-- Total Donations (All Alumni) --}}
   {{-- Admin Dashboard UI ONLY (no variables yet) --}}
 <div class="space-y-8">
    {{-- Row 1: KPIs --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
       <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Total Donations (Paid)</p>

            {{-- If amount is stored in PESOS --}}
            <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                ₱{{ number_format($allDonationsTotal, 2) }}
            </p>

            <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">
                Updated {{ now()->format('M d, Y h:i A') }}
            </p>
        </div>

       <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Donations This Month</p>

            {{-- If amount is stored in PESOS --}}
            <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                ₱{{ number_format($donationsThisMonth, 2) }}
            </p>

            <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">Paid only</p>
        </div>

       <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Upcoming Events</p>

            <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                {{ $upcomingEventsCount }}
            </p>

            <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">Active + future</p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Pending Verifications</p>
            <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">0</p>
            <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">Needs review</p>
        </div>
    </div>

    {{-- Row 2: Two columns --}}
    <div class="grid grid-cols-1">

        {{-- Right: Latest payments --}}
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3 dark:border-zinc-700">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Latest Payments</h2>
                    <p class="mt-0.5 text-xs text-zinc-600 dark:text-zinc-400">Most recent paid transactions</p>
                </div>

                <a href="#"
                   class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-zinc-50 text-xs uppercase text-zinc-600 dark:bg-zinc-800/60 dark:text-zinc-300">
                        <tr>
                            <th class="px-4 py-3">Donor</th>
                            <th class="px-4 py-3 text-right">Amount</th>
                            <th class="px-4 py-3">Paid at</th>
                            <th class="px-4 py-3">Ref</th>
                        </tr>
                    </thead>

                   <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($latestPayments as $p)
                            <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/40">
                                <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $p->alumni?->lname }}, {{ $p->alumni?->fname }} {{ $p->alumni?->mname }}
                                </td>

                                {{-- If amount is stored in PESOS --}}
                                <td class="px-4 py-3 text-right text-zinc-900 dark:text-zinc-100">
                                    ₱{{ number_format($p->amount, 2) }}
                                </td>

                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                    {{ $p->paid_at?->format('M d, Y h:i A') ?? '—' }}
                                </td>

                                <td class="px-4 py-3 text-xs text-zinc-600 dark:text-zinc-400">
                                    {{ $p->paymongo_checkout_session_id ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                    No paid transactions yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    @endcan

 
</div>