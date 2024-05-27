@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="table-responsive">
                        <form class="card" action="{{ route('admin.settings.add.useful.links.config.store') }}"
                            method="post">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Useful Links Config</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label for="icon" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="name">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="link" class="col-sm-3 col-form-label">URL</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="url" name="url"
                                            placeholder="URL">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="add-item-config" value="add-item-useful-links">
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
