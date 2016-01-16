<?php

return [
    'dashboard' => [
        [
            'view'  => 'forum::backend.widgets.threadCount',
            'name'  => 'Thread Count',
            'class' => '\Cms\Modules\Forum\Composers\Widgets@ThreadCount',
        ],
        [
            'view'  => 'forum::backend.widgets.postCount',
            'name'  => 'Post Count',
            'class' => '\Cms\Modules\Forum\Composers\Widgets@PostCount',
        ],
    ],

];
