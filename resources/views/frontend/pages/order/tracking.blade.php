{{-- @php use App\Helpers\Template; @endphp --}}
@extends('frontend.main')
@section('content')
    <section class="faq-breadcrumb pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h3 class="fw-bold">Theo Dõi Đơn Hàng</h3>
                        <form action="{{ route('frontend.order.tracking') }}" class="faq-form-tag" method="POST">
                            @csrf
                            <div class="input-group">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="search" class="form-control" id="orderCode" name="code"
                                    value="{{ session('code') }}" placeholder="Tìm đơn theo mã đơn hàng">
                                <button type="submit" class="btn theme-bg-color text-white btn-md fw-bold">Tìm
                                    đơn hàng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            @if (session('order'))
                <section class="order-detail">
                    <div class="container pb-5">
                        <div class="row g-sm-4 g-3">
                            <div class="text-center">
                                <div class="order-tracking-icon">
                                    <i data-feather="package" class="text-content"></i>
                                </div>
                                <div class="order-details-name">
                                    <h5 class="text-content mb-2">Mã Đơn Hàng</h5>
                                    <h3 class="theme-color fw-bold">{{ session('code') }}</h3>
                                </div>
                            </div>

                            <div class="col-12 overflow-hidden">
                                <ol class="progtrckr">
                                    @inject('template', 'App\Helpers\Template')
                                    @foreach (session('status') as $key => $item)
                                        <li
                                            class='progtrckr-{{ $template::getOrderStatusHandle(session('order'), $key, session('status')) }}'>
                                            <h5>{{ $item }}</h5>
                                        </li>
                                    @endforeach
                                </ol>

                            </div>
                        </div>
                    </div>
                </section>
            @elseif(session('error'))
                <section class="order-detail">
                    <div class="container pb-5">
                        <div class="text-center">
                            <h2 class="text-content">{{ session('error') }}</h2>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection
