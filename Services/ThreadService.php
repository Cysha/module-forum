<?php namespace Cms\Modules\Forum\Services;

use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;
use Cms\Modules\Forum\Repositories\Thread\RepositoryInterface as ThreadRepo;
use Cms\Modules\Forum\Repositories\Post\RepositoryInterface as PostRepo;
use BeatSwitch\Lock\Integrations\Laravel\Facades\Lock;
use Cms\Modules\Forum\Models\Category;

class ThreadService
{
    public function __construct(CategoryRepo $category, ThreadRepo $thread, PostRepo $post)
    {
        $this->category = $category;
        $this->thread = $thread;
        $this->post = $post;
    }

    /**
     * Get all threads, apart from those the user doesn't have permission for
     *
     * @return array
     */
    public function getAll()
    {
        $categories = $this->category->all()->filter(function ($model) {
            return Lock::can('read', 'forum_frontend', $model->id);
        });

        return $this->thread->transformModels(
            $this->thread->whereIn('category_id', $categories->lists('id')->toArray())->get()
        );
    }

    public function getByCategory(Category $category)
    {
        if (Lock::cannot('read', 'forum_frontend', $category->id)) {
            return abort(404);
        }

        return $this->thread->transformModels(
            $this->thread->getByCategory($category->id)
        );
    }

    public function getById($id)
    {
        $data = [];

        $thread = $this->thread->getById($id);
        if (Lock::cannot('read', 'forum_frontend', $thread->category->id)){
            return abort(404);
        }

        $data['thread'] = $thread->transform();

        $pagination = $thread->posts()->paginate(10);
        $data['posts'] = $pagination->transform(function ($model) {
            return $model->transform();
        });

        return $data;
    }

    public function create(array $data, Category $category)
    {
        $thread = $this->thread->create($data);
        if ($thread === null) {
            return false;
        }

        $data['thread_id'] = $thread->id;
        $post = $this->post->create($data);
        if ($post === false) {
            return false;
        }

        return $thread;
    }

    public function update(array $data)
    {
        $post = $this->post->create($data);
        if ($post === false) {
            return false;
        }

        return true;
    }
}
