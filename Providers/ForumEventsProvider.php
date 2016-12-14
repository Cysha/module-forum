<?php

namespace Cms\Modules\Forum\Providers;

use Cms\Modules\Core\Providers\BaseEventsProvider;

class ForumEventsProvider extends BaseEventsProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

    ];

    /**
     * Register any other events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
