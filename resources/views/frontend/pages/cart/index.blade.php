@php
    use App\Helpers\Template;
@endphp
@inject('cartService', 'App\Services\Cart\CartService')
@extends('frontend.main')
@section('content')
    <section class="cart-section section-b-space">
        <div class="container">
            @if (session('coupon_expired'))
                <div class="alert alert-warning">
                    {{ session('coupon_expired') }}
                </div>
            @endif
            @if (!isset($cart) || $cart->products->isEmpty())
                <div class="text-center">
                    <p>Giỏ hàng của bạn đang trống</p>
                    <a href="{{ route('frontend.home.index') }}">Tiếp tục mua hàng</a>
                </div>
            @else
                <div class="row g-sm-5 g-3">
                    <div class="col-xxl-9">
                        <form action="{{ route('frontend.productcart.updateQuantity') }}" method="POST">
                            @csrf
                            <div class="cart-table">
                                <div class="table-responsive-xl">
                                    <table class="table">
                                        <tbody>
                                            @foreach ($cart->products as $item)
                                                <tr class="product-box-contain">
                                                    <td class="product-detail">
                                                        <div class="product border-0">
                                                            <a href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}"
                                                                class="product-image">
                                                                <img src="{{ $item->media[0]->getUrl() }}"
                                                                    class="img-fluid blur-up lazyload"
                                                                    alt="{{ $item->name }}">
                                                            </a>
                                                            <div class="product-detail">
                                                                <ul>
                                                                    <li class="name">
                                                                        <a
                                                                            href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item->name) . '-' . $item->id]) }}">{{ $item->name }}</a>
                                                                    </li>
                                                                    <li class="text-content" style="cursor: pointer">
                                                                        <button type="button"
                                                                            class="remove close_button btn btn-light btn-sm"
                                                                            data-product-id="{{ $item->pivot->product_id }}">Xóa</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="price">
                                                        <h5>{{ Template::numberFormatVND($item->flash_sale_price) }}</h5>
                                                        <del
                                                            class="text-content">{{ Template::numberFormatVND($item->original_price) }}</del>
                                                    </td>

                                                    <td class="quantity">
                                                        <div class="quantity-price">
                                                            <div class="cart_qty">
                                                                <div class="input-group">
                                                                    <button type="button" class="btn qty-left-minus"
                                                                        data-type="minus" data-field="">
                                                                        <i class="fa fa-minus ms-0"></i>
                                                                    </button>
                                                                    <input type="hidden"
                                                                        name="products[{{ $item->pivot->product_id }}][product_id]"
                                                                        value="{{ $item->pivot->product_id }}">
                                                                    <input class="form-control input-number qty-input"
                                                                        type="number"
                                                                        name="products[{{ $item->pivot->product_id }}][quantity]"
                                                                        value="{{ $item->pivot->quantity }}"
                                                                        min="1">
                                                                    <button type="button" class="btn qty-right-plus"
                                                                        data-type="plus" data-field="">
                                                                        <i class="fa fa-plus ms-0"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="subtotal">
                                                        <h4 class="table-title text-content">Tổng</h4>
                                                        <strong>{{ Template::numberFormatVND($item->total) }}</strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-solid-default btn-sm fw-bold ms-auto">
                                    Cập nhật giỏ hàng
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-xxl-3">
                        <div class="summery-box p-sticky">
                            <div class="summery-contain">
                                <div class="coupon-cart">
                                    <h6 class="text-content mb-2">Áp dụng phiếu giảm giá</h6>
                                    <form id="coupon-form">
                                        <div class="mb-3 coupon-box input-group">
                                            <input type="text" class="form-control" name="code"
                                                placeholder="Nhập mã giảm giá..." value="{!! $cart->coupon->code ?? null !!}">
                                            <input type="hidden" name="total" value="{{ $cart->total }}">
                                            <button type="submit" class="btn-apply">Apply</button>
                                        </div>
                                    </form>
                                    <div id="coupon-message"></div>
                                    @if ($cartService->checkCoupon())
                                        <a id="delete-coupon" href="#" data-coupon-id="{{ $cart->coupon_id }}">
                                            Xóa coupon
                                        </a>
                                    @else
                                        <a id="delete-coupon" style="display: none;" href="#"
                                            data-coupon-id="{{ $cart->coupon_id }}">Xóa coupon</a>
                                    @endif
                                    @if ($coupon)
                                        <div class="coupon-info">
                                            @foreach ($coupon as $item)
                                                <p class="coupon-code" data-code="{{ $item['code'] }}"
                                                    style="cursor: pointer">
                                                    Sử dụng mã giảm giá: {{ $item['code'] }}
                                                </p>
                                            @endforeach
                                        </div>
                                    @endif
                                    <ul class="summery-discount">
                                        <li>
                                            <h4>Tổng tiền gốc</h4>
                                            <h4 class="price" id="original-total">
                                                {{ Template::numberFormatVND($total) }}
                                            </h4>
                                        </li>

                                        <li>
                                            <h4>Giảm giá</h4>
                                            <h4 class="price" id="discount-amount">
                                                {{ Template::numberFormatVND($cart->discount_amount) }}</h4>
                                        </li>
                                    </ul>


                                </div>
                            </div>

                            <ul class="summery-total">
                                <li class="list-total border-top-0">
                                    <h4>Tổng tiền</h4>
                                    <h4 class="price theme-color" id="discounted-total">
                                        {{ Template::numberFormatVND($cart->total) }}</h4>
                                </li>
                            </ul>

                            <div class="button-group cart-button">
                                <ul>
                                    <li>
                                        <button onclick="location.href = '{{ route('frontend.order.create') }}'"
                                            class="btn btn-animation proceed-btn fw-bold">Tiến hành thanh toán</button>
                                    </li>

                                    <li>
                                        <button onclick="location.href = '{{ route('frontend.home.showProducts') }}';"
                                            class="btn btn-light shopping-button text-dark">
                                            <i class="fa-solid fa-arrow-left-long"></i>Xem sản phẩm khác</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <form id="delete-product-form" action="{{ route('frontend.productcart.destroy') }}" method="POST"
        style="display: none;">
        @csrf
        <input type="hidden" name="product_id" id="delete-product-id">
    </form>
@endsection
@section('scripts')
    <script>
        document.querySelectorAll('.remove.close_button').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const deleteForm = document.getElementById('delete-product-form');
                const deleteProductIdInput = document.getElementById('delete-product-id');
                deleteProductIdInput.value = productId;
                deleteForm.submit();
            });
        });

        $('.coupon-code').on('click', function() {
            var code = $(this).data('code');
            var currentCode = $('input[name="code"]').val();

            if (currentCode !== code) {
                if (currentCode !== "") {
                    // Nếu đã có coupon, xóa nó trước
                    deleteCoupon(function() {
                        applyCoupon(code);
                    });
                } else {
                    // Nếu chưa có coupon, áp dụng ngay
                    applyCoupon(code);
                }
            }
        });

        function applyCoupon(code) {
            $('input[name="code"]').val(code);
            $('#coupon-form').submit();
        }

        function deleteCoupon(callback) {
            $.ajax({
                url: '{{ route('frontend.home.deleteCoupon') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        updateCouponDisplay(response, false);
                        if (callback) callback();
                    }
                },
                error: function(xhr) {
                    $('#coupon-message').text('Có lỗi xảy ra khi xóa coupon').css('color', 'red');
                }
            });
        }

        $('#coupon-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('frontend.home.applyCoupon') }}',
                method: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    updateCouponDisplay(response, true);
                },
                error: function(xhr) {
                    $('#coupon-message').text(xhr.responseJSON.error).css('color', 'red');
                    $('#delete-coupon').hide();
                }
            });
        });

        $('#delete-coupon').on('click', function(e) {
            e.preventDefault();
            deleteCoupon();
        });

        function updateCouponDisplay(response, isCouponApplied) {
            $('#coupon-message').text(response.message).css('color', 'green');
            $('#original-total').text(response.original_total);
            $('#discount-amount').text(isCouponApplied ? response.discount_amount : '0đ');
            $('#discounted-total').text(response.discounted_total);
            $('#delete-coupon').toggle(isCouponApplied);
            $('.summery-discount').toggle(isCouponApplied);
            if (!isCouponApplied) {
                $('input[name="code"]').val('');
            }
        }
    </script>
@endsection
