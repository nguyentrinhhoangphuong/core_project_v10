@foreach ($itemsCategory as $category)
    <div style="margin-left: {{ $level * 20 }}px;">
        <label value="{{ $category->name }}">
            <input type="checkbox" value="{{ $category->id }}"> {{ $category->name }}
        </label>
    </div>
    @if (!empty($category->children))
        @include('admin.components.category-checkboxes', [
            'itemsCategory' => $category->children,
            'level' => $level + 1,
        ])
    @endif
@endforeach
