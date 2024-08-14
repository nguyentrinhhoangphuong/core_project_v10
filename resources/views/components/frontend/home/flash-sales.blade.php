@php
    use App\Helpers\Template;
@endphp

@if ($activeFlashSale)
    <div class="row align-items-center justify-content-between mt-4">
        <div class="col-auto">
            <h3><strong>Flash Sales</strong></h3>
        </div>
        <div class="col-auto">
            <div class="alert alert-warning text-center">
                Kết thúc sau: <span id="countdown" class="fw-bold"></span>
            </div>
        </div>
        <div class="col-auto">
            <a class="dropdown-item" id="high" href="{{ route('frontend.home.flashsales') }}">
                Xem tất cả
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="slider-6_1 product-wrapper">
                @foreach ($flashSaleProducts as $product)
                    <div>
                        <div class="product-box-3 wow fadeInUp">
                            <div class="product-header">
                                <div class="product-image">
                                    <a
                                        href="{{ route('frontend.home.productDetails', ['slug' => Template::slug($product->name) . '-' . $product->id]) }}">
                                        <img src="{{ $product->media[0]->getUrl() }}" class="img-fluid blur-up lazyload"
                                            alt="{{ $product->name }}">
                                    </a>

                                </div>
                            </div>
                            <div class="product-footer">
                                <div class="product-detail">
                                    <a
                                        href="{{ route('frontend.home.productDetails', ['slug' => Template::slug($product->name) . '-' . $product->id]) }}">
                                        <h5 class="name">{{ $product->name }}</h5>
                                    </a>
                                    <h5 class="price">
                                        <span
                                            style="color: brown">{{ Template::numberFormatVND($product->flash_sale_price) }}</span>
                                        <del>{{ Template::numberFormatVND($product->original_price) }}</del>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@section('scripts')
    <script>
        var endTime = "{{ $activeFlashSale->end_time }}";
    </script>
    <script src="{{ asset('_frontend/js/countDownDate.js') }}"></script>
@endsection
