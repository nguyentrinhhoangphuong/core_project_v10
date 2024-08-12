@php
    use App\Helpers\Template;
@endphp
<div class="pt-25">
    <div class="category-menu">
        <h3>Sản phẩm thịnh hành</h3>
        <ul class="product-list product-right-sidebar border-0 p-0">
            @foreach ($trendingProducts as $product)
                <li>
                    <div class="offer-product">
                        <a href="{{ route('frontend.home.productDetails', ['slug' => Template::slug($product->name) . '-' . $product->id]) }}"
                            class="offer-image">
                            @if (count($product->media) > $loop->index)
                                <img src="{{ $product->media[0]->getUrl() }}" class="img-fluid blur-up lazyload"
                                    alt="">
                            @endif
                        </a>

                        <div class="offer-detail">
                            <div>
                                <a
                                    href="{{ route('frontend.home.productDetails', ['slug' => Template::slug($product->name) . '-' . $product->id]) }}">
                                    <h6 class="name">{{ $product->name }}</h6>
                                </a>
                                <h6 class="price theme-color">{{ Template::numberFormatVND($product->price) }}</h6>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
