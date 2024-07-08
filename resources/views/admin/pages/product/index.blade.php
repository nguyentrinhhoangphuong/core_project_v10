@extends('admin.main')
@section('content')
    @include('admin.elements.header', ['btnAdd' => true])
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.products.filter />
                </div>
                <div class="col-12">
                    <div class="card card-body">
                        <div class="table-responsive">
                            <div id="successMessageContainer"></div>
                            @include('admin.pages.' . $controllerName . '.list', ['items' => $items])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.toggle-is_status, .toggle-is_top, .toggle-is_featured').on('change', function() {
                var checkbox = $(this);
                var itemId = checkbox.data('item-id');
                var status = checkbox.is(':checked') ? 1 : 0;
                var controller = checkbox.data('controller');
                var field = checkbox.hasClass('toggle-is_status') ? 'status' :
                    checkbox.hasClass('toggle-is_top') ? 'is_top' : 'is_featured';

                $.ajax({
                    url: '/admin/' + controller + '/update-status',
                    method: 'POST',
                    data: {
                        field: field,
                        status: status,
                        id: itemId,
                    },
                    success: function(response) {
                        fireNotif("Cập nhật thành công", "success", 3000);
                    }
                });
            });
        });
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
    </script>
    @stack('filter-scripts')
@endsection
