$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // ======================================= DATA TABLE =========================================
    // SLIDER
    $("#myTable").DataTable({
        iDisplayLength: 100,
        aLengthMenu: [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100],
        ],
    });
    $("#tablecontents").sortable({
        items: "tr",
        cursor: "move",
        opacity: 0.6,
        update: function () {
            let info;
            sendOrderToServer();
            info = true
                ? fireNotif("Update thành công", "success", 3000)
                : fireNotif("Update không thành công", "error", 3000);
        },
    });
    $("#tablecontents").on("mouseenter", "tr", function () {
        $(this).css("cursor", "move"); // Hoặc sử dụng "move" thay cho "pointer" tùy thuộc vào thiết kế bạn muốn
    }).on("mouseleave", "tr", function () {
        $(this).css("cursor", "default");
    });
    function sendOrderToServer() {
        var order = [];
        var routeName = $(".row1").attr("data-routename");
        $("tr.row1").each(function (index, element) {
            order.push({
                id: $(this).attr("data-id"),
                keyValue: $(this)
                    .find("input[name='links']")
                    .attr("data-key-value"),
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
            success: function (response) {
                if (response.status == "success") {
                    info = true;
                } else {
                    info = false;
                }
            },
        });
    }

    // ============================================= SEARCH ==========================================
    let $btnSearch = $("button#btn-search");
    let $inputSearchField = $("input[name = search_field]"); //hidden
    let $inputSearchValue = $("input[name = search_value]");
    let $submitMenuCategory = $(".accordion-item #sumbitMenuCategory");
    let $submitMenuCategoryProducts = $(
        ".accordion-item #sumbitMenuCategoryProducts"
    );

    // chọn filed cần search
    $(".select-field").click(function () {
        // Lấy giá trị của data-field từ mục được chọn
        var searchType = $(this).data("field");
        // Gán giá trị cho input hidden
        $inputSearchField.val(searchType);

        // Thay đổi nội dung của button thành giá trị của data-field
        $("#selectDataField").text($(this).text());
    });

    // ================== nút search ==============================================================
    $btnSearch.click(function (e) {
        let params = ["page", "filter_status", "select_field", "select_value"];
        let pathname = window.location.pathname; // /admin/sliders
        let searchField =
            $inputSearchField.val() == "" ? "all" : $inputSearchField.val();
        let searchValue = $inputSearchValue.val();

        // lấy params hiện tại có trên thanh địa chỉ
        let link = "";
        let searchParams = new URLSearchParams(window.location.search);
        $.each(params, function (key, value) {
            if (searchParams.has(value)) {
                link += value + "=" + searchParams.get(value) + "&";
            }
        });

        if (searchValue.replace(/\s/g, "") == "") {
            alert("Nhập giá trị cần tìm");
        } else {
            window.location.href =
                pathname +
                "?" +
                link +
                "search_field=" +
                searchField +
                "&search_value=" +
                searchValue.replace(/\s+/g, "+").toLowerCase();
        }
    });

    // ================== DELETE SLIDER ==============================================================
    document.addEventListener("click", function (e) {
        const el = e.target;
        if (el.classList.contains("item_delete")) {
            if (confirm("Xóa mục này?")) {
                el.querySelector("form").submit();
            }
        }
    });

    // ================= Change Category ==============================================================
    // Function to update category asynchronously
    function updateCategory(id, category_id, controller) {
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: controller + "/update-category/" + id,
            method: "POST",
            data: {
                category_id: category_id,
                _token: csrfToken,
            },
            success: function (response) {
                // Update the select options if the request is successful
                if (response.success) {
                    // Update select options
                    $('.category-select2[data-item-id="' + id + '"]')
                        .val(category_id)
                        .trigger("change.select2");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }
    // Event handler for keypress and change events
    $(".category-select2, .change-category").on(
        "keypress change",
        function (e) {
            if (e.type === "keypress" && e.which !== 13) {
                return; // Exit if keypress is not Enter key
            }
            var id = $(this).data("item-id");
            var category_id = $(this).val();
            var controller = $(this).data("controller");
            updateCategory(id, category_id, controller);
        }
    );

    // ================== CHANGE STATUS ==============================================================
    // Event handler for toggle status button
    $(".toggle-status").click(function () {
        var button = $(this);
        var itemId = $(this).data("item-id");
        var currentStatus = $(this).data("item-status");
        var controller = $(this).data("controller");
        var newStatus = currentStatus === 1 ? 0 : 1;
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        // them disable cho btn
        $.ajax({
            url: controller + "/update-status/" + itemId,
            method: "POST",
            data: {
                status: newStatus,
                _token: csrfToken,
            },
            success: function (response) {
                let active = response.data.active;
                let inactive = response.data.inactive;
                if (response.success) {
                    fireNotif("cập nhật status thành công", "success", 3000);
                    // Update the status button text and class
                    button.text(newStatus === "active" ? active : inactive);
                    button
                        .removeClass("btn-outline-success btn-outline-danger")
                        .addClass(
                            newStatus === "active"
                                ? "btn-outline-success"
                                : "btn-outline-danger"
                        );
                    // Update the data-item-status attribute
                    button.data("item-status", newStatus);
                }
            },
            complete: function () {
                setTimeout(function () {
                    $("#successMessageContainer").html("");
                }, 3000);
            },
        });
    });

    // ================= SLECT 2 ======================================================================
    // khởi tạo select2()
    $(".category-select2").select2();

    // ================= nested sortable ===============================================================
    const nestedQuery = ".nested-sortable";
    const identifier = "sortableId";
    const root = document.getElementById("nestedDemo");
    function serialize(sortable) {
        var serialized = [];
        var children = [].slice.call(sortable.children);
        for (var i in children) {
            var nested = children[i].querySelector(nestedQuery);
            serialized.push({
                id: children[i].dataset[identifier],
                children: nested ? serialize(nested) : [],
            });
        }
        return serialized;
    }

    function initSortable() {
        var nestedSortables = [].slice.call(
            document.querySelectorAll(".nested-sortable")
        );
        for (var i = 0; i < nestedSortables.length; i++) {
            new Sortable(nestedSortables[i], {
                group: "nested",
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onEnd: function () {
                    // This event is triggered after a drag-and-drop operation completes
                    const element = document.querySelector(".nested-sortable");
                    const routeName = element.dataset.routename;
                    let url = "/admin/" + routeName + "/updateTree";
                    let data = serialize(root);
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            data: data,
                        },
                        success: function (data) {},
                    });
                },
            });
        }
    }
    initSortable();
    // ========================= MENUS MAGEMENT SUBMIT FORM ==========================================
    function submitMenu(url, categoryModelType) {
        var selectedValues = [];
        // Duyệt qua tất cả các checkbox đã chọn và lấy giá trị của chúng
        $(".accordion-body input[type='checkbox']:checked").each(function () {
            var id = $(this).val();
            var name = $(this).closest("label").attr("value");
            var checkboxInfo = {
                model_id: id,
                name: name,
            };
            selectedValues.push(checkboxInfo);
        });

        $.ajax({
            url: url,
            method: "POST",
            dataType: "html",
            data: {
                selectedValues: selectedValues,
                categoryModelType: categoryModelType,
            },
            success: function (data) {
                console.log(data);
                // window.location.reload();
                $(".accordion-body input[type='checkbox']:checked").prop(
                    "checked",
                    false
                );
                var nestedDemoDiv = $("#nestedDemo");
                nestedDemoDiv.html(data);
                initSortable();
                // $.each(data.items.selectedValues, function (index, item) {
                //     if (typeof item !== "object" || !item.name) {
                //         console.error("Dữ liệu mục không hợp lệ:", item);
                //         return;
                //     }
                //     var newItemDiv = $("<div></div>")
                //         .attr("data-sortable-id", item.model_id)
                //         .addClass("list-group-item")
                //         .text(item.name);
                //     nestedDemoDiv.append(newItemDiv);
                // });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(
                    "Lỗi khi thực hiện yêu cầu:",
                    textStatus,
                    errorThrown
                );
            },
        });
    }

    $submitMenuCategory.click(function () {
        var categoryModelType = $("#collapse-2")
            .find(".accordion-body")
            .data("category-model-type");
        submitMenu("/admin/menus", categoryModelType);
    });

    $submitMenuCategoryProducts.click(function () {
        var categoryProductsModelType = $("#collapse-3")
            .find(".accordion-body")
            .data("category-products-model-type");
        submitMenu("/admin/menus", categoryProductsModelType);
    });

    // ======================== Custom link ===================================
    $("form").submit(function (event) {
        var url = $("#urlInput").val();
        var name = $("#linkTextInput").val();
        if (url.trim() === "" || name.trim() === "") {
            alert("Vui lòng điền vào cả hai trường URL và Tên Url.");
            event.preventDefault(); // Ngăn chặn việc submit form
        }
    });

    // ========================================== Update trức tiếp từ field ========================
    $(document).on("click", function (event) {
        if (!$(event.target).closest(".editable-field").length) {
            // Mất focus trên tất cả các trường chỉnh sửa
            $(".editable-field").blur();
        }
    });
    // Gắn sự kiện 'keypress' vào trường chỉnh sửa
    $(".editable-field")
        .each(function () {
            // Lưu giá trị ban đầu của mỗi trường vào data-oldValue
            $(this).data("oldValue", $(this).val());
        })
        .keypress(function (event) {
            if (event.which === 13) {
                event.preventDefault();

                var inputField = $(this);
                var newValue = inputField.val();
                var oldValue = inputField.data("oldValue"); // Lấy giá trị cũ từ data-oldValue
                var itemId = inputField.closest("tr").data("id");
                var routeName = inputField.closest("tr").data("routename");
                var fieldName = inputField.attr("name");

                if (oldValue !== newValue) {
                    // So sánh giá trị mới và cũ
                    $.ajax({
                        url: routeName + "/update-field",
                        method: "POST",
                        data: {
                            itemId: itemId,
                            fieldName: fieldName,
                            value: newValue,
                        },
                        success: function (response) {
                            console.log(response);
                            fireNotif("Update thành công", "success", 3000);
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                            fireNotif("Lỗi khi cập nhật", "error", 3000);
                        },
                        complete: function () {
                            inputField.data("oldValue", newValue); // Cập nhật giá trị cũ sau khi hoàn thành request
                        },
                    });
                }
                inputField.blur();
            }
        });
});

// ================ review image ==================
var openFile = function (event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function () {
        var dataURL = reader.result;
        var output = document.getElementById("output");
        output.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
};

// ===================== DROPZONE =================
if (document.getElementById("document-dropzone")) {
    Dropzone.autoDiscover = false;
    var altIndex = 0;
    $(document).ready(function () {
        var documentdropzone = new Dropzone("#document-dropzone", {
            url: "/admin/products/media",
            paramName: "file",
            maxFiles: 10,
            uploadMultiple: true,
            addRemoveLinks: true,
            maxFilesize: 2,
            dictDefaultMessage:
                "Kéo và thả file vào đây hoặc nhấn để chọn file",
            dictRemoveFile: "Xóa",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            init: function () {
                this.on("addedfile", function (file) {
                    // Create container div for input fields
                    var inputContainer = document.createElement("div");
                    inputContainer.classList.add("dz-input-container");

                    // Create input field for alt
                    var altInput = document.createElement("input");
                    altInput.setAttribute("type", "text");
                    altInput.setAttribute("name", "alt[]");
                    altInput.classList.add("dz-alt-input");

                    // Create input field for text
                    var imageInput = document.createElement("input");
                    imageInput.setAttribute("type", "hidden");
                    imageInput.setAttribute("name", "images[]");
                    imageInput.setAttribute("value", file.name);

                    inputContainer.appendChild(altInput);
                    inputContainer.appendChild(imageInput);

                    file.previewElement.appendChild(inputContainer);

                    // Thêm input hidden vào biểu mẫu
                    document.querySelector("form").appendChild(imageInput);
                });

                thisDropzone = this;
                let id = getId();
                $.get(`/admin/products/${id}/files`, function (data) {
                    console.log(data);
                    data.sort(function (a, b) {
                        return a.order - b.order;
                    });
                    $.each(data, function (key, value) {
                        var mockFile = {
                            media_id: value.media_id,
                            name: value.name,
                            url: value.url,
                            size: value.size,
                            order: value.order,
                            alt: value.alt,
                        };

                        var url =
                            `/media/${mockFile.media_id}/` + mockFile.name;
                        thisDropzone.options.addedfile.call(
                            thisDropzone,
                            mockFile
                        );
                        thisDropzone.options.thumbnail.call(
                            thisDropzone,
                            mockFile,
                            url
                        );
                        mockFile.previewElement.classList.add("dz-success");
                        mockFile.previewElement.classList.add("dz-complete");

                        var alt = document.createElement("input");
                        alt.setAttribute("type", "text");
                        alt.setAttribute("name", "alt[]");
                        alt.setAttribute("value", mockFile.alt);
                        mockFile.previewElement.appendChild(alt);

                        var images = document.createElement("input");
                        images.setAttribute("type", "hidden");
                        images.setAttribute("name", "images[]");
                        images.setAttribute("value", mockFile.name);
                        mockFile.previewElement.appendChild(images);
                    });
                });

                this.on("removedfile", function (file) {
                    console.log(file.name);
                    $("form").append(
                        '<input type="hidden" name="image_delete[]" value="' +
                            file.name +
                            '">' +
                            '<input type="hidden" name="product_id" value="' +
                            id +
                            '">'
                    );
                });
            },
        });
        $("#document-dropzone").sortable({
            items: ".dz-preview",
            cursor: "move",
            opacity: 0.5,
            containment: "parent",
        });
        $("#document-dropzone").disableSelection();
    });
}

function getId() {
    var url = window.location.href;
    var segments = url.split("/");
    return segments[segments.length - 2]; // Lấy phần tử thứ 2 từ cuối cùng (ID)
}
