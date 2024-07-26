@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="flex-grow-1" style="min-width: 200px;">
                            <x-admin.order.filter />
                        </div>
                        <div class="flex-grow-1" style="min-width: 300px;">
                            <x-admin.order.search />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="successMessageContainer"></div>
                        @include('admin.pages.order.' . $controllerName . '.list', [
                            'orders' => $items,
                        ])
                    </div>
                </div>
            </div>
        </div>
        @include('admin.templates.pagination')
    </div>
@endsection
