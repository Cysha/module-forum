<?php

$serializer = new SuperClosure\Serializer();

return [
    'Auth' => [
        'User' => [
            'forumThreads' => $serializer->serialize(function ($self) {
                return $self->hasMany('Cms\Modules\Forum\Models\Thread');
            }),

            'forumPosts' => $serializer->serialize(function ($self) {
                return $self->hasMany('Cms\Modules\Forum\Models\Post', 'author_id');
            }),
        ],
    ],
];
