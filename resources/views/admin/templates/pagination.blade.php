<div class="x_content">
    <div class="row">
        {{-- <div class="col-md-6">
            <p class="m-b-0">
                <span class="badge bg-info">{{ $items->perPage() }} items per page</span>
                <span class="badge bg-success">{{ $items->total() }} items</span>
                <span class="badge bg-danger">{{ $items->lastPage() }} pages</span>
            </p>
        </div> --}}
        @if ($items->lastPage() > 1)
            <div class="col-md-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Sử dụng appends để thêm query string --}}
                        {{ $items->appends(request()->query())->links('pagination.pagination_backend') }}
                    </ul>
                </nav>
            </div>
        @endif
    </div>
</div>
