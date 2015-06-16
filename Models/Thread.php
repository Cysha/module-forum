<?php namespace Cms\Modules\Forum\Models;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Thread extends BaseModel
{

    protected $table = 'threads';
    protected $fillable = ['category_id', 'author_id', 'name', 'locked', 'views'];
    protected $appends = ['postCount', 'lastPage'];
    protected $touches = ['category'];

    protected $identifiableName = 'name';
    protected $link = [
        'route' => 'forum.thread.show',
        'attributes' => [
            'forum_thread_id' => 'id',
            'forum_thread_name' => 'slug'
        ],
    ];

    public function posts()
    {
        return $this->hasMany(__NAMESPACE__.'\Post');
    }

    public function latestPost()
    {
        return $this->hasOne(__NAMESPACE__.'\Post')->latest();
    }

    public function category()
    {
        return $this->belongsTo(__NAMESPACE__.'\Category');
    }

    public function author()
    {
        return $this->belongsTo('Cms\Modules\Auth\Models\User');
    }

    public function getPostCountAttribute()
    {
        return $this->posts->count();
    }

    public function getPaginationAttribute()
    {
        $paginator = new LengthAwarePaginator(new Collection(), $this->postCount, 10);

        return $paginator->toArray();
    }

    public function transform()
    {
        $return = [
            'id' => $this->id,
            'name' => $this->name,
            // 'slug' => $this->makeSlug(),
            'category_id' => $this->category_id,
            'post_count' => $this->postCount,
            'created' => date_array($this->created_at),
            'updated' => date_array($this->updated_at),

            'pagination' => $this->pagination,
            'links' => [
                'self' => (string) $this->makeLink(true),
                'last_page' => (string) $this->makeLink(true).'?page='.array_get($this->pagination, 'last_page'),
                'reply' => (string) $this->makeLink(true),
            ],

            'author' => [],
            'category' => [],
            'latestPost' => [],
        ];

        if ($this->author !== null) {
            $return['author'] = $this->author->transform();
        }

        if ($this->category !== null) {
            $return['category'] = $this->category->transform();
        }

        if ($this->latestPost !== null) {
            $lastPost = $this->latestPost;
            $return['latestPost'] = (array) $lastPost->transform();
            $return['links']['last_post'] = (string) sprintf(
                '%s?page=%d#post-%s',
                $this->makeLink(true),
                array_get($this->pagination, 'last_page'),
                $lastPost->id
            );
        }

        return $return;
    }
}
