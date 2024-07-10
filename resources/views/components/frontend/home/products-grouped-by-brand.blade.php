<div class="container">
    @foreach ($productsByBrand as $brandName => $products)
        <section class="product-section">
            <div class="container">
                <div class="row align-items-center justify-content-between mb-3">
                    <div class="col-auto">
                        <h3><strong>{{ ucfirst($brandName) }}</strong></h3>
                    </div>
                    <div class="col-auto">
                        <a class="dropdown-item" id="high"
                            href="{{ route('frontend.home.filterProduct', ['brand[]' => $products['brand_id']]) }}">
                            Xem tất cả
                        </a>
                    </div>
                </div>
                <div
                    class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                    @foreach ($products['products'] as $product)
                        <div class="col">
                            <div class="product-box-3 h-100 wow fadeInUp">
                                <div class="product-header">
                                    <div class="product-image">
                                        <a href="product-left-thumbnail.html">
                                            <img src="{{ $product['image'] }}" class="img-fluid blur-up lazyload"
                                                alt="{{ $product['name'] }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="product-detail">
                                        <a href="product-left-thumbnail.html">
                                            <h5 class="name text-center">{{ $product['name'] }}</h5>
                                        </a>
                                        <table style="width: 100%">
                                            <tbody>
                                                @foreach ($product['processed_attributes'] as $attribute)
                                                    <tr>
                                                        <td>{{ $attribute['attribute_name'] }}</td>
                                                        <td>{{ implode(', ', $attribute['attribute_values']) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <h2 class="price">
                                                <span
                                                    style="background-color: #0da487; color: #fff; padding: 5px 2rem; border-radius: 5px;">
                                                    {{ \App\Helpers\Template::numberFormatVND($product['price']) }}
                                                </span>
                                                <del>{{ \App\Helpers\Template::numberFormatVND($product['original_price']) }}</del>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
</div>
