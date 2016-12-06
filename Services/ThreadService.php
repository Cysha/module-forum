<?php

namespace Cms\Modules\Forum\Services;

use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;
use Cms\Modules\Forum\Repositories\Thread\RepositoryInterface as ThreadRepo;
use Cms\Modules\Forum\Repositories\Post\RepositoryInterface as PostRepo;
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
     * Get all threads, apart from those the user doesn't have permission for.
     *
     * @return array
     */
    public function getAll()
    {
        $data = [];
        $data['category'] = null;

        // grab the categories we have permissions to read
        $categories = $this->category->all()->filter(function ($model) {
            return hasPermission('read', 'forum_frontend', $model->id);
        });

        // turn them into an array of ids
        $ids = $categories->lists('id')->toArray();

        // then get the threads for these ids
        $pagination = $this->thread->getByCategories($ids, 10);

        // then paginate those
        $data['threads'] = $pagination->transform(function ($model) {
            return $model->transform();
        });
        $data['pagination'] = $pagination;

        $data['links']['last_page'] = route('pxcms.forum.index').'?page='.$pagination->lastPage();

        // and throw it all back to the view
        return $data;
    }

    public function getByCategory(Category $category)
    {
        if (!hasPermission('read', 'forum_frontend', $category->id)) {
            return abort(404);
        }

        $data = [];

        $data['category'] = $category->transform();

        $pagination = $this->thread->getByCategory($category->id, 10);
        $data['threads'] = $pagination->transform(function ($model) {
            return $model->transform();
        });
        $data['pagination'] = $pagination;

        return $data;
    }

    public function getById($id)
    {
        $data = [];

        $thread = $this->thread->getById($id);
        if (!hasPermission('read', 'forum_frontend', $thread->category->id)) {
            return abort(404);
        }

        $data['thread'] = $thread->transform();

        $pagination = $thread->posts()->paginate(10);
        $data['posts'] = $pagination->transform(function ($model) {
            return $model->transform();
        });
        $data['pagination'] = $pagination;

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
