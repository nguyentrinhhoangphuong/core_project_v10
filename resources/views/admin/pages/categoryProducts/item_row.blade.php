@php
    $id = $item->id;
    $name = $item->name;
    $btnStatus = $item->status === 'active' ? 'btn-success' : 'btn-danger';
    $statusLabel = $item->status === 'active' ? $statusOptions['active'] : $statusOptions['inactive'];
    $indentation = str_repeat('&nbsp;', $item->depth * 4); // Thay đổi số lượng dấu cách tùy theo độ sâu
@endphp

<div data-sortable-id="{{ $item->id }}" class="list-group-item nested-item"
    style="margin-left: {{ $item->depth * 20 }}px;">
    <div class="d-flex align-items-center">
        <div>
            <span class="item-name">{!! $indentation !!}{{ $item->name }}</span>
        </div>
        <div class="btn-group btn-group-sm">
            <button class="btn {{ $btnStatus }} text-white toggle-status" data-item-id="{{ $item->id }}"
                data-item-status="{{ $item->status }}" data-controller="{{ $routeName }}">
                {{ $statusLabel }}
            </button>
            <a class="btn btn-primary text-white" href="{{ route('admin.category-products.edit', ['item' => $item]) }}">
                Edit
            </a>
            <button class="btn btn-danger text-white"
                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                Delete
            </button>
            <form id="delete-form-{{ $item->id }}"
                action="{{ route('admin.category-products.destroy', ['item' => $item]) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <a href="{{ route('admin.category-products.addAttribute', ['categoryProductsId' => $item->id]) }}"
                class="btn btn-out">Thêm thuộc tính</a>
        </div>
    </div>

    @if (count($item->children))
        <div class="list-group mt-2 nested-sortable">
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
