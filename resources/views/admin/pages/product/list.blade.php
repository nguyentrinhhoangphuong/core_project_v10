@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp
<table class="table table-vcenter card-table table-striped display">
    <thead>
        <tr>
            <th class="w-1">#</th>
            <th class="w-10">Hình</th>
            <th class="w-15">Tên sản phẩm</th>
            <th class="w-10">Trạng thái</th>
            <th class="w-25">Mô tả</th>
            <th class="w-10">Giá</th>
            <th class="w-10">Hành động</th>
        </tr>
    </thead>
    <tbody id="result">
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    // sap xep theo order_column
                    $sortedMedia = $item->media->sortBy('order_column');
                    $mediaUrl = $sortedMedia->isNotEmpty() ? $sortedMedia->first()->getUrl('webp') : '';

                    $images = json_decode($item['images'], true);
                    $index = $key + 1;
                    $id = $item['id'];
                    $name = $item['name'];
                    $content = $item['content'];
                    $price = $item['price'];
                    $description = $item['description'];
                    $btnStatus = $item->status == 'active' ? 'btn-outline-success' : 'btn-outline-danger';
                    $routeName = $routeName;
                @endphp
                <tr>
                    <td>{!! $index !!}</td>
                    <td class="text-secondary">
                        <img src="{!! $mediaUrl !!}" width="100"alt="{!! $name !!}">
                    </td>
                    <td class="text-secondary">{!! $name !!}</td>
                    <td>
                        <button class="btn {{ $btnStatus }} toggle-status" data-item-id="{{ $item->id }}"
                            data-item-status="{{ $item->status }}" data-controller="{{ $routeName }}">
                            {{ $item->status === 'active' ? $statusOptions['active'] : $statusOptions['inactive'] }}
                        </button>
                    </td>
                    <td>
                        <input type="text" class="form-control editable-field" name="description"
                            value="{{ $description }}">
                    </td>
                    <td>
                        <input type="text" class="form-control editable-field" name="price"
                            value="{!! $price !!}">
                    </td>
                    <td>
                        <a class="btn btn-outline-primary" data-id="{{ $id }}"
                            href="{{ route('admin.' . $routeName . '.edit', ['item' => $id]) }}">Edit</a>
                        <button class="btn btn-outline-danger item_delete">
                            Delete
                            <form action="{{ route('admin.' . $routeName . '.destroy', ['item' => $item]) }}"
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
