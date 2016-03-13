<?php

namespace Cms\Modules\Forum\Composers;

use Cms\Modules\Forum\Repositories\Thread\RepositoryInterface as ThreadRepo;
use Cms\Modules\Forum\Repositories\Post\RepositoryInterface as PostRepo;

class Widgets
{
    /**
     * @var Cms\Modules\Forum\Repositories\Thread\RepositoryInterface
     */
    protected $threads;
    /**
     * @var Cms\Modules\Forum\Repositories\Post\RepositoryInterface
     */
    protected $posts;

    public function __construct(ThreadRepo $threads, PostRepo $posts)
    {
        $this->threads = $threads;
        $this->posts = $posts;
    }

    public function ThreadCount($view)
    {
        $count = $this->threads->all()->count();
        $view->with('counter', $count);
    }

    public function PostCount($view)
    {
        $count = $this->posts->all()->count();
        $view->with('counter', $count);
    }
}
