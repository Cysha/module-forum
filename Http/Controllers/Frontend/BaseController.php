<?php

namespace Cms\Modules\Forum\Http\Controllers\Frontend;

use Cms\Modules\Core\Http\Controllers\BaseFrontendController;

class BaseController extends BaseFrontendController
{
    public $layout = '2-column-left';

    public function boot()
    {
        $this->setSidebar('forum_default');
        $this->theme->asset()->add('forum_partials', 'modules/forum/css/partials.css', ['theme']);

        $this->theme->breadcrumb()->add(trans('forum::common.forum'), route('pxcms.forum.index'));
        $this->theme->prependTitle(trans('forum::common.thread').' | ');

        parent::boot();
    }
}
