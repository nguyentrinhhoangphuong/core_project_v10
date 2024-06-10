<form action="{{ route('admin.product-attributes.store') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="row">
                <div class="mb-3">
                    <label class="form-label">Danh sách thuộc tính</label>
                    <select class="form-select attributes" name="attribute_id">
                        <option value="" selected>Tùy chọn</option>
                        @foreach ($attributes as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select attribute_value_id" name="attribute_value_id[]" multiple
                        disabled="disabled">
                    </select>
                </div>
                <input type="hidden" name="product_id" value="{{ $productId }}">
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-center">
        <a href="{{ route('admin.products.index') }}" class="btn btn-link me-2">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
