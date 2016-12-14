<?php

namespace Cms\Modules\Forum\Http\Controllers\Backend;

use Cms\Modules\Admin\Traits\DataTableTrait;
use Cms\Modules\Forum\Datatables\CategoryManager;

class CategoryManagerController extends BaseController
{
    use DataTableTrait;

    public function categoryManager()
    {
        $this->theme->breadcrumb()->add('Category Manager', route('admin.forum.category.manager'));

        return $this->renderDataTable(with(new CategoryManager())->boot());
    }
}
