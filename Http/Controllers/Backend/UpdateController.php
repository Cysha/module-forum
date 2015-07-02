<?php namespace Cms\Modules\Forum\Http\Controllers\Backend;

use Cms\Modules\Core\Http\Controllers\BaseBackendController;
use Cms\Modules\Forum\Models\Category;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{

    public function getForm(Category $category)
    {
        $this->getDetails($category);

        return $this->setView('backend.category.basic', [
            'category' => $category,
        ]);
    }

    public function postForm(Category $category, Request $input)
    {
        $input = $input->only(['name', 'slug', 'color']);

        $category->hydrateFromInput($input);

        if ($category->save() === false) {
            return redirect()->back()->withErrors($category->getErrors());
        }

        return redirect()->back()->withInfo('Category Updated');
    }

    public function postDown(Category $category, Request $input)
    {
        $category->order++;

        if ($category->save() === false) {
            return $this->sendMessage($category->getErrors(), 500);
        }

        return $this->sendMessage('Ok', 200);
    }

    public function postUp(Category $category, Request $input)
    {
        if (($category->order - 1) <= 0) {
            $category->order = 1;
        } else {
            $category->order--;
        }

        if ($category->save() === false) {
            return $this->sendMessage($category->getErrors(), 500);
        }

        return $this->sendMessage('Ok', 200);
    }
}
