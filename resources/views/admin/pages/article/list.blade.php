@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp
<table class="table table-vcenter card-table table-striped">
    <thead>
        <tr>
            <th class="w-1">#</th>
            <th class="w-1">Hình</th>
            <th class="w-1">Tiêu đề</th>
            <th class="w-1">Danh mục</th>
            <th class="w-1">Trạng thái</th>
            <th class="w-1">Nội dung</th>
            <th class="w-2">Hành động</th>
        </tr>
    </thead>
    <tbody id="result">
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    $index = $key + 1;
                    $id = $item['id'];
                    $mediaUrl = count($item['media']) > 0 ? $item['media'][0]->getUrl('webp') : '';
                    $name = $item['title'];
                    $category_id = $item['category_id'];
                    $description = Template::showContent($item['content']);
                    $btnStatus = $item->status == 'active' ? 'btn-outline-success' : 'btn-outline-danger';
                @endphp
                <tr>
                    <td>{!! $index !!}</td>
                    <td class="text-secondary"><img src="{!! $mediaUrl !!}" alt="{!! $name !!}"></td>
                    <td class="text-secondary">{!! $name !!}</td>
                    <td class="text-secondary">
                        <select class="form-select category-select2 change-category" data-item-id="{{ $id }}"
                            data-controller="articles" style="width: 100%" name="category_id">
                            @foreach ($itemsCategory as $key => $value)
                                <option value="{{ $key }}" @if ($category_id == $key) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button class="btn {{ $btnStatus }} toggle-status" data-item-id="{{ $item->id }}"
                            data-item-status="{{ $item->status }}" data-controller="articles">
                            {{ $item->status === 'active' ? $statusOptions['active'] : $statusOptions['inactive'] }}
                        </button>
                    </td>
                    <td>{!! $description !!}</td>
                    <td>
                        <a class="btn btn-outline-primary"
                            href="{{ route('admin.' . $routeName . '.edit', ['item' => $id]) }}">Edit</a>
                        <a class="btn btn-outline-danger item_delete" data-id="{{ $id }}"
                            data-type="{!! $routeName !!}">Delete</a>
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
