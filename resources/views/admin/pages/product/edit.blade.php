@php
    use App\Helpers\Template as Template;
    $statusOptions = [
        'active' => config('zvn.template.status.active.name'),
        'inactive' => config('zvn.template.status.inactive.name'),
    ];
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    @php
        $id = $item['id'];
        $name = $item['name'];
        $description = $item['description'];
        $status = $item['status'];
        $content = $item['content'];
        $mediaUrl = count($item['media']) > 0 ? $item['media'][0]->getUrl('webp') : '';
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
                                <label class="form-label">name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">description</label>
                                <input type="text" class="form-control" name="description"
                                    value="{{ old('description', $description) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    @foreach ($statusOptions as $key => $value)
                                        <option value="{{ $key }}"
                                            @if (old('status', $status) == $key) selected @endif>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">content</label>
                                <input type="text" class="form-control" name="content"
                                    value="{{ old('content', $content) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('cruds.admin.product.fields.images') }}</label>
                                <div id="myDropzone" class="dropzone"></div>
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
        <input type="hidden" name="id" value="{!! $id !!}">
    </form>
@endsection
