<?php namespace Cms\Modules\Forum\Composers;

use Cms\Modules\Forum\Services\CategoryService;

class Sidebar
{

    protected $category;

    public function __construct(CategoryService $category)
    {
        $this->category = $category;
    }

    public function categoryList($view)
    {
        $categories = $this->category->all();

        if ($categories === false || !count($categories)) {
            $view->with('forum_categories', []);
            return;
        }

        $view->with('forum_categories', $categories);
    }
}
