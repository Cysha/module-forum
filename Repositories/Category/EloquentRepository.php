<?php namespace Cms\Modules\Forum\Repositories\Category;

use Cms\Modules\Forum\Repositories\Category\RepositoryInterface;
use Cms\Modules\Core\Repositories\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository extends BaseEloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        return 'Cms\Modules\Forum\Models\Category';
    }
}
