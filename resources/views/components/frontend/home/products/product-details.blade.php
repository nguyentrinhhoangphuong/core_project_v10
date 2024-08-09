@php
    use App\Helpers\Template;
@endphp
<style>
    .product-variants {
        margin-bottom: 20px;
    }

    .variant-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        background-color: #fff;
    }

    .variant-card.active {
        border-color: #28a745;
        background-color: #e8f5e9;
    }

    .variant-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .variant-name {
        font-size: 0.9rem;
        font-weight: bold;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .variant-price {
        font-size: 0.85rem;
        color: #666;
    }

    .variant-card:hover {
        border-color: #28a745;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 767px) {
        .row-cols-md-3>* {
            flex: 0 0 auto;
            width: 50%;
        }
    }

    @media (max-width: 575px) {
        .row-cols-md-3>* {
            width: 100%;
        }
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        @if ($product->description != null)
            <div class="product-title">
                <h4>Mô tả</h4>
            </div>
            <div class="pickup-detail">
                <h4 class="text-content">{{ $product->description }}</h4>
            </div>
        @endif

        <div class="note-box product-package">
            <form id="addToCartForm" action="{{ route('frontend.productcart.store') }}" method="POST" class="w-100">
                @csrf
                <input type="hidden" name="productid" value="{{ $product->id }}">
                <div class="product-variants mt-4">
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        @if (count($seriesProducts) > 1)
                            @foreach ($seriesProducts as $index => $item)
                                @php
                                    $variantName =
                                        $item['attributeString'] != ''
                                            ? $item['attributeString']
                                            : ucfirst($item['series']);
                                @endphp
                                <div class="variant-card {{ $item['productId'] === $product->id ? 'active' : '' }}">
                                    <a href="{{ route('frontend.home.productDetails', ['slug' => Str::slug($item['productName']) . '-' . $item['productId']]) }}"
                                        class="variant-link">
                                        <div class="variant-name">{{ $variantName }}</div>
                                        <div class="variant-price">{{ Template::numberFormatVND($item['price']) }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
                <button type="submit" class="btn btn-md bg-dark cart-button text-white w-100">
                    Mua Ngay
                </button>
                <div class="buy-box">
                    <a href="#" class="add-to-wishlist" data-product-id="{{ $product->id }}">
                        <input type="hidden" name="productid" value="{{ $product->id }}">
                        @inject('wishListService', 'App\Services\WishList\WishListService')
                        @php
                            $isAddToWithList = $wishListService->isAddToWithList($product->id);
                        @endphp
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="{{ $isAddToWithList == true ? 'full' : 'none' }}" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-heart">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg>
                        <span
                            id="text-heart">{{ $isAddToWithList == true ? 'Đã thêm vào danh sách yêu thích' : 'Thêm vào danh sách yêu thích' }}</span>
                    </a>
                </div>

            </form>
        </div>

        <div class="pickup-box" style="border-bottom: 0px ">
            <div class="product-info">
                <ul class="product-info-list product-info-list-2">
                    <li>Thương hiệu: <a
                            href="{{ route('frontend.home.showProducts', ['brand[]' => $product->brandProduct->id]) }}">{{ ucwords($product->brandProduct->name) }}</a>
                    </li>
                    <li>Dòng: <a
                            href="{{ route('frontend.home.showProducts', ['slug' => Template::slug($product->categoryProduct->name) . '-' . $product->categoryProduct->id]) }}">{{ ucwords($product->categoryProduct->name) }}</a>
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
                    @php
                        $groupedAttributes = $product->productAttributes->groupBy('attribute_id');
                    @endphp

                    <table class="table table-striped">
                        <tbody>
                            @foreach ($groupedAttributes as $attributeId => $attributes)
                                @php
                                    $attribute = $attributes->first();
                                    if (!$attribute || !$attribute->attribute) {
                                        continue;
                                    }
                                    $attributeName = $attribute->attribute->name;
                                    $values = $attributes
                                        ->map(function ($attr) {
                                            return $attr->attributeValue ? $attr->attributeValue->value : null;
                                        })
                                        ->filter()
                                        ->unique()
                                        ->implode(', ');
                                @endphp
                                @if ($attributeName && $values)
                                    <tr>
                                        <td>{{ $attributeName }}</td>
                                        <td>{{ $values }}</td>
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
    $('.add-to-wishlist').on('click', function(event) {
        event.preventDefault();
        var productId = $(this).data('product-id');
        var $svg = $(this).find('svg');
        var textHeart = $('#text-heart');
        var isInWishlist = $svg.attr('fill') === 'full';
        var url, method;
        if (isInWishlist) {
            url = '{{ route('frontend.home.removeFromWishList', ':productId') }}'.replace(':productId',
                productId);
            method = 'DELETE';
        } else {
            url = '{{ route('frontend.home.addToWishList') }}';
            method = 'POST';
        }
        $.ajax({
            url: url,
            method: method,
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(res) {
                if (res.success) {
                    showNotificationForWishList(res.message)
                    $('.wishlist-count').text(res.wishlistCount);
                    if (isInWishlist) {
                        // Xóa khỏi danh sách yêu thích
                        $svg.attr('fill', 'none');
                        textHeart.text('Thêm vào danh sách yêu thích');
                    } else {
                        // Thêm vào danh sách yêu thích
                        $svg.attr('fill', 'full');
                        textHeart.text('Đã thêm vào danh sách yêu thích');
                    }
                } else {
                    alert('Có lỗi xảy ra.');
                }
            }
        });
    });

    $('#addToCartForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.success) {
                    $('body').find('.cart-count').text(res.countProducts == 0 ? res.countProducts +
                        1 : res
                        .countProducts);
                    var lastProduct = res.cartData.products[res.cartData.products.length - 1];
                    updateCartHover(res.cartData);
                    showNotification(lastProduct.name, lastProduct.image);
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            }
        });
    });

    function showNotification(productName, productImageUrl) {
        $('#notificationProductName').text(productName);
        $('#notificationImage').attr('src', productImageUrl);
        $('#cartNotification').fadeIn().delay(3000).fadeOut(); // Show for 3 seconds
    }

    function showNotificationForWishList(message) {
        $('#message').text(message);
        $('#wishListNotification').fadeIn().delay(3000).fadeOut(); // Show for 3 seconds
    }

    function updateCartHover(cartData) {
        if (cartData.products.length > 0) {
            var cartHtml = '<ul class="cart-list">';
            cartData.products.forEach(function(item) {
                var productSlug = item.name.toLowerCase().replace(/ /g, '-') + '-' + item.id;
                var productDetailUrl = '/products/' + productSlug;

                cartHtml += `
                <li class="product-box-contain">
                    <div class="drop-cart">
                        <a href="${productDetailUrl}" class="drop-image">
                            <img src="${item.image}" class="blur-up lazyload" alt="">
                        </a>
                        <div class="drop-contain">
                            <a href="${productDetailUrl}">
                                <h5>${item.name}</h5>
                            </a>
                            <h6>
                                <span>${item.quantity}x </span>${item.price_formatted}
                            </h6>
                        </div>
                    </div>
                </li>
            `;
            });
            cartHtml += '</ul>';
            cartHtml += `
            <div class="price-box">
                <h5>Tổng cộng :</h5>
                <h4 class="theme-color fw-bold">${cartData.total_formatted}</h4>
            </div>
            <div class="button-group">
                <a href="${cartData.cart_url}" class="btn btn-sm cart-button w-100">
                    Xem giỏ hàng
                </a>
            </div>
        `;
            $('.onhover-div').html(cartHtml);

        } else {
            $('.onhover-div').html(`
            <div class="button-group">
                <a href="#" class="btn btn-sm cart-button w-100">
                    Giỏ hàng trống
                </a>
            </div>
        `);
        }
    }
</script>
