@if ($paginator->hasPages())
    <div class="d-flex flex-column align-items-center">
        <!-- Tombol Navigasi -->
        <div class="mb-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-sm btn-secondary disabled" aria-disabled="true">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-secondary" rel="prev">‹</a>
            @endif

            {{-- Pagination Elements --}}
            <span class="mx-2">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="btn btn-sm btn-secondary disabled">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="btn btn-sm btn-primary">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="btn btn-sm btn-secondary">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-secondary" rel="next">›</a>
            @else
                <span class="btn btn-sm btn-secondary disabled" aria-disabled="true">›</span>
            @endif
        </div>

        <!-- Informasi Jumlah Data -->
        <div>
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    </div>
@endif
