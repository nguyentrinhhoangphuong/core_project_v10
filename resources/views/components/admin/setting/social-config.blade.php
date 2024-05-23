@php
    $xhtmlSocial = '';
    if (isset($items)) {
        $results = json_decode($items['value'], true);
        $key_value = $items['key_value'];

        foreach ($results as $item) {
            $icon = $item['icon'];
            $id = $item['id'];
            $result = json_decode($item['links'], true);
            $values = array_column($result, 'value');
            $links = implode(', ', $values);
            $edit = route('admin.settings.edit.social.config', ['id' => $item['id'], 'key_value' => $key_value]);

            $xhtmlSocial .= sprintf(
                '<tr class="row1" data-id="%s" data-routename="%s">
                    <td class="handle"><i class="fa fa-sort"></i></td>
                    <td>
                        <i class="%s"></i>
                    </td>
                    <td class="text-secondary">
                        <input name="links" value="%s" data-tag-id="%s" data-key-value="%s"/>
                    </td>
                    <td>
                        <input type="button" class="btn btn-outline-red" id="delete-item-social" data-tag-id="%s" data-key-value="%s" data-route-name="%s" value="Xóa">
                    </td>
                </tr>',
                $id,
                $routeName,
                $icon,
                $links,
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
            <h3 class="card-title mb-0">Social Config</h3>
            <a href="{{ route('admin.settings.add.social.config') }}" class="btn btn-primary">Thêm
                mới</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Icon</th>
                            <th>Link</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tablecontents">
                        {!! $xhtmlSocial !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        var reloadCount = 0;
        var reloadConfig1 = true; // Đánh dấu liệu có tải lại phần social-config-1 hay không
        if (performance.navigation.type == 2 && reloadConfig1) {
            reloadCount++;
            if (reloadCount < 2) { // Tải lại chỉ khi reloadCount < 2
                location.reload();
            }
        }


        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('input[name="links"]').forEach((input) => {
                let tagify = new Tagify(input);
                new DragSort(tagify.DOM.scope, {
                    selector: "." + tagify.settings.classNames.tag,
                    callbacks: {
                        dragEnd: () => {
                            tagify.updateValueByDOMTags();
                            updateSocialLinks(tagify, input);
                        },
                    },
                });

                tagify.on("add", function(e) {
                    addSocialLink(e);
                });

                tagify.on("remove", function(e) {
                    removeSocialLink(e);
                });

                tagify.on("edit:updated", function(e) {
                    editSocialLink(e);
                });
            });
            // Initialize sortable table rows
            $("#tablecontents").sortable({
                items: "tr",
                handle: ".handle",
                cursor: "move",
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                },
            });
            // Delete item
            $(document).on("click", "#delete-item-social", function() {
                deleteSocialItem($(this));
            });
        });

        function updateSocialLinks(tagify, input) {
            let tags = tagify.value.map(tag => tag.value);
            let tagId = input.dataset.tagId;
            let keyValue = input.dataset.keyValue;
            $.ajax({
                method: "POST",
                url: "/admin/settings/ajax-update-social-position/" + tagId,
                data: {
                    tags: tags,
                    id: tagId,
                    keyValue: keyValue
                },
                success: function(response) {
                    fireNotif(response.message, "success", 3000);
                },
            });
        }

        function addSocialLink(event) {
            let newValue = event.detail.data.value;
            let keyValue = event.detail.tagify.DOM.originalInput.dataset.keyValue;
            let tagId = event.detail.tagify.DOM.originalInput.dataset.tagId;
            $.ajax({
                method: "POST",
                url: "/admin/settings/ajax-insert-social-config/",
                data: {
                    newValue: newValue,
                    keyValue: keyValue,
                    id: tagId
                },
                success: function(response) {
                    fireNotif(response.message, "success", 3000);
                },
            });
        }

        function removeSocialLink(event) {
            let removedValue = event.detail.data.value;
            let tagId = event.detail.tagify.DOM.originalInput.dataset.tagId;
            let keyValue = event.detail.tagify.DOM.originalInput.dataset.keyValue;
            $.ajax({
                method: "DELETE",
                url: "/admin/settings/ajax-delete-social-config/" + tagId,
                data: {
                    removedValue: removedValue,
                    id: tagId,
                    keyValue: keyValue
                },
                success: function(response) {
                    fireNotif(response.message, "success", 3000);
                },
            });
        }

        function editSocialLink(event) {
            let newValue = event.detail.data.value;
            let oldValue = event.detail.previousData.value;
            let tagId = event.detail.tagify.DOM.originalInput.dataset.tagId;
            let keyValue = event.detail.tagify.DOM.originalInput.dataset.keyValue;
            if (newValue == oldValue) return;
            $.ajax({
                method: "POST",
                url: "/admin/settings/ajax-update-social-config/" + tagId,
                data: {
                    newValue: newValue,
                    oldValue: oldValue,
                    id: tagId,
                    keyValue: keyValue
                },
                success: function(response) {
                    fireNotif(response.message, "success", 3000);
                },
            });
        }

        function sendOrderToServer() {
            let order = [];
            let routeName = $(".row1").attr("data-routename");
            $("tr.row1").each(function(index) {
                order.push({
                    id: $(this).attr("data-id"),
                    keyValue: $(this).find("input[name='links']").attr("data-key-value"),
                    position: index + 1,
                });
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: routeName + "/update-ordering",
                data: {
                    order: order,
                },
                success: function(response) {
                    if (response.status == "success") {
                        fireNotif("Update thành công", "success", 3000);
                    } else {
                        fireNotif("Update không thành công", "error", 3000);
                    }
                },
            });
        }

        function deleteSocialItem(button) {
            let tagId = button.data("tag-id");
            let keyValue = button.data("key-value");
            let routeName = button.data("route-name");
            let row = button.closest('tr'); // Find the closest row (tr) containing the "Xóa" button
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
                    row.remove(); // Remove the row from the table
                },
            });
        }
    </script>
@endsection
