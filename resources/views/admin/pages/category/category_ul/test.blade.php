@if (count($items) > 0)
    <ul>
        @foreach ($items as $item)
            @include('admin.pages.category.category_ul.child_test', [
                'item' => $item,
            ])
        @endforeach
    </ul>
@endif
