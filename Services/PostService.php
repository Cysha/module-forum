<?php

namespace Cms\Modules\Forum\Services;

use BeatSwitch\Lock\Integrations\Laravel\Facades\Lock;
use Cms\Modules\Forum\Models\Category;
use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;
use Cms\Modules\Forum\Repositories\Post\RepositoryInterface as PostRepo;
use Cms\Modules\Forum\Repositories\Thread\RepositoryInterface as ThreadRepo;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(CategoryRepo $category, ThreadRepo $thread, PostRepo $post)
    {
        $this->category = $category;
        $this->thread = $thread;
        $this->post = $post;
    }

    public function getById($id)
    {
        $models = $this->post
            ->with(['thread', 'thread.category'])
            ->getById($id);

        return $this->post->transformModels($models);
    }

    public function getDataById($id)
    {
        $data = [];

        // grab the post
        $post = $this->post->getById($id);
        $category_id = $post->thread->category->id;

        // if they cant read the category we dont want em here atall
        // test for read perms
        if (Lock::cannot('read', 'forum_frontend', $category_id)) {
            return abort(404);
        }

        $canEdit = false;
        // test for mod perms for this category
        if (Lock::can('mod', 'forum_frontend', $category_id)) {
            $canEdit = true;

        // if they dont have mod perms test for user rights
        } elseif (Lock::can('update', 'forum_frontend', $category_id)
                && $post->author->id == Auth::id()) {
            $canEdit = true;
        }

        if ($canEdit === false) {
            return redirect()
                ->back()
                ->withError('Error: You do not posess the necessary permissions to edit this post.');
        }

        $data['post'] = $post->transform();
        $data['thread'] = $post->thread->transform();
        $data['category'] = $post->thread->category->transform();

        return $data;
    }
}
