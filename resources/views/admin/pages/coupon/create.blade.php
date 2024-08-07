@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <form action="{{ route('admin.coupon.store') }}" method="post" class="card">
        @csrf
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    @include('admin.templates.error')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung giảm giá</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Loại giảm giá</label>
                                <select class="form-select" name="discount_type" required>
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định
                                    </option>
                                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần
                                        trăm</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giảm (%)</label>
                                <input type="number" step="0.01" class="form-control" name="discount_value"
                                    value="{{ old('discount_value') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Giá trị đơn hàng tối thiểu</label>
                                <input type="number" step="0.01" class="form-control" name="min_order_amount"
                                    value="{{ old('min_order_amount') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giảm giá tối đa</label>
                                <input type="number" step="0.01" class="form-control" name="max_discount_amount"
                                    value="{{ old('max_discount_amount') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giới hạn sử dụng</label>
                                <input type="number" class="form-control" name="usage_limit"
                                    value="{{ old('usage_limit') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input type="datetime-local" class="form-control" name="starts_at"
                                    value="{{ old('starts_at') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày kết thúc</label>
                                <input type="datetime-local" class="form-control" name="expires_at"
                                    value="{{ old('expires_at') }}" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                    value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Kích hoạt</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="{{ route('admin.coupon.index') }}" class="btn btn-link me-2">Hủy</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </form>
@endsection
