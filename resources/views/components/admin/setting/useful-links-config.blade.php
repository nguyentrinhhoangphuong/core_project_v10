@php
    $xhtmlUsefulLinks = '';
    if (isset($items)) {
        $results = json_decode($items['value'], true);
        $key_value = $items['key_value'];
        foreach ($results as $item) {
            $id = $item['id'];
            $name = $item['name'];
            $url = $item['url'];

            $xhtmlUsefulLinks .= sprintf(
                '<tr class="row_UsefulLinks" data-id="%s" data-routename="%s">
                    <td class="handle" style="cursor: move"><i class="fa fa-sort"></i></td>
                    <td>
                        <input class="form-control editable-usefullink-field" name="name" value="%s"/>
                    </td>
                    <td>
                        <input class="form-control editable-usefullink-field" name="url" value="%s" data-tag-id="%s" data-key-value="%s"/>
                    </td>
                    <td>
                        <input type="button" class="btn btn-outline-red" id="delete-item-usefullink" data-tag-id="%s" data-key-value="%s" data-route-name="%s" value="Xóa">
                    </td>
                </tr>',
                $id,
                $routeName,
                $name,
                $url,
                $id,
                $key_value,
                $id,
                $key_value,
                $routeName,
            );
        }
    }
@endphp
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Useful Links Config</h3>
            <a href="{{ route('admin.settings.add.useful.links.config') }}" class="btn btn-primary">Thêm
                mới</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Link</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tablecontents_UsefulLinks">
                        {!! $xhtmlUsefulLinks !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts_admin_footer_UsefulLinks')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#tablecontents_UsefulLinks").sortable({
                items: "tr",
                handle: ".handle",
                cursor: "move",
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                },
            });

            $(".editable-usefullink-field")
                .each(function() {
                    // Lưu giá trị ban đầu của mỗi trường vào data-oldValue
                    $(this).data("oldValue", $(this).val());
                })
                .keypress(function(event) {
                    if (event.which === 13) {
                        event.preventDefault();
                        var inputField = $(this);
                        var newValue = inputField.val();
                        var oldValue = inputField.data("oldValue"); // Lấy giá trị cũ từ data-oldValue
                        var itemId = inputField.closest("tr").data("id");
                        var routeName = inputField.closest("tr").data("routename");
                        var fieldName = inputField.attr("name");
                        var keyValue = inputField.closest("tr").find("input[name='url']").attr(
                            "data-key-value");
                        if (oldValue !== newValue) {
                            $.ajax({
                                url: routeName + "/ajax-update-useful-link-field",
                                method: "POST",
                                data: {
                                    itemId: itemId,
                                    fieldName: fieldName,
                                    value: newValue,
                                    keyValue: keyValue,
                                },
                                success: function(response) {
                                    console.log(response);
                                    fireNotif("Update thành công", "success", 3000);
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                    fireNotif("Lỗi khi cập nhật", "error", 3000);
                                },
                                complete: function() {
                                    inputField.data("oldValue",
                                        newValue); // Cập nhật giá trị cũ sau khi hoàn thành request
                                },
                            });
                        }
                        inputField.blur();
                    }
                });


            $(document).on("click", "#delete-item-usefullink", function() {
                deleteItemUsefullink($(this));
            });

        });

        function sendOrderToServer() {
            let order = [];
            let routeName = $(".row_UsefulLinks").attr("data-routename");
            $("tr.row_UsefulLinks").each(function(index) {
                order.push({
                    id: $(this).attr("data-id"),
                    keyValue: $(this).find("input[name='url']").attr("data-key-value"),
                    position: index + 1,
                });
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: routeName + "/ajax-update-useful-link-ordering",
                data: {
                    order: order,
                },
                success: function(response) {
                    fireNotif(response.message, "success", 3000);
                },
            });
        }

        function deleteItemUsefullink(button) {
            let tagId = button.data("tag-id");
            let keyValue = button.data("key-value");
            let routeName = button.data("route-name");
            let row = button.closest('tr');
            if (confirm("Bạn có chắc chắn muốn xóa mục này không?")) {
                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: routeName + "/ajax-delete-item",
                    data: {
                        id: tagId,
                        keyValue: keyValue,
                    },
                    success: function(response) {
                        fireNotif(response.message, "success", 3000);
                        row.remove();
                    },
                });
            }
        }
    </script>
@endsection
