$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#myTable").DataTable({
        iDisplayLength: 100,
        aLengthMenu: [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100],
        ],
    });

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
        var newStatus = currentStatus === "active" ? "inactive" : "active";
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var successMessage = `
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </div>
                            <div>
                                Cập nhật status thành công
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
        $("#successMessageContainer").html(successMessage);
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
            data: {
                selectedValues: selectedValues,
                categoryModelType: categoryModelType,
            },
            success: function (data) {
                window.location.reload();
                // $(".accordion-body input[type='checkbox']:checked").prop(
                //     "checked",
                //     false
                // );
                // var nestedDemoDiv = $("#nestedDemo");
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

    // ======================== SAVE MENU ===================================
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
