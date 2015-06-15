<?php namespace Cms\Modules\Forum\Models;

use Cms\Modules\Core\Models\BaseModel as CoreBaseModel;

class BaseModel extends CoreBaseModel
{

    public function __construct()
    {
        parent::__construct();

        $prefix = config('cms.forum.config.table-prefix', 'forum_');
        $this->table = $prefix.$this->table;
    }

}
