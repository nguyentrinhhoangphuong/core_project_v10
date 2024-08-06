@extends('admin.main')

@section('content')
    @include('admin.elements.header', ['btnAdd' => true])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="successMessageContainer"></div>
                        @include('admin.pages.' . $controllerName . '.list', [
                            'items' => $items,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
