<select>
    <option value="0">--- Select Category ---</option>
    @if (count($items) > 0)
        @php
            $level = '/--------';
        @endphp
        @foreach ($items as $item)
            @include('admin.pages.category.category_selectbox.child_test', [
                'item' => $item,
                'level' => $level,
            ])
        @endforeach
    @endif
</select>
