@php
    use App\Helpers\Template;
    $xhtml = null;
    foreach ($featuredProducts as $product) {
        $id = $product['id'];
        $name = $product['name'];
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
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        '<div class="col">
                        <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                            <div class="col">
                                <div class="product-box-3 h-100 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="' .
            $url .
            '">
                                                <img src="http://127.0.0.1:8000/media/385/n4i5497w1-fix_9823d4347b6844ac9f3d8f5ad49efa13_grande.png" class="img-fluid blur-up lazyloaded" alt="">
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
                                                <tbody></tbody>
                                            </table>
                                            <div class="text-center">
                                                <h2 class="price">
                                                    <span style="background-color: #0da487; color: rgb(255, 255, 255);padding: 5px 2rem;border-radius: 5px;">' .
            $price .
            '</span>
                                                    <del>' .
            $original_price .
            '</del>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
    }
@endphp
<section class="product-section">
    <div class="container">
        <div class="row align-items-center justify-content-between mb-3">
            <div class="col-auto">
                <h3><strong>Sản Phẩm Đặc Trưng</strong></h2>
            </div>
            <div class="col-auto">
                <a class="dropdown-item" id="high"
                    href="{{ route('frontend.home.showProducts', ['sort' => 'featured']) }}">
                    Xem tất cả
                </a>
            </div>
        </div>
        <div
            class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
            {!! $xhtml !!}
        </div>
    </div>
</section>
