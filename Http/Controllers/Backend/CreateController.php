<?php namespace Cms\Modules\Forum\Http\Controllers\Backend;

use Cms\Modules\Core\Http\Controllers\BaseBackendController;
use Cms\Modules\Forum\Services\CategoryService;
use Cms\Modules\Forum\Models\Category;
use Illuminate\Http\Request;

class CreateController extends BaseController
{

    public function getForm()
    {
        $this->theme->setTitle('Create Category');
        $this->theme->breadcrumb()->add('Create Category', route('backend.forum.category.create'));

        return $this->setView('backend.category.basic', [
            'category' => with(new Category),
        ]);
    }

    public function postForm(CategoryService $categoryService, Request $input)
    {
        $input = $input->only(['name', 'slug', 'color']);

        $category = $categoryService->create($input);
        if ($category === false) {
            return redirect()
                ->back()
                ->withErrors($category->getErrors());
        }

        return redirect()
            ->route('backend.forum.category.update', $category->id)
            ->withInfo('Category Created!');
    }

}
