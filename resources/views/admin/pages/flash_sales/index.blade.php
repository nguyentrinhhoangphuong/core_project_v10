@extends('admin.main')
@section('content')
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="page-title">{{ $title }}</h2>
            <a class="btn btn-primary" href="{{ route('admin.flash-sales.create') }}">Thêm</a>
        </div>
    </div>
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-striped display" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Tên flash sale</th>
                                        <th>Tỷ lệ chiết khấu</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @if (count($flashSales) > 0)
                                        @foreach ($flashSales as $flashSale)
                                            <tr>
                                                <td>{{ $flashSale->name }}</td>
                                                <td>{{ $flashSale->discount_percentage }}%</td>
                                                <td>{{ $flashSale->start_time }}</td>
                                                <td>{{ $flashSale->end_time }}</td>
                                                <td>
                                                    <a class="btn btn-outline-primary"
                                                        href="{{ route('admin.flash-sales.edit', $flashSale->id) }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('admin.flash-sales.destroy', $flashSale->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger item_delete">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Không có dữ liệu để hiển thị.</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
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
            $('.select-products').select2();
            @if (session('success'))
                fireNotif("{{ session('success') }}", "success", 3000);
            @endif
        });
    </script>
@endsection
