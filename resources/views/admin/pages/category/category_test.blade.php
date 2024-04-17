@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-md-4">
            <div class="card card-body">
                <div class="table-responsive">
                    @include('admin.pages.' . $controllerName . '.category_ul.test', [
                        'items' => $items,
                    ])
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body">
                <div class="table-responsive">
                    @include('admin.pages.' . $controllerName . '.category_table.test', [
                        'items' => $items,
                    ])
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body">
                <div class="table-responsive">
                    @include('admin.pages.' . $controllerName . '.category_selectbox.test', [
                        'items' => $items,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
