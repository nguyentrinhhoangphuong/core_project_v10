<li>{{ $item->name }}</li>
@if (count($item->categories) > 0)
    <ul>
        @foreach ($item->categories as $childCategory)
            @include('admin.pages.category.category_ul.child_test', ['item' => $childCategory])
        @endforeach
    </ul>
@endif
