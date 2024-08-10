@php
    $statusOptions = [
        '1' => config('zvn.template.status.active.name'),
        '0' => config('zvn.template.status.inactive.name'),
    ];
    $topOptions = [
        '1' => config('zvn.template.isTop.active.name'),
        '0' => config('zvn.template.isTop.inactive.name'),
    ];
    $featuredOptions = [
        '1' => config('zvn.template.isFeatured.active.name'),
        '0' => config('zvn.template.isFeatured.inactive.name'),
    ];
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    @php
        $id = $item['id'];
        $name = $item['name'];
        $sku = $item['sku'];
        $price = $item['price'];
        $original_price = $item['original_price'];
        $slug = $item['slug'];
        $qty = $item['qty'];
        $description = $item['description'];
        $status = $item['status'];
        $is_top = $item['is_top'];
        $is_featured = $item['is_featured'];
        $seo_title = $item['seo_title'];
        $seo_description = $item['seo_description'];
        $content = $item['content'];
        $brand_id = $item['brand_id'];
        $series_id = $item['series_id'];
        $category_product_id = $item['category_product_id'];
    @endphp
    <form action="{{ route('admin.' . $routeName . '.update', ['item' => $id]) }}" method="post" enctype="multipart/form-data"
        class="card">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    @include('admin.templates.error')
                    <div class="row">
                        <div class="col-md-6 col-xl-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="{{ old('slug', $slug) }}">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('cruds.admin.product.fields.qty') }}</label>
                                        <input type="number" class="form-control" name="qty"
                                            value="{{ old('qty', $qty) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('cruds.admin.product.fields.price') }}</label>
                                        <input type="text" class="form-control" name="price"
                                            value="{{ old('price', $price) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">{{ __('cruds.admin.product.fields.original_price') }}</label>
                                        <input type="text" class="form-control" name="original_price"
                                            value="{{ old('original_price', $original_price) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('cruds.admin.product.fields.brand') }}</label>
                                        <select class="form-select brand" name="brand_id" id="brand_id">
                                            <option value="" selected>Tùy chọn</option>
                                            @foreach ($brands as $key => $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('brand_id', $brand_id) == $item->id) selected @endif>
                                                    {{ ucfirst($item->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Dòng sản phẩm</label>
                                        <select class="form-select brand" name="series_id" id="series_id">
                                            <option value="" selected>Tùy chọn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" class="form-control" name="sku"
                                            value="{{ old('sku', $sku) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">{{ __('cruds.admin.product.fields.description') }}</label>
                                        <input type="text" class="form-control" name="description"
                                            value="{{ old('description', $description) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Danh mục chính</label>
                                        <select class="form-select category_product" name="category_product_id">
                                            @foreach ($categoryProduct as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('category_product_id', $category_product_id) == $item->id) selected @endif>
                                                    {{ str_repeat('/-----', $item->depth) }} {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Danh mục phụ</label>
                                        <select class="form-select category_product" id="sub_category"
                                            name="sub_category_id[]" multiple>
                                            @foreach ($categoryProduct as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (in_array($item->id, old('sub_category_id', $subCategoryId))) selected @endif>
                                                    {{ str_repeat('/-----', $item->depth) }} {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('cruds.admin.product.fields.status') }}</label>
                                        <select class="form-select" name="status">
                                            <option value="" selected>Tùy chọn</option>
                                            @foreach ($statusOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if (old('status', $status) == $key) selected @endif>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('cruds.admin.product.fields.isTop') }}</label>
                                        <select class="form-select" name="is_top">
                                            <option value="" selected>Tùy chọn</option>
                                            @foreach ($topOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if (old('is_top', $is_top) == $key) selected @endif>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label
                                            class="form-label">{{ __('cruds.admin.product.fields.isFeatured') }}</label>
                                        <select class="form-select" name="is_featured">
                                            <option value="" selected>Tùy chọn</option>
                                            @foreach ($featuredOptions as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if (old('is_featured', $is_featured) == $key) selected @endif>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SEO title</label>
                                        <input type="text" class="form-control" name="seo_title"
                                            value="{{ old('seo_title', $seo_title) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SEO description</label>
                                        <input type="text" class="form-control" name="seo_description"
                                            value="{{ old('seo_description', $seo_description) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.content') }}</label>
                                <textarea class="form-control" name="content" id="editor1">{{ old('editor1', $content) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.images') }}</label>
                                <div class="needsclick dropzone" id="document-dropzone"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="{{ route('admin.' . $routeName . '.index') }}" class="btn btn-link me-2">Hủy</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
        <input type="hidden" name="id" value="{!! $id !!}">
    </form>
@endsection
@section('scripts')
    <script src="{{ asset('_admin/js/my-slug.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.category_product').select2();
            $('.brand').select2();

            var initialBrandId = $('#brand_id').val();
            if (initialBrandId) {
                loadSeries(initialBrandId, {{ $series_id }});
            }

            $('#brand_id').change(function() {
                var brandId = $(this).val();
                $('#series_id').empty();
                $('#series_id').append('<option value="" selected>Tùy chọn</option>');
                if (brandId) {
                    loadSeries(brandId, null);
                }
            });

            function loadSeries(brandId, selectedSeriesId) {
                var url = "{{ route('admin.get.series.by.brandid', ['brand_id' => ':brandId']) }}";
                url = url.replace(':brandId', brandId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var selected = selectedSeriesId == value.id ? 'selected' : '';
                            $('#series_id').append('<option value="' + value.id + '" ' +
                                selected + '>' + value.name + '</option>');
                        });
                    }
                });
            }
        });
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
    </script>
@endsection
