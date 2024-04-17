@php
    use App\Models\Category;
    $node = Category::find($id);
@endphp


<span style="width:45px" class="d-inline-block">
    @if ($node->getPrevSibling())
        <a href="{{ route('admin.categories.move', ['id' => $id, 'type' => 'up']) }}"
            class="btn btn-primary btn-sm">UP</a>
    @endif
</span>

<span style="width:65px" class="d-inline-block">
    @if ($node->getNextSibling())
        <a href="{{ route('admin.categories.move', ['id' => $id, 'type' => 'down']) }}"
            class="btn btn-danger btn-sm">DOWN</a>
    @endif
</span>
