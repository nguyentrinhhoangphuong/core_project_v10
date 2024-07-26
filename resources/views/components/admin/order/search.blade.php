<form id="searchForm" action="{{ route('admin.order.index') }}" method="GET"
    class="d-flex flex-wrap gap-2 align-items-end">
    @foreach (request()->except(['code', 'page']) as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <div style="flex: 1 1 200px;">
        <label for="keyword" class="form-label">Mã đơn hàng</label>
        <input type="text" id="code" name="code" value="{{ request('code') }}" class="form-control"
            placeholder="Nhập mã đơn hàng" required>
    </div>
    <div style="flex: 0 0 auto;">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        <a href="{{ route('admin.order.index') }}" class="btn btn-primary">Xóa bộ lọc</a>
    </div>
</form>
