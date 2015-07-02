<?php

return [

    'backend_sidebar' => [
        'Forum' => [
            'order' => 4,
            'children' => [
                [
                    'route' => 'backend.forum.category.manager',
                    'text' => 'Category Manager',
                    'icon' => 'fa-comments-o',
                    'order' => 1,
                    'permission' => 'create@forum_backend',
                    'activePattern' => '\/forum\/categories\/*',
                ],
                [
                    'route' => 'backend.forum.permissions.manager',
                    'text' => 'Category Permissions Manager',
                    'icon' => 'fa-lock',
                    'order' => 2,
                    'permission' => 'create@forum_backend',
                ],
            ],
        ],
    ],

    'backend_forum_category_menu' => [
        [
            'route' => ['backend.forum.category.update', ['forum_category_id' => 'segment:4']],
            'text' => 'Basic Info',
            'icon' => 'fa-file-text-o',
            'order' => 1,
            'permission' => 'update@forum_backend',
        ],
        [
            'route' => ['backend.forum.category.permissions', ['forum_category_id' => 'segment:4']],
            'text' => 'Permissions',
            'icon' => 'fa-key',
            'order' => 2,
            'permission' => 'update@forum_backend',
        ],
    ],

];
