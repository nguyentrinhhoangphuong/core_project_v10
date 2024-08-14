@inject('cartService', 'App\Services\Cart\CartService')
@php
    use App\Helpers\Template;
    $cart = $cartService->getFromCookie();
@endphp

<div class="rightside-box">
    <div class="search-full">
        <div class="input-group">
            <span class="input-group-text">
                <i data-feather="search" class="font-light"></i>
            </span>
            <input type="text" class="form-control search-type" placeholder="Search here..">
            <span class="input-group-text close-search">
                <i data-feather="x" class="font-light"></i>
            </span>
        </div>
    </div>
    <ul class="right-side-menu">
        {{-- ========================== WISH LIST ================================= --}}
        <li class="right-side">
            <div class="delivery-login-box">
                <div class="delivery-icon">
                    <div class="search-box">
                        <i data-feather="search"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="right-side">
            <a href="{{ route('frontend.home.wishList') }}" class="btn p-0 position-relative header-wishlist">
                <i data-feather="heart"></i>
                @inject('wishListService', 'App\Services\WishList\WishListService')
                <span class="position-absolute top-0 start-100 translate-middle badge wishlist-count">
                    {{ $wishListService->countProducts() }}
                </span>
            </a>
        </li>
        {{-- ==================== CART ======================== --}}
        <li class="right-side">
            <div class="onhover-dropdown header-badge">
                <a href="{{ route('frontend.cart.index') }}" class="btn p-0 position-relative header-wishlist">
                    <i data-feather="shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge cart-count">
                        {{ $cartService->countProducts() }}
                    </span>
                </a>
                <!-- Notification Popup -->
                <div id="cartNotification" class="notification-popup"
                    style="display: none; position: fixed; bottom: 10px; right: 10px; background-color: #333; color: #fff; padding: 10px; border-radius: 5px; z-index: 1000;">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <img src="" id="notificationImage" class="img-fluid"
                                style="width: 60px; height: 60px; object-fit: cover;" alt="">
                        </div>
                        <div>
                            <h6 class="mb-0">Thêm vào giỏ hàng:</h6>
                            <span id="notificationProductName"></span>
                        </div>
                    </div>
                </div>

                <div id="wishListNotification" class="notification-popup"
                    style="display: none; position: fixed; bottom: 10px; right: 10px; background-color: #333; color: #fff; padding: 10px; border-radius: 5px; z-index: 1000;">
                    <div class="d-flex align-items-center">
                        <div>
                            <span id="message"></span>
                        </div>
                    </div>
                </div>

                <div class="onhover-div">
                    @if ($cartService->countProducts())
                        <ul class="cart-list">
                            @if ($cart && $cart->products->count())
                                @foreach ($cart->products as $item)
                                    <li class="product-box-contain">
                                        <div class="drop-cart">
                                            <a href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}"
                                                class="drop-image">
                                                <img src="{{ $item->media[0]->getUrl() }}" class="blur-up lazyload"
                                                    alt="">
                                            </a>

                                            <div class="drop-contain">
                                                <a
                                                    href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}">
                                                    <h5>{{ $item->name }}</h5>
                                                </a>
                                                <h6>
                                                    <span>{{ $item->pivot->quantity }}x
                                                    </span>{{ Template::numberFormatVND($item->flash_sale_price) }}
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                        <div class="price-box">
                            <h5>Tổng cộng:</h5>
                            <h4 class="theme-color fw-bold">
                                {{ Template::numberFormatVND($cart->total) }}
                            </h4>
                        </div>

                        <div class="button-group">
                            <a href="{{ route('frontend.cart.index') }}" class="btn btn-sm cart-button w-100">
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
        </li>
        {{-- <li class="right-side onhover-dropdown">
            <div class="delivery-login-box">
                <div class="delivery-icon">
                    <i data-feather="user"></i>
                </div>
                <div class="delivery-detail">
                    <h6>Hello,</h6>
                    <h5>My Account</h5>
                </div>
            </div>

            <div class="onhover-div onhover-div-login">
                <ul class="user-box-name">
                    <li class="product-box-contain">
                        <i></i>
                        <a href="{{ route('frontend.home.login') }}">Đăng nhập</a>
                    </li>

                    <li class="product-box-contain">
                        <a href="{{ route('frontend.home.register') }}">Đăng ký</a>
                    </li>

                    <li class="product-box-contain">
                        <a href="forgot.html">Quên mật khẩu</a>
                    </li>
                </ul>
            </div>
        </li> --}}
    </ul>
</div>
