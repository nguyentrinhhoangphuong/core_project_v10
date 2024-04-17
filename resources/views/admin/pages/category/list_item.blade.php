@php
    $id = $item->id;
    $name = $item->name;
    $status = $statusOptions[$item['status']];
@endphp
<tr>
    <td>{{ str_repeat('/-----', $item->depth) }} {!! $name !!}</td>
    <td>@include('admin.pages.category.order', ['id' => $id])</td>
    <td>{!! $status !!}</td>
    <td>
        <a class="btn btn-outline-primary" href="{{ route('admin.categories.edit', ['item' => $item]) }}">Edit</a>
        <button class="btn btn-outline-danger item_delete">
            Delete
            <form action="{{ route('admin.categories.destroy', ['item' => $item]) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </button>

    </td>
</tr>
