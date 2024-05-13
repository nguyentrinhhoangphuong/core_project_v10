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
        $title = $item['title'];
        $content = $item['content'];
        $status = $item['status'];
        $category_id = $item['category_id'];
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
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title"
                                    value="{{ old('title', $title) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea class="form-control" name="content" id="editor1">{{ old(' editor1', $content) }}</textarea>
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
                                <label class="form-label">Danh mục</label>
                                <select class="form-select category-select2 select2-hidden-dropdown" style="width: 100%"
                                    name="category_id">
                                    @foreach ($itemsCategory as $key => $value)
                                        <option value="{{ $key }}"
                                            @if (old('category_id', $category_id) == $key) selected @endif>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumb</label>
                                <input type="file" class="form-control" name="thumb">
                            </div>
                            <div class="mb-3">
                                <img src="{!! $mediaUrl !!}" alt="{!! $title !!}" width="140">
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
        <input type="hidden" name="thumb_current" value="{!! $item['thumb'] !!}">
    </form>
@endsection
