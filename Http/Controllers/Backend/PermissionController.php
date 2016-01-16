<?php namespace Cms\Modules\Forum\Http\Controllers\Backend;

use BeatSwitch\Lock\Manager;
use Cms\Modules\Auth\Models\Permission;
use Cms\Modules\Auth\Models\Role;
use Cms\Modules\Auth\Repositories\Role\RepositoryInterface as RoleRepo;
use Cms\Modules\Forum\Repositories\Category\RepositoryInterface as CategoryRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends BaseController
{

    public function getForm(CategoryRepo $category, RoleRepo $role)
    {
        $this->theme->setTitle('Category Permission Manager');
        $this->theme->breadcrumb()->add('Category Permission Manager', route('backend.forum.permissions.manager'));

        $permissions = Permission::groupBy('action', 'resource_type', 'resource_id')
                        ->orderBy('resource_type', 'asc')
                        ->orderBy('resource_id', 'asc')
                        ->orderBy('action', 'asc')
                        ->get();
        $categories = $category->orderBy('order', 'asc')->get();
        $roles = $role->all();

        $keys = [];
        foreach ($categories as $cat) {
            foreach ($roles as $role) {
                $keys[] = strtolower($cat->name.'_'.$role->name);
            }
        }

        return $this->setView('backend.category.permissions', compact('permissions', 'categories', 'roles', 'keys'));
    }

    public function postForm(RoleRepo $roles, Request $input, Manager $lockManager)
    {

        $roles = $roles->all();

        if (!count($input->get('permissions'))) {
            return redirect()->back()->withError('Error: no permissions were passed to be processed');
        }

        foreach ($input->get('permissions') as $role_id => $permissions) {
            $role = $roles->filter(function($row) use($role_id) {
                return ($row->id === $role_id);
            })->first();

            // if role doesnt exist
            if ($role === null) {
                continue;
            }

            // grab the lock instance
            $lock = $lockManager->role($role->name);

            // then run through all the permissions and apply them accordingly
            foreach ($permissions as $permission => $mode) {
                list($permission, $resource, $resource_id) = processPermission($permission);

                switch (strtolower($mode)) {
                    case 'privilege':
                        $lock->allow($permission, $resource, $resource_id);
                    break;

                    case 'restriction':
                        $lock->deny($permission, $resource, $resource_id);
                    break;

                    case 'inherit':
                        $perm = with(new Permission)
                            ->whereAction($permission)
                            ->whereResourceType($resource)
                            ->whereResourceId($resource_id)
                            ->get();

                        if ($perm !== null) {
                            DB::table('permission_role')
                                ->whereRoleId($role->id)
                                ->whereIn('permission_id', $perm->lists('id')->toArray())
                                ->delete();
                        }
                    break;
                }
            }
        }

        artisan_call('cache:clear');
        return redirect()->back()
            ->withInfo('Permissions Processed.');
    }


}
