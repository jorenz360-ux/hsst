@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        {{-- Results count --}}
        <p class="text-sm text-[#7a7060]">
            @if ($paginator->firstItem())
                Showing
                <span class="font-semibold text-[#1a1410]">{{ $paginator->firstItem() }}</span>
                –
                <span class="font-semibold text-[#1a1410]">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-semibold text-[#1a1410]">{{ $paginator->total() }}</span>
                results
            @else
                {{ $paginator->count() }} results
            @endif
        </p>

        {{-- Page links --}}
        <div class="flex items-center gap-1">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center border border-[#e8e2d6] bg-white text-[#d0c8bc]" aria-disabled="true">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex h-9 w-9 items-center justify-center border border-[#e8e2d6] bg-white text-[#7a7060] transition hover:border-[#b88a3d] hover:bg-[#faf9f7] hover:text-[#1a1410]"
                   aria-label="{{ __('pagination.previous') }}">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex h-9 w-9 items-center justify-center border border-[#e8e2d6] bg-white text-sm text-[#9a9080]">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="inline-flex h-9 w-9 items-center justify-center border border-[#b88a3d] bg-[#d4b06a] text-sm font-bold text-[#091852]">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="inline-flex h-9 w-9 items-center justify-center border border-[#e8e2d6] bg-white text-sm text-[#7a7060] transition hover:border-[#b88a3d] hover:bg-[#faf9f7] hover:text-[#1a1410]"
                               aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex h-9 w-9 items-center justify-center border border-[#e8e2d6] bg-white text-[#7a7060] transition hover:border-[#b88a3d] hover:bg-[#faf9f7] hover:text-[#1a1410]"
                   aria-label="{{ __('pagination.next') }}">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </a>
            @else
                <span class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center border border-[#e8e2d6] bg-white text-[#d0c8bc]" aria-disabled="true">
                    <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </span>
            @endif

        </div>
    </nav>
@endif
