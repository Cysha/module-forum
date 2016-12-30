<?php

use Dingo\Api\Routing\Router as ApiRouter;

$router->version('v1', ['middleware' => ['api.auth'], 'namespace' => 'V1'], function (ApiRouter $router) {

    $router->group(['prefix' => 'widget/forum'], function (ApiRouter $router) {
        $router->get('post-count', 'WidgetController@getPostCount');
        $router->get('thread-count', 'WidgetController@getThreadCount');
    });

});
