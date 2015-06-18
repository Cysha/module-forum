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
            ->with(['posts', 'latestPost.author', 'author'])
            ->whereIn('category_id', $category_ids)
            ->orderBy('updated_at', 'desc');

        return $paginate === false ? $query->get() : $query->paginate($paginate);
    }

    public function getById($thread_id)
    {
        return $this->model
            ->with(['posts', 'latestPost.author', 'posts.author'])
            ->findOrFail($thread_id);
    }
}
