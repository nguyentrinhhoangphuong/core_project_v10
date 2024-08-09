@php
    use App\Helpers\Template;
@endphp
<div class="card-header">
    <h3 class="card-title">Đơn hàng mới nhất</h3>
</div>
<div class="table-responsive">
    <table class="table table-vcenter">
        <thead>
            <tr>
                <th>Code</th>
                <th>Khách hàng</th>
                <th>Trạng thái</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderService->getlatestOrders() as $item)
                <tr>
                    <td>
                        <a href="{{ route('admin.order.detail', ['id' => $item->id]) }}">
                            {{ $item->code }}
                        </a>
                    </td>
                    <td class="text-secondary">
                        {{ $item->name }}
                    </td>
                    <td class="text-secondary">
                        <span class="{{ Template::getBadgeStatus($item->status) }}"></span>
                        {{ Template::getOrderStatus($item->status) }}
                    </td>
                    <td class="text-secondary">
                        {{ Template::numberFormatVND($item->total_amount) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
