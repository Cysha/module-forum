<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'forum'], function (Router $router) {

    $router->group(['prefix' => 'categories'], function (Router $router) {

        $router->group(['prefix' => 'create', 'middleware' => 'hasPermission', 'hasPermission' => 'create@forum_backend'], function (Router $router) {
            $router->post('/', ['uses' => 'CreateController@postForm']);
            $router->get('/', ['as' => 'backend.forum.category.create', 'uses' => 'CreateController@getForm']);
        });

        $router->group(['prefix' => '{forum_category_id}', 'middleware' => 'hasPermission', 'hasPermission' => 'update@forum_backend'], function (Router $router) {
            $router->group(['prefix' => '/'], function (Router $router) {
                $router->post('/', ['uses' => 'UpdateController@postForm']);
                $router->get('/', ['as' => 'backend.forum.category.update', 'uses' => 'UpdateController@getForm']);
            });

            $router->post('up', ['as' => 'backend.forum.category.move-up', 'uses' => 'UpdateController@postUp']);
            $router->post('down', ['as' => 'backend.forum.category.move-down', 'uses' => 'UpdateController@postDown']);

        });

        $router->get('/', ['as' => 'backend.forum.category.manager', 'uses' => 'CategoryManagerController@categoryManager']);

    });

    $router->group(['prefix' => 'permissions'], function (Router $router) {
        $router->post('/', ['uses' => 'PermissionController@postForm']);
        $router->get('/', ['as' => 'backend.forum.permissions.manager', 'uses' => 'PermissionController@getForm']);

    });

});
