@php
    use App\Helpers\Template;
@endphp
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.dashboard.index') }}"
                        href="{{ route('admin.dashboard.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M13.45 11.55l2.05 -2.05" />
                                <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.sliders.index') }}"
                        href="{{ route('admin.sliders.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Sliders
                        </span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.categories.index') }}"
                        href="{{ route('admin.categories.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Categories
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.articles.index') }}"
                        href="{{ route('admin.articles.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Articles
                        </span>
                    </a>
                </li> --}}
                <li class="nav-item dropdown">
                    @php
                        $productRoutes = [
                            'admin.products.index',
                            'admin.category-products.index',
                            'admin.attributes.index',
                            'admin.brand.index',
                            'admin.coupon.index',
                            'admin.flash-sales.index',
                        ];
                    @endphp
                    <a class="nav-link dropdown-toggle {{ in_array(Route::currentRouteName(), $productRoutes) ? 'active' : '' }}"
                        href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                        aria-expanded="{{ in_array(Route::currentRouteName(), $productRoutes) ? 'true' : 'false' }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Products
                        </span>
                    </a>
                    <div class="dropdown-menu {{ request()->is('admin/products*', 'admin/category-products*', 'admin/attributes*', 'admin/brand*', 'admin/coupon*', 'admin/flash-sales*') ? 'show' : '' }}"
                        data-bs-popper="static">
                        <div
                            class="dropdown-menu-columns {{ request()->is('admin/products*', 'admin/category-products*', 'admin/attributes*', 'admin/brand*', 'admin/coupon*', 'admin/flash-sales*') ? 'show' : '' }}">
                            <a class="dropdown-item {{ Route::currentRouteName() == 'admin.products.index' ? 'active text-white' : '' }}"
                                href="{{ route('admin.products.index') }}">
                                All Products
                            </a>
                            <a class="dropdown-item {{ Route::currentRouteName() == 'admin.category-products.index' ? 'active text-white' : '' }}"
                                href="{{ route('admin.category-products.index') }}">
                                Category Products
                            </a>
                            <a class="dropdown-item {{ Route::currentRouteName() == 'admin.attributes.index' ? 'active text-white' : '' }}"
                                href="{{ route('admin.attributes.index') }}">
                                Attributes
                            </a>
                            <a class="dropdown-item {{ Route::currentRouteName() == 'admin.brand.index' ? 'active text-white' : '' }}"
                                href="{{ route('admin.brand.index') }}">
                                Brand
                            </a>
                            <a class="dropdown-item {{ Route::currentRouteName() == 'admin.coupon.index' ? 'active text-white' : '' }}"
                                href="{{ route('admin.coupon.index') }}">
                                Coupon
                            </a>
                            <a class="dropdown-item {{ request()->is('admin/flash-sales*') ? 'active text-white' : '' }}"
                                href="{{ route('admin.flash-sales.index') }}">
                                Flash sales
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.menus.index') }}"
                        href="{{ route('admin.menus.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Menus
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.order.index') }}"
                        href="{{ route('admin.order.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Orders
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.settings.index') }}"
                        href="{{ route('admin.settings.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Settings
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Template::isActive('admin.fileManager.index') }}"
                        href="{{ route('admin.fileManager.index') }}">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/mail-opened -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Files Manager
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout') }}">
                        <span class="nav-link-title">
                            Logout
                        </span>
                    </a>
                </li>
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button" aria-expanded="false">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-folder">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Help
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="https://tabler.io/docs" target="_blank" rel="noopener">
                            Documentation
                        </a>
                        <a class="dropdown-item" href="./changelog.html">
                            Changelog
                        </a>

                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
</aside>
