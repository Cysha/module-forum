<?php

namespace Cms\Modules\Forum\Repositories\Category;

use Cms\Modules\Core\Repositories\BaseEloquentRepository;

class EloquentRepository extends BaseEloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        return 'Cms\Modules\Forum\Models\Category';
    }
}
