<?php namespace Cms\Modules\Forum\Http\Controllers\Backend;

use Cms\Modules\Core\Http\Controllers\BaseBackendController;
use Cms\Modules\Forum\Datatables\CategoryManager;
use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;
use Cms\Modules\Auth\Repositories\Role\RepositoryInterface as RoleRepo;
use Cms\Modules\Admin\Traits\DataTableTrait;

class CategoryManagerController extends BaseBackendController
{
    use DataTableTrait;

    public function categoryManager()
    {
        return $this->renderDataTable(with(new CategoryManager)->boot());
    }

    public function permissionsManager(CategoryRepo $category, RoleRepo $role)
    {
        $perms = config('cms.forum.permissions.forum_frontend');
        $categories = $category->orderBy('order', 'asc')->get();
        $roles = $role->all();

        return $this->setView('backend.partials.category-permissions', compact('perms', 'categories', 'roles'));
    }

}
