<?php namespace Cms\Modules\Forum\Models;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Request;
use League\CommonMark\CommonMarkConverter;

class Post extends BaseModel
{

    protected $table = 'posts';
    protected $fillable = ['thread_id', 'author_id', 'body'];
    protected $appends = ['post_url'];
    protected $touches = ['thread'];

    public function thread()
    {
        return $this->belongsTo(__NAMESPACE__.'\Thread');
    }

    public function author()
    {
        return $this->belongsTo('Cms\Modules\Auth\Models\User');
    }

    public function getBodyAttribute($value)
    {
        return escape(with(new CommonMarkConverter)->convertToHtml($value));
    }

    public function getPostUrlAttribute()
    {
        return sprintf('%s?page=%d#post-%s',
            Request::url(),
            Request::input('page', 1),
            $this->id
        );
    }

    public function transform()
    {
        $return = [
            'id' => $this->id,
            'thread_id' => $this->thread_id,
            'body' => $this->body,
            'created' => date_array($this->created_at),
            'updated' => date_array($this->updated_at),

            'links' => [
                'self' => (string) $this->post_url,
            ],

            'author' => [],
            'category' => [],
            'latestPost' => [],
        ];

        if ($this->author !== null) {
            $return['author'] = $this->author->transform();
        }

        if ($this->category !== null) {
            $return['category'] = $this->category->transform(function ($model) {
                return $model->transform();
            });
        }

        if ($this->latestPost !== null) {
            $lastPost = $this->latestPost;
            $return['latestPost'] = (array) $lastPost->transform();
            $return['links']['last_post'] = (string) sprintf(
                '%s?page=%d#post-%s',
                $this->makeLink(true),
                $this->lastPage,
                $lastPost->id
            );
        }

        return $return;
    }
}
