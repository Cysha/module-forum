<?php

namespace Cms\Modules\Forum\Repositories\Post;

use Cms\Modules\Core\Repositories\BaseEloquentRepository;

class EloquentRepository extends BaseEloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        return 'Cms\Modules\Forum\Models\Post';
    }

    public function getById($thread_id)
    {
        return $this->model
            ->with(['author', 'thread', 'thread.category'])
            ->findOrFail($thread_id);
    }
}
