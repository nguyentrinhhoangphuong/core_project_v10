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
            <th class="w-5">Hình</th>
            <th class="w-7">Tên sản phẩm</th>
            <th class="">Trạng thái</th>
            <th class="">Giá</th>
            <th class="">Hành động</th>
        </tr>
    </thead>
    <tbody id="result">
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    // sap xep theo order_column
                    $sortedMedia = $item->media->sortBy('order_column');
                    $media = $sortedMedia->isNotEmpty() ? $sortedMedia->first() : null;
                    $mediaUrl = '';

                    if ($media) {
                        // Kiểm tra xem có phiên bản WebP không, nếu không thì dùng ảnh gốc
                        $mediaUrl = $media->hasGeneratedConversion('webp') ? $media->getUrl('webp') : $media->getUrl();
                    }

                    $images = json_decode($item['images'], true);
                    $index = $key + 1;
                    $id = $item['id'];
                    $name = $item['name'];
                    $content = $item['content'];
                    $price = $item['price'];
                    $description = $item['description'];
                    $btnStatus = $item->status == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                    $routeName = $routeName;
                @endphp
                <tr data-id="{{ $id }}" data-routename="{{ $routeName }}">
                    <td>{!! $index !!}</td>
                    <td class="text-secondary">
                        <img src="{!! $mediaUrl !!}" width="100"alt="{!! $name !!}">
                    </td>
                    <td class="text-secondary">{!! $name !!}</td>
                    <td>
                        <p>{!! $price !!}</p>
                    </td>
                    <td>
                        <label class="dropdown-item form-switch">
                            <input class="form-check-input m-0 me-2 toggle-status" type="checkbox"
                                data-item-id="{{ $item->id }}" data-item-status="{{ $item->status }}"
                                data-controller="{{ $routeName }}" {{ $item->status === 1 ? 'checked' : '' }}>
                        </label>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary" data-id="{{ $id }}"
                            href="{{ route('admin.' . $routeName . '.edit', ['item' => $id]) }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <button class="btn btn-outline-danger item_delete">
                            <i class="fa-regular fa-trash-can"></i>
                            <form action="{{ route('admin.' . $routeName . '.destroy', ['item' => $item]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </button>
                        <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-gear"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('admin.product-attributes.index', ['productId' => $id, 'productName' => $name]) }}">thuộc
                                    tính sản phẩm</a>
                            </li>
                        </ul>

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
