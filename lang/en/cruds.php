<?php
return [
    'admin' => [
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
                'description' => 'Mô tả',
                'price' => 'Giá sản phẩm',
                'content' => 'Nội dung',
                'status' => 'Trạng thái',
                'images' => 'Hình ảnh sản phẩm',
            ]
        ],
        'category' => [
            'fields' => [
                'id' => 'ID',
                'name' => 'Tên'
            ]
        ]
    ]
];
