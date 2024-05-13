@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp
<table class="table table-vcenter card-table table-striped display" id="myTable">
    <thead>
        <tr>
            <th class="w-1">#</th>
            <th class="w-1">Hình</th>
            <th class="w-1">Tên</th>
            <th class="w-1">Trạng thái</th>
            <th class="w-1">Nội dung</th>
            <th class="w-1">Link</th>
            <th class="w-2">Hành động</th>
        </tr>
    </thead>
    <tbody id="tablecontents">
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    $index = $key + 1;
                    $id = $item['id'];
                    $mediaUrl = count($item['media']) > 0 ? $item['media'][0]->getUrl('webp') : '';
                    $name = $item['name'];
                    $link = $item['link'];
                    $description = $item['description'];
                    $btnStatus = $item->status == 'active' ? 'btn-outline-success' : 'btn-outline-danger';
                    $routeName = $routeName;
                @endphp
                <tr class="row1" data-id="{{ $id }}" data-routename="{{ $routeName }}">
                    <td><i class="fa fa-sort"></i></td>
                    <td class="text-secondary">
                        <img src="{!! $mediaUrl !!}" width="100"alt="{!! $name !!}">
                    </td>
                    <td class="text-secondary">{!! $name !!}</td>
                    <td>
                        <button class="btn {{ $btnStatus }} toggle-status" data-item-id="{{ $item->id }}"
                            data-item-status="{{ $item->status }}" data-controller="sliders">
                            {{ $item->status === 'active' ? $statusOptions['active'] : $statusOptions['inactive'] }}
                        </button>
                    </td>
                    <td>
                        <input type="text" class="editable-field" name="description" value="{{ $description }}">
                    </td>
                    <td>
                        <input type="text" class="editable-field" name="link" value="{!! $link !!}">
                    </td>
                    <td>
                        <a class="btn btn-outline-primary"
                            href="{{ route('admin.' . $routeName . '.edit', ['item' => $id]) }}">Edit</a>
                        <button class="btn btn-outline-danger item_delete">
                            Delete
                            <form action="{{ route('admin.sliders.destroy', ['item' => $item]) }}" method="POST">
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
