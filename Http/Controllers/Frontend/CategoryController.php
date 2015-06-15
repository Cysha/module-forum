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
    public $layout = '2-column-left';

    public function boot()
    {
        $this->setSidebar('forum_default');

        $this->theme->breadcrumb()->add('Forum', route('pxcms.forum.index'));
        $this->theme->asset()->add('forum_partials', 'modules/forum/css/partials.css', ['theme']);
        $this->theme->prependTitle('Forum | ');
    }

    public function getAll(ThreadService $thread)
    {
        $data = [];

        $data['category'] = null;
        $data['threads'] = $thread->getAll();

        return $this->setView('frontend.pages.category.index', $data);
    }

    public function show(Category $category, ThreadService $threadService)
    {
        // make sure we have permission to be here
        if (Lock::cannot('read', 'forum_frontend', $category->id)) {
            return abort(404);
        }

        // set teh breadcrumb & title
        $this->theme->breadcrumb()->add(array_get($category, 'name'), array_get($category, 'links.self'));
        $this->setTitle(array_get($category, 'name'));

        $data['category'] = $category->transform();
        $data['threads'] = $threadService->getByCategory($category);

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

        return $this->setView('frontend.pages.thread.create', $categoryService->getCreateData());
    }

    public function store(Category $category, Request $input, ThreadService $threadService, ThreadCreateRequest $request)
    {
        $input = $input->except(['_token']);
        $input['author_id'] = \Auth::id();

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
                ->withError('Thread could not be created, please try again.');
        }

        return redirect(array_get($thread->transform(), 'links.self'))
            ->withInfo('Thread created successfully.');
    }
}
