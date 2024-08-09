@inject('orderService', 'App\Services\Order\OrderService')
@extends('admin.main')
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                @include('admin.pages.dashboard.overview')
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                @include('admin.pages.dashboard.latestOrders')
            </div>
        </div>
    </div>
@endsection
