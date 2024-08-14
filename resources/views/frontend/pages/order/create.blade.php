@php
    use App\Helpers\Template;
@endphp
@extends('frontend.main')
@section('content')
    <section class="cart-section section-b-space">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <h3 class="mb-4 text-center">Thông tin khách mua hàng</h3>
                    <form action="{{ route('frontend.order.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                    checked>
                                <label class="form-check-label" for="male">Anh</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                <label class="form-check-label" for="female">Chị</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="tel" class="form-control" name="phone" placeholder="Nhập số điện thoại"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="email" class="form-control" name="email" placeholder="Nhập email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" name="address" placeholder="Địa chỉ giao hàng">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="homeDelivery" checked>
                                <label class="form-check-label" for="homeDelivery">Giao hàng tận nơi</label>
                                <p><small>(Thanh toán khi giao hàng)</small></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control" rows="3" name="options" placeholder="Lưu ý yêu cầu khác (Không bắt buộc)"></textarea>
                        </div>
                        <input type="hidden" name="total_amount" value="{{ $cart->total }}">
                        <input type="hidden" name="coupon_id" value="{{ $cart->coupon_id ?? null }}">
                        <button type="submit" class="btn w-100" style="color: white; background-color: brown">
                            ĐẶT HÀNG NGAY
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="cart-table">
                        <div class="table-responsive-xl">
                            <div class="text-center pb-4">
                                <h4>Tổng tiền</h4>
                                <h3 class="price theme-color">
                                    <strong>{{ Template::numberFormatVND($cart->total) }}</strong>
                                </h3>
                            </div>
                            <table class="table">
                                <tbody>
                                    @foreach ($cart->products as $item)
                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="row">
                                                    <div class="col">
                                                        <p class="product-image">
                                                            <img src="{{ $item->media[0]->getUrl() }}"
                                                                class="img-fluid blur-up lazyload"
                                                                alt="{{ $item->name }}">
                                                        </p>
                                                    </div>
                                                    <div class="col">
                                                        <p> {{ $item->name }} </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h4 class="table-title text-content">Số lượng</h4>
                                                    </div>
                                                    <div class="col">
                                                        <strong>{{ $item->pivot->quantity }}</strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h4 class="table-title text-content">Giá</h4>
                                                    </div>
                                                    <div class="col">
                                                        <strong>{{ Template::numberFormatVND($item->flash_sale_price) }}</strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h4 class="table-title text-content">Tổng</h4>
                                                    </div>
                                                    <div class="col">
                                                        <strong> {{ Template::numberFormatVND($item->total) }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
