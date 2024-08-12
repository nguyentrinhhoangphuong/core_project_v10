{{-- @extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card card-body">
                @include('admin.templates.error')
                <form
                    action="{{ route('admin.category-products.saveAttributeId', ['categoryProductsId' => request()->categoryProductsId]) }}"
                    method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Danh sách thuộc tính</label>
                                    <div class="card">
                                        <div class="card-body">
                                            @foreach ($attributes as $item)
                                                <div class="form-check d-flex align-items-center mb-2">
                                                    <input class="form-check-input me-2" type="checkbox"
                                                        value="{{ $item->id }}" name="attribute_ids[]"
                                                        id="attribute_{{ $item->id }}"
                                                        {{ in_array($item->id, $currentAttributeIds) ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="attribute_{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-link me-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        @if (session('success'))
            fireNotif("{{ session('success') }}", "success", 3000);
        @endif
    </script>
@endsection --}}
