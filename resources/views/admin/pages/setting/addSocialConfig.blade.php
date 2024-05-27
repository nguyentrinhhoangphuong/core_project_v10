@php
    $iconConfig = config('zvn.icon');
    $xhtmlIcon = null;
    foreach ($iconConfig as $key => $item) {
        $xhtmlIcon .= sprintf(
            '<div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="icon" id="%s" value="%s">
                <label class="form-check-label" for="%s">
                    <span class="btn btn-outline-primary">
                        <i class="%s"></i></span>
                </label>
            </div>',
            $key,
            $item,
            $key,
            $item,
        );
    }

@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="table-responsive">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="card" action="{{ route('admin.settings.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Social Config</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                                    <div class="col-sm-9">
                                        {!! $xhtmlIcon !!}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="link" class="col-sm-3 col-form-label">Link</label>
                                    <div class="col-sm-9">
                                        <input name='links' value='' />
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="add-item-config" value="add-item-social">
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_admin_footer_Social')
    <script>
        var input = document.querySelector("input[name=links]"),
            tagify = new Tagify(input);

        var dragsort = new DragSort(tagify.DOM.scope, {
            selector: "." + tagify.settings.classNames.tag,
            callbacks: {
                dragEnd: onDragEnd,
            },
        });

        function onDragEnd(elm) {
            tagify.updateValueByDOMTags();
        }
    </script>
@endsection
