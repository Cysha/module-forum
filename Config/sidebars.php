<?php

return [

    'left' => [
        'forum_default' => [
            [
                'title'     => 'Categories',
                'view'      => 'forum::frontend.sidebars.categories',
                'render_in' => '_panel-no-body',
                'order'     => 1,
            ],
            [
                'title'     => 'Top 5 Posters',
                'view'      => 'forum::frontend.sidebars.topposters',
                'render_in' => '_panel',
                'order'     => 2,
            ],
        ],
    ],

];
