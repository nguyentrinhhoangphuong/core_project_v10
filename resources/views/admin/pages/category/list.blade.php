@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp
<table class="table table-vcenter card-table table-striped" id="myTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Sắp xếp</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody id="result">
        @if (count($items) > 0)
            @foreach ($items as $key => $item)
                @php
                    $index = $key + 1;
                    $id = $item->id;
                    $name = $item->name;
                    $btnStatus = $item->status == 'active' ? 'btn-outline-success' : 'btn-outline-danger';
                @endphp
                <tr>
                    <td>{!! $index !!}</td>
                    <td>{{ str_repeat('/-----', $item->depth) }} {!! $name !!}</td>
                    <td>@include('admin.pages.category.order', ['id' => $id])</td>
                    <td>
                        <button class="btn {{ $btnStatus }} toggle-status" data-item-id="{{ $item->id }}"
                            data-item-status="{{ $item->status }}" data-controller="categories">
                            {{ $item->status === 'active' ? $statusOptions['active'] : $statusOptions['inactive'] }}
                        </button>
                    </td>
                    <td>
                        <a class="btn btn-outline-primary"
                            href="{{ route('admin.categories.edit', ['item' => $item]) }}">Edit</a>
                        <button class="btn btn-outline-danger item_delete">
                            Delete
                            <form action="{{ route('admin.categories.destroy', ['item' => $item]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">Không có dữ liệu để hiển thị.</td>
            </tr>
        @endif

    </tbody>
</table>
