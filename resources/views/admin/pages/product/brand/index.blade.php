@extends('admin.main')
@section('content')
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="page-title">{{ $title }}</h2>
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modal-report">Thêm</a>
        </div>
    </div>
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12 d-flex justify-content-end">
                    <x-admin.area-search :params="$params" />
                </div>
                <div class="col-12">
                    <div class="card card-body">
                        <div class="table-responsive">
                            @include('admin.pages.product.' . $controllerName . '.list', [
                                'items' => $items,
                            ])
                        </div>
                    </div>
                </div>
                @include('admin.templates.pagination')
            </div>
        </div>
    </div>
@endsection
