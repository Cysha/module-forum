<?php

namespace Cms\Modules\Forum\Repositories\Thread;

use Cms\Modules\Core\Repositories\BaseEloquentRepository;

class EloquentRepository extends BaseEloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        return 'Cms\Modules\Forum\Models\Thread';
    }

    public function getByCategory($category_id, $paginate = false)
    {
        if (!is_array($category_id)) {
            $category_id = [$category_id];
        }

        return $this->getByCategories($category_id, $paginate);
    }

    public function getByCategories(array $category_ids, $paginate = false)
    {
        $query = $this->model
            ->with(['category', 'posts', 'latestPost.author', 'author'])
            ->whereIn('category_id', $category_ids)
            ->orderBy('updated_at', 'desc')
            ->select(['forum_threads.id', 'forum_threads.category_id', 'forum_threads.author_id', 'forum_threads.name', 'forum_threads.created_at']);

        return $paginate === false ? $query->get() : $query->paginate($paginate);
    }

    public function getById($thread_id)
    {
        return $this->model
            ->with(['posts', 'latestPost.author', 'posts.author'])
            ->findOrFail($thread_id);
    }
}
