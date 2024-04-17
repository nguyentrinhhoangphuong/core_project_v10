<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center">
        <h2 class="page-title">{{ $title }}</h2>
        @isset($btnAdd)
            <a href="{{ $routeCreate }}" class="btn btn-primary">Thêm</a>
        @endisset
    </div>
</div>
