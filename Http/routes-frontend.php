<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'forum'], function (Router $router) {

    $router->group(['prefix' => 'category'], function (Router $router) {

        $router->group(['prefix' => '{forum_category_id}-{forum_category_name}'], function (Router $router) {

            $router->post('create', ['uses' => 'CategoryController@store']);
            $router->get('create', ['as' => 'forum.thread.create', 'uses' => 'CategoryController@create']);


            $router->get('/', ['as' => 'forum.category.show', 'uses' => 'CategoryController@show']);
        });

    });

    $router->group(['prefix' => 'thread'], function (Router $router) {

        $router->group(['prefix' => '{forum_thread_id}-{forum_thread_name}'], function (Router $router) {

            $router->post('/', ['as' => 'forum.thread.post', 'uses' => 'ThreadController@update']);
            $router->get('/', ['as' => 'forum.thread.show', 'uses' => 'ThreadController@show']);
        });

    });



    $router->get('/', ['as' => 'pxcms.forum.index', 'uses' => 'CategoryController@getAll']);
});
