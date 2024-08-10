<div data-sortable-id="{{ $item->id }}" class="list-group-item nested-item"
    style="margin-left: {{ $item->depth * 20 }}px;">
    <div class="d-flex align-items-center">
        <div>
            <span class="item-name">{{ $item->name }}</span>
        </div>
        <div class="btn-group btn-group-sm">
            <label class="dropdown-item form-switch">
                <input class="form-check-input m-0 me-2 toggle-status" type="checkbox" data-item-id="{{ $item->id }}"
                    data-item-status="{{ $item->status }}" data-controller="{{ $routeName }}"
                    {{ $item->status === 1 ? 'checked' : '' }}>
            </label>
            <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', ['item' => $item]) }}">Edit</a>
            <button class="btn btn-sm btn-danger item_delete">
                Delete
                <form action="{{ route('admin.categories.destroy', ['item' => $item]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </button>
        </div>
    </div>
    @if (count($item->children))
        <div class="list-group nested-sortable">
            @foreach ($item->children as $itemChild)
                @include('admin.pages.' . $controllerName . '.item_row', ['item' => $itemChild])
            @endforeach
        </div>
    @endif
</div>
<style>
    .list-group-item {
        border: 1px solid #e3e3e3;
        border-radius: .375rem;
        padding: 1rem;
        margin-bottom: 0.5rem;
        background-color: #ffffff;
        transition: background-color 0.3s ease;
    }

    .item-name {
        font-weight: bold;
        margin-right: 1rem;
        font-size: 1rem;
        display: inline-block;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
        /* Khoảng cách giữa các nút */
    }

    .btn-group .btn {
        flex: 1;
        /* Các nút có cùng kích thước */
        padding: 0.375rem 0.75rem;
        /* Đảm bảo kích thước đồng nhất */
        font-size: 0.875rem;
        /* Đảm bảo kích thước chữ đồng nhất */
        line-height: 1.5;
        /* Đảm bảo chiều cao dòng đồng nhất */
        margin-right: 0;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        /* Kích thước nhỏ hơn cho btn-group-sm */
        font-size: 0.75rem;
        /* Kích thước chữ nhỏ hơn cho btn-group-sm */
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
