<?php namespace Cms\Modules\Forum\Services;

use BeatSwitch\Lock\Integrations\Laravel\Facades\Lock;
use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;
use Cms\Modules\Forum\Models\Category;
use Cms\Modules\Auth\Models\Role;

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

    public function create(array $data)
    {
        // create the category
        $category = $this->category->create($data);
        if ($category === null) {
            return false;
        }

        // duplicate the frontend permissions
        $permissions = config('cms.forum.permissions.forum_frontend');

        // attach em to the admin group, will sort the rest of the perms out manually
        $role = Role::find(config('cms.auth.config.roles.admin_group'));
        foreach ($permissions as $permission => $description) {

            app('BeatSwitch\Lock\Manager')
                ->role($role->name)
                ->allow($permission, 'forum_frontend', $category->id);
        }

        return $category;
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

    public function getAllCategories()
    {
        $models = cache_forever('forum_categories', 'getAllCategories', function () {
            return $this->category
                ->with(['threadCount'])
                ->orderBy('order', 'asc')
                ->get();
        });

        return $models->filter(function ($model) {
            return Lock::can('read', 'forum_frontend', $model->id);
        });
    }
}
