<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.elements.head')
</head>

<body class="container">

    <!-- Loader Start -->
    {{-- @include('frontend.components.home.loader-start') --}}
    <!-- Loader End -->

    <!-- Header Start -->
    @include('frontend.elements.header')
    <!-- Header End -->

    <!-- mobile fix menu start -->
    @include('frontend.components.home.mobile-menu')
    <!-- mobile fix menu end -->

    @yield('content')

    @if (!Request::is('register'))
        <!-- Footer Section Start -->
        @include('frontend.elements.footer')
        <!-- Footer Section End -->

        <!-- Quick View Modal Box Start -->
        @include('frontend.components.home.quick-view-modal')
        <!-- Quick View Modal Box End -->

        <!-- Location Modal Start -->
        {{-- @include('frontend.components.home.location-modal-start') --}}
        <!-- Location Modal End -->

        <!-- Cookie Bar Box Start -->
        {{-- @include('frontend.components.home.cookie-bar-box-start') --}}
        <!-- Cookie Bar Box End -->

        <!-- Deal Box Modal Start -->
        {{-- @include('frontend.components.home.deal-box-modal-start') --}}
        <!-- Deal Box Modal End -->
    @endif
    <!-- Tap to top and theme setting button start -->
    @include('frontend.components.home.tap-to-top')
    <!-- Tap to top and theme setting button end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    @include('frontend.elements.scripts')
</body>

</html>
