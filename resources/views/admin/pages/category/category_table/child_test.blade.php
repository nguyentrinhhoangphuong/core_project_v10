<tr>
    <td>{{ $item->id }}</td>
    <td>{{ $level . $item->name }}</td>
</tr>

@if (count($item->categories) > 0)
    @php
        $level = '/--------' . $level;
    @endphp
    @foreach ($item->categories as $childCategory)
        @include('admin.pages.category.category_table.child_test', ['item' => $childCategory])
    @endforeach
@endif
