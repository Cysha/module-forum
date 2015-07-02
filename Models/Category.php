<?php namespace Cms\Modules\Forum\Models;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Category extends BaseModel
{

    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'order', 'color'];
    protected $appends = ['threadCount', 'label', 'pagination'];
    protected $casts = [
        'order' => 'int',
    ];

    protected $identifiableName = 'name';
    protected $link = [
        'route' => 'forum.category.show',
        'attributes' => [
            'forum_frontend_id' => 'id',
            'forum_frontend_name' => 'slug'
        ],
    ];

    public function threads()
    {
        return $this->hasMany(__NAMESPACE__.'\Thread');
    }

    public function threadCount()
    {
        return $this->hasMany(__NAMESPACE__.'\Thread')
            ->selectRaw('category_id, count(id) as count')
            ->groupBy('category_id');
    }

    public function getThreadCountAttribute()
    {
        if (!isset($this->relations['threadCount'])) {
            return 0;
        }

        $first = $this->relations['threadCount']->first();
        if (is_object($first)) {
            return $first->count;
        }

        return 0;
    }

    public function getLabelAttribute($value)
    {
        return sprintf('<span class="label label-default" data-label="%s"><i class="fa fa-circle fa-fw"></i> %s</span>', $this->color, $this->name);
    }

    public function getPaginationAttribute()
    {
        $paginator = new LengthAwarePaginator(new Collection(), $this->threadCount, 10);

        return $paginator->toArray();
    }

    public function transform()
    {
        $return = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'order' => $this->order,
            'thread_count' => (int) 0,

            'label' => $this->label,

            'pagination' => $this->pagination,
            'links' => [
                'self' => (string) $this->makeLink(true),
                'create' => (string) route('forum.thread.create', [
                    'forum_frontend_id' => $this->id,
                    'forum_frontend_name' => $this->slug
                ]),
                'last_page' => (string) $this->makeLink(true).'?page='.array_get($this->pagination, 'last_page'),
            ],
        ];

        if ($this->threadCount !== null) {
            $return['thread_count'] = (int) $this->threadCount;
        }

        return $return;
    }
}
