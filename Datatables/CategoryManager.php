<?php namespace Cms\Modules\Forum\Datatables;

use Lock;

class CategoryManager
{
    public function boot()
    {
        return [
            /**
             * Page Decoration Values
             */
            'page' => [
                'title' => 'Forum Manager',
                'alert' => [
                    'class' => 'info',
                    'text'  => '<i class="fa fa-info-circle"></i> You can manage your forum categories from here.'
                ],
                'header' => [
                    [
                        'btn-text' => 'Create Category',
                        'btn-route' => 'backend.forum.category.create',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon' => 'fa fa-plus'
                    ],
                ],
            ],

            /**
             * Set up some table options, these will be passed back to the view
             */
            'options' => [
                'pagination' => false,
                'searching' => false,
                'ordering' => false,
                'sort_column' => 'order',
                'sort_order' => 'desc',
                'source' => 'backend.forum.category.manager',
                'collection' => function () {
                    $model = 'Cms\Modules\Forum\Models\Category';
                    return $model::with('threads')->orderBy('order', 'asc')->get();
                },
            ],

            /**
             * Lists the tables columns
             */
            'columns' => [
                'order' => [
                    'th' => 'Order',
                    'tr' => function ($model) {
                        return $model->order;
                    },
                    'width' => '5%',
                ],

                'name' => [
                    'th' => 'Category Name',
                    'tr' => function ($model) {
                        return $model->name;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'Color' => [
                    'th' => 'Color',
                    'tr' => function ($model) {
                        return sprintf('<span style="color: %2$s;">%1$s</span>', $model->color, $model->color);
                    },
                    'width' => '10%',
                ],

                'thread_count' => [
                    'th' => '<span data-title="Thread Count" data-toggle="tooltip"><i class="fa fa-question-circle"></i></span>',
                    'tr' => function ($model) {
                        return $model->threads->count();
                    },
                    'width' => '3%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        $return = [
                            [
                                'btn-title' => 'Edit Category',
                                'btn-link'  => route('backend.forum.category.update', $model->id),
                                'btn-class' => 'btn btn-warning btn-xs btn-labeled',
                                'btn-icon'  => 'fa fa-pencil',
                                'hasPermission' => 'update@forum_backend',
                            ]
                        ];

                        if ($model->order > 1) {
                            $return[] = [
                                'btn-title' => 'Move Up',
                                'btn-link'  => route('backend.forum.category.move-up', $model->id),
                                'btn-class' => 'btn btn-default btn-xs btn-labeled',
                                'btn-icon'  => 'fa fa-arrow-up',
                                'btn-method' => 'post',
                                'btn-extras' => 'data-remote="true" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                                'hasPermission' => 'update@forum_backend',
                            ];
                        }

                        $return[] = [
                            'btn-title' => 'Move Down',
                            'btn-link'  => route('backend.forum.category.move-down', $model->id),
                            'btn-class' => 'btn btn-default btn-xs btn-labeled',
                            'btn-icon'  => 'fa fa-arrow-down',
                            'btn-method' => 'post',
                            'btn-extras' => 'data-remote="true" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                            'hasPermission' => 'update@forum_backend',
                        ];

                        return $return;
                    },
                ],
            ]
        ];

    }
}
