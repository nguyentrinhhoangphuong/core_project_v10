@php
    use App\Helpers\Template;
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <form action="{{ isset($item) ? route('admin.flash-sales.update', $item->id) : route('admin.flash-sales.store') }}"
        method="POST" class="card">
        @csrf
        @if (isset($item))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-6 col-xl-12">
                            <div class="mb-3">
                                <label for="name">Tên</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $item->name ?? '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="discount_percentage">Tỷ lệ chiết khấu</label>
                                <input type="number" name="discount_percentage" id="discount_percentage"
                                    class="form-control"
                                    value="{{ old('discount_percentage', $item->discount_percentage ?? '') }}"
                                    min="0" max="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="start_time">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="start_time" class="form-control"
                                    value="{{ old('start_time', isset($item) ? \Carbon\Carbon::parse($item->start_time)->format('Y-m-d\TH:i') : '') }}">
                            </div>

                            <div class="mb-3">
                                <label for="end_time">Thời gian kết thúc</label>
                                <input type="datetime-local" name="end_time" class="form-control"
                                    value="{{ old('end_time', isset($item) ? \Carbon\Carbon::parse($item->end_time)->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="products">Chọn sản phẩm</label>
                                <select name="products[]" id="products" class="form-control select-products" multiple>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if (isset($item) && $item->products->contains($product->id)) selected @endif>
                                            {{ $product->name }} - Giá: {{ Template::numberFormatVND($product->price) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-link me-2">Hủy</a>
            <button type="submit" class="btn btn-primary">{{ isset($item) ? 'Cập nhật' : 'Tạo mới' }}</button>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select-products').select2();
        });
    </script>
@endsection
