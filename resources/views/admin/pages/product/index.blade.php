@extends('admin.main')
@section('content')
    @include('admin.elements.header', ['btnAdd' => true])
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
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
        function deleteSession(key) {
            $.ajax({
                url: '/session/delete', // URL của route xử lý xóa session
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "key": key // Key của session cần xóa
                },
                success: function() {
                    console.log("Session '" + key + "' has been deleted.");
                }
            });
        }
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
    </script>
@endsection
