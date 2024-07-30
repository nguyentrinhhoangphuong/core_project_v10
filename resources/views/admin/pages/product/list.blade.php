<table class="table table-vcenter card-table table-striped display">
    <thead>
        <tr>
            <th class="">#</th>
            <th class="">Hình</th>
            <th class="">Tên sản phẩm</th>
            <th class="">Thương hiệu</th>
            <th class="">Giá</th>
            <th class="">Trạng thái</th>
            <th class="">Top</th>
            <th class="">Featured</th>
            <th class="">Hành động</th>
        </tr>
    </thead>
    <tbody id="result">
        @include('admin.pages.' . $controllerName . '.list_row', ['items' => $items])
    </tbody>
</table>
