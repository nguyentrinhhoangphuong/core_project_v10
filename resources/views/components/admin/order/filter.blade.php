<label class="form-label">Trạng thái</label>
<select id="order_status" class="form-select w-auto" name="order_status" onchange="filterOrders()">
    <option value="">Tất cả</option>
    @foreach ($status as $status_key => $order_status)
        <option {{ $status_key == request()->status ? 'selected' : '' }} value="{{ $status_key }}">
            {{ $order_status }} ({{ $orderCounts[$status_key] ?? 0 }})
        </option>
    @endforeach
</select>
@section('scripts')
    <script>
        function filterOrders() {
            let url;
            var orderStatus = document.getElementById('order_status').value;
            if (orderStatus) {
                url = "{{ route('admin.order.index') }}?status=" + orderStatus;
            } else {
                url = "{{ route('admin.order.index') }}";
            }
            window.location.href = url;
        }
    </script>
@endsection
