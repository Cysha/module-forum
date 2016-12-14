<?php

return [

    'backend_sidebar' => [
        'Forum' => [
            'order' => 101,
            'children' => [
                [
                    'route' => 'admin.forum.category.manager',
                    'text' => 'Category Manager',
                    'icon' => 'fa-comments-o',
                    'order' => 1,
                    'permission' => 'create@forum_backend',
                    'activePattern' => '\/{backend}\/forum\/categories\/*',
                ],
                [
                    'route' => 'admin.forum.permissions.manager',
                    'text' => 'Permissions Manager',
                    'icon' => 'fa-lock',
                    'order' => 2,
                    'permission' => 'create@forum_backend',
                    'activePattern' => '\/{backend}\/forum\/permissions\/*',
                ],
            ],
        ],
    ],

    'backend_forum_category_menu' => [
        [
            'route' => ['admin.forum.category.update', ['forum_category_id' => 'segment:4']],
            'text' => 'Basic Info',
            'icon' => 'fa-file-text-o',
            'order' => 1,
            'permission' => 'update@forum_backend',
        ],
    ],

];
