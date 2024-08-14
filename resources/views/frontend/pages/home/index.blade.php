@extends('frontend.main')
@section('content')
    <!-- Home Section Start -->
    <x-frontend.slider.carousel />
    <!-- Home Section End -->

    <x-frontend.home.flash-sales />

    {{-- Top Product --}}
    <x-frontend.home.top-products />
    {{-- End Top Product --}}

    {{-- Featured Product --}}
    <x-frontend.home.featured-products />
    {{-- End Featured Product --}}

    {{-- Product Grouped By Brand --}}
    {{-- <x-frontend.home.products-grouped-by-brand /> --}}
    {{-- End Product Grouped By Brand --}}
@endsection
