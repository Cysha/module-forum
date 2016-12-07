<?php

namespace Cms\Modules\Forum\Http\Controllers\Frontend;

use Cms\Modules\Forum\Http\Requests\ThreadReplyRequest;
use Cms\Modules\Forum\Models\Thread;
use Cms\Modules\Forum\Services\ThreadService;
use Illuminate\Http\Request;

class ThreadController extends BaseController
{
    /**
     * Show a thread.
     *
     * @param int                                      $thread_id
     * @param Cms\Modules\Forum\Services\ThreadService $threadService
     *
     * @return View
     */
    public function show($thread_id, ThreadService $threadService, Request $input)
    {
        $data = $threadService->getById($thread_id);

        // make sure page is in bounds
        if ($input->get('page') > array_get($data, 'thread.pagination.last_page')) {
            return redirect(array_get($data, 'thread.links.last_post'))
                ->withInfo(trans('forum::common.messages.last_page'));
        }

        return $this->setView('frontend.pages.thread.index', $data);
    }

    /**
     * Reply to a thread.
     *
     * @param int                                                $thread_id
     * @param Cms\Modules\Forum\Services\ThreadService           $threadService
     * @param Cms\Modules\Forum\Http\Requests\ThreadReplyRequest $request
     *
     * @return View
     */
    public function update($thread_id, ThreadService $threadService, ThreadReplyRequest $request)
    {
        $request = $request->except(['_token']);
        $request['author_id'] = \Auth::id();
        $request['thread_id'] = $thread_id;

        $thread = $threadService->getById($thread_id);

        $category = array_get($thread, 'thread.category');

        // make sure we have permission to be here
        if (!hasPermission('reply', 'forum_frontend', (int) array_get($category, 'id'))) {
            return redirect(array_get($category, 'links.self'))
                ->withError(trans('auth::auth.permissions.unauthorized', [
                    'permission' => 'user.create',
                    'resource' => 'forum_frontend',
                    'resource_id' => $category['id'],
                ]));
        }

        $post = $threadService->update($request);
        if ($post === false) {
            return redirect()->back()
                ->withError(trans('forum::common.messages.reply_not_created'));
        }

        // grab it again just to get teh updated info
        $thread = $threadService->getById($thread_id);

        return redirect(array_get($thread, 'thread.links.last_post'))
            ->withInfo(trans('forum::common.messages.reply_created'));
    }
}
