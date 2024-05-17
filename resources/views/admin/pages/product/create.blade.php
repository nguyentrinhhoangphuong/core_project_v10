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
                                <label class="form-label">{{ __('cruds.admin.product.fields.name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.price') }}</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.description') }}</label>
                                <input type="text" class="form-control" name="description"
                                    value="{{ old('description') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.status') }}</label>
                                <select class="form-select" name="status">
                                    @foreach ($statusOptions as $key => $value)
                                        <option value="{{ $key }}"
                                            @if (old('status', 'active') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.content') }}</label>
                                <input type="text" class="form-control" name="content" value="{{ old(' content') }}">
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
            <a href="{{ route('admin.' . $routeName . '.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
