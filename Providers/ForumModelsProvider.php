<?php

namespace Cms\Modules\Forum\Providers;

use Cms\Modules\Forum\Models\Post;
use Cms\Modules\Forum\Models\Thread;
use Illuminate\Support\ServiceProvider;

class ForumModelsProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     */
    public function boot()
    {
        $model = config('cms.auth.config.user_model');

        $model::macro('forumThreads', function () {
            return $this->hasMany(Thread::class);
        });

        $model::macro('forumPosts', function () {
            return $this->hasMany(Post::class, 'author_id');
        });
    }
}
