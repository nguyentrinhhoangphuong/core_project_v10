@php
    use App\Helpers\Template;
@endphp

<div class="col-xl-6 wow fadeInUp">
    <div class="product-left-box">
        <div class="row g-2">
            <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                <div class="product-main-2 no-arrow">
                    @foreach ($product->media as $media)
                        <div>
                            <div class="slider-image">
                                <img src="{{ $media->getUrl() }}" id="img-{{ $loop->index + 1 }}"
                                    data-zoom-image="{{ $media->getUrl() }}"
                                    class="img-fluid image_zoom_cls-{{ $loop->index }} blur-up lazyload" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                <div class="left-slider-image-2 left-slider no-arrow slick-top">
                    @foreach ($product->media as $media)
                        <div>
                            <div class="sidebar-image">
                                <img src="{{ $media->getUrl() }}" class="img-fluid blur-up lazyload" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
    <div class="right-box-contain">
        <h2 class="name">{{ $product->name }}</h2>
        <div class="price-rating">
            <h3 class="theme-color price">{{ Template::numberFormatVND($product->price) }}
                <del class="text-content">{{ Template::numberFormatVND($product->original_price) }}</del>
            </h3>
        </div>
        <div class="product-title">
            <h4>Mô tả</h4>
        </div>
        <div class="pickup-detail">
            <h4 class="text-content">{{ $product->description }}</h4>
        </div>
        <form action=""></form>
        <div class="note-box product-package">
            <form action="{{ route('frontend.productcart.store') }}" method="POST" class="w-100">
                @csrf
                <input type="hidden" name="productid" value="{{ $product->id }}">
                <button type="submit" class="btn btn-md bg-dark cart-button text-white w-100" id="buyNowButton">
                    Mua Ngay
                </button>
            </form>
        </div>

        <div class="pickup-box" style="border-bottom: 0px ">
            <div class="product-info">
                <ul class="product-info-list product-info-list-2">
                    <li>Thương hiệu: <a
                            href="{{ route('frontend.home.filterProduct', ['brand[]' => $product->brandProduct->id]) }}">{{ ucwords($product->brandProduct->name) }}</a>
                    </li>
                    <li>Dòng máy: <a
                            href="{{ route('frontend.home.showProductbyCategory', ['slug' => Template::slug($product->categoryProduct->name) . '-' . $product->categoryProduct->id]) }}">{{ ucwords($product->categoryProduct->name) }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="product-section-box">
        <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                    type="button" role="tab">Cấu hình
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                    type="button" role="tab">Thông tin sản phẩm
                </button>
            </li>
        </ul>

        <div class="tab-content custom-tab" id="myTabContent">
            <div class="tab-pane fade show active" id="info" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            @foreach ($product->productAttributes as $attribute)
                                @if ($attribute->attribute && $attribute->attributeValue)
                                    <tr>
                                        <td>{{ $attribute->attribute->name }}</td>
                                        <td>{{ $attribute->attributeValue->value }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="description" role="tabpanel">
                <div class="product-description">
                    <div class="nav-desh">
                        <p class="card-text">
                            <span class="more-text">
                                {!! $product->content !!}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buyNowButton = document.getElementById('buyNowButton');

        function resetButton() {
            buyNowButton.disabled = false;
            buyNowButton.innerText = 'Mua Ngay';
        }
        // Reset nút khi trang được hiển thị lại từ cache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                resetButton();
            }
        });
        buyNowButton.addEventListener('click', function(event) {
            setTimeout(function() {
                buyNowButton.disabled = true;
                buyNowButton.innerText = 'Đang xử lý...';
            }, 50);
        });
    });
</script>
