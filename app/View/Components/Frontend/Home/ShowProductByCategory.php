<?php

namespace App\View\Components\Frontend\Home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
// controller(khởi tạo product)->truyền sang components (đặt trên view-controller)(thực hiện setAttribute)-render view-component
class ShowProductByCategory extends Component
{
    protected $products;
    protected $requiredAttributes = ['cpu', 'ram', 'ssd'];

    /**
     * Create a new component instance.
     */
    public function __construct($products)
    {
        $this->products = $products;
        $this->processProductAttributes();
    }

    protected function processProductAttributes()
    {
        foreach ($this->products as $product) {
            $processedAttributes = [];
            // Tạo một mảng tạm thời để lưu các thuộc tính theo thứ tự 'cpu', 'ram', 'ssd'
            foreach ($this->requiredAttributes as $requiredAttribute) {
                foreach ($product->productAttributes as $attribute) {
                    if ($attribute->attribute && $attribute->attributeValue) {
                        if ($attribute->attribute->slug === $requiredAttribute) {
                            $attributeName = $attribute->attribute->name;
                            $attributeValue = $attribute->attributeValue->value;

                            // Kiểm tra xem đã có thuộc tính này trong mảng $processedAttributes chưa
                            $found = false;
                            foreach ($processedAttributes as &$processedAttribute) {
                                if ($processedAttribute['attribute_name'] === $attributeName) {
                                    // Nếu đã có, thêm giá trị vào mảng giá trị
                                    $processedAttribute['attribute_values'][] = $attributeValue;
                                    $found = true;
                                    break;
                                }
                            }

                            // Nếu chưa có, thêm mới vào mảng $processedAttributes
                            if (!$found) {
                                $processedAttributes[] = [
                                    'attribute_name' => $attributeName,
                                    'attribute_values' => [$attributeValue],
                                ];
                            }
                        }
                    }
                }
            }
            // Gán mảng $processedAttributes vào thuộc tính tùy chỉnh 'processed_attributes' của sản phẩm
            $product->setAttribute('processed_attributes', $processedAttributes);
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.show-product-by-category', [
            'productsComponent' => $this->products,
        ]);
    }
}
