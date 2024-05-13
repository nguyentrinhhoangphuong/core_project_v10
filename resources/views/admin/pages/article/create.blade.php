@php
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <form action="{{ route('admin.' . $routeName . '.store') }}" method="post" enctype="multipart/form-data" class="card">
        @csrf
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    @include('admin.templates.error')
                    <div class="row">
                        <div class="col-md-6 col-xl-12">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea class="form-control" name="content" id="editor1">{{ old('editor1') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    @foreach ($statusOptions as $key => $value)
                                        <option value="{{ $key }}"
                                            @if (old('status', 'active') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Danh mục</label>
                                <select type="text" class="form-select category-select2 select2-hidden-dropdown"
                                    style="width: 100%" name="category_id" value="">
                                    @foreach ($itemsCategory as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumb</label>
                                <input type="file" class="form-control image-with-preview" name="thumb"
                                    accept='image/*' onchange='openFile(event)'>
                                <div>
                                    {{-- không dùng  onchange='openFile(event)' sử dụng tên class --}}
                                    {{-- <img id='output' width="25%"> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="{{ route('admin.' . $routeName . '.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
