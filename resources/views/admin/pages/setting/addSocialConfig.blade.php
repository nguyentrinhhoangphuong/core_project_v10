@extends('admin.main')
@section('content')
    @include('admin.elements.header')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="table-responsive">
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
                                        <input type="text" class="form-control" id="icon" name="icon"
                                            placeholder="Social Icon">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="link" class="col-sm-3 col-form-label">Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="link" name="link"
                                            placeholder="Social Link">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="ordering" class="col-sm-3 col-form-label">Ordering</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="ordering" name="ordering"
                                            placeholder="Ordering">
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
