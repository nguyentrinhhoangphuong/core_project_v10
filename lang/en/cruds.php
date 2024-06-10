<?php
return [
    'admin' => [
        'status' => 'Trạng thái',
        'slider' => [
            'fields' => [
                'id' => 'ID',
                'name' => 'Tiêu đề',
                'description' => 'Mô tả',
                'status' => 'Trạng thái'
            ]
        ],
        'product' => [
            'fields' => [
                'id' => 'ID',
                'name' => 'Tên sản phẩm',
                'qty' => 'Số lượng',
                'description' => 'Mô tả',
                'brand' => 'Thương hiệu',
                'price' => 'Giá sản phẩm',
                'original_price' => 'Giá gốc',
                'content' => 'Nội dung',
                'status' => 'Trạng thái',
                'isTop' => 'Sản phẩm mới/top',
                'isFeatured' => 'Sản phẩm nổi bật',
                'images' => 'Hình ảnh sản phẩm',
            ]
        ],
        'product-variant' => [
            'fields' => [
                'id' => 'ID',
                'name' => 'Tên biến thể',
                'status' => 'Trạng thái',
            ]
        ],
        'category' => [
            'fields' => [
                'id' => 'ID',
                'name' => 'Tên'
            ]
        ],
        'attributes' => [
            'fields' => [
                'name' => 'Tên thuộc tính'
            ]
        ],
        'brand' => [
            'fields' => [
                'name' => 'Tên thương hiệu'
            ]
        ]
    ]
];
