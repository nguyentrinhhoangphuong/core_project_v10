@inject('cartService', 'App\Services\Cart\CartService')
@inject('wishListService', 'App\Services\WishList\WishListService')
@php
    use App\Helpers\Template;
    $cart = $cartService->getFromCookie();
@endphp
<style>
    header.active .sticky-header {
        transition: all 0.3s ease;
    }

    .scroll-visible {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        display: flex;
        align-items: center;
        z-index: 1001;
    }

    .scroll-visible span {
        margin-right: 10px;
    }

    .scroll-visible span p {
        width: 18px;
        height: 18px;
    }

    header.active .scroll-visible {
        opacity: 1;
        visibility: visible;
    }

    .header-wishlist {
        position: relative;
    }

    .header-wishlist .badge {
        display: flex;
        justify-content: center;
        font-size: 0.75em;
        padding: 0.25em 0.4em;
        position: absolute;
        top: -8px;
        min-width: 1em;
        min-height: 1em;
        border-radius: 2px;
        z-index: 1002;
    }

    .vertical-line {
        height: 20px;
        width: 1px;
        background-color: #ccc;
        margin: 0 10px;
    }

    .scroll-visible>span {
        display: flex;
        align-items: center;
    }
</style>
<header>

    <div class="top-nav top-header ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <x-frontend.header.logo />
                        <x-frontend.header.middle-box />
                        <x-frontend.header.rightside-box />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sticky-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-nav">
                        <x-frontend.header.categories-products />
                        <div class="header-nav-middle">
                            <div class="main-nav navbar navbar-expand-xl navbar-light">
                                <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                    <div class="offcanvas-header navbar-shadow">
                                        <h5>Menu</h5>
                                        <button class="btn-close lead" type="button"
                                            data-bs-dismiss="offcanvas"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav">
                                            <x-frontend.header.header-nav-middle />
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="scroll-visible">
                            <span>
                                <a href="{{ route('frontend.home.wishList') }}"
                                    class="btn p-0 position-relative header-wishlist">
                                    <i data-feather="heart"></i>
                                    <p class="position-absolute top-0 start-100 translate-middle badge wishlist-count"
                                        style="background-color: #ff7272">
                                        {{ $wishListService->countProducts() }}
                                    </p>
                                </a>
                            </span>
                            <span class="vertical-line"></span>
                            <span>
                                <div class="onhover-dropdown header-badge">
                                    <a href="{{ route('frontend.cart.index') }}"
                                        class="btn p-0 position-relative header-wishlist">
                                        <i data-feather="shopping-cart"></i>
                                        <p class="position-absolute top-0 start-100 translate-middle badge cart-count"
                                            style="background-color: #ff7272">
                                            {{ $cartService->countProducts() }}
                                        </p>
                                    </a>
                                    <div class="onhover-div">
                                        @if ($cartService->countProducts())
                                            <ul class="cart-list">
                                                @if ($cart && $cart->products->count())
                                                    @foreach ($cart->products as $item)
                                                        <li class="product-box-contain">
                                                            <div class="drop-cart">
                                                                <a href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}"
                                                                    class="drop-image">
                                                                    <img src="{{ $item->media[0]->getUrl() }}"
                                                                        class="blur-up lazyload" alt="">
                                                                </a>

                                                                <div class="drop-contain">
                                                                    <a
                                                                        href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}">
                                                                        <h5>{{ $item->name }}</h5>
                                                                    </a>
                                                                    <h6>
                                                                        <span>{{ $item->pivot->quantity }}x
                                                                        </span>{{ Template::numberFormatVND($item->price) }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif

                                            </ul>
                                            <div class="price-box">
                                                <h5>Tổng cộng :</h5>
                                                <h4 class="theme-color fw-bold">
                                                    {{ Template::numberFormatVND($cart->total) }}
                                                </h4>
                                            </div>

                                            <div class="button-group">
                                                <a href="{{ route('frontend.cart.index') }}"
                                                    class="btn btn-sm cart-button w-100">
                                                    Xem giỏ hàng
                                                </a>
                                            </div>
                                        @else
                                            <div class="button-group">
                                                <a href="#" class="btn btn-sm cart-button w-100">
                                                    Giỏ hàng trống
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('header');
        const stickyHeader = document.querySelector('.sticky-header');
        const headerHeight = stickyHeader.offsetHeight;

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > headerHeight) {
                header.classList.add('active');
                stickyHeader.style.zIndex = '1000'; // Đảm bảo header ở trên
            } else {
                header.classList.remove('active');
                stickyHeader.style.zIndex = ''; // Reset lại z-index khi không cần sticky
            }
        });
    });
</script>
