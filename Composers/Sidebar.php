<?php

namespace Cms\Modules\Forum\Composers;

use Cms\Modules\Forum\Services\CategoryService;
use Cms\Modules\Auth\Repositories\User\RepositoryInterface as UserRepo;

class Sidebar
{
    protected $category;
    protected $user;

    public function __construct(CategoryService $category, UserRepo $user)
    {
        $this->category = $category;
        $this->user = $user;
    }

    public function categoryList($view)
    {
        $categories = $this->category->getAllCategories()->transform(function ($model) {
            return $model->transform();
        });

        if ($categories === false || !count($categories)) {
            $view->with('forum_categories', []);

            return;
        }

        $view->with('forum_categories', $categories);
    }

    public function topPosters($view)
    {
        $userList = cache_forever('forum_sidebars', 'sidebar_topposters', function () {
            $users = $this->user->with(['forumPosts'])->limit(5)->all();

            if ($users === false || !count($users)) {
                $view->with('forum_posters', []);

                return;
            }

            $userList = $users->map(function ($user) {
                $return = $user->transform();
                $return['post_count'] = $user->forumPosts->count();

                return $return;
            })->sort(function ($a, $b) {
                return array_get($a, 'post_count', 1) < array_get($b, 'post_count', 1);
            });

            return $userList;
        });

        $view->with('forum_posters', $userList);
    }
}
