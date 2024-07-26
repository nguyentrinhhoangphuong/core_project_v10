@php
    use App\Helpers\Template;
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h3>Thông tin khác hàng</h3>
                            <div>
                                <label><strong>Tên:</strong> </label>
                                {{ $orderDetails['gender'] == 'female' ? 'chị' : 'anh' }}
                                {{ $orderDetails['customer_name'] }}
                            </div>
                            <div>
                                <label><strong>Địa chỉ:</strong></label> {{ $orderDetails['address'] }}
                            </div>
                            <div>
                                <label><strong>Số điện thoại:</strong> </label> {{ $orderDetails['phone'] }}
                            </div>
                            <div>
                                <label><strong>Email:</strong> </label> {{ $orderDetails['email'] }}
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <h2>CODE: {{ $orderDetails['code'] }}</h2>
                            <p>Ngày Đặt hàng: {{ $orderDetails['created_at'] }}</p>
                            <div class="d-flex justify-content-end align-items-center">
                                <label for="status" class="me-2">Trạng thái</label>
                                <input type="hidden" value="{{ $orderDetails['id'] }}" id="orderid">
                                <select id="order_status" class="form-select w-auto" name="order_status">
                                    @foreach (config('order_status.status') as $status_key => $order_status)
                                        <option {{ $status_key == $orderDetails['status'] ? 'selected' : '' }}
                                            value="{{ $status_key }}">{{ $order_status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="card card-body">
                        <table class="table table-transparent table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">Hình</th>
                                    <th>Sản phẩm </th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Giá</th>
                                    <th class="text-end">Tổng</th>
                                </tr>
                            </thead>
                            @foreach ($orderDetails['products'] as $item)
                                <tr>
                                    <td><img src="{{ $item['image'] }}" width="50"></td>
                                    <td>
                                        <p class="strong mb-1">{{ $item['name'] }}</p>
                                    </td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td class="text-end">{{ Template::numberFormatVND($item['price']) }}</td>
                                    <td class="text-end">
                                        {{ Template::numberFormatVND($item['price'] * $item['quantity']) }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="4" class="font-weight-bold text-uppercase text-end">Tổng tiền:</td>
                                <td class="font-weight-bold text-end">
                                    {{ Template::numberFormatVND($orderDetails['total_amount']) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#order_status').on('change', function() {
                let status = $(this).val();
                let orderid = $('#orderid').val();
                $.ajax({
                    url: "{{ route('admin.order.status.change') }}",
                    method: 'POST',
                    data: {
                        status: status,
                        orderid: orderid,
                    },
                    success: function(res) {
                        if (res.success) {
                            fireNotif(res.message, "success", 3000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Lỗi khi thực hiện yêu cầu:', textStatus, errorThrown);
                    },
                });
            })
        })
    </script>
@endsection
