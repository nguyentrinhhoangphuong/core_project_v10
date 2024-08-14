@php
    use App\Helpers\Template;
@endphp
@extends('admin.main')
@section('content')
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="page-title">{{ $title }}</h2>
            <a class="btn btn-primary" href="{{ route('admin.coupon.create') }}">Thêm</a>
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
                                        <th>CODE</th>
                                        <th>Loại giảm giá</th>
                                        <th>Giảm (%)</th>
                                        <th>Giá trị đơn hàng tối thiểu</th>
                                        <th>Giảm giá tối đa</th>
                                        <th>Giới hạn sử dụng</th>
                                        <th>Số lần đã sử dụng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @if (count($items) > 0)
                                        @foreach ($items as $key => $item)
                                            @php
                                                $id = $item['id'];
                                                $code = $item['code'];
                                                $discount_type =
                                                    $item['discount_type'] == 'percent' ? 'Phần trăm' : 'Cố định';
                                                $discount_value = number_format($item['discount_value']) . '%';
                                                $min_order_amount = Template::numberFormatVND(
                                                    $item['min_order_amount'],
                                                );
                                                $max_discount_amount = Template::numberFormatVND(
                                                    $item['max_discount_amount'],
                                                );
                                                $usage_limit = $item['usage_limit'];
                                                $used_count = $item['used_count'];
                                                $starts_at = Template::dateFormat($item['starts_at']);
                                                $expires_at = Template::dateFormat($item['expires_at']);
                                                $is_active = $item['is_active'];
                                            @endphp
                                            <tr class="row1">
                                                <td>{!! $code !!}</td>
                                                <td>{{ $discount_type }}</td>
                                                <td>{{ $discount_value }}</td>
                                                <td>{{ $min_order_amount }}</td>
                                                <td>{{ $max_discount_amount }}</td>
                                                <td>{{ $usage_limit }}</td>
                                                <td>{{ $used_count }}</td>
                                                <td>{{ $starts_at }}</td>
                                                <td>{{ $expires_at }}</td>
                                                <td>
                                                    @if ($item->isExpired)
                                                        <span class="badge bg-danger text-white">Hết hạn</span>
                                                    @elseif ($is_active)
                                                        <span class="badge bg-success text-white">Đang hoạt động</span>
                                                    @else
                                                        <span class="badge bg-secondary text-white">Không hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-primary"
                                                        href="{{ route('admin.coupon.edit', ['item' => $id]) }}"><i
                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                    <button class="btn btn-outline-danger item_delete">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                        <form
                                                            action="{{ route('admin.coupon.destroy', ['item' => $item]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu để hiển thị.</td>
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
            @if (session('success'))
                fireNotif("{{ session('success') }}", "success", 3000);
            @endif
        });
    </script>
@endsection
