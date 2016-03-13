<?php

namespace Cms\Modules\Forum\Providers;

use Cms\Modules\Core\Providers\BaseModuleProvider;

class ForumModuleServiceProvider extends BaseModuleProvider
{
    /**
     * Register the defined middleware.
     *
     * @var array
     */
    protected $middleware = [
        'Forum' => [
        ],
    ];

    /**
     * The commands to register.
     *
     * @var array
     */
    protected $commands = [
        'Forum' => [
        ],
    ];

    /**
     * Register view composers.
     *
     * @var array
     */
    protected $composers = [
        'Forum' => [
            'Sidebar@categoryList' => ['forum::frontend.sidebars.categories'],
            'Sidebar@topPosters' => ['forum::frontend.sidebars.topposters'],
        ],
    ];

    /**
     * Register repository bindings to the IoC.
     *
     * @var array
     */
    protected $bindings = [
        'Cms\Modules\Forum\Repositories\Category' => ['RepositoryInterface' => 'EloquentRepository'],
        'Cms\Modules\Forum\Repositories\Thread' => ['RepositoryInterface' => 'EloquentRepository'],
        'Cms\Modules\Forum\Repositories\Post' => ['RepositoryInterface' => 'EloquentRepository'],
    ];

    /**
     * Register Auth related stuffs.
     */
    public function register()
    {
        parent::register();
    }
}
