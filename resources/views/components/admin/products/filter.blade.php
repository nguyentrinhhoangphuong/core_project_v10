<div class="accordion" id="accordion-example">
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading-1">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1"
                aria-expanded="false">
                Bộ Lọc
            </button>
        </h2>
        <div id="collapse-1" class="accordion-collapse collapse" aria-labelledby="heading-1"
            data-bs-parent="#accordion-example">
            <div class="accordion-body pt-0">
                <form action="{{ route('admin.products.filter') }}" method="POST">
                    @csrf
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        @php
                            $xhtml = '';
                            // Thêm bộ lọc thương hiệu
                            $xhtml .= '<div class="col">
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">Thương hiệu</label>
                                            <select name="brand[]" id="brand" class="form-control filter-select" multiple>';
                            foreach ($brands as $brand) {
                                $xhtml .= sprintf(
                                    '<option value="%s" %s>%s</option>',
                                    $brand->id,
                                    request()->brand == $brand->id ? 'selected' : '',
                                    ucfirst($brand->name),
                                );
                            }
                            $xhtml .= '</select></div></div>';

                            // Thêm các bộ lọc khác từ attribute
                            foreach ($attribute as $item) {
                                $name = $item->name;
                                $slug = $item->slug;
                                $xhtml .= sprintf(
                                    ' <div class="col">
                                        <div class="mb-3">
                                            <label for="%1$s" class="form-label">%1$s</label>
                                                <select name="%2$s[]" id="%1$s" class="form-control filter-select" multiple>',
                                    $name,
                                    $slug,
                                );
                                foreach ($item->attributeValue as $value) {
                                    $xhtml .= sprintf('<option value="%s">%s</option>', $value->id, $value->value);
                                }
                                $xhtml .= '</select></div></div>';
                            }
                        @endphp

                        {!! $xhtml !!}
                    </div>
                    <button type="submit" class="btn btn-primary" id="filter-products">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('filter-scripts')
    <script>
        $(document).ready(function() {
            $('.filter-select').select2({
                placeholder: "Chọn mục",
                allowClear: true // Cho phép người dùng xóa lựa chọn bằng cách nhấp vào dấu x
            });

            $('#filter-products').click(function(e) {
                e.preventDefault();
                var form = $('form')[0];
                var url = form.action;
                var formData = new FormData(form);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.success) {
                            $('#result').html(res.data);
                            fireNotif("Lọc sản phẩm thành công", "success", 3000);

                            // Cuộn xuống phần hiển thị kết quả
                            $('html, body').animate({
                                scrollTop: $('#result').offset().top
                            }, 500);
                        }
                    }
                });
            })
        });
    </script>
@endpush

<style>
    .accordion-button:not(.collapsed) {
        color: inherit;
        background-color: inherit;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    #filter-products {
        margin-top: 1rem;
    }
</style>
