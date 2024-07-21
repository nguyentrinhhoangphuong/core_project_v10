@php
    use App\Helpers\Template;
@endphp
@extends('frontend.main')
@section('content')
    <section class="cart-section section-b-space">
        <div class="container">
            @if (!isset($cart) || $cart->products->isEmpty())
                <div class="text-center">
                    <p>Giỏ hàng của bạn đang trống</p>
                    <a href="{{ route('frontend.home.filterProduct') }}">Tiếp tục mua hàng</a>
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
                                                            <a href="product-left-thumbnail.html" class="product-image">
                                                                <img src="{{ $item->media[0]->getUrl() }}"
                                                                    class="img-fluid blur-up lazyload"
                                                                    alt="{{ $item->name }}">
                                                            </a>
                                                            <div class="product-detail">
                                                                <ul>
                                                                    <li class="name">
                                                                        <a
                                                                            href="product-left-thumbnail.html">{{ $item->name }}</a>
                                                                    </li>
                                                                    <li class="text-content" style="cursor: pointer">
                                                                        <button type="button"
                                                                            class="remove close_button btn btn-light btn-sm"
                                                                            data-product-id="{{ $item->pivot->product_id }}">Xóa</button>
                                                                    </li>
                                                                    {{-- <li class="text-content" style="cursor: pointer">
                                                                        <form
                                                                            action="{{ route('frontend.productcart.destroy') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="product_id"
                                                                                value="{{ $item->pivot->product_id }}">
                                                                            <button type="submit"
                                                                                class="remove close_button btn btn-light btn-sm">Xóa</button>
                                                                        </form>
                                                                    </li> --}}

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="price">
                                                        <h5>{{ Template::numberFormatVND($item->price) }}</h5>
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
                                    <h6 class="text-content mb-2">Coupon Apply</h6>
                                    <div class="mb-3 coupon-box input-group">
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter Coupon Code Here...">
                                        <button class="btn-apply">Apply</button>
                                    </div>
                                </div>
                            </div>

                            <ul class="summery-total">
                                <li class="list-total border-top-0">
                                    <h4>Tổng tiền</h4>
                                    <h4 class="price theme-color">{{ Template::numberFormatVND($cart->total) }}</h4>
                                </li>
                            </ul>

                            <div class="button-group cart-button">
                                <ul>
                                    <li>
                                        <button onclick="location.href = '{{ route('frontend.order.create') }}'"
                                            class="btn btn-animation proceed-btn fw-bold">Tiến hành thanh toán</button>
                                    </li>

                                    <li>
                                        <button onclick="location.href = '{{ route('frontend.home.filterProduct') }}';"
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
    </script>
@endsection
