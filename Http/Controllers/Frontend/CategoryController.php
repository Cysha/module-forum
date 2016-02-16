<?php namespace Cms\Modules\Forum\Http\Controllers\Frontend;

use BeatSwitch\Lock\Integrations\Laravel\Facades\Lock;
use Cms\Modules\Forum\Http\Requests\ThreadCreateRequest;
use Cms\Modules\Forum\Models\Category;
use Cms\Modules\Forum\Services\CategoryService;
use Cms\Modules\Forum\Services\ThreadService;
use Former\Facades\Former;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function getAll(ThreadService $threadService, Request $input)
    {
        $data = $threadService->getAll();

        // make sure page is in bounds
        if ($input->get('page') > $data['pagination']->lastPage()) {
            return redirect(array_get($data, 'links.last_page'))
                ->withInfo(trans('forum::common.messages.last_page'));
        }

        return $this->setView('frontend.pages.category.index', $data);
    }

    public function show(Category $category, ThreadService $threadService, Request $input)
    {
        // make sure we have permission to be here
        if (Lock::cannot('read', 'forum_frontend', $category->id)) {
            return abort(404);
        }

        $data = $threadService->getByCategory($category, 10);

        // make sure page is in bounds
        if ($input->get('page') > array_get($data, 'pagination.last_page')) {
            return redirect(array_get($data, 'links.last_page'))
                ->withInfo(trans('forum::common.messages.last_page'));
        }

        // set teh breadcrumb & title
        $this->theme->breadcrumb()->add(array_get($category, 'name'), array_get($category, 'links.self'));
        $this->setTitle(array_get($category, 'name'));

        return $this->setView('frontend.pages.category.index', $data);
    }

    public function create(Category $category, CategoryService $categoryService)
    {
        $this->setTitle('Create Thread');

        // make sure we have permission to be here
        if (Lock::cannot('post', 'forum_frontend', $category->id)) {
            return redirect(array_get($category->transform(), 'links.self'))
                ->withError(trans('auth::auth.permissions.unauthorized', [
                    'permission' => 'user.create',
                    'resource' => 'forum_frontend',
                    'resource_id' => $category->id,
                ]));
        }

        Former::populateField('category_id', $category->id);

        return $this->setView('frontend.pages.thread.create', $categoryService->getCreateData($category));
    }

    public function store(Category $category, Request $input, ThreadService $threadService, ThreadCreateRequest $request)
    {
        $input = $input->except(['_token']);
        $input['author_id'] = \Auth::id();
        $input['category_id'] = $category->id;

        // make sure we have permission to be here
        if (Lock::cannot('post', 'forum_frontend', $category->id)) {
            return redirect(array_get($category->transform(), 'links.self'))
                ->withError(trans('auth::auth.permissions.unauthorized', [
                    'permission' => 'user.create',
                    'resource' => 'forum_frontend',
                    'resource_id' => $category->id,
                ]));
        }

        $thread = $threadService->create($input, $category);
        if ($thread === false) {
            return redirect()->back()
                ->withError(trans('forum::common.messages.thread_not_created'));
        }

        return redirect(array_get($thread->transform(), 'links.self'))
            ->withInfo(trans('forum::common.messages.thread_created'));
    }
}
