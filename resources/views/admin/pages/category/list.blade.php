@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp

<div id="nestedDemo" class="list-group col nested-sortable">
    @foreach ($items as $item)
        @include('admin.pages.category.category_row', ['item' => $item])
    @endforeach
</div>
