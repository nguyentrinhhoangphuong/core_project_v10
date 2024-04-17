<?php
return [
    'url' => [
        'prefix_admin' => 'admin',
        'prefix_news' => 'news',
    ],

    'format' => [
        'long_time' => 'H:m:s d/m/Y',
        'short_time' => 'd/m/Y',
    ],

    'template' => [
        'status' => [
            'all' => ['name' => 'Lọc trạng thái', 'class' => 'dropdown-item'],
            'active' => ['name' => 'Kích hoạt', 'class' => 'dropdown-item'],
            'inactive' => ['name' => 'Chưa kích hoạt', 'class' => 'dropdown-item'],
        ],

        'isHome' => [
            'yes' => ['name' => 'Hiển thị Home', 'class' => 'btn-info'],
            'no' => ['name' => 'Không hiển thị Home', 'class' => 'btn-warning']
        ],

        'level' => [
            'admin' => ['name' => 'Quản trị viên', 'class' => 'btn-info'],
            'member' => ['name' => 'User', 'class' => 'btn-warning']
        ],

        'search' => [
            'all' => ['name' => 'Search by All'],
            'id' => ['name' => 'Search by ID'],
            'name' => ['name' => 'Search by Name'],
            'title' => ['name' => 'Search by Title'],
            'username' => ['name' => 'Search by Username'],
            'fullname' => ['name' => 'Search by Fullname'],
            'email' => ['name' => 'Search by Email'],
            'description' => ['name' => 'Search by Description'],
            'link' => ['name' => 'Search by Link'],
            'content' => ['name' => 'Search by Content'],
            'company_name' => ['name' => 'Search by Company'],
            'position' => ['name' => 'Search by Position'],
            'source' => ['name' => 'Search by Source'],
        ],

        'button' => [
            'edit' => ['class' => 'btn-success', 'title' => 'Edit', 'icon' => 'fa-pencil', 'route-name' => '/form'],
            'delete' => ['class' => 'btn-danger btn-delete', 'title' => 'Delete', 'icon' => 'fa-trash', 'route-name' => '/delete'],
            'info' => ['class' => 'btn-info', 'title' => 'View', 'icon' => 'fa-pencil', 'route-name' => '/info'],
        ],
    ],

    'config' => [
        'search' => [
            'slider' => ['all', 'name', 'description', 'link'],
            'category' => ['all', 'name'],
            'article' => ['all', 'title', 'content']
        ],
        'button' => [
            'slider' => ['edit', 'delete'],
        ]
    ]
];
