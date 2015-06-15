<?php namespace Cms\Modules\Forum\Services;

use BeatSwitch\Lock\Integrations\Laravel\Facades\Lock;
use Cms\Modules\Forum\Models\Category;
use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;

class CategoryService
{
    public function __construct(CategoryRepo $category)
    {
        $this->category = $category;
    }

    public function getById($category_id)
    {
        $models = $this->category
            ->with(['threadCount'])
            ->getById($category_id);

        return $this->category->transformModels($models);
    }

    public function all()
    {
        return $this->category->transformModels(
            $this->getAllCategories()
        );
    }

    public function getCreateData(Category $category)
    {
        $data = [];

        $data['categories'] = $this->getAllCategories()->filter(function ($model) {
            return Lock::can('post', 'forum_frontend', $model->id);
        });

        $data['category'] = $category->transform();

        return $data;
    }

    protected function getAllCategories()
    {
        $models = $this->category
            ->with(['threadCount'])
            ->orderBy('order', 'asc')
            ->get();

        return $models->filter(function ($model) {
            return Lock::can('read', 'forum_frontend', $model->id);
        });
    }
}
