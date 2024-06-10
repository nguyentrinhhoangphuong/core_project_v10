@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12 d-flex justify-content-end">
                    {{-- <x-admin.area-search :params="$params" /> --}}
                </div>
                <div class="col-12">
                    <div class="row row-cards">
                        <div class="col-8">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    @include('admin.pages.product.' . $controllerName . '.list', [
                                        'groupedItems' => $groupedItems,
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-body">
                                @include('admin.templates.error')
                                @include('admin.pages.product.' . $controllerName . '.form-products-attr', [
                                    'productId' => $productId,
                                    'attributes' => $attributes,
                                ])
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.attributes').change(function() {
                var attributeId = $(this).val();
                if (attributeId) {
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "/admin/product-attributes/get-attribute-value-by-id",
                        data: {
                            attributeId: attributeId
                        },
                        success: function(data) {
                            if (data) {
                                var attributeValuesDropdown = $('.attribute_value_id');
                                attributeValuesDropdown.empty();
                                $.each(data, function(index, item) {
                                    attributeValuesDropdown.append('<option value="' +
                                        item.attribute_value_id + '">' + item
                                        .attributeValues + '</option>');
                                });
                                attributeValuesDropdown.prop('disabled', false);
                                attributeValuesDropdown.select2();
                                attributeValuesDropdown.select2('open');
                            } else {
                                $(".attribute_values").empty();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $(".attribute_values").empty();
                    $('.attribute_values').prop('disabled', true);
                }
            });
        });
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
    </script>
@endsection
