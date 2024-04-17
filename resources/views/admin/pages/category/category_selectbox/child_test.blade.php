<option value="{{ $item->id }}">{{ $level . $item->name }}</option>

@if (count($item->categories) > 0)
    @php
        $level = '/--------' . $level;
    @endphp
    @foreach ($item->categories as $childCategory)
        @include('admin.pages.category.category_selectbox.child_test', ['item' => $childCategory])
    @endforeach
@endif
