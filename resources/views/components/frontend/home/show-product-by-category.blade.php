@php
    use App\Helpers\Template;
    // Lấy tên route hiện tại
    $currentRoute = Route::currentRouteName();
    $isWishlistRoute = $currentRoute === 'frontend.home.wishList'; // Kiểm tra nếu route hiện tại là 'wishlist'
    $xhtml = '';
    if (count($productsComponent) > 0) {
        foreach ($productsComponent as $product) {
            $id = $product->id;
            $name = $product->name;
            $price = Template::numberFormatVND($product->price);
            $original_price = Template::numberFormatVND($product->original_price);
            $url = route('frontend.home.productDetails', ['slug' => Str::slug($name) . '-' . $id]);
            $sortedMedia = $product->media->sortBy('order_column');
            $media = $sortedMedia->isNotEmpty() ? $sortedMedia->first() : null;
            $mediaUrl = '';

            if ($media) {
                // Kiểm tra xem có phiên bản WebP không, nếu không thì dùng ảnh gốc
                $mediaUrl = $media->hasGeneratedConversion('webp') ? $media->getUrl('webp') : $media->getUrl();
            }
            $attributes = '';
            // Processed attributes handling
            if (isset($product->processed_attributes) && is_array($product->processed_attributes)) {
                foreach ($product->processed_attributes as $attribute) {
                    $attribute_name = $attribute['attribute_name'];
                    $attribute_values = implode(', ', $attribute['attribute_values']);
                    $attributes .= '<tr><td>' . $attribute_name . '</td><td>' . $attribute_values . '</td></tr>';
                }
            }

            // Build the product HTML
            $xhtml .=
                '
            <div class="col">
                <div class="product-box-3 h-100 wow fadeInUp">
                    <div class="product-header">
                        <div class="product-image">
                            <a href="' .
                $url .
                '">
                                <img src="' .
                $mediaUrl .
                '" class="img-fluid blur-up lazyload" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="product-footer">
                        <div class="product-detail">
                            <a href="' .
                $url .
                '">
                                <h5 class="name text-center">' .
                $name .
                '</h5>
                            </a>
                            <table style="width: 100%">
                                <tbody>' .
                $attributes .
                '</tbody>
                            </table>
                            <div class="text-center">
                                <h2 class="price">
                                    <span style="background-color: #0da487; color: rgb(255, 255, 255);padding: 5px 2rem;border-radius: 5px;">
                                        ' .
                $price .
                '
                                    </span>
                                    <del>' .
                $original_price .
                '</del>
                                </h2>' .
                ($isWishlistRoute
                    ? '
                                <a class="remove-from-wishlist" style="cursor: pointer;" data-id="' .
                        $id .
                        '">xóa</a>'
                    : '') .
                '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        $xhtml .= '<h3 class="container">Chưa có sản phẩm</h3>';
    }
@endphp


<div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
    {!! $xhtml !!}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.remove-from-wishlist').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            var $button = $(this);

            $.ajax({
                url: '{{ route('frontend.home.removeFromWishList', ':productId') }}'.replace(
                    ':productId', productId),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    $('#wishlist-count').text(res.wishlistCount);
                    $button.closest('.product-box-3').remove();
                    if (res.wishlistCount == 0) {
                        // Hiển thị thông báo rằng không còn sản phẩm nào
                        $('.product-list-section').html(
                            '<h3 class="container">Chưa có sản phẩm</h3>');
                    }
                    alert(res.message);
                },
                error: function(xhr) {
                    // Handle error
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            });
        });
    });
</script>
