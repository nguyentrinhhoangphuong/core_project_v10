@extends('admin.main')
@section('content')
    @include('admin.elements.header', ['btnAdd' => true])
    <div id="successMessageContainer"></div>
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="col-12 d-flex justify-content-between mb-2">
                        <!-- Dropdown bên trái -->
                        {{-- {!! $showDropdownItemsStatus !!} --}}
                        <x-area-dropdown-items-status :params="$params" :routeName="$routeName" />
                        <!-- Ô tìm kiếm, Dropdown và Nút tìm kiếm bên phải -->
                        {{-- {!! $showAreaSearch !!} --}}
                        <x-admin.area-search :params="$params" />
                    </div>
                    <div class="card">
                        <div class="table-responsive">
                            @include('admin.pages.' . $controllerName . '.list', [
                                'items' => $items,
                                'itemsCategory' => $itemsCategory,
                            ])
                        </div>
                    </div>
                </div>
                @include('admin.templates.pagination')
            </div>
        </div>
    </div>
@endsection
