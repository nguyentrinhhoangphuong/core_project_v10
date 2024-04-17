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
        $link = $item['link'];
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
                                <label class="form-label">link</label>
                                <input type="text" class="form-control" name="link" value="{{ old('link', $link) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thumb</label>
                                <input type="file" class="form-control" name="thumb">
                            </div>
                            <div class="mb-3">
                                <img src="{!! $mediaUrl !!}" alt="{!! $name !!}" width="140">
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
