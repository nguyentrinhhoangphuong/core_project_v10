@php
    use App\Helpers\Template;
    $xhtml = '';
    if (count($productsComponent) > 0) {
        foreach ($productsComponent as $product) {
            $name = $product->name;
            $price = Template::numberFormatVND($product->price);
            $original_price = Template::numberFormatVND($product->original_price);
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
                            <a href="product-left-thumbnail.html">
                                <img src="' .
                $mediaUrl .
                '" class="img-fluid blur-up lazyload" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="product-footer">
                        <div class="product-detail">
                            <a href="product-left-thumbnail.html">
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
                                </h2>
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
