<?php namespace Cms\Modules\Forum\Repositories\Thread;

use Cms\Modules\Forum\Repositories\Thread\RepositoryInterface;
use Cms\Modules\Core\Repositories\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository extends BaseEloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        return 'Cms\Modules\Forum\Models\Thread';
    }


    public function getByCategory($category_id)
    {
        return $this->model
            ->with(['posts', 'latestPost.author', 'author'])
            ->where('category_id', $category_id)
            ->get();
    }

    public function getById($thread_id)
    {
        return $this->model
            ->with(['posts', 'posts.author'])
            ->findOrFail($thread_id);
    }
}
