<?php

namespace Cms\Modules\Forum\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
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
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}
