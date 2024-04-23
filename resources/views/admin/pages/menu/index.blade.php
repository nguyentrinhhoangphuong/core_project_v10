@extends('admin.main')
@section('content')
    @include('admin.elements.header', ['btnAdd' => true])
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-4">
                    <div class="card card-body">
                        <div class="table-responsive">
                            @include('admin.pages.' . $controllerName . '.add_menu_items', [
                                'itemsCategory' => $itemsCategory,
                                'itemsCategoryProducts' => $itemsCategoryProducts,
                            ])
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card card-body">
                        <div class="table-responsive">
                            <div class="page-header d-print-none">
                                <div class="container-xl">
                                    <div class="row g-2 align-items-center">
                                        <div class="col">
                                            <h2 class="page-title">
                                                Menu structure
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('admin.pages.' . $controllerName . '.list', [
                                'items' => $items,
                            ])
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
