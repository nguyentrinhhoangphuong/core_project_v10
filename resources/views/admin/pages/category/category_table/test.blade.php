<table class="table table-vcenter card-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        @if (count($items) > 0)
            @php
                $level = '/--------';
            @endphp
            @foreach ($items as $item)
                @include('admin.pages.category.category_table.child_test', [
                    'item' => $item,
                    'level' => $level,
                ])
            @endforeach
        @endif
    </tbody>
</table>
