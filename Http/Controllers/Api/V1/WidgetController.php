<?php

namespace Cms\Modules\Forum\Http\Controllers\Api\V1;

use Cms\Modules\Forum\Repositories\Thread\RepositoryInterface as ThreadRepo;
use Cms\Modules\Forum\Repositories\Post\RepositoryInterface as PostRepo;

class WidgetController extends BaseController
{
    public function getPostCount(PostRepo $postRepo)
    {
        return $this->sendResponse('ok', 200, [
            'post_count' => $postRepo->count(),
        ]);
    }

    public function getThreadCount(ThreadRepo $threadRepo)
    {
        return $this->sendResponse('ok', 200, [
            'thread_count' => $threadRepo->count(),
        ]);
    }
}
