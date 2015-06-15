<?php namespace Cms\Modules\Forum\Http\Controllers\Frontend;

use BeatSwitch\Lock\Integrations\Laravel\Facades\Lock;
use Cms\Modules\Forum\Http\Requests\ThreadReplyRequest;
use Cms\Modules\Forum\Models\Thread;
use Cms\Modules\Forum\Services\ThreadService;
use Illuminate\Http\Request;

class ThreadController extends BaseController
{
    public $layout = '2-column-left';

    public function boot()
    {
        $this->setSidebar('forum_default');

        $this->theme->breadcrumb()->add('Forum', route('pxcms.forum.index'));
        $this->theme->asset()->add('forum_partials', 'modules/forum/css/partials.css', ['theme']);
        $this->theme->prependTitle('Thread | ');
    }

    /**
     * Show a thread
     *
     * @param  integer $thread_id
     * @param  Cms\Modules\Forum\Services\ThreadService $threadService
     *
     * @return View
     */
    public function show($thread_id, ThreadService $threadService)
    {
        return $this->setView('frontend.pages.thread.index',
            $threadService->getById($thread_id)
        );
    }

    /**
     * Reply to a thread
     *
     * @param  integer $thread_id
     * @param  Cms\Modules\Forum\Services\ThreadService $threadService
     *
     * @return View
     */
    public function update($thread_id, ThreadService $threadService, Request $input, ThreadReplyRequest $request)
    {

        $input = $input->except(['_token']);
        $input['author_id'] = \Auth::id();
        $input['thread_id'] = $thread_id;

        $thread = $threadService->getById($thread_id);

        $category = array_get($thread, 'thread.category');

        // make sure we have permission to be here
        if (Lock::cannot('reply', 'forum_frontend', (int) array_get($category, 'id'))) {
            return redirect(array_get($category, 'links.self'))
                ->withError(trans('auth::auth.permissions.unauthorized', [
                    'permission' => 'user.create',
                    'resource' => 'forum_frontend',
                    'resource_id' => $category['id'],
                ]));
        }

        $post = $threadService->update($input);
        if ($post === false) {
            return redirect()->back()
                ->withError('Thread could not be created, please try again.');
        }

        // grab it again just to get teh updated info
        $thread = $threadService->getById($thread_id);

        return redirect(array_get($thread, 'thread.links.self'))
            ->withInfo('Replied successfully.');
    }


}
