@php
    use App\Helpers\Template;
@endphp
<table class="table table-vcenter">
    <thead>
        <tr>
            <th>ID Đơn Hàng</th>
            <th>Tên Khách Hàng</th>
            <th>Ngày Đặt Hàng</th>
            <th>Trạng Thái</th>
            <th>Tổng Số Tiền</th>
            <th>Địa Chỉ Giao Hàng</th>
            <th>Ghi Chú</th>
            <th>Số Điện Thoại</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ Template::dateFormat($order->created_at) }}</td>
                <td>
                    <span class="{{ Template::getBadgeStatus($order->status) }}"></span>
                    {{ Template::getOrderStatus($order->status) }}
                </td>
                <td>{{ Template::numberFormatVND($order->total_amount) }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->options }}</td>
                <td>{{ $order->phone }}</td>
                <td><a href="{{ route('admin.order.detail', ['id' => $order->id]) }}"><i
                            class="fa-regular fa-pen-to-square"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
