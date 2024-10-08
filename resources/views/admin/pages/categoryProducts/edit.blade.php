@php
    use App\Helpers\Template as Template;

    $statusOptions = [
        '1' => config('zvn.template.status.active.name'),
        '0' => config('zvn.template.status.inactive.name'),
    ];

@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    @php
        $id = $item['id'];
        $name = $item['name'];
        $status = $item['status'];
        $parent_id = $item['parent_id'];
    @endphp
    <form action="{{ route('admin.' . $routeName . '.update', ['item' => $item]) }}" method="post" class="card">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    @include('admin.templates.error')
                    <div class="row">
                        <div class="col-md-6 col-xl-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $name) }}">
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
                                <label class="form-label">Parent</label>
                                <select class="form-select" name="parent_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $item && $category->id == $parent_id ? 'selected' : '' }}>
                                            {{ str_repeat('/-----', $category->depth) }} {{ $category->name }}
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
            <a href="{{ route('admin.' . $routeName . '.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <input type="hidden" name="id" value="{!! $id !!}">
    </form>
@endsection
