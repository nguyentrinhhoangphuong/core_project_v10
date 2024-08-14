@extends('frontend.main')
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container">
            <div class="row">
                <x-frontend.home.products.breadcrumb :categoryBreadcrumb="$categoryBreadcrumb" :product="$product" />
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <x-frontend.home.products.product-details :product="$product" :seriesProducts="$seriesProducts" :activeFlashSale="$activeFlashSale" />
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                    <div class="right-sidebar-box">
                        <x-frontend.home.products.trending-products :trendingProducts="$trendingProducts" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container">
            <x-frontend.home.products.related-product :relatedProducts="$relatedProducts" />
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection
