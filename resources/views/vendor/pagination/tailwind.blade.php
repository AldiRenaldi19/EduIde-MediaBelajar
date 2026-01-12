@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <ul class="inline-flex items-center -space-x-px">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true" aria-label="Previous">
                    <span class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white/5 border border-white/5 rounded-l-lg">&laquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-2 ml-0 leading-tight text-gray-200 bg-white/5 border border-white/5 rounded-l-lg hover:bg-white/10">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li aria-disabled="true"><span class="px-3 py-2 leading-tight text-gray-500 bg-white/5 border border-white/5">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page"><span class="px-3 py-2 leading-tight text-white bg-indigo-600 border border-indigo-600">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="px-3 py-2 leading-tight text-gray-200 bg-white/5 border border-white/5 hover:bg-white/10">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-2 leading-tight text-gray-200 bg-white/5 border border-white/5 rounded-r-lg hover:bg-white/10">&raquo;</a>
                </li>
            @else
                <li aria-disabled="true" aria-label="Next">
                    <span class="px-3 py-2 leading-tight text-gray-500 bg-white/5 border border-white/5 rounded-r-lg">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
