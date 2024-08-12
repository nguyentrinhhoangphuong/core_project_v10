@extends('frontend.main')
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>{{ $breadcrumb }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('frontend.home.index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container">
            <div class="row">

                {{-- FILTER --}}
                <div class="col-custom-3">
                    <div class="left-box wow fadeInUp">
                        <x-frontend.home.filters :request="$request" :filterAttributes="$filterAttributes" :brands="$brands ?? []" :filterSummary="$filterSummary"
                            :slug="$slug" />
                    </div>
                </div>

                @if (count($filterAttributes) || count($brands))
                    <div class="col-custom-">
                        {{-- SORT BY --}}
                        <div class="show-button">
                            {{-- SORT BY MOBILE --}}
                            <div class="filter-button-group mt-0">
                                <div class="filter-button d-inline-block d-lg-none">
                                    <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                                </div>
                            </div>
                            <div class="top-filter-menu">
                                <div class="category-dropdown">
                                    <h5 class="text-content">Sắp xếp theo :</h5>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown">
                                            @php
                                                $currentSort = request()->input('sort', 'default');
                                                $sortText = [
                                                    'default' => 'Mặc định',
                                                    'price-asc' => 'Giá tăng dần',
                                                    'price-desc' => 'Giá giảm dần',
                                                    'featured' => 'Nổi bật',
                                                    'top' => 'top',
                                                ];
                                            @endphp
                                            <span>{{ $sortText[$currentSort] }}</span> <i
                                                class="fa-solid fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" id="pop"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}">Nổi
                                                    bật</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="high"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'top']) }}">Top</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="low"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'price-desc']) }}">Giá
                                                    giảm
                                                    dần</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="high"
                                                    href="{{ request()->fullUrlWithQuery(['sort' => 'price-asc']) }}">Giá
                                                    tăng
                                                    dần</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PRODUCTS --}}
                        <x-frontend.home.show-product-by-category :products="$products" />

                        {{-- PAGINATION --}}
                        {{ $products->appends(request()->query())->links('pagination.pagination_frontend') }}

                    </div>
                @else
                @endif
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

    </body>

    </html>
@endsection
