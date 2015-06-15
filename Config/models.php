<?php

return [
    'Auth' => [
        'User' => [
            'forumThreads' => function ($self) {
                return $self->hasMany('Cms\Modules\Forum\Models\Thread');
            },

            'forumPosts' => function ($self) {
                return $self->hasMany('Cms\Modules\Forum\Models\Post');
            },
        ],
    ],
];
