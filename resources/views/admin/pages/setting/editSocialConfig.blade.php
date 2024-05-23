@php
    $icon = $items['icon'];
    $link = $items['link'];
    $id = $items['id'];
    $key_value = $items['key_value'];
@endphp
@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="table-responsive">
                        <form class="card" action="{{ route('admin.settings.update.social.config') }}" method="post">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Social Config</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="icon" name="icon"
                                            placeholder="Social Icon" value="{{ $icon }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="link" class="col-sm-3 col-form-label">Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="link" name="link"
                                            placeholder="Social Link" value="{{ $link }}">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="key_value" value="{{ $key_value }}">
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
