@php
    $id = $item->id;
    $name = $item->name;
    $btnStatus = $item->status == 'active' ? 'btn-outline-success' : 'btn-outline-danger';
@endphp
<div data-sortable-id="{{ $item->id }}" class="list-group-item nested-{{ $item->depth }}">
    {{ $item->name }}
    <button class="btn btn-sm {{ $btnStatus }} toggle-status" data-item-id="{{ $item->id }}"
        data-item-status="{{ $item->status }}" data-controller="categories">
        {{ $item->status === 'active' ? $statusOptions['active'] : $statusOptions['inactive'] }}
    </button>
    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.edit', ['item' => $item]) }}">Edit</a>
    <button class="btn btn-sm btn-outline-danger item_delete">
        Delete
        <form action="{{ route('admin.categories.destroy', ['item' => $item]) }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </button>
    @if (count($item->children))
        <div class="list-group nested-sortable border border-2">
            @foreach ($item->children as $itemChild)
                @include('admin.pages.category.category_row', ['item' => $itemChild])
            @endforeach
        </div>
    @endif
</div>
