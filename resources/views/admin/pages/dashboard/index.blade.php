@extends('admin.main')
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                @include('admin.pages.dashboard.overview')
            </div>
        </div>
    </div>
@endsection
