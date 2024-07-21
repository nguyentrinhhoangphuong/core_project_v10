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
            <div class="onhover-dropdown header-badge">
                <a href="{{ route('frontend.cart.index') }}" class="btn p-0 position-relative header-wishlist">
                    <i data-feather="shopping-cart"></i>
                    @inject('cartService', 'App\Services\Cart\CartService')
                    <span class="position-absolute top-0 start-100 translate-middle badge">
                        {{ $cartService->countProducts() }}
                    </span>
                </a>
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
