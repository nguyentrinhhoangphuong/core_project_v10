@php
    use App\Helpers\Template;
@endphp
@extends('frontend.main')
@section('content')
    <section class="breadcrumb-section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>{{ $breadcrumb ?? '' }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('frontend.home.index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ $breadcrumb ?? '' }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cart-section section-b-space">
        <div class="container">
            <x-frontend.home.show-product-by-category :products="$products" />
        </div>
    </section>
@endsection
