@php
    use App\Helpers\Template;
@endphp
<div class="text-center mb-3">
    <h2>Sản phẩm liên quan</h2>
</div>
<div class="row">
    <div class="col-12">
        <div class="slider-6_1 product-wrapper">
            @foreach ($relatedProducts as $product)
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
                                    <span class="theme-color">{{ Template::numberFormatVND($product->price) }}</span>
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
