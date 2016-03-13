<?php

namespace Cms\Modules\Forum\Providers;

use Cms\Modules\Core\Providers\CmsRoutingProvider;
use Illuminate\Routing\Router;

class ForumRoutingProvider extends CmsRoutingProvider
{
    protected $namespace = 'Cms\Modules\Forum\Http\Controllers';

    /**
     * @return string
     */
    protected function getFrontendRoute()
    {
        return __DIR__.'/../Http/routes-frontend.php';
    }

    /**
     * @return string
     */
    protected function getBackendRoute()
    {
        return __DIR__.'/../Http/routes-backend.php';
    }

    /**
     * @return string
     */
    protected function getApiRoute()
    {
        return __DIR__.'/../Http/routes-api.php';
    }

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('forum_category_id', function ($id) {
            return with(new \Cms\Modules\Forum\Models\Category())
                ->findOrFail($id);
        });

        //$router->bind('forum_thread_id', function ($id) {
        //    return with(new \Cms\Modules\Forum\Models\Thread)
        //        ->findOrFail($id);
        //});

        $router->bind('forum_post_id', function ($id) {
           return with(new \Cms\Modules\Forum\Models\Post())
                ->with('thread')
                ->findOrFail($id);
        });
    }
}
