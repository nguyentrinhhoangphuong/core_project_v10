<div data-sortable-id="{{ $item->id }}" class="list-group-item nested-{{ $item->depth }}">
    {{ $item->name }}
    <div>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.menus.edit', ['item' => $item]) }}">Edit</a>
        <button class="btn btn-sm btn-outline-danger item_delete">
            Delete
            <form action="{{ route('admin.menus.destroy', ['item' => $item]) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </button>
    </div>
    <div class="list-group nested-sortable">
        @if (count($item->children))
            @foreach ($item->children as $itemChild)
                @include('admin.pages.' . $controllerName . '.item_row', ['item' => $itemChild])
            @endforeach
        @endif
    </div>
</div>
